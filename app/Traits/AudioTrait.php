<?php

namespace App\Traits;

use App\Models\AudioContent;
use App\Models\Project;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait AudioTrait
{
    public function storeAudio(Request $request, $result, $duration, $Uuid, $filename)
    {
        $project = Project::where('uuid', $Uuid)->firstOrFail();

        $project->name = $request->input('name');
        $project->user_id = $request->user()->id;
        $metadata = $project->metadata == NULL ? array() : json_decode($project->metadata, true);
        foreach($request->input('fields') as $key => $value){
            if (array_key_exists($key, $metadata)) {
                $metadata[$key] = $value;
            } else {
                $metadata[$key] = $value;
            }
        }
        $project->metadata = json_encode($metadata);
        $project->created_at = date('Y-m-d H:i:s');
        $project->updated_at = date('Y-m-d H:i:s');
        $project->save();

        $audioContent = new AudioContent;
        $audioContent->document_id = $project->id;
        $audioContent->file = $filename;
        $audioContent->seconds = $duration;
        $audioContent->text = $result['text'];
        $audioContent->created_at = date('Y-m-d H:i:s');
        $audioContent->updated_at = date('Y-m-d H:i:s');
        $audioContent->save();

        return $audioContent;
    }

    public function fetchAudio(Request $request, $filename)
    {
        $openai_api_key = $this->api['api_key'];
        $url = $request->input('fields.mode') == 'transcribe' ? 'https://api.openai.com/v1/audio/transcriptions' : 'https://api.openai.com/v1/audio/translations';
        $filepath = public_path('uploads/audio') . '/' . $filename;
        
        // Create a new cURL resource
        $ch = curl_init();

        // Set the cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'file' => new \CURLFile($filepath),
                'model' => 'whisper-1',
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $openai_api_key,
                'Content-Type: multipart/form-data',
            ],
            CURLOPT_RETURNTRANSFER => true,
        ]);

        // Execute the request and capture the response
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            throw new Exception("cURL error: $error_message");
        }

        // Close the cURL resource
        curl_close($ch);

        //dd($response);
        $response_json = json_decode($response, true);

        return $response_json;
    }
}
