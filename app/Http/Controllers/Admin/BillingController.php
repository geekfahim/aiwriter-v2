<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Models\BillingHistory;
use App\Models\UserSubscription;
use Helper;
use Session;
use Validator;

class BillingController extends BaseController
{
    public function index(Request $request){
        $data['rows'] = DB::table('billing_histories')
            ->join('users', 'users.id', '=', 'billing_histories.user_id')
            ->select('*', 'billing_histories.status as billing_status')
            ->orderBy('billing_date', 'desc')
            ->paginate(10);

        return view('admin.billing.main', $data);
    }

    public function search(Request $request){
        $query = $request->input('query');
        
        $data['rows'] = DB::table('billing_histories')
            ->join('user_subscriptions', 'user_subscriptions.subscription_id', '=', 'billing_histories.subscription_id')
            ->join('users', 'users.id', '=', 'user_subscriptions.user_id')
            ->where(function ($q) use ($query) {
                $q->where('users.first_name', 'like', "%$query%")
                    ->orWhere('users.last_name', 'like', "%$query%")
                    ->orWhere('users.email', 'like', "%$query%")
                    ->orWhereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE '%$query%'");
            })
            ->select('*', 'billing_histories.status as billing_status')
            ->orderBy('billing_date', 'desc')
            ->paginate(10);
        
        if ($request->isMethod('post')){
            return view('admin.billing.table', $data);
        } else if ($request->isMethod('get')){
            return view('admin.billing.main', $data);
        }
    }
}