<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Models\EmailTemplate;
use Helper;
use Session;
use Validator;

class EmailTemplateController extends BaseController
{
    /**
     * Display a listing of email templates.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = EmailTemplate::all();
        return view('admin.settings.templates.index', compact('rows'));
    }

    /**
     * Show the form for editing the email template.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = EmailTemplate::find($id);
        return view('admin.settings.templates.edit', compact('template'));
    }

     /**
     * Update the specified email template in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editTemplate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }

        $template = EmailTemplate::findOrFail($id);
        $template->subject = $request->input('subject');
        $template->body = $request->input('body');
        $template->save();

        return response()->json(['success' => true, 'message'=> __('Email template updated successfully')]);
    }
}