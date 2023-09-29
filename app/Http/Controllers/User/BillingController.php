<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Models\BillingHistory;
use App\Models\Coupon;
use App\Models\TaxRate;
use App\Models\UserSubscription;
use App\Resolvers\PaymentPlatformResolver;
use CurrencyHelper;
use Helper;
use Session;
use Validator;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\Shared\ZipArchive;

class BillingController extends BaseController
{
    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function index(Request $request){
        return view('user.billing');
    }

    public function view_invoice(Request $request, $id){
        $data['invoice'] = BillingHistory::where('user_id', auth()->user()->id)
            ->where('billing_id', $id)->first();
        return view('user.invoice', $data);
    }

    public function download_invoice($id)
    {   
        Settings::setPdfRendererName(Settings::PDF_RENDERER_TCPDF);
        Settings::setPdfRendererPath(base_path('vendor/tecnickcom/tcpdf/'));

        $invoice = BillingHistory::where('user_id', auth()->user()->id)
            ->where('billing_id', $id)->first();

        $pdf = PDF::loadView('user.invoice', compact('invoice'));
        $filename = Helper::config('billing_invoice_prefix').$invoice->billing_id;

        return $pdf->download($filename . '.pdf');
    }

    public function add_coupon(Request $request, $id, $period){
        if ($request->isMethod('get')){
            $data['period'] = $period;
            $data['planId'] = $id;
            return view('user.settings.pay.coupon', $data);
        } else if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'code' => 'required'
            ]);

            if ($validator->passes()) {
                $coupon = Coupon::where('code', '=', $request->input('code'))->first();

                if(!$coupon){
                    $validator->getMessageBag()->add('code', __('This coupon code is invalid!'));
                } else {
                    if ($coupon && $coupon->quantity <= $coupon->quantity_redeemed && $coupon->quantity != -1) {
                        $validator->getMessageBag()->add('code', __('This coupon code is invalid!'));
                    } else {
                        session()->put('couponCode', $request->input('code'));
                        
                        $data['discount'] = 0;
                        if(session()->has('couponCode')){
                            $data['discount'] = Coupon::where('code', session()->get('couponCode'))->first()->percentage;
                        }
                        $data['period'] = $period;
                        $data['plan'] = DB::table('subscription_plans')->where('id', $id)->first();
                        $data['taxRates'] = TaxRate::where('deleted_at', NULL)->where('status', 'active')->orderBy('type', 'asc')->get();
                        $data['payment_methods'] = DB::table('integrations')->where('type', 'payment')->where('status', 1)->get();
                        $data['inclTaxRatesPercentage'] = $data['taxRates']->where('type', '=', 'inclusive')->sum('percentage');
                        $data['exclTaxRatesPercentage'] = $data['taxRates']->where('type', '=', 'exclusive')->sum('percentage');

                        return response()->json(['success' => true, 'view' => view('user.settings.pay.index', $data)->render()]);
                    }
                }
            }
            return response()->json(['success' => false,'errors'=>$validator->messages()->get('*')]);
        }
    }

    public function remove_coupon(Request $request, $id, $period){
        session()->forget('couponCode');
               
        $data['discount'] = 0;
        if(session()->has('couponCode')){
            $data['discount'] = Coupon::where('code', session()->get('couponCode'))->first()->percentage;
        }
        $data['period'] = $period;
        $data['plan'] = DB::table('subscription_plans')->where('id', $id)->first();
        $data['taxRates'] = TaxRate::where('deleted_at', NULL)->where('status', 'active')->orderBy('type', 'asc')->get();
        $data['payment_methods'] = DB::table('integrations')->where('type', 'payment')->where('status', 1)->get();
        $data['inclTaxRatesPercentage'] = $data['taxRates']->where('type', '=', 'inclusive')->sum('percentage');
        $data['exclTaxRatesPercentage'] = $data['taxRates']->where('type', '=', 'exclusive')->sum('percentage');

        return view('user.settings.pay.index', $data);
    }

    public function pay(Request $request, $id, $period){
        if ($request->isMethod('get')){
            $data['discount'] = 0;
            if(session()->has('couponCode')){
                $data['discount'] = Coupon::where('code', session()->get('couponCode'))->first()->percentage;
            }
            $data['period'] = $period;
            $data['plan'] = DB::table('subscription_plans')->where('id', $id)->first();
            $data['taxRates'] = TaxRate::where('deleted_at', NULL)->where('status', 'active')->orderBy('type', 'asc')->get();
            $data['payment_methods'] = DB::table('integrations')->where('type', 'payment')->where('status', 1)->get();
            $data['inclTaxRatesPercentage'] = $data['taxRates']->where('type', '=', 'inclusive')->sum('percentage');
            $data['exclTaxRatesPercentage'] = $data['taxRates']->where('type', '=', 'exclusive')->sum('percentage');

            return view('user.settings.pay.index', $data);
        } else if ($request->isMethod('post')){
            $plan = DB::table('subscription_plans')->where('id', $id)->first();

            // Get the tax rates
            $taxRates = TaxRate::where('deleted_at', NULL)->where('status', 'active')->get();

            // Sum the inclusive tax rates
            $inclTaxRatesPercentage = $taxRates->where('type', '=', 'inclusive')->sum('percentage');

            // Sum the exclusive tax rates
            $exclTaxRatesPercentage = $taxRates->where('type', '=', 'exclusive')->sum('percentage');

            // Get the coupon
            $coupon = null;
            if(session()->get('couponCode') !== null){
                $coupon = Coupon::where('code', session()->get('couponCode'))->first();
                if ($coupon && $coupon->quantity > $coupon->quantity_redeemed || $coupon->quantity == -1) {
                    $coupon = Coupon::where('code', session()->get('couponCode'))->first();
                }
            }

            // Plan amount
            $plan_amount = $period == 'monthly' ? $plan->monthly_price : $plan->yearly_price;

            // Get the total amount to be charged
            $amount = CurrencyHelper::format_number(CurrencyHelper::checkoutTotal($plan_amount, $coupon != null ? $coupon->percentage : 0, $exclTaxRatesPercentage, $inclTaxRatesPercentage));
            
            //Handle payment checkout
            $paymentPlatform = $this->paymentPlatformResolver->resolveService($request->payment_platform);
            session()->put('paymentPlatformId', $request->payment_platform);

            return $paymentPlatform->handleSubscription($request, $plan, $coupon, $taxRates, $amount, $period == 'monthly' ? 'month' : 'year');
        } 
    }
}