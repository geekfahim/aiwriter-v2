<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\Http\Controllers\Controller as BaseController;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Validator;

class CouponController extends BaseController
{
    /**
     * Display a listing of the tax rates.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Coupon::where('deleted_at', '=', NULL)->get();
        return view('admin.settings.coupons.index', compact('rows'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get')){
            return view('admin.settings.coupons.create');
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'code' => 'required|unique:coupons',
                'percentage' => 'required|numeric',
                'quantity' => 'required|numeric',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
            }
    
            $coupon = new Coupon();
            $coupon->name = $request->name;
            $coupon->code = $request->code;
            $coupon->percentage = $request->percentage;
            $coupon->quantity = $request->quantity;
            $coupon->created_at = date('Y-m-d H:i:s');
            $coupon->updated_at = date('Y-m-d H:i:s');
            $coupon->save();
    
            return response()->json(['success' => true, 'message'=> __('Coupon added successfully')]);
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('get')){
            $data['coupon'] = Coupon::where('id', $id)->first();
            return view('admin.settings.coupons.edit', $data);
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'code' => 'required|unique:coupons,code,'.$id,
                'percentage' => 'required|numeric',
                'quantity' => 'required|numeric',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
            }
    
            $coupon = Coupon::findOrFail($id);
            $coupon->name = $request->name;
            $coupon->code = $request->code;
            $coupon->percentage = $request->percentage;
            $coupon->quantity = $request->quantity;
            $coupon->updated_at = date('Y-m-d H:i:s');
            $coupon->save();
    
            return response()->json(['success' => true, 'message'=> __('Coupon updated successfully')]);
        }
    }

    /**
     * Deactivate coupon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = 'inactive';
        $coupon->updated_at = date('Y-m-d H:i:s');
        $coupon->save();
        return response()->json(['success' => true, 'message'=> __('Coupon deactivated successfully.')]);
    }

    /**
     * Activate coupon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = 'active';
        $coupon->updated_at = date('Y-m-d H:i:s');
        $coupon->save();
        return response()->json(['success' => true, 'message'=> __('Coupon activated successfully.')]);
    }

    /**
     * Delete coupon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = 'inactive';
        $coupon->deleted_at = date('Y-m-d H:i:s');
        $coupon->save();
        return response()->json(['success' => true, 'message'=> __('Coupon deleted successfully.')]);
    }
}