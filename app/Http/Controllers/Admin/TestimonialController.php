<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller as BaseController;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Validator;

class TestimonialController extends BaseController
{
    /**
     * Display a listing of administrative users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Review::where('status', 'active')->get();
        return view('admin.settings.testimonials.index', compact('rows'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod('get')){
            return view('admin.settings.testimonials.create');
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'review' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
            }
    
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = $file->hashName();

                // Check if the file exists
                if (file_exists(public_path('uploads/brand/' . $filename))) {
                    unlink(public_path('uploads/brand/' . $filename));
                }

                // Save the file
                $file->move(public_path('uploads/brand'), $filename);
            }

            $insert = Review::insert([
                'name' => $request->name,
                'review' => $request->review,
                'image' => $filename,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if($insert){
                return response()->json(['success' => true, 'message'=> __('Review added successfully')]);
            }
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('get')){
            $review = Review::find($id);
            return view('admin.settings.testimonials.edit', compact('review'));
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'review' => 'required',
                'image' => 'sometimes|file|mimes:jpeg,jpg,png'
            ]);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
            }

            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = $file->hashName();

                // Check if the file exists
                if (file_exists(public_path('uploads/brand/' . $filename))) {
                    unlink(public_path('uploads/brand/' . $filename));
                }

                // Save the file
                $file->move(public_path('uploads/brand'), $filename);
            } else {
                $filename = Review::find($id)->image;
            }
    
            $insert = Review::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'review' => $request->review,
                    'image' => $filename,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
    
            return response()->json(['success' => true, 'message'=> __('Review updated successfully')]);
        }
    }

    public function delete($id)
    {
        $review = Review::findOrFail($id);

        if($review){
            $review->status = 'deleted';
            $review->save();
            return response()->json(['success' => true, 'message'=> __('Review deleted successfully.')]);
        }
    }
}
