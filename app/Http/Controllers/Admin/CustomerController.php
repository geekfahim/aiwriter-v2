<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Models\BillingHistory;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPlansLog;
use App\Models\User;
use App\Models\UserSubscription;
use Helper;
use Session;
use Validator;

class CustomerController extends BaseController
{
    /**
     * Display a listing of customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = User::with('subscription.plan')
            ->where('role', '=', 'customer')
            ->where('status', '!=', 'deleted')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.customers.index', compact('rows'));
    }

    public function search(Request $request){
        $query = $request->input('query');
        
        $data['rows'] = User::with('subscription')
            ->where('role', '=', 'customer')
            ->where('status', '!=', 'deleted')
            ->where(function ($q) use ($query) {
                $q->where('users.first_name', 'like', "%$query%")
                    ->orWhere('users.last_name', 'like', "%$query%")
                    ->orWhere('users.email', 'like', "%$query%")
                    ->orWhereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE '%$query%'");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        if ($request->isMethod('post')){
            return view('admin.customers.table', $data);
        } else if ($request->isMethod('get')){
            return view('admin.customers.index', $data);
        }
    }

    /**
     * Show the form for creating a new customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subscription_plans = SubscriptionPlan::all()->where('status', '=', 'active');
        return view('admin.customers.create', compact('subscription_plans'));
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->where(function ($query) {
                    $query->whereIn('role', ['customer']);
                }),
            ],
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'subscription_type' => 'required',
            'amount' => 'required|numeric',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }

        DB::beginTransaction();

        try {
            $date = Carbon::now();

            if($request->subscription_type == 'monthly'){
                $next_billing_date = $date->addMonths(1);
            } else if($request->subscription_type == 'yearly') {
                $next_billing_date = $date->addYears(1);
            }
            
            // Insert a new row into the "users" table with the customer's personal information
            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            if ($request->has('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->role = 'customer';
            $user->save();

            // Retrieve the ID of the new user
            $user_id = $user->id;
            $subscriptionPlan = SubscriptionPlan::where('id', $request->subscription_plan_id)->first();
            if($request->subscription_type == 'monthly'){
                $token = $subscriptionPlan->monthly_token;
            }else{
                $token = $subscriptionPlan->yearly_token;
            }
            // Insert a new row into the "user_subscriptions" table with the user's ID and the ID of the subscription plan they have chosen
            $user_subscription = UserSubscription::create([
                'user_id' => $user_id,
                'plan_id' => $request->subscription_plan_id,
                'available_token' => $token,
                'created_at' => NULL,
                'recurring_at' => NULL,
                'status' => 'inactive',
            ]);

            DB::commit();

            // Return the user ID to the client
            return response()->json(['success' => true, 'user_id' => $user_id], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('Error creating customer')
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.customers.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($id)->where(function ($query) {
                    $query->whereIn('role', ['admin', 'manager']);
                }),
            ],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }

        $user = User::findOrFail($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json(['success' => true, 'message'=> __('User updated successfully')]);
    }

    /**
     * Delete a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'deleted';
        $user->save();
        return response()->json(['success' => true, 'message'=> __('User deleted successfully.')]);
    }

    /**
     * Deactivate a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'inactive';
        $user->save();
        return response()->json(['success' => true, 'message'=> __('User deactivated successfully.')]);
    }

    /**
     * Activate a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();
        return response()->json(['success' => true, 'message'=> __('User activated successfully.')]);
    }
}