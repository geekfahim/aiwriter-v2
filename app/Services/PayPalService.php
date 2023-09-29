<?php

namespace App\Services;

use Carbon\Carbon;
use CurrencyHelper;
use DB;
use Helper;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Models\BillingHistory;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserSubscription;
use App\Traits\ConsumesExternalServices;

class PayPalService
{
    use ConsumesExternalServices;

    public function __construct()
    {
        $paypalInfo = DB::table('integrations')->where('name', 'PayPal')->first();
        $this->config = unserialize($paypalInfo->data);
        $this->baseUri = $this->config['mode'] == 'sandbox' ? 'https://api-m.sandbox.paypal.com/' : 'https://api-m.paypal.com/';
        $this->clientId = $this->config['client_id'];
        $this->clientSecret = $this->config['secret'];
    }

    public function resolveAccessToken()
    {
        $httpClient = new HttpClient();

        // Attempt to retrieve the auth token
        try {
            $payPalAuthRequest = $httpClient->request('POST', $this->baseUri . 'v1/oauth2/token', [
                    'auth' => [$this->clientId, $this->config['secret']],
                    'form_params' => [
                        'grant_type' => 'client_credentials'
                    ]
                ]
            );

            return json_decode($payPalAuthRequest->getBody()->getContents())->access_token;
        } catch (RequestException $e) {
            Log::info($e->getResponse()->getBody()->getContents());

            return response()->json([
                'status' => 400,
                'error' => $e->getResponse()->getBody()->getContents()
            ], 400);

            //return back()->with('error', $e->getResponse()->getBody()->getContents());
        }
    }

    public function makeRequest($method, $url, $body)
    {
        $httpClient = new HttpClient();

        try {
            $request = $httpClient->request($method, $this->baseUri . $url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->resolveAccessToken(),
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode($body)
                ]
            );

            return (object) array('success' => true, 'data' => json_decode($request->getBody()->getContents()));
        } catch (RequestException $e) {
            return (object) array('success' => false, 'error' => json_decode($e->getResponse()->getBody()->getContents()));
        }
    }

    public function getProduct($plan)
    {
        return $this->makeRequest(
            'GET',
            'v1/catalogs/products/' . 'product_' . $plan->id,
            [],
        );
    }

    public function createProduct($plan)
    {
        return $this->makeRequest(
            'POST',
            'v1/catalogs/products',
            [
                'id' => 'product_' . $plan->id,
                'name' => $plan->name,
                'description' => $plan->description,
                'type' => 'SERVICE'
            ],
        );
    }

    public function createPlan($plan, $payPalProduct, $amount, $interval)
    {
        $payPalPlan = 'plan_' . $plan->id . '_' .$interval . '_' . $amount . '_' . Helper::config('currency');

        return $this->makeRequest(
            'POST',
            'v1/billing/plans',
            [
                'product_id' => $payPalProduct->id,
                'name' => $payPalPlan,
                'status' => 'ACTIVE',
                'billing_cycles' => [
                    [
                        'frequency' => [
                            'interval_unit' => strtoupper($interval),
                            'interval_count' => 1,
                        ],
                        'tenure_type' => 'REGULAR',
                        'sequence' => 1,
                        'total_cycles' => 0,
                        'pricing_scheme' => [
                            'fixed_price' => [
                                'value' => $amount,
                                'currency_code' => Helper::config('currency'),
                            ],
                        ]
                    ]
                ],
                'payment_preferences' => [
                    'auto_bill_outstanding' => true,
                    'payment_failure_threshold' => 0,
                ],
            ],
        );
    }

    public function createSubscription($plan, $payPalPlan, $coupon, $taxRates, $amount, $interval)
    {
        return $this->makeRequest(
            'POST',
            'v1/billing/subscriptions',
            [
                'plan_id' => $payPalPlan->id,
                'application_context' => [
                    'brand_name' => config('settings.title'),
                    'locale' => 'en-US',
                    'shipping_preference' => 'SET_PROVIDED_ADDRESS',
                    'user_action' => 'SUBSCRIBE_NOW',
                    'payment_method' => [
                        'payer_selected' => 'PAYPAL',
                        'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                    ],
                    'return_url' => url('billing'),
                    'cancel_url' => url('billing')
                ],
                'custom_id' => http_build_query([
                    'user' => auth()->user()->id,
                    'plan' => $plan->id,
                    'plan_amount' => $interval == 'year' ? $plan->yearly_price : $plan->monthly_price,
                    'amount' => $amount,
                    'currency' => Helper::config('currency'),
                    'interval' => $interval,
                    'coupon' => $coupon->id ?? null,
                    'tax_rates' => isset($taxRates) ?? $taxRates->pluck('id')->implode('_'),
                ])
            ],
        );
    }

    public function handleSubscription(Request $request, $plan, $coupon, $taxRates, $amount, $interval)
    {
        //Check if product exists
        $payPalProduct = $this->getProduct($plan);

        //Create product if not exist
        if(!$payPalProduct->success){
            $payPalProduct = $this->createProduct($plan);
        }

        //Create plan
        $payPalPlan = $this->createPlan($plan, $payPalProduct->data, $amount, $interval);

        //Create the subscription
        $payPalSubscription = $this->createSubscription($plan, $payPalPlan->data, $coupon, $taxRates, $amount, $interval);

        return redirect($payPalSubscription->data->links[0]->href);
    }

    public function verifyWebhook(Request $request, $payload)
    {
        return $this->makeRequest(
            'POST',
            'v1/notifications/verify-webhook-signature',
            [
                
                'auth_algo' => $request->header('PAYPAL-AUTH-ALGO'),
                'cert_url' => $request->header('PAYPAL-CERT-URL'),
                'transmission_id' => $request->header('PAYPAL-TRANSMISSION-ID'),
                'transmission_sig' => $request->header('PAYPAL-TRANSMISSION-SIG'),
                'transmission_time' => $request->header('PAYPAL-TRANSMISSION-TIME'),
                'webhook_id' => $this->config['webhook_id'],
                'webhook_event' => $payload
            ],
        );
    }

    public function cancelSubscription($plan_subscription_id)
    {
        return $this->makeRequest(
            'POST',
            'v1/billing/subscriptions/' . $plan_subscription_id . '/cancel',
            [
                'reason' => __('Cancelled')
            ],
        );
    }

    public function handleWebhook(Request $request)
    {
        $httpClient = new HttpClient();

        // Get the payload's content
        $payload = json_decode($request->getContent());

        // Attempt to validate the webhook signature
        $payPalWHSignatureRequest = $this->verifyWebhook($request, $payload);

        // Check if the webhook's signature status is successful
        if ($payPalWHSignatureRequest->data->verification_status != 'SUCCESS') {
            //Log::info('PayPal signature validation failed.');

            return response()->json([
                'status' => 400,
                'error' => __('PayPal signature validation failed.')
            ], 400);
        }

        // Parse the custom metadata parameters
        parse_str($payload->resource->custom_id ?? ($payload->resource->custom ?? null), $metadata);

        if ($metadata) {
            $user = User::where('id', '=', $metadata['user'])->first();
            $user_subscription = UserSubscription::where('user_id', '=', $metadata['user'])->first();

            // If a user was found
            if ($user) {
                if ($payload->event_type == 'BILLING.SUBSCRIPTION.CREATED') {
                    // If the user previously had a subscription, attempt to cancel it
                    if ($user_subscription->subscription_id) {
                        $user_subscription->cancelSubscription();
                    }

                    $user_subscription->plan_id = $metadata['plan'];
                    $user_subscription->plan_amount = $metadata['amount'];
                    $user_subscription->plan_interval = $metadata['interval'];
                    $user_subscription->payment_processor = 'paypal';
                    $user_subscription->subscription_id = $payload->resource->id;
                    $user_subscription->status = $payload->resource->status;
                    $user_subscription->created_at = Carbon::now();
                    $user_subscription->recurring_at = null;
                    $user_subscription->cancelled_at = null;
                    $user_subscription->save();

                    // If a coupon was used
                    if (isset($metadata['coupon']) && $metadata['coupon']) {
                        $coupon = Coupon::find($metadata['coupon']);

                        // If a coupon was found
                        if ($coupon) {
                            // Increase the coupon usage
                            $coupon->increment('quantity_redeemed', 1);
                        }
                    }
                } elseif (stripos($payload->event_type, 'BILLING.SUBSCRIPTION.') !== false) {
                    // If the subscription exists
                    if ($user_subscription->payment_processor == 'paypal' && $user_subscription->subscription_id == $payload->resource->id) {
                        // Update the recurring date
                        if (isset($payload->resource->billing_info->next_billing_time)) {
                            $user_subscription->recurring_at = Carbon::create($payload->resource->billing_info->next_billing_time);
                        }

                        // Update the subscription status
                        if (isset($payload->resource->status)) {
                            $user_subscription->status = $payload->resource->status;
                        }

                        // If the subscription has been cancelled
                        if ($payload->event_type == 'BILLING.SUBSCRIPTION.CANCELLED') {
                            // Update the subscription end date and recurring date
                            if (!empty($user_subscription->recurring_at)) {
                                $user_subscription->cancelled_at = $user_subscription->recurring_at;
                                $user_subscription->recurring_at = null;
                            }
                        }

                        $user_subscription->save();
                    }
                } elseif ($payload->event_type == 'PAYMENT.SALE.COMPLETED') {
                    // If the payment does not exist
                    if (!BillingHistory::where([['processor', '=', 'paypal'], ['payment_id', '=', $payload->resource->id]])->exists()) {
                        $payment = BillingHistory::create([
                            'user_id' => $user->id,
                            'plan_id' => $metadata['plan'],
                            'payment_id' => $payload->resource->id,
                            'processor' => 'paypal',
                            'amount' => $metadata['amount'],
                            'currency' => $metadata['currency'],
                            'interval' => $metadata['interval'],
                            'status' => 'completed',
                            'coupon' => $metadata['coupon'] ?? null,
                            'tax_rates' => $metadata['tax_rates'] ?? null,
                            'customer' => $user->billing_information,
                            'billing_date' => date('Y-m-d H:i:s')
                        ]);

                        // Attempt to send the payment confirmation email
                        /*try {
                            Mail::to($user->email)->locale($user->locale)->send(new PaymentMail($payment));
                        }
                        catch (\Exception $e) {}*/
                    }
                }
            }
        }

        return response()->json([
            'status' => 200
        ], 200);
    }
}