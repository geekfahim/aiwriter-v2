<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Models\ProjectTemplate;
use App\Models\ProjectTemplateCategory;
use App\Models\SubCategory;

use App\Models\ChatContent;

use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Validator;
use Session;

use Illuminate\Support\Facades\File;

class PromptTemplateController extends BaseController
{
    public function index()
    {
                //$data['chats'] = chatContent::where('user_id', auth()->user()->id)->get();
        $chats = array();
        //Get previous chat id
        $chat_id = !empty(chatContent::max('chat_id')) ? chatContent::max('chat_id') + 1 : 1;
        Session::put('chat_id', $chat_id);
        
        
        
        
        $data['rows'] = ProjectTemplate::where('deleted', 0)->orderBy('id','DESC')->paginate(10);
        $categories = ProjectTemplateCategory::where('deleted',0)->get();
        $subcategories = SubCategory::where('is_deleted',0)->get();
        $SubscriptionPlan = SubscriptionPlan::where('status', '!=', 'deleted')
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.settings.prompts.list', compact('data', 'categories', 'subcategories','SubscriptionPlan','chats'));
    }
    
    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('category_id');

        $subcategories = SubCategory::where('category_id', $categoryId)->where('is_deleted',0)->get();

        return response()->json(['subcategories' => $subcategories]);
    }

    public function show_prompt()
    {
        $data['rows'] = ProjectTemplate::where('deleted', 0)->orderBy('id', 'desc')->paginate(10);
        return view('admin.settings.prompts.prompt-list', $data);
    }
    
    public function import_prompt()
    {
        $data['rows'] = ProjectTemplate::where('deleted', 0)->orderBy('id', 'desc')->paginate(10);
        return view('admin.settings.prompts.import-prompt', $data);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get')){
            $data['categories'] = ProjectTemplateCategory::get();
            return view('admin.settings.prompts.create', $data);
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'main_description' => 'required',
                'category' => 'required',
                'status' => 'required',
                'plan' => 'required',
                'type' => 'required|array|min:1',
                'type.*' => 'required|string|distinct|min:1',
                'title' => 'required|array|min:1',
                'title.*' => 'required|string|distinct|min:1',
                'description' => 'required|array|min:1',
                'description.*' => 'required|string|distinct|min:1'
            ]);
    
            if ($validator->passes()) {
                $template = new ProjectTemplate();
                $template->name = $request->name;
                $template->category = $request->category;
                $template->plan_id = $request->plan;
                $template->subcategory = $request->subcategory;
                $template->description = $request->main_description;
                $template->status = $request->status;
                $data = array();
                $titles = $request->title;
                
                foreach ($titles as $index => $title) {
                    $data['field_'.$index + 1] = array(
                        'type' => $request->type[$index],
                        'title' => $title,
                        'description' => $request->description[$index],
                        'placeholder' => $request->placeholder[$index]
                    );
                }

                $template->metadata = json_encode($data);
                if($template->save()){
                    return response()->json([
                        'success' => true,
                        'redirect' => route('show_prompt')
                    ]);
                    
                
                } else {
                    return response()->json(['success' => false, 'message'=> __('Something went wrong. Please refresh the page and try again!')]);
                }
            }

            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }
    }
    
    public function bulk_create(Request $request)
    {
        $file = $request->file('excel_file');
        $path = $file->getRealPath();
    
        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);
        $status = [];
    
        while (($row = fgetcsv($handle)) !== false) {
            if (count($header) === count($row)) { // Check if header and row have the same number of columns
                $rowData = [];
                foreach ($header as $index => $columnName) {
                    $cleanColumnName = ltrim($columnName, "\xEF\xBB\xBF"); // Remove BOM character if present
                    $rowData[$cleanColumnName] = $row[$index];
                }
                if (array_key_exists('Template Name', $rowData) 
                    && array_key_exists('Description', $rowData)
                    && array_key_exists('Status', $rowData)
                    && array_key_exists('Input Title', $rowData)
                    && array_key_exists('Field Type', $rowData)
                    && array_key_exists('AI Prompt', $rowData)
                    && array_key_exists('Field Placeholder', $rowData)
                ) {
                    // Check if the rowData array contains the key 'name'
                    $template = new ProjectTemplate(); // Create a new instance of your model
                    $template->name = $rowData['Template Name'];
                    $template->category = 1;
                    $template->description = $rowData['Description'];
                    $template->status = $rowData['Status'];
                    
                    $data = array();
                    
                    $data['field_1'] = array(
                        'type' => $rowData['Field Type'],
                        'title' => $rowData['Input Title'],
                        'description' => $rowData['AI Prompt'],
                        'placeholder' => $rowData['Field Placeholder']
                    );
                    
                    $template->metadata = json_encode($data);
                    if(($rowData['Field Type']=='input' || $rowData['Field Type']=='textarea') && $rowData['Status']=='active' || $rowData['Status']=='inactive'){
                        $template->save(); 
                        $status = [
                            "success"=>true,
                            "message"=>"Data Inserted Successfully"
                        ];
                    }else{
                        
                        $status = [
                            "success"=>false,
                            "message"=>"Please Check Something is wrong!"
                        ];
                    }
                    
                }else{
                    $status = [
                        "success"=>false,
                        "message"=>"Field Does not match please check coumn name."
                        ];
                        break;
                }
            }
        }
        fclose($handle);
    
        return response()->json(["status"=>$status]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get')){
            $data['prompt'] = ProjectTemplate::where('id', $id)->first();
            $data['categories'] = ProjectTemplateCategory::where('deleted',0)->get();
            $data['subcategories'] = SubCategory::where('is_deleted',0)->get();
            $data['plans'] = SubscriptionPlan::where('status', '!=', 'deleted')->get();
            return view('admin.settings.prompts.edit', $data);
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'main_description' => 'required',
                'category' => 'required',
                'status' => 'required',
                'type' => 'required|array|min:1',
                'type.*' => 'required|string|distinct|min:1',
                'title' => 'required|array|min:1',
                'title.*' => 'required|string|distinct|min:1',
                'description' => 'required|array|min:1',
                'description.*' => 'required|string|distinct|min:1'
            ]);
    
            if ($validator->passes()) {
                $template = ProjectTemplate::find($id);
                if (!$template) {
                    return response()->json(['success' => false, 'message' => __('Template not found')]);
                }

                $template->name = $request->name;
                $template->category = $request->category;
                $template->subcategory = $request->subcategory;
                $template->description = $request->main_description;
                $template->status = $request->status;
                $template->plan_id = $request->plan;
                $data = array();
                $titles = $request->title;
                
                foreach ($titles as $index => $title) {
                    $data['field_'.$index + 1] = array(
                        'type' => $request->type[$index],
                        'title' => $title,
                        'description' => $request->description[$index],
                        'placeholder' => $request->placeholder[$index]
                    );
                }
                
                $template->metadata = json_encode($data);
                if($template->save()){
                    return response()->json(['success' => true, 'message'=> __('Template created successfully')]);
                } else {
                    return response()->json(['success' => false, 'message'=> __('Something went wrong. Please refresh the page and try again!')]);
                }
            }

            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }
    }

    public function bulk_delete(Request $request)
    {
        $data = $request->all();
        if ($data['id'] > 0) {
            foreach ($data['id'] as $value) {
                $this->delete($value);
            }
        }
        return response()->json([
            "success" => true,
            "message" => __('Template deleted successfully.'),
            // "data" => $data['id']
        ]);
    }


    public function delete($id)
    {
        $template = ProjectTemplate::findOrFail($id);

        if($template){
            $template->deleted = 1;
            $template->save();
            return response()->json(['success' => true, 'message'=> __('Template deleted successfully.')]);
        } else {
            return response()->json(['success' => true, 'message'=> __('Something went wrong. Please refresh the page and try again!')]);
        }
    }
  
       

    public function search(Request $request)
{
    $output = '';
    $query = $request->get('query');

    if ($query != '') {
        $data = ProjectTemplate::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')->where('deleted', 0)
            ->orWhereHas('category_new', function ($categoryQuery) use ($query) {
                $categoryQuery->where('category_name', 'like', '%' . $query . '%');
            })->with('category_new','subCategory')
            ->get();
            
    } else {
        $data = '';
    }

    return response()->json($data);
}

    


    
        

}