<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Models\FavoriteTemplate;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\Project;
use App\Models\ProjectTemplate;
use App\Models\ProjectTemplateCategory;
use App\Models\Review;
use App\Models\User;
use App\Models\AddToken;
use App\Resolvers\PaymentPlatformResolver;
use Helper;
use Session;
use Validator;
use Stripe;

class DocumentController extends BaseController
{
    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function index(Request $request){
        $data['projects'] = Project::where('user_id', auth()->user()->id)
            ->orderBy('updated_at', 'desc')
            ->where('type', 'content')
            ->where('deleted', 0)
            ->paginate(10);
        $data['plans'] = SubscriptionPlan::where('status', 'active')->get();
        $data['alltemplates'] = DB::table('project_templates')->get();
        $data['review'] = Review::where('status', 'active')->orderBy('id', 'asc')->first();
        $data['categories'] = ProjectTemplateCategory::where('deleted', 0)->get();
        $data['templates'] = ProjectTemplate::where('status', 'active')->where('deleted', 0)->get();
        $data['subscription'] = userSubscription::where('user_id', auth()->user()->id)->first();
        $data['word_count'] = DB::table('project_contents')
                ->where('user_id', auth()->user()->id)
                ->sum('word_count');

        return view('user.project.index', $data);
    }
    
   public function prompts(Request $request)
{
    $stripeInfo = DB::table('integrations')->where('name', 'Stripe')->first();
    $stripeData = unserialize($stripeInfo->data);
    \Stripe\Stripe::setApiKey($stripeData['secret_key']);
    $sessionId = $request->get('session_id');
    if(!empty($sessionId) && !is_null($sessionId)){
        $session = \Stripe\Checkout\Session::retrieve($sessionId);
        
        $stripe = new \Stripe\StripeClient($stripeData['secret_key']);
        $line_items = $stripe->checkout->sessions->allLineItems($sessionId);
        $intent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
        if($intent->status == 'succeeded'){
            $input['user_id'] = auth()->user()->id;
            $input['token'] = $line_items->data[0]->quantity;
            $input['amount'] = $line_items->data[0]->amount_subtotal;
            $input['payment_id'] = $session->payment_intent;
            AddToken::create($input);
            $plan = DB::table('user_subscriptions')->where('user_id', $input['user_id'])->first();
            $token = $input['token'] + $plan->available_token;
            DB::table('user_subscriptions')->where('user_id', $input['user_id'])->update(['available_token' => $token]);
            return redirect(url('prompts'));
        }
    }
    
    $data['projects'] = Project::where('user_id', auth()->user()->id)
        ->orderBy('updated_at', 'desc')
        ->where('type', 'content')
        ->where('deleted', 0)
        ->paginate(10);

    $data['plans'] = SubscriptionPlan::where('status', 'active')->get();
    $data['alltemplates'] = DB::table('project_templates')->get();
    $data['review'] = Review::where('status', 'active')->orderBy('id', 'asc')->first();
    $data['categories'] = ProjectTemplateCategory::where('deleted', 0)->get();

    // $query = ProjectTemplate::join('user_subscriptions', 'user_subscriptions.plan_id', 'project_templates.plan_id')
    //     ->where('project_templates.status', '=', 'active')
    //     ->where('project_templates.deleted', 0);

    $subscription = userSubscription::where('user_id', auth()->user()->id)->first();
    // $data['templates'] = $query->where('user_subscriptions.plan_id', $subscription->plan_id)->paginate(12);

    $query = ProjectTemplate::query();

        $query->join('subscription_plans', 'subscription_plans.id', '=', 'project_templates.plan_id')
            ->select('project_templates.*', 'subscription_plans.id as subscription_id', 'subscription_plans.monthly_price as monthly_price', 'subscription_plans.yearly_price as yearly_price');
            $query->where('plan_id', '=', $subscription->plan_id);
            $data['templates'] = $query->paginate(12);

    if ($this->checkSubscription($subscription->plan_id)) {

        if(Helper::has_active_subscription() == false){
            $data['plan_status'] = 1;
        }else{
            $data['plan_status'] = 0;
        }
        $data['subscription'] = $subscription;
        $data['word_count'] = DB::table('project_contents')
            ->where('user_id', auth()->user()->id)
            ->sum('word_count');
            
        return view('user.prompts', $data);
    } else {
        echo '<div class="col-md-3 mb-3">
                <div class="card card-xs shadow-sm text-start h-100" role="button">
                    <div class="card-body p-4">
                        <h6 class="mb-3 text-capitalize" onclick="upgrade">Upgrade Plan to access Prompt</h6>
                        <button type="button" class="btn btn-dark btn-pointer w-100 pt-2 pb-2" onclick="showModal()" >Select Plan</button>
                    </div>
                </div>
            </div>';
    }
}



    
    public function sort(Request $request)
    {
        $plans = SubscriptionPlan::where('status', 'active')->get();
        $sortValue = $request->input('sortValue');
        $categoryId = $request->input('categoryId');
        $planId = $request->input('planId');
        
        // Retrieve the sorted templates based on the selected sort value and category
        $query = ProjectTemplate::query();
        
        if ($sortValue === '1' || $sortValue === '2') {
            $query->orderBy('name', $sortValue === '1' ? 'asc' : 'desc');
        } elseif ($sortValue === '3') {
            $query->latest();
        }
        
        if ($categoryId != 0) {
            $query->where('category', $categoryId);
        }
        
        
        $query->join('subscription_plans', 'subscription_plans.id', '=', 'project_templates.plan_id')
            ->select('project_templates.*', 'subscription_plans.id as subscription_id', 'subscription_plans.monthly_price as monthly_price', 'subscription_plans.yearly_price as yearly_price');
    
 
        if ($planId == 'collection') {
            $query->join('favorite_templates', 'project_templates.id', '=', 'favorite_templates.template_id')
                ->addSelect('favorite_templates.template_id')->where('favorite_templates.user_id',auth()->user()->id);;
        }else{
            $query->where('plan_id', '=', $planId);
        }
                
        $templates = $query->paginate(12);
        
        if ($this->checkSubscription($planId)) {
            if(Helper::has_active_subscription() == false){
                $plan_status = false;
            }else{
                $plan_status = true;
            }
            return view('user.templates.grid', compact('templates', 'plan_status', 'planId'));
        } else {

            if($planId =='collection'){
                return view('user.templates.grid', compact('templates'));
            }else{
                
               echo '<div class="col-md-3 mb-3">
                        <div class="card card-xs shadow-sm text-start h-100" role="button">
                            <div class="card-body p-4">
                                <h6 class="mb-3 text-capitalize" onclick="upgrade">Upgrade Plan to access Prompt</h6>
                                <button type="button" class="btn btn-dark btn-pointer w-100 pt-2 pb-2" onclick="showModal()" >Select Plan</button>
                            </div>
                        </div>
                    </div>';
            }
        }
    }

    
    public function checkSubscription($planId) {
        $subs = userSubscription::where('user_id', auth()->user()->id)->where('plan_id', $planId)->first();

        // dd($subs);
        
        $freePlan = SubscriptionPlan::where('status', 'active')
        ->where('monthly_price',0)
        ->where('yearly_price',0)
        ->where('id',$planId)->first();
        
        if(!$freePlan){
            if ($subs) {
                return true;
            } else {
                return false;
            }
        }else{
            return true;
        }
    }

    public function addToken(Request $request, $token, $amount) {
        if ($request->isMethod('get')){
            $data['token'] = $token;
            $data['token_amount'] = $amount;
            $data['payment_methods'] = DB::table('integrations')->where('type', 'payment')->where('status', 1)->get();
            return view('user.settings.pay.addToken', $data);
        } else if ($request->isMethod('post')){
            $paymentPlatform = $this->paymentPlatformResolver->resolveService($request->payment_platform);
            session()->put('paymentPlatformId', $request->payment_platform);
            return $paymentPlatform->handleToken($request, $token, $amount);
        }
    }

    public function addTokenDetailsToken(Request $request) {

            \Stripe\Stripe::setApiKey($stripeSecretKey);
            header('Content-Type: application/json');

            $YOUR_DOMAIN = 'http://localhost:4242';

            $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price' => '{{PRICE_ID}}',
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
            ]);

            header("HTTP/1.1 303 See Other");
            header("Location: " . $checkout_session->url);
    }
    public function addTokenDetails(Request $request) {
        try {
            Stripe\Stripe::setApiKey($request->secret_key);
                
            $customer = Stripe\Customer::create(array(
                    "email" => auth()->user()->email,
                    "source" => $request->stripeToken
                ));
    
                $stripePay = Stripe\Charge::create ([
                        "amount" => str_replace(',', '', $request->amount) * 100,
                        "currency" => Helper::config('currency'),
                        "customer" => $customer->id,
                        "description" => $request->token.'purchased by'.auth()->user()->email
                ]);
                dd($stripePay);
            return $stripePay;
        } catch (\Exception $e) {
            
            $stripePay = '';
            info($e);
            
            return $stripePay;
        }

    }

    // public function pay(Request $request, $id, $period){
    //     if ($request->isMethod('get')){
    //         $data['discount'] = 0;
    //         if(session()->has('couponCode')){
    //             $data['discount'] = Coupon::where('code', session()->get('couponCode'))->first()->percentage;
    //         }
    //         $data['period'] = $period;
    //         $data['plan'] = DB::table('subscription_plans')->where('id', $id)->first();
    //         $data['taxRates'] = TaxRate::where('deleted_at', NULL)->where('status', 'active')->orderBy('type', 'asc')->get();
    //         $data['payment_methods'] = DB::table('integrations')->where('type', 'payment')->where('status', 1)->get();
    //         $data['inclTaxRatesPercentage'] = $data['taxRates']->where('type', '=', 'inclusive')->sum('percentage');
    //         $data['exclTaxRatesPercentage'] = $data['taxRates']->where('type', '=', 'exclusive')->sum('percentage');

    //         return view('user.settings.pay.index', $data);
    //     } else if ($request->isMethod('post')){
    //         $plan = DB::table('subscription_plans')->where('id', $id)->first();

    //         // Get the tax rates
    //         $taxRates = TaxRate::where('deleted_at', NULL)->where('status', 'active')->get();

    //         // Sum the inclusive tax rates
    //         $inclTaxRatesPercentage = $taxRates->where('type', '=', 'inclusive')->sum('percentage');

    //         // Sum the exclusive tax rates
    //         $exclTaxRatesPercentage = $taxRates->where('type', '=', 'exclusive')->sum('percentage');

    //         // Get the coupon
    //         $coupon = null;
    //         if(session()->get('couponCode') !== null){
    //             $coupon = Coupon::where('code', session()->get('couponCode'))->first();
    //             if ($coupon && $coupon->quantity > $coupon->quantity_redeemed || $coupon->quantity == -1) {
    //                 $coupon = Coupon::where('code', session()->get('couponCode'))->first();
    //             }
    //         }

    //         // Plan amount
    //         $plan_amount = $period == 'monthly' ? $plan->monthly_price : $plan->yearly_price;

    //         // Get the total amount to be charged
    //         $amount = CurrencyHelper::format_number(CurrencyHelper::checkoutTotal($plan_amount, $coupon != null ? $coupon->percentage : 0, $exclTaxRatesPercentage, $inclTaxRatesPercentage));
            
    //         //Handle payment checkout
    //         $paymentPlatform = $this->paymentPlatformResolver->resolveService($request->payment_platform);
    //         session()->put('paymentPlatformId', $request->payment_platform);

    //         return $paymentPlatform->handleSubscription($request, $plan, $coupon, $taxRates, $amount, $period == 'monthly' ? 'month' : 'year');
    //     } 
    // }
    




// public function filter_bysub(Request $request)
// {
//         // Get the selected subcategories from the AJAX request
//         $selectedSubcategories = $request->input('subcategories');

//         // Perform the filtering of project templates based on the selected subcategories
//         $filteredProjectTemplates = ProjectTemplate::where('subcategory', $selectedSubcategories)->get();
    
//         // Return the filtered project templates as a response (you can modify this as per your requirements)
//         return response()->json([
//             'projectTemplates' => $filteredProjectTemplates,
//         ]);
    
// }
}