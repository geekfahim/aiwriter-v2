<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\Http\Controllers\Controller as BaseController;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Validator;

class SubscriptionPlanController extends BaseController
{
    /**
     * Display a listing of the subscription plans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = SubscriptionPlan::where('status', '!=', 'deleted')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.settings.subscription-plans.index', compact('rows'));
    }

    /**
     * Show the form for creating a new subscription plan.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.subscription-plans.create');
    }

    /**
    * Store a newly created subscription plan in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function plan_check(){
        $plan = SubscriptionPlan::where('monthly_price',0)->where('yearly_price',0);
        if($plan){
            return response()->json([
                "success"=>true,
                "message"=>"FREE PLAN ALREADY EXIST! YOU CAN EDIT THEM."
                ]);
        }else{
            return response()->json([
                "success"=>false,
                "message"=>"FREE PLAN DOES NOT EXIST!"
                ]);
        }
    }
     
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'monthly_price' => 'required|numeric',
            'yearly_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }

        $plan = new SubscriptionPlan();
        $plan->name = $request->input('name');
        $plan->description = $request->input('description');
        $plan->monthly_price = $request->input('monthly_price');
        $plan->yearly_price = $request->input('yearly_price');
        $plan->words = $request->input('words');
        $plan->minutes = $request->input('minutes');
        $plan->image_count = $request->input('image_count');
        $plan->file_size = $request->input('file_size');
        $plan->allow_export = $request->input('allow_export') ? 1 : 0;
        $plan->allow_copy = $request->input('allow_copy') ? 1 : 0;
        $plan->max_prompt = $request->input('max_prompt');
        $plan->yearly_token = $request->input('yearly_token');
        $plan->monthly_token = $request->input('monthly_token');
        $plan->trial_token = $request->input('trial_token');
        $plan->editional_token_price = $request->input('editional_token_price');
        $plan->yearly_access = $request->input('max_promt_timeline') ? 1 : 0;
        $plan->status = 1;
        $plan->save();

        return response()->json(['success' => true, 'message'=> __('Plan created successfully')]);
    }

    /**
     * Show the form for editing the specified subscription plan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = SubscriptionPlan::find($id);
        return view('admin.settings.subscription-plans.edit', compact('plan'));
    }

    /**
     * Update the specified subscription plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPlan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required',
            'monthly_price' => 'required|numeric',
            'yearly_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }

        $plan = SubscriptionPlan::findOrFail($id);
        $plan->name = $request->name;
        $plan->description = $request->description;
        $plan->monthly_price = $request->monthly_price;
        $plan->yearly_price = $request->yearly_price;
        $plan->words = $request->words;
        $plan->minutes = $request->minutes;
        $plan->image_count = $request->image_count;
        $plan->file_size = $request->file_size;
        $plan->allow_export = $request->allow_export ? 1 : 0;
        $plan->allow_copy = $request->allow_copy ? 1 : 0;
        $plan->yearly_token = $request->input('yearly_token');
        $plan->monthly_token = $request->input('monthly_token');
        $plan->trial_token = $request->input('trial_token');
        $plan->max_prompt = $request->input('max_prompt');
        $plan->editional_token_price = $request->input('editional_token_price');
        $plan->yearly_access = $request->input('max_promt_timeline') ? 1 : 0;
        $plan->save();

        return response()->json(['success' => true, 'message'=> __('Plan updated successfully')]);
    }

    public function popularize($id)
    {
        DB::table('settings')
        ->updateOrInsert([
            'key' => 'popular_plan'
        ],[
            'value' => $id,
        ]);

        return response()->json(['success' => true, 'message'=> __('Subscription plan marked as popular successfully.')]);
    }

    /**
     * Delete a subscription plan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->status = 'deleted';
        $plan->save();
        return response()->json(['success' => true, 'message'=> __('Subscription plan deleted successfully.')]);
    }

    /**
     * Deactivate a subscription plan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->status = 'inactive';
        $plan->save();
        return response()->json(['success' => true, 'message'=> __('Subscription plan deactivated successfully.')]);
    }

    /**
     * Activate a subscription plan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->status = 'active';
        $plan->save();
        return response()->json(['success' => true, 'message'=> __('Subscription plan activated successfully.')]);
    }

    /**
     * Get subscription amount.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_price(Request $request, $id)
    {
        if($request->period == 'month'){
            $amount = SubscriptionPlan::find($id)->monthly_price;
        } else if($request->period == 'year') {
            $amount = SubscriptionPlan::find($id)->yearly_price;
        }

        return response()->json(['success' => true, 'amount'=> $amount]);
    }
}
