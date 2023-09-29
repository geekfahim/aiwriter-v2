<?php

namespace App\Services;

use Carbon\Carbon;
use DB;
use Helper;
use Illuminate\Http\Request;
use App\Models\BillingHistory;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserSubscription;
use App\Traits\ConsumesExternalServices;

class StripeService
{
    public function __construct()
    {
        $stripeInfo = DB::table('integrations')->where('name', 'Stripe')->first();
        $this->config = unserialize($stripeInfo->data);
        $this->stripe = new \Stripe\StripeClient($this->config['secret_key']);
    }

    public function getProduct($plan)
    {
        try {
            return (object) array('success' => true, 'data' => $this->stripe->products->retrieve($plan->id));
        } catch (\Exception $e) {
            return (object) array('success' => false, 'error' => $e->getMessage());
        }
    }

    public function createProduct($plan)
    {
        try {
            $stripeProduct = $this->stripe->products->create([
                'id' => $plan->id,
                'name' => $plan->name,
                'description' => $plan->description
            ]);

            return (object) array('success' => true, 'data' => $stripeProduct);
        } catch (\Exception $e) {
            return (object) array('success' => false, 'error' => $e->getMessage());
        }
    }

    public function updateProduct($plan, $stripeProduct)
    {
        try {
            $stripeProduct = $this->stripe->products->update($stripeProduct->id, [
                'name' => $plan->name
            ]);
            return (object) array('success' => true, 'data' => $stripeProduct);
        } catch (\Exception $e) {
            return (object) array('success' => false, 'error' => $e->getMessage());
        }
    }

    public function getPlan($stripePlan)
    {
        try {
            return (object) array('success' => true, 'data' => $this->stripe->plans->retrieve($stripePlan));
        } catch (\Exception $e) {
            return (object) array('success' => false, 'error' => $e->getMessage());
        }
    }

    public function createPlan($stripePlan, $stripeAmount, $productId, $interval, $currency)
    {
        try {
            $stripePlan = $this->stripe->plans->create([
                'amount' => $stripeAmount,
                'currency' => $currency,
                'interval' => $interval,
                'product' => $productId,
                'id' => $stripePlan,
            ]);
            return (object) array('success' => true, 'data' => $stripePlan);
        } catch (\Exception $e) {
            return (object) array('success' => false, 'error' => $e->getMessage());
        }
    }

    public function checkout($plan, $stripePlan, $amount, $coupon, $taxRates, $interval, $currency)
    {
        try {
            $stripeSession = $this->stripe->checkout->sessions->create([
                'success_url' => url('billing'),
                'cancel_url' => url('billing'),
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price' => $stripePlan->id,
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'subscription',
                'subscription_data' => [
                    'metadata' => [
                        'user' => auth()->user()->id,
                        'plan' => $plan->id,
                        'plan_amount' => $interval == 'year' ? $plan->yearly_price : $plan->monthly_price,
                        'amount' => $amount,
                        'currency' => $currency,
                        'interval' => $interval,
                        'coupon' => $coupon->id ?? null,
                        'tax_rates' => isset($taxRates) ?? $taxRates->pluck('id')->implode('_')
                    ],
                ]
            ]);
            return (object) array('success' => true, 'data' => $stripeSession);
        } catch (\Exception $e) {
            return (object) array('success' => false, 'error' => $e->getMessage());
        }
    }

    public function handleSubscription(Request $request, $plan, $coupon, $taxRates, $amount, $interval)
    {
        //Get the product
        $product = $this->getProduct($plan);

        if($product->success){
            //Check if the product name is still the same
            if ($plan->name != $product->data->name) {
                $product = $this->updateProduct($plan, $product->data);
            }
        } else {
            $product = $this->createProduct($plan);
        }

        $stripeAmount = in_array(Helper::config('currency'), config('currencies.zero_decimals')) ? $amount : ($amount * 100);
        $stripePlan = $plan->id . '_' .$interval . '_' . $stripeAmount . '_' . Helper::config('currency');

        // Attempt to retrieve the plan
        $stripePlanQuery = $this->getPlan($stripePlan);

        if(!$stripePlanQuery->success){
            // Attempt to create the plan
            $stripePlanQuery = $this->createPlan($stripePlan, $stripeAmount, $product->data->id, $interval, Helper::config('currency'));
        }

        //Create the checkout session
        $stripeSession = $this->checkout($plan, $stripePlanQuery->data, $amount, $coupon, $taxRates, $interval, Helper::config('currency'));

        return redirect($stripeSession->data->url);
    }

    public function handleToken(Request $request, $token, $amount)
    {
        // $stripeAmount = in_array(Helper::config('currency'), config('currencies.zero_decimals')) ? $amount : ($amount*100);
        
        $perTokenPrice = $amount/$token*100;
            $checkout_session = $this->stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => Helper::config('currency'),
                    'product_data' => [
                        'name' => 'Token',
                    ],
                        'unit_amount' => $perTokenPrice,
                    ],
                    'quantity' => $token,
                  ]],
            'mode' => 'payment',
            'success_url' => route('prompts_user', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => url('prompts'),
            ]);
        return redirect($checkout_session->url);
    }

    public function cancelSubscription($plan_subscription_id)
    {
        // Attempt to cancel the current subscription
        try {
            $request = $this->stripe->subscriptions->update(
                $plan_subscription_id,
                ['cancel_at_period_end' => true]
            );
            return (object) array('success' => true, 'data' => $request);
        } catch (\Exception $e) {
            return (object) array('success' => false, 'error' => $e->getMessage());
        }
    }

    public function handleWebhook(Request $request)
    {
        // Attempt to validate the Webhook
        try {
            $stripeEvent = \Stripe\Webhook::constructEvent($request->getContent(), $request->server('HTTP_STRIPE_SIGNATURE'), $this->config['webhook_secret']);
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            //Log::info($e->getMessage());

            return response()->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            //Log::info($e->getMessage());

            return response()->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }

        // Get the metadata
        $metadata = $stripeEvent->data->object->lines->data[0]->metadata ?? ($stripeEvent->data->object->metadata ?? null);

        if (isset($metadata->user)) {
            if ($stripeEvent->type != 'customer.subscription.created' && stripos($stripeEvent->type, 'customer.subscription.') !== false) {
                // Provide enough time for the subscription created event to be handled
                sleep(3);
            }

            $user = User::where('id', '=', $metadata->user)->first();
            $user_subscription = UserSubscription::where('user_id', $metadata->user)->first();
            $newPlan = DB::table('subscription_plans')->where('id', $metadata->plan)->first();
            $available_token = $user_subscription->available_token ?? 0;
            if($metadata->interval == 'year'){
                $newToken = $newPlan->yearly_token;
            }else{
                $newToken = $newPlan->monthly_token;
            }
            // If a user was found
            if ($user) {
                if ($stripeEvent->type == 'customer.subscription.created') {
                    // If the user previously had a subscription, attempt to cancel it
                    if ($user_subscription->subscription_id) {
                        $user_subscription->cancelSubscription();
                    }

                    $user_subscription->plan_id = $metadata->plan;
                    $user_subscription->plan_amount = $metadata->amount;
                    $user_subscription->plan_interval = $metadata->interval;
                    $user_subscription->payment_processor = 'stripe';
                    $user_subscription->available_token = $newToken + $available_token;
                    $user_subscription->subscription_id = $stripeEvent->data->object->id;
                    $user_subscription->status = $stripeEvent->data->object->status;
                    $user_subscription->created_at = Carbon::now();
                    $user_subscription->recurring_at = $stripeEvent->data->object->current_period_end ? Carbon::createFromTimestamp($stripeEvent->data->object->current_period_end) : null;
                    $user_subscription->cancelled_at = null;
                    $user_subscription->save();

                    // If a coupon was used
                    if (isset($metadata->coupon) && $metadata->coupon) {
                        $coupon = Coupon::find($metadata->coupon);

                        // If a coupon was found
                        if ($coupon) {
                            // Increase the coupon usage
                            $coupon->increment('quantity_redeemed', 1);
                        }
                    }
                } elseif (stripos($stripeEvent->type, 'customer.subscription.') !== false) {
                    // If the subscription exists
                    if ($user_subscription->payment_processor == 'stripe' && $user_subscription->subscription_id == $stripeEvent->data->object->id) {
                        // Update the recurring date
                        if ($stripeEvent->data->object->current_period_end) {
                            $user_subscription->recurring_at = Carbon::createFromTimestamp($stripeEvent->data->object->current_period_end);
                        }

                        // Update the subscription status
                        if ($stripeEvent->data->object->status) {
                            $user_subscription->status = $stripeEvent->data->object->status;
                        }

                        // Update the subscription end date
                        if ($stripeEvent->data->object->cancel_at_period_end) {
                            $user_subscription->cancelled_at = Carbon::createFromTimestamp($stripeEvent->data->object->current_period_end);
                        } elseif ($stripeEvent->data->object->cancel_at) {
                            $user_subscription->cancelled_at = Carbon::createFromTimestamp($stripeEvent->data->object->cancel_at);
                        } elseif ($stripeEvent->data->object->canceled_at) {
                            $user_subscription->cancelled_at = Carbon::createFromTimestamp($stripeEvent->data->object->canceled_at);
                        } else {
                            $user_subscription->cancelled_at = null;
                        }

                        // Reset the subscription recurring date
                        if (!empty($user_subscription->cancelled_at)) {
                            $user_subscription->recurring_at = null;
                        }

                        $user_subscription->save();
                    }
                } elseif ($stripeEvent->type == 'invoice.paid') {
                    // Make sure the invoice contains the payment id
                    if ($stripeEvent->data->object->charge) {
                        // If the payment does not exist
                        if (!BillingHistory::where([['processor', '=', 'stripe'], ['payment_id', '=', $stripeEvent->data->object->charge]])->exists()) {
                            $payment = BillingHistory::create([
                                'user_id' => $user->id,
                                'plan_id' => $metadata->plan,
                                'payment_id' => $stripeEvent->data->object->charge,
                                'processor' => 'stripe',
                                'amount' => $metadata->amount,
                                'currency' => $metadata->currency,
                                'interval' => $metadata->interval,
                                'status' => 'completed',
                                'coupon' => $metadata->coupon ?? null,
                                'tax_rates' => $metadata->tax_rates ?? null,
                                'customer' => $user->billing_information,
                                'billing_date' => date('Y-m-d H:i:s')
                            ]);

                            // Attempt to send the payment confirmation email
                            /*try {
                                Mail::to($user->email)->locale($user->locale)->send(new PaymentMail($payment));
                            }
                            catch (\Exception $e) {}*/
                        }
                    } else {
                        return response()->json([
                            'status' => 400
                        ], 400);
                    }
                }
            }
        }

        return response()->json([
            'status' => 200
        ], 200);
    }
}