<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectTemplate;
use App\Models\ProjectTemplateCategory;
use App\Models\SubCategory;
use Validator;

class SubCategoryController extends Controller
{

    public function list($id)
    {
         $subcategories = SubCategory::where('category_id',$id)->where('is_deleted', 0)->paginate(10);
         return view('admin.settings.prompt-categories.prompt-subcategories.list',compact('subcategories'));

    }
    public function create(Request $request)
    {
        if ($request->isMethod('get')){
            $categories = ProjectTemplateCategory::where('deleted', 0)->get();
            return view('admin.settings.prompt-categories.prompt-subcategories.create',compact('categories'));
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'category_id' => 'required',
            ]);
    
            if ($validator->passes()) {
                $subcategory = new SubCategory();
                $subcategory->name = $request->name;
                $subcategory->category_id = $request->category_id;

                if($subcategory->save()){
                    
                    return response()->json(['success' => true, 'message'=> __('SubCategory Saved Successfully!')]);
                } else {
                    return response()->json(['success' => false, 'message'=> __('Something went wrong. Please refresh the page and try again!')]);
                }
            }

            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }
    }
    
    public function update(Request $request, $id)
    {
        if ($request->isMethod('get')){
            $subcategory = SubCategory::find($id);
            $categories = ProjectTemplateCategory::where('deleted', 0)->get();
            return view('admin.settings.prompt-categories.prompt-subcategories.edit',compact('subcategory','categories'));
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'category_id' => 'required'
            ]);
    
            if ($validator->passes()) {
                $subcategory = SubCategory::find($id);
                if (!$subcategory) {
                    return response()->json(['success' => false, 'message' => __('SubCategory not found')]);
                }
                $subcategory->name = $request->name;
                $subcategory->category_id = $request->category_id;

                if($subcategory->save()){
                    return response()->json(['success' => true, 'message'=> __('SubCategory updated successfully')]);
                } else {
                    return response()->json(['success' => false, 'message'=> __('Something went wrong. Please refresh the page and try again!')]);
                }
            }


            

            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }
    }
    public function delete(Request $request, $id)
    {
        if ($request->isMethod('get')){
            $subcategory = SubCategory::find($id);
            return view('admin.settings.prompt-categories.prompt-subcategories.delete',compact('subcategory'));
        } else if ($request->isMethod('post')){
            
                $subcategory = SubCategory::findOrFail($id);
                if (!$subcategory) {
                    return response()->json(['success' => false, 'message' => __('SubCategory not found')]);
                }

                $subcategory->is_deleted = 1;
                $subcategory->save();
                if($subcategory->save()){
                    return response()->json(['success' => true, 'message'=> __('SubCategory deleted successfully.')]);
                } else {
                    return response()->json(['success' => true, 'message'=> __('Something went wrong. Please refresh the page and try again!')]);
                }

        }
    }
}