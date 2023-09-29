<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\Http\Controllers\Controller as BaseController;
use App\Models\TaxRate;
use Illuminate\Http\Request;
use Validator;

class TaxController extends BaseController
{
    /**
     * Display a listing of the tax rates.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = TaxRate::where('deleted_at', '=', NULL)->get();
        return view('admin.settings.tax-rates.index', compact('rows'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get')){
            return view('admin.settings.tax-rates.create');
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'type' => 'required',
                'percentage' => 'required|numeric',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
            }
    
            $taxrate = new TaxRate();
            $taxrate->name = $request->name;
            $taxrate->type = $request->type;
            $taxrate->percentage = $request->percentage;
            $taxrate->created_at = date('Y-m-d H:i:s');
            $taxrate->updated_at = date('Y-m-d H:i:s');
            $taxrate->save();
    
            return response()->json(['success' => true, 'message'=> __('Tax rate added successfully')]);
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('get')){
            $data['tax'] = TaxRate::where('id', $id)->first();
            return view('admin.settings.tax-rates.edit', $data);
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'type' => 'required',
                'percentage' => 'required|numeric',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
            }
    
            $taxrate = TaxRate::findOrFail($id);
            $taxrate->name = $request->name;
            $taxrate->type = $request->type;
            $taxrate->percentage = $request->percentage;
            $taxrate->updated_at = date('Y-m-d H:i:s');
            $taxrate->save();
    
            return response()->json(['success' => true, 'message'=> __('Tax rate updated successfully')]);
        }
    }

    /**
     * Deactivate tax rate.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $taxrate = TaxRate::findOrFail($id);
        $taxrate->status = 'inactive';
        $taxrate->updated_at = date('Y-m-d H:i:s');
        $taxrate->save();
        return response()->json(['success' => true, 'message'=> __('Tax rate deactivated successfully.')]);
    }

    /**
     * Activate tax rate.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $taxrate = TaxRate::findOrFail($id);
        $taxrate->status = 'active';
        $taxrate->updated_at = date('Y-m-d H:i:s');
        $taxrate->save();
        return response()->json(['success' => true, 'message'=> __('Tax rate activated successfully.')]);
    }

    /**
     * Delete tax rate.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $taxrate = TaxRate::findOrFail($id);
        $taxrate->status = 'inactive';
        $taxrate->deleted_at = date('Y-m-d H:i:s');
        $taxrate->save();
        return response()->json(['success' => true, 'message'=> __('Tax rate deleted successfully.')]);
    }
}