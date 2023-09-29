<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Models\AudioContent;
use App\Models\FavoriteTemplate;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\Project;
use App\Models\ProjectTemplate;
use App\Models\ProjectTemplateCategory;
use App\Models\Review;
use App\Models\User;
use App\Rules\AllowedAudioFormat;
use App\Traits\AudioTrait;
use Helper;
use Session;
use Validator;
use FFMpeg;

class AudioController extends BaseController
{
    use AudioTrait;

    public function __construct()
    {
        $api = DB::table('integrations')->where('name', 'Open AI')->first();
        $this->api = unserialize($api->data);
    }

    public function index(Request $request){
        $data['projects'] = Project::where('user_id', auth()->user()->id)
            ->orderBy('updated_at', 'desc')
            ->where('type', 'audio')
            ->where('deleted', 0)
            ->paginate(10);
        $data['plans'] = SubscriptionPlan::where('status', 'active')->get();
        $data['alltemplates'] = DB::table('project_templates')->get();
        $data['review'] = Review::where('status', 'active')->orderBy('id', 'asc')->first();
        $data['templates'] = ProjectTemplate::where('status', 'active')->where('deleted', 0)->limit('2')->get();
        $data['subscription'] = userSubscription::where('user_id', auth()->user()->id)->first();
        $data['seconds_count'] = DB::table('audio_contents')
                ->join('projects', 'projects.id', '=', 'audio_contents.document_id')
                ->where('projects.user_id', auth()->user()->id)
                ->sum('audio_contents.seconds');

        return view('user.speech.index', $data);
    }

    public function search(Request $request){
        $query = $request->input('query');
        
        $data['projects'] = Project::where('type', '=', 'audio')
            ->where('deleted', '=', '0')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        
        if ($request->isMethod('post')){
            return view('user.speech.table', $data);
        } else if ($request->isMethod('get')){
            return view('user.speech.index', $data);
        }
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if ($validator->passes()) {
            $query = Project::create([
                'user_id' => auth()->user()->id,
                'type' => 'audio',
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
        $project = Project::where('uuid', $uuid)->firstOrFail();
        $data['project'] = $project;
        $data['audio'] = AudioContent::where('document_id', $project->id)
            ->where('deleted_at', null)
            ->orderBy('created_at', 'desc')
            ->first();

        return response()->json(['success' => true, 'view' => view('user.speech.view', $data)->render()]);
    }

    public function update_project(Request $request, $uuid)
    {
        $project = Project::where('uuid', $uuid)->firstOrFail();
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'fields.mode' => 'required',
            'audio_file' => [
                'required',
                'file',
                new AllowedAudioFormat(['mp3', 'mp4', 'mpeg', 'mpga', 'm4a', 'wav', 'webm']),
            ],
        ]);

        if ($validator->passes()) {
            $file = $request->file('audio_file');
            $filename = $file->hashName();

            // Check if the file exists
            if (file_exists(public_path('uploads/audio/' . $filename))) {
                unlink(public_path('uploads/audio/' . $filename));
            }

            // Save the file
            $file->move(public_path('uploads/audio'), $filename);

            //Read audio duration
            $audio = FFMpeg::fromDisk('public')->open('uploads/audio/' . $filename);
            $duration = $audio->getDurationInSeconds(); // in seconds

            //Fetch transcript
            $audioText = $this->fetchAudio($request, $filename);
            $response = $this->storeAudio($request, $audioText, $duration, $uuid, $filename);

            //View data
            $project = Project::where('uuid', $uuid)->firstOrFail();
            $data['project'] = $project;
            $data['audio'] = AudioContent::where('document_id', $project->id)
                ->where('deleted_at', null)
                ->first();

            return response()->json(['success' => true, 'message' => 'Your audio has been transcribed successfully!', 'view' => view('user.speech.view', $data)->render()]);
        }

        return response()->json(['success' => false, 'message' => 'Correct the errors below!', 'errors'=>$validator->messages()->get('*')]);
    }
}