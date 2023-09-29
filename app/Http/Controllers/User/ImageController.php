<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; 
use App\Models\FavoriteTemplate;
use App\Models\ImageContent;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\Project;
use App\Models\ProjectTemplate;
use App\Models\ProjectTemplateCategory;
use App\Models\Review;
use App\Models\User;
use App\Traits\ImageTrait;
use Helper;
use Session;
use Stripe\Stripe;
use Validator;

class ImageController extends BaseController
{
    use ImageTrait;

    public function __construct()
    {
        $api = DB::table('integrations')->where('name', 'Open AI')->first();
        $this->api = unserialize($api->data);
    }

    public function index(Request $request){
        $data['projects'] = Project::where('user_id', auth()->user()->id)
            ->orderBy('updated_at', 'desc')
            ->where('type', 'image')
            ->where('deleted', 0)
            ->paginate(10);
        $data['plans'] = SubscriptionPlan::where('status', 'active')->get();
        $data['alltemplates'] = DB::table('project_templates')->get();
        $data['review'] = Review::where('status', 'active')->orderBy('id', 'asc')->first();
        $data['templates'] = ProjectTemplate::where('status', 'active')->where('deleted', 0)->limit('2')->get();
        $data['subscription'] = userSubscription::where('user_id', auth()->user()->id)->first();
        $data['image_count'] = DB::table('image_contents')
                ->join('projects', 'projects.id', '=', 'image_contents.document_id')
                ->where('projects.user_id', auth()->user()->id)
                ->count();

        return view('user.image.index', $data);
    }

    public function search(Request $request){
        $query = $request->input('query');
        
        $data['projects'] = Project::where('type', '=', 'image')
            ->where('deleted', '=', '0')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        
        if ($request->isMethod('post')){
            return view('user.image.table', $data);
        } else if ($request->isMethod('get')){
            return view('user.image.index', $data);
        }
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if ($validator->passes()) {
            $query = Project::create([
                'user_id' => auth()->user()->id,
                'type' => 'image',
                'name' => $request->name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    
            if($query){
                return response()->json(['success' => true, 'redirectUrl'=>url('project/'.$query->uuid)]);
            } else {
                return response()->json(['success' => false,'message'=>__('Something wrong happened. Please refresh the page and try again!')]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Correct the errors below!', 'errors'=>$validator->messages()->get('*')]);
    }

    public function view($uuid, $id)
    {
        $project = Project::with('category')->where('user_id', auth()->user()->id)
            ->where('uuid', $uuid)
            ->where('user_id', auth()->user()->id)
            ->first();

        $data['project'] = $project;

        $data['imageCount'] = ImageContent::where('document_id', $project->id)
            ->where('deleted_at', null)
            ->count();
        $data['mainImage'] = ImageContent::where('id', $id)
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->first();
        $data['images'] = ImageContent::where('document_id', $project->id)
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->paginate(4);

        return response()->json(['success' => true, 'view' => view('user.image.view', $data)->render()]);
    }

    public function update_project(Request $request, $uuid)
    {
        $project = Project::where('uuid', $uuid)->firstOrFail();
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'fields.description' => 'required',
            'fields.resolution' => 'required',
        ]);

        if ($validator->passes()) {
            $image = $this->fetchImage($request);
            $response = $this->storeImage($request, $image, $uuid);

            $data['project'] = $project;
            $data['imageCount'] = ImageContent::where('document_id', $project->id)
                ->where('deleted_at', null)
                ->count();
            $data['mainImage'] = ImageContent::where('document_id', $project->id)
                ->where('deleted_at', null)
                ->orderBy('id', 'desc')
                ->first();
            $data['images'] = ImageContent::where('document_id', $project->id)
                ->where('deleted_at', null)
                ->orderBy('id', 'desc')
                ->paginate(4);

            return response()->json(['success' => true, 'message' => 'Your image has been generated successfully!', 'view' => view('user.image.view', $data)->render()]);
        }

        return response()->json(['success' => false, 'message' => 'Correct the errors below!', 'errors'=>$validator->messages()->get('*')]);
    }

    public function download($id)
    {
        $image = ImageContent::where('id', $id)->first();
        $path = public_path('uploads/images/' . $image->url);

        if (!file_exists($path)) {
            abort(404);
        }

        $headers = [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename='. $image->url,
        ];
        return response()->download($path, $image->url, $headers);
    }

    public function delete($id)
    {
        $image = ImageContent::where('id', $id)->first();

        $update = ImageContent::where('id', $id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => auth()->user()->id
            ]);

        $project = Project::where('id', $image->document_id)->first();

        $data['project'] = $project;

        $data['imageCount'] = ImageContent::where('document_id', $project->id)
            ->where('deleted_at', null)
            ->count();
        $data['mainImage'] = ImageContent::where('document_id', $project->id)
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->first();
        $data['images'] = ImageContent::where('document_id', $project->id)
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->paginate(4);

        return response()->json(['success' => true, 'view' => view('user.image.view', $data)->render()]);
    }
}