<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Models\ProjectTemplate;
use App\Models\ProjectTemplateCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Validator;

class CategoryController extends BaseController
{
    public function index()
    {
        $data['rows'] = ProjectTemplateCategory::where('deleted', 0)->paginate(10);
        return view('admin.settings.prompt-categories.list', $data);
    }
    public function show()
    {
        $data['rows'] = ProjectTemplateCategory::where('deleted', 0)->paginate(10);
        return view('admin.settings.prompt-categories.category-list', $data);
    }
    public function create(Request $request)
    {
       if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
            ]);
    
            if ($validator->passes()) {
                $category = new ProjectTemplateCategory();
                $category->category_name = $request->name;

                if($category->save()){
                    return response()->json([
                        'success' => true,
                        'redirect' => route('list_cat')
                    ]);
                    
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
            $data['category'] = ProjectTemplateCategory::where('id', $id)->first();
            return view('admin.settings.prompt-categories.edit', $data);
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
            ]);
    
            if ($validator->passes()) {
                $category = ProjectTemplateCategory::find($id);
                if (!$category) {
                    return response()->json(['success' => false, 'message' => __('Category not found')]);
                }
                $category->category_name = $request->name;

                if($category->save()){
                    return response()->json(['success' => true, 'message'=> __('Category created successfully')]);
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
            $data['category'] = ProjectTemplateCategory::where('deleted', 0)->where('id', $id)->first();
            $data['categories'] = ProjectTemplateCategory::where('deleted', 0)->where('id','!=', $id)->get();
            return view('admin.settings.prompt-categories.delete', $data);
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'category' => 'required',
            ]);

            if ($validator->passes()) {
                $category = ProjectTemplateCategory::findOrFail($id);
                if (!$category) {
                    return response()->json(['success' => false, 'message' => __('Category not found')]);
                }

                $category->deleted = 1;
                $category->save();
                if($category->save()){
                    //Change all templates to selected category
                    ProjectTemplate::where('category', $id)->update([
                        'category' => $request->category
                    ]);

                    return response()->json(['success' => true, 'message'=> __('Category deleted successfully.')]);
                } else {
                    return response()->json(['success' => true, 'message'=> __('Something went wrong. Please refresh the page and try again!')]);
                }
            }

            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }
    }
}