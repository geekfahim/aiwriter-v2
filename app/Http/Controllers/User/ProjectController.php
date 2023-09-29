<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Models\AudioContent;
use App\Models\ImageContent;
use App\Models\Project;
use App\Models\ProjectContent;
use App\Models\ProjectTemplate;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use GuzzleHttp\Client;
use Helper;
use Session;
use Validator;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\Shared\ZipArchive;
use App\Http\Controllers\User\DashboardController;

class ProjectController extends BaseController
{
    public function __construct()
    {
        $api = DB::table('integrations')->where('name', 'Open AI')
            ->first();
        $this->api = unserialize($api->data);
    }

    public function search(Request $request){
        $query = $request->input('query');
        
        $data['projects'] = Project::where('type', '=', 'content')
            ->where('deleted', '=', '0')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        
        if ($request->isMethod('post')){
            return view('user.project.table', $data);
        } else if ($request->isMethod('get')){
            return view('user.project.index', $data);
        }
    }

    public function create(Request $request, $template){
        if($request->isMethod('get')){
            $userSubscription= userSubscription::where('user_id', auth()->user()->id)->first();
            $data['plan'] = SubscriptionPlan::where('id', $userSubscription->plan_id)->first();
            $data['template'] = ProjectTemplate::where('id', $template)->first();
            $data['userSubscription'] = $userSubscription;
            return view('user.templates.create', $data);
        } elseif($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
            ]);

            if ($validator->passes()) {
                $userSubscription = userSubscription::where('user_id', auth()->user()->id)->first();
                $plan = SubscriptionPlan::where('id', $userSubscription->plan_id)->first();
                if($plan->monthly_price > 0 || $plan->yearly_price > 0){
                    $plan = 'paid';
                }else{
                    $plan = 'free';
                }
                if($plan == 'paid'){
                    if($userSubscription->available_token > 0){
                        $userSubscription->available_token=$userSubscription->available_token-1;
                        $userSubscription->save();
                    }else{
                        
                    }
                }

                $query = Project::create([
                    'user_id' => auth()->user()->id,
                    'type' => 'content',
                    'name' => $request->name,
                    'template_id' => $template,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                if($query){
                    return response()->json(['success' => true,'redirectUrl'=>url('project/'.$query->uuid)]);
                } else {
                    return response()->json(['success' => false,'message'=>__('Something wrong happened. Please refresh the page and try again!')]);
                }
            }
            return response()->json(['success' => false, 'message' => 'Correct the errors below!', 'errors'=>$validator->messages()->get('*')]);
        }
    }

    public function view(Request $request, $uuid){
        $project = Project::with('category')->where('user_id', auth()->user()->id)
            ->where('uuid', $uuid)
            ->where('user_id', auth()->user()->id)
            ->first();

        if($project){
            $data['project'] = $project;
            if($project->type == 'content'){
                $data['generate'] = Helper::generate_more_words();
                $data['contents'] = ProjectContent::where('project_id', $project->id)
                    ->where('deleted', 0)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $data['saved_count'] = ProjectContent::where('project_id', $project->id)
                    ->where('deleted', 0)
                    ->where('is_saved', 1)
                    ->count();

                return view('user.project.edit', $data);
            } else if($project->type == 'image'){
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

                return view('user.image.edit', $data);
            } else if($project->type == 'audio'){
                $project = Project::where('uuid', $uuid)->firstOrFail();
                $data['project'] = $project;
                $data['audio'] = AudioContent::where('document_id', $project->id)
                    ->where('deleted_at', null)
                    ->orderBy('created_at', 'desc')
                    ->first();

                return view('user.speech.edit', $data);
            } 
        } else {
            return redirect('dashboard');
        }
    }

    public function update_project(Request $request, $uuid){
        $project = Project::where('uuid', $uuid)->firstOrFail();
        if($request->has('name')){
            $project->name = $request->input('name');
        }

        if($request->has('fields')){
            $metadata = $project->metadata == NULL ? array() : json_decode($project->metadata, true);
            foreach($request->input('fields') as $key => $value){
                if (array_key_exists($key, $metadata)) {
                    $metadata[$key] = $value;
                } else {
                    $metadata[$key] = $value;
                }
            }
            $project->metadata = json_encode($metadata);
        }
        
        $project->save();

        return response()->json(['success' => true]);
    }

    public function generate_content(Request $request, $uuid)
    {   
        $project = Project::where('uuid', $uuid)->firstOrFail();
        $template = ProjectTemplate::where('id', $project->template_id)->first();
        $fields = json_decode($template->metadata, true);

        if(Helper::generate_more_words()){
            $sentence = '';
            foreach ($fields as $key => $field){
                $description = $field['description'];
                $answer = Helper::getArrayKey($key, json_decode($project->metadata, true));
                $sentence .= $description .' '. $answer.'.';
            }

            $tone = Helper::getArrayKey('tone', json_decode($project->metadata, true));
            $language = Helper::getArrayKey('language', json_decode($project->metadata, true));
            $sentence .= ' Use a '.$tone.' tone'.'.';
            $sentence .= ' Write in the following language '.$language.'.';

            $prompt = $sentence;
            $openai_api_key = $this->api['api_key'];
            
            $client = new \GuzzleHttp\Client();
            
            $endpoint = ($this->api['model'] == 'text-davinci-003')
                ? 'completions'
                : 'chat/completions';

            $json = [
                'model' => ($endpoint == 'completions') ? 'text-davinci-003' : 'gpt-3.5-turbo',
                'max_tokens' => 1024,
                'n' => 1,
                'stop' => null,
                'temperature' => 1,
                'presence_penalty' => 2,
                'frequency_penalty' => 1,
            ];

            if ($endpoint == 'completions') {
                $json['prompt'] = $prompt;
            } else {
                $json['messages'] = [['role' => 'user', 'content' => $prompt]];
            }

            $response = $client->post("https://api.openai.com/v1/$endpoint", [
                'headers' => ['Authorization' => 'Bearer ' . $openai_api_key, 'Content-Type' => 'application/json'],
                'json' => $json,
            ]);
            
            $completions = json_decode((string) $response->getBody(), true);

            if($this->api['model'] == 'text-davinci-003'){
                $generated_text = $completions['choices'][0]['text'];
            } else {
                $generated_text = $completions['choices'][0]['message']['content'];
            }
            
            $text_to_count = preg_split('/\s+/', $generated_text);
            ProjectContent::create([
                'user_id' => auth()->user()->id,
                'project_id' => $project->id,
                'content' => $generated_text,
                'word_count' => count($text_to_count),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        $data['generate'] = Helper::generate_more_words();
        $data['contents'] = ProjectContent::where('project_id', $project->id)
            ->where('deleted', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.project.content', $data);
    }

    function update_workspace_content(Request $request, $uuid){
        $project = Project::where('uuid', $uuid)->firstOrFail();
        $project->content = $request->input('content');
        $project->save();

        if($project){
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    function delete_content($id){
        $content = ProjectContent::where('id', $id)
            ->update([
                'deleted' => 1
            ]);

        return response()->json(['success' => true]);
    }

    function save_content($id){
        $content = ProjectContent::where('id', $id)->first();

        if($content->is_saved == 0){
            $content = $content->update([
                'is_saved' => 1
            ]);

            if($content){
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function delete_project(Request $request, $uuid){
        $content = Project::where('uuid', $uuid)
            ->update([
                'deleted' => 1
            ]);

        return response()->json(['success' => true]);
    }

    public function export_project(Request $request, $uuid, $type)
    {   
        $document = Project::with('category')->where('uuid', $uuid)
            ->first();

        Settings::setPdfRendererName(Settings::PDF_RENDERER_TCPDF);
        Settings::setPdfRendererPath(base_path('vendor/tecnickcom/tcpdf/'));

        $content = $document->content;

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $html = Html::addHtml($section, $content);
        
        $filename = str_replace(' ', '_', $document->name);

        if($type == 'word'){
            $phpWord->save(storage_path('app/documents/' . $filename . '.docx'), 'Word2007');
            return response()->download(storage_path('app/documents/' . $filename . '.docx'));
        } else {
            $phpWord->save(storage_path('app/documents/' . $filename . '.pdf'), 'PDF');
            return response()->download(storage_path('app/documents/' . $filename . '.pdf'));
        }
    }
}