<?php

namespace App\Traits;

use App\Models\ImageContent;
use App\Models\Project;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait ImageTrait
{
    public function storeImage(Request $request, $result, $Uuid)
    {
        $project = Project::where('uuid', $Uuid)->firstOrFail();

        $fileName = Str::uuid();
        $httpClient = new \GuzzleHttp\Client();

        $httpClient->request('GET', $result['data'][0]['url'], [
            'sink' => public_path('uploads/images/' . $fileName)
        ]);

        $imageResource = imagecreatefrompng(public_path('uploads/images/' . $fileName));
        $imageFileName = $fileName . '.jpg';

        // Convert and optimize the image
        imagejpeg($imageResource, public_path('uploads/images/' . $imageFileName), 88);

        // Remove the original image
        unlink(public_path('uploads/images/' . $fileName));

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

        $imageContent = new ImageContent;
        $imageContent->document_id = $project->id;
        $imageContent->resolution = $request->input('fields.resolution');
        $imageContent->url = $imageFileName;
        $imageContent->created_at = date('Y-m-d H:i:s');
        $imageContent->updated_at = date('Y-m-d H:i:s');
        $imageContent->save();

        return $imageContent;
    }

    public function fetchImage(Request $request)
    {
        $openai_api_key = $this->api['api_key'];
        $client = new \GuzzleHttp\Client();

        $response = $client->post("https://api.openai.com/v1/images/generations", [
            'headers' => ['Authorization' => 'Bearer ' . $openai_api_key, 'Content-Type' => 'application/json'],
            'json' => [
                'prompt' => trim(preg_replace('/(?:\s{2,}+|[^\S ])/', ' ', $request->input('fields.description'))) . ($request->input('fields.style') ? '. ' . __('The image should have :style style.', ['style' => $request->input('fields.style')]) : '') . ($request->input('fields.medium') ? '. ' . __('The image should be on a :medium medium.', ['medium' => $request->input('fields.medium')]) : '') . ($request->input('fields.filter') ? '. ' . __('Apply :filter filter.', ['filter' => $request->input('fields.filter')]) : ''),
                'n' => $request->has('fields.variations') ? (float) $request->input('fields.variations') : 1,
                'size' => $request->input('fields.resolution'),
                'response_format' => 'url',
                'user' => 'user' . auth()->user()->id
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
