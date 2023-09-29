<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Models\BillingHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;

class DashboardController extends BaseController{
    public function index(){
        $rows = User::all()->where('role', '!=', 'customer')->where('status', '!=', 'deleted');
        if(DB::table('projects')->count() > 0){
            $data['topTemplates'] = DB::table('projects')
                ->select('template_id', DB::raw('MAX(project_templates.name) as name'), DB::raw('count(*) as total'))
                ->join('project_templates', 'projects.template_id', '=', 'project_templates.id')
                ->groupBy('template_id')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();
        } else {
            $data['topTemplates'] = array();
        }

        $data['customersTotal'] = DB::table('users')->where('role', 'customer')->count();
        $data['subscriptionsTotal'] = DB::table('user_subscriptions')->where('status', 'active')->count();
        $data['contentTotal'] = DB::table('project_contents')->sum('word_count');
        $data['billingTotal'] = BillingHistory::whereIn('status', ['Paid', 'Completed'])->sum('amount');

        return view('admin.dashboard', $data);
    }
}