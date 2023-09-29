<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use Helper;
use Session;
use Validator;

class SettingController extends BaseController
{
    public function index(Request $request){
        if ($request->isMethod('get')){
            $data['title'] = 'My Profile';
            return view('user.settings.profile', $data);
        } elseif ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,' . auth()->id() . ',id,role,customer',
            ]);
    
            if ($validator->passes()) {
                $errors = [];
                $success = false;
                $user = auth()->user();

                if (!empty($request->old_password) || !empty($request->password) || !empty($request->password_confirmation)) {
                    if (!Hash::check($request->old_password, $user->password)) {
                        $errors['old_password'] = ['Old password is incorrect'];
                        return response()->json(['success' => $success, 'message' => __('Please correct the errors!'), 'errors' => $errors]);
                    }

                    if(empty($request->password)){
                        $errors['password'] = ['Password field is empty'];
                        return response()->json(['success' => $success, 'message' => __('Please correct the errors!'), 'errors' => $errors]);
                    }
                    
                    if ($request->password != $request->password_confirmation) {
                        $errors['password'] = ['Passwords do not match'];
                        return response()->json(['success' => $success, 'message' => __('Please correct the errors!'), 'errors' => $errors]);
                    }

                    $user->password = Hash::make($request->password);
                }

                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->save();

                $success = true;
                return response()->json(['success' => $success, 'message' => __('Profile updated successfully!'), 'errors' => $errors]);
            }

            return response()->json(['success' => false,'errors'=>$validator->messages()->get('*')]);
        }
    }

    public function password(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->passes()) {
            $user = User::where('id', auth()->user()->id)->first();

            if (Hash::check($request->old_password, $user->password)) { 
                User::where('id', auth()->user()->id)
                    ->update([
                        'password' => Hash::make($request->password),
                    ]);

                return response()->json(['success' => true, 'message'=>__('Password updated successfully!')]);
            } else {
                $validator->getMessageBag()->add('old_password', __('Incorrect password'));  
                return response()->json([
                    'success' => false, 
                    'message' => __('Please correct the errors indicated below'), 
                    'error'=>$validator->messages()->get('*')
                ], 200);
            }
        }

        return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
    }

    public function billing(Request $request){
        $data['title'] = 'Billing';
        $data['plans'] = SubscriptionPlan::where('status', 'active')->get();
        $data['subscription'] = UserSubscription::where('user_id', auth()->user()->id)->first();
        $data['invoices'] = DB::table('billing_histories')
            ->where('user_id', auth()->user()->id)
            ->orderBy('billing_date', 'desc')
            ->paginate(10);

        return view('user.settings.billing', $data);
    }
}