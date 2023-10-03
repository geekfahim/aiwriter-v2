<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Hash;
use Helper;
use Session;
use Socialite;
use Validator;

class FrontendController extends BaseController
{
    public function index(Request $request){
        $name = 'home';
        $page = DB::table('pages')->where('name', $name)->first();
        //Check if content is available
        if(!isset($page->content)){
            $default_content = view('frontend.defaults.'.$name)->render();
            $update = DB::table('pages')
                ->where('name', $name)
                ->update([
                    'content' => $default_content
                ]);
        }

        $data['page'] = DB::table('pages')->where('name', $name)->first();
        $data['reviews'] = Review::where('status', 'active')->get();
        $data['page_title'] = __('Home');
        return view('frontend.main', $data);
    }

    public function pricing(Request $request){
        $data['page_title'] = 'Pricing';
        $data['plans'] = SubscriptionPlan::where('status', 'active')->orderBy('monthly_price', 'asc')->get();

        return view('frontend.pricing', $data);
    }

    public function terms(Request $request){
        $name = 'terms';
        $page = DB::table('pages')->where('name', $name)->first();

        //Check if content is available
        if(!isset($page->content)){
            $default_content = view('frontend.defaults.'.$name)->render();

            $update = DB::table('pages')
                ->where('name', $name)
                ->update([
                    'content' => $default_content
                ]);
        }

        $data['page'] = DB::table('pages')->where('name', $name)->first();
        $data['page_title'] = __('Terms & Conditions');

        return view('frontend.terms', $data);
    }

    public function privacy(Request $request){
        $name = 'policy';
        $page = DB::table('pages')->where('name', $name)->first();

        //Check if content is available
        if(!isset($page->content)){
            $default_content = view('frontend.defaults.'.$name)->render();

            $update = DB::table('pages')
                ->where('name', $name)
                ->update([
                    'content' => $default_content
                ]);
        }

        $data['page'] = DB::table('pages')->where('name', $name)->first();
        $data['page_title'] = __('Privacy Policy');

        return view('frontend.policy', $data);
    }

    public function contact(Request $request){
        if ($request->isMethod('get')){
            $data['page_title'] = __('Contact Us');

            return view('frontend.contact', $data);
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'details' => 'required',
            ]);

            if ($validator->passes()) {
                if(Helper::config('recaptcha_active') == 1){
                    $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');

                    if ($score <= 0.5) {
                        $validator->getMessageBag()->add('g-recaptcha-response', __('Your credentials are incorrect!'));
                        return response()->json(['success' => false, 'error' => $validator->messages()->get('*')]);
                    }
                }

                $user = (object) array(
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                );

                $contact = (object) array(
                    'details' => $request->details,
                    'sendTo' => $request->email,
                );

                Helper::sendEmailToUser('Contact Us - Customer', $user, $contact);

                $admincontact = (object) array(
                    'details' => $request->details,
                    'sendTo' => Helper::config('email'),
                );

                Helper::sendEmailToUser('Contact Us - Admin', $user, $admincontact);

                return response()->json(['success' => true, 'redirect' => url('contact-us'), 'message' => __('We\'ve received your enquiry!')]);
            }

            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }
    }
//@todo
    public function customPrompt()
    {
//        $name = 'policy';
//        $page = DB::table('pages')->where('name', $name)->first();
//        dd($page);
//        $data['page'] = DB::table('pages')->where('name', $name)->first();
//        $data['page_title'] = __('Privacy Policy');
        return view('frontend.custom_prompt_service');
    }

    public function aiWriter()
    {
        return view('frontend.ai_writer');
    }
}
