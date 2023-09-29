<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; 
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Hash;
use Helper;
use League\ISO3166\ISO3166;
use Session;
use Socialite;
use Validator;
use Carbon\Carbon;
class AuthController extends BaseController
{
    public function index(Request $request){
        return view('dashboard');
    }

    public function login(Request $request){
        if ($request->isMethod('get')){
            $data['facebook_active'] = DB::table('integrations')->where('name', 'Facebook')->first()->status;
            $data['google_active'] = DB::table('integrations')->where('name', 'Google')->first()->status;

            return view('user.login', $data);
        } else if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),[
                'email' => 'required|exists:users,email',
                'password' => 'required',
            ]);
    
            if ($validator->passes()) {
                if(Helper::config('recaptcha_active') == 1){
                    $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'login');

                    if ($score <= 0.5) {
                        $validator->getMessageBag()->add('g-recaptcha-response', __('Your credentials are incorrect!'));
                        return response()->json(['success' => false, 'error' => $validator->messages()->get('*')]);
                    }
                }

                $user = User::where('email', $request->email)->where('role', 'customer')->first();
                if($user){
                    if (Hash::check($request->password, $user->password)) {
                        if($user->status == 'deleted'){
                            $validator->getMessageBag()->add('email', __('Your account has been deactivated!'));
                            return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
                        } else {
                            Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password]);
                            return response()->json(['success' => true, 'redirect'=>url('dashboard')]);
                        }
                    } else {
                        $validator->getMessageBag()->add('email', __('Your credentials are incorrect!'));
                        return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
                    }
                } else {
                    $validator->getMessageBag()->add('email', __('Your credentials are incorrect!'));
                    return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
                }
            }
            return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
        }
    }

    public function signup(Request $request){
        if ($request->isMethod('get')){

            $data['facebook_active'] = DB::table('integrations')->where('name', 'Facebook')->first()->status;
            $data['google_active'] = DB::table('integrations')->where('name', 'Google')->first()->status;
            $iso = new ISO3166;
            $data['countries'] = $iso->all();
            $subscription_plans = SubscriptionPlan::all()->where('status', '=', 'active');
            return view('user.signup',$data,compact('subscription_plans'));
        } else if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),[
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,NULL,id,role,customer',
                'password' => 'required|min:8',
                'country' => 'required',
            ]);
    
            if ($validator->passes()) {
                if(Helper::config('recaptcha_active') == 1){
                    $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'signup');

                    if ($score <= 0.5) {
                        $validator->getMessageBag()->add('g-recaptcha-response', __('Your credentials are incorrect!'));
                        return response()->json(['success' => false, 'error' => $validator->messages()->get('*')]);
                    }
                }

                try {
                    DB::transaction(function () use ($request) {
                        $user = User::create([
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'email' => $request->email,
                            'password' => bcrypt($request->password),
                            'role' => 'customer',
                            'country' => $request->country,
                        ]);

                        $plan = SubscriptionPlan::all()->where('id',$request->subscription_plan_id)->first();
                        // Create Subscription
                       // Insert a new row into the "user_subscriptions" table with the user's ID and the ID of the subscription plan they have chosen
                       $subscriptionType = $request->subscription_type;
                       $recurringDays = ($subscriptionType == "month") ? 30 : 7;
                       
                       $user_subscription = UserSubscription::create([
                           'user_id' => $user->id,
                           'plan_id' => $request->subscription_plan_id,
                           'available_token' => $plan->trial_token,
                           'created_at' => null,
                           'recurring_at' => null,
                           'status' => 'inactive',
                       ]);

                        Helper::sendEmailToUser('Registration', $user);

                        if(Helper::config('verify_email') == 1){
                            Helper::sendEmailToUser('Verify Email', $user);
                        }
                    });
                    Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password]);
                    return response()->json(['success' => true, 'redirect'=>url('dashboard')]);
                } catch (QueryException $e) {
                    return response()->json(['message' => 'Failed to create user']);
                }
            }
            return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
        }
    }

    public function get_price(Request $request, $id)
    {
        if($request->period == 'month'){
            $amount = SubscriptionPlan::find($id)->monthly_price;
        } else if($request->period == 'year') {
            $amount = SubscriptionPlan::find($id)->yearly_price;
        }

        return response()->json(['success' => true, 'amount'=> $amount]);
    }
    public function makeGoogleDriver()
    {
        $metadata = DB::table('integrations')->where('name', 'Google')->first();
        $metadata = unserialize($metadata->data);
        $app_id = $metadata !== false ? isset($metadata['client_id']) ?  $metadata['client_id'] : '' : '';
        $app_secret = $metadata !== false ? isset($metadata['client_secret']) ? $metadata['client_secret'] : '' : '';

        $config = [
            'client_id' => $app_id,
            'client_secret' => $app_secret,
            'redirect' => url('google/callback'),
        ];

        return Socialite::buildProvider('\Laravel\Socialite\Two\GoogleProvider', $config);
    }

    public function googleLogin(){
        return $this->makeGoogleDriver()->redirect();
    }

    public function googleCallback(){
        $gUser = $this->makeGoogleDriver()->user();
        $finduser = User::where('email', $gUser->email)
            ->where('role', 'customer')
            ->where('status', '!=', 'deleted')
            ->first();

        if ($finduser) {
            User::where('email', $gUser->email)
                ->where('role', 'customer');

            Auth::guard('user')->login($finduser);
            return redirect('dashboard');
        } else {
            //dd($gUser);
            $user = new User();
            $user->first_name = $gUser->user['given_name'];
            $user->last_name = $gUser->user['family_name'];
            $user->email = $gUser->email;
            $user->password = NULL;
            $user->role = 'customer';
            $user->country = NULL;
            $user->save();

            //Create Subscription
            $user_subscription = new UserSubscription();
            $user_subscription->user_id = $user->id;
            $user_subscription->plan_id = null;
            $user_subscription->status = 'inactive';
            $user_subscription->save();

            Auth::guard('user')->login($user, true);
            //Helper::sendEmailToUser('Registration', $user);
            return redirect('dashboard');
        }
    }

    public function makeFacebookDriver()
    {
        $metadata = DB::table('integrations')->where('name', 'Facebook')->first();
        $metadata = unserialize($metadata->data);
        $app_id = $metadata !== false ? isset($metadata['client_id']) ?  $metadata['client_id'] : '' : '';
        $app_secret = $metadata !== false ? isset($metadata['client_secret']) ? $metadata['client_secret'] : '' : '';

        $config = [
            'client_id' => $app_id,
            'client_secret' => $app_secret,
            'redirect' => url('facebook/callback'),
        ];

        return Socialite::buildProvider('\Laravel\Socialite\Two\FacebookProvider', $config);
    }

    public function redirectToFacebook(){
        return $this->makeFacebookDriver()->redirect();
    }

    public function handleFacebookCallback(){
        $gUser = $this->makeFacebookDriver()->fields(['name', 'first_name', 'last_name', 'email', 'gender', 'verified'])->user();
        $finduser = User::where('email', $gUser->email)
            ->where('role', 'customer')
            ->where('status', '!=', 'deleted')
            ->first();

        if ($finduser) {
            User::where('email', $gUser->email)
                ->where('role', 'customer');

            Auth::guard('user')->login($finduser);
            return redirect('dashboard');
        } else {
            //dd($gUser->id);
            $user = new User();
            $user->first_name = $gUser->user['first_name'];
            $user->last_name = $gUser->user['last_name'];
            $user->email = $gUser->email;
            $user->password = NULL;
            $user->role = 'customer';
            $user->country = NULL;
            $user->save();

            //Create Subscription
            $user_subscription = new UserSubscription();
            $user_subscription->user_id = $user->id;
            $user_subscription->plan_id = null;
            $user_subscription->status = 'inactive';
            $user_subscription->save();

            Auth::guard('user')->login($user, true);
            //Helper::sendEmailToUser('Registration', $user);
            return redirect('dashboard');
        }
    }

    public function forgot(Request $request){
        if ($request->isMethod('get')){
            return view('user.forgot');
        } else if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),[
                'email' => 'required|email',
            ]);
    
            if ($validator->passes()) {
                if(Helper::config('recaptcha_active') == 1){
                    $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'forgotPassword');

                    if ($score <= 0.5) {
                        $validator->getMessageBag()->add('g-recaptcha-response', __('Your credentials are incorrect!'));
                        return response()->json(['success' => false, 'error' => $validator->messages()->get('*')]);
                    }
                }

                $user = User::where('email', $request->email)->where('role', 'customer')->where('status', 'active')->first();
                if (!$user) {
                    $validator->getMessageBag()->add('email', __('We could not find a user with that email address.'));
                    return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
                }

                $token = Str::random(60);
                $passwordReset = PasswordReset::updateOrCreate(
                    ['email' => $user->email],
                    ['token' => $token, 'created_at' => now()]
                );

                //Send Link
                Helper::sendEmailToUser('Reset Password', $user);

                return response()->json(['success' => true, 'message' => __('We have emailed you a password reset link!')]);
            }

            return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
        }
    }

    public function resetPassword(Request $request, $token)
    {
        if ($request->isMethod('get')) {
            $tokenValid = DB::table('password_resets')->where('token', $token)->first();
            if (!$tokenValid) {
                return redirect()->route('login')->withErrors(['token' => __('Invalid token')]);
            }
            return view('user.resetPassword', ['token' => $token]);
        } else if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),[
                'password' => 'required|min:8|confirmed',
            ]);
    
            if ($validator->passes()) {
                if(Helper::config('recaptcha_active') == 1){
                    $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'resetPassword');

                    if ($score <= 0.5) {
                        $validator->getMessageBag()->add('g-recaptcha-response', __('Your credentials are incorrect!'));
                        return response()->json(['success' => false, 'error' => $validator->messages()->get('*')]);
                    }
                }

                $user = DB::table('password_resets')->where('token', $token)->first();

                $updateUser = User::where('email', $user->email)
                    ->where('role', 'customer')
                    ->update([
                        'password' => bcrypt($request->password)
                    ]);

                if($updateUser){
                    DB::table('password_resets')->where('token', $token)->delete();
                    Auth::guard('user')->attempt(['email' => $user->email, 'password' => $request->password]);

                    $user = DB::table('users')->where('email', $user->email)->where('role', 'customer')->first();
                    Helper::sendEmailToUser('Password Reset Notification', $user);
                    return response()->json(['success' => true, 'redirect'=>url('dashboard')]);
                } else {
                    return response()->json(['success' => false]);
                }
            }

            return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
        }
    }

    public function logout(){
        Auth::guard('user')->logout();
        Session::flush();
        return redirect('login');
    }
}