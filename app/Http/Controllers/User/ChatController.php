<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Models\ChatContent;
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

class ChatController extends BaseController
{
    public function __construct()
    {
        $api = DB::table('integrations')->where('name', 'Open AI')->first();
        $this->api = unserialize($api->data);
    }

    public function index(Request $request){
        //$data['chats'] = chatContent::where('user_id', auth()->user()->id)->get();
        $data['chats'] = array();
        //Get previous chat id
        $chat_id = !empty(chatContent::max('chat_id')) ? chatContent::max('chat_id') + 1 : 1;
        Session::put('chat_id', $chat_id);
        return view('user.chat.view', $data);
    }

    public function changePersonality(Request $request){
        Session::put('personality', $request->personality);
    }

    public function processMessage(Request $request){
        $validator = Validator::make($request->all(),[
            'message' => 'required',
        ]);

        if ($validator->passes()) {
            $previous_response = chatContent::orderByDesc('id')->where('chat_id', session('chat_id'))->first();
            if($previous_response){
                $last_response = $previous_response->content;
                $personality = session()->has('personality') ? ' reply as an assistant with the following personality: '.session('personality').' Your previous response was'.$last_response.'. You can continue from there.' : '';
            } else {
                $last_response = '';
                $personality = session()->has('personality') ? ' reply as an assistant with the following personality: '.session('personality') : '';
            }
            
            $prompt = $request->message.$personality;
            $openai_api_key = $this->api['api_key'];
            $client = new \GuzzleHttp\Client();
            $json = [
                'model' => ($this->api['model'] == 'text-davinci-003') ? 'text-davinci-003' : 'gpt-3.5-turbo',
                'max_tokens' => 1024,
                'n' => 1,
                'stop' => null,
                'temperature' => 1,
                'presence_penalty' => 2,
                'frequency_penalty' => 1,
            ];

            $json['messages'] = [['role' => 'user', 'content' => $prompt ]];
            $response = $client->post("https://api.openai.com/v1/chat/completions", [
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

            chatContent::create([
                'chat_id' => session('chat_id'),
                'user_id' => auth()->user()->id,
                'prompt' => $prompt,
                'content' => str_replace(['\n', '\r'], ['^', '|'], $generated_text),
                'word_count' => count($text_to_count),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json(['success' => true, 'message' => $generated_text]);
        }
    }
}