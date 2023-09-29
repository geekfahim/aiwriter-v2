<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use Helper;
use Session;
use Validator;

class SubscriptionController extends BaseController
{
    public function index(Request $request){
        $data['rows'] = UserSubscription::with('user','plan')
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.subscriptions.index', $data);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $data['rows'] = UserSubscription::with('user', 'plan')
            ->join('users', 'users.id', '=', 'user_subscriptions.user_id')
            ->where(function ($q) use ($query) {
                $q->where('users.first_name', 'like', "%$query%")
                    ->orWhere('users.last_name', 'like', "%$query%")
                    ->orWhere('users.email', 'like', "%$query%")
                    ->orWhereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE '%$query%'");
            })
            ->orderBy('user_subscriptions.subscription_id', 'desc')
            ->paginate(10);
        
        if ($request->isMethod('post')){
            return view('admin.subscriptions.table', $data);
        } else if ($request->isMethod('get')){
            return view('admin.subscriptions.index', $data);
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('get')){
            $data['plans'] = SubscriptionPlan::where('status', 'active')->get();
            $data['subscription'] = UserSubscription::where('user_id', $id)->first();
            
            return view('admin.subscriptions.edit', $data);
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'start_date' => 'required',
                'end_date' => 'required',
                'plan' => 'required',
                'status' => 'required',
                'billing_period' => 'required'
            ]);

            if ($validator->passes()) {
                UserSubscription::where('user_id', $id)->update([
                    'plan_id' => $request->plan,
                    'created_at' => $request->start_date,
                    'recurring_at' => $request->end_date,
                    'status' => $request->status,
                    'plan_interval' => $request->billing_period,
                    'available_token' => $request->token
                ]);

                return response()->json(['success' => true, 'message'=> __('Subscription updated successfully')]);
            }
            return response()->json(['success' => false,'error'=>$validator->messages()->get('*')]);
        }
    }
}