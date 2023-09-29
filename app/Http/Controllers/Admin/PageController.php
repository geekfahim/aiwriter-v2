<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\Http\Controllers\Controller as BaseController;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Validator;

class PageController extends BaseController
{
    public function index()
    {
        $data['rows'] = DB::table('pages')
            ->get();

        return view('admin.settings.pages.index', $data);
    }

    public function reset($id){
        $page = DB::table('pages')->where('id', $id)->first();
        $default_content = view('frontend.defaults.'.$page->name)->render();

        $update = DB::table('pages')
            ->where('id', $id)
            ->update([
                'content' => $default_content
            ]);

        return response()->json(['success' => true, 'message'=> __('Page content reset successfully')]);
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('get')){
            $data['page'] = DB::table('pages')->where('id', $id)->first();

            return view('admin.settings.pages.edit', $data);
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'body' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
            }

            $update = DB::table('pages')
                ->where('id', $id)
                ->update([
                    'content' => $request->body
                ]);


            if($update){
                return response()->json(['success' => true, 'message'=> __('Page edited successfully')]);
            }
        }
    }
}
