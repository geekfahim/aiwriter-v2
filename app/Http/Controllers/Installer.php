<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Models\UserSubscription;
use Helper;
use Session;
use Validator;

class Installer extends Controller
{
    public function checkConnectDatabase(Request $request){
        $connection = $request->input('database_connection');
        config([
            'database' => [
                'default' => $connection."_check",
                'connections' => [
                    $connection."_check" => [
                        'driver' => $connection,
                        'host' => $request->input('database_hostname'),
                        'port' => $request->input('database_port'),
                        'database' => $request->input('database_name'),
                        'username' => $request->input('database_username'),
                        'password' => $request->input('database_password'),
                    ],
                ],
            ],
        ]);
        try {
            DB::connection()->getPdo();
            $check = DB::table('information_schema.tables')->where("table_schema","performance_schema")->get();
            if(empty($check) and $check->count() == 0){
                return response()->json(['success' => false,'message'=>__("Access denied for user!. Please check your configuration.")]);
            }
            if(DB::connection()->getDatabaseName()){
                return response()->json(['success' => true,'message'=>__("Yes! Successfully connected to the DB: ".DB::connection()->getDatabaseName())]);
            }else{
                return response()->json(['success' => false,'message'=>__("Could not find the database. Please check your configuration.")]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message'=>$e->getMessage()]);
        }
    }
}