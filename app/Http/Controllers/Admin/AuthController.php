<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule; 
use App\Models\PasswordReset;
use App\Models\User;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Hash;
use Helper;
use Session;
use Socialite;
use Validator;

class AuthController extends BaseController{
    public function login(Request $request){
        if ($request->isMethod('get')){
            return view('admin.login');
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

                $user = User::where('email', $request->email)->where('role', 'admin')->first();
                if($user){
                    if (Hash::check($request->password, $user->password)) {
                        if($user->status == 'deleted'){
                            $validator->getMessageBag()->add('email', __('Your account has been deactivated!'));
                            return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
                        } else {
                            Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]);
                            return response()->json(['success' => true, 'redirect'=>route('admin.dashboard')]);
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

    public function forgot(Request $request){
        if ($request->isMethod('get')){
            return view('admin.forgot');
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

                $user = User::where('email', $request->email)->where('role', '!=', 'customer')->where('status', 'active')->first();
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
                return redirect()->route('admin.login')->withErrors(['token' => __('Invalid token')]);
            }
            return view('admin.resetPassword', ['token' => $token]);
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
                    ->where('role', '!=', 'customer')
                    ->update([
                        'password' => bcrypt($request->password)
                    ]);

                if($updateUser){
                    DB::table('password_resets')->where('token', $token)->delete();
                    Auth::guard('admin')->attempt(['email' => $user->email, 'password' => $request->password]);
                    return response()->json(['success' => true, 'redirect'=>route('admin.dashboard')]);
                } else {
                    return response()->json(['success' => false]);
                }
            }

            return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        Session::flush();
        return redirect('admin/login');
    }
}