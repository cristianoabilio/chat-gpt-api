<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneratedAudio;
use App\Models\GenerateImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use OpenAI\Laravel\Facades\OpenAI;

class GenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::user()->id;
        $images = GenerateImage::orderBy('id', 'desc')
            ->get();

        return view('admin.backend.generate.all-images', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.backend.generate.generate-image');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $prompt = $request->input('prompt');

        /// Step 1: Generate image using OpenAI
        $response = OpenAI::images()->create([
            'model' => 'dall-e-3',
            'prompt' => $prompt,
            'n' => 1,
            'size' => '1024x1024',
            'quality' => 'standard'
        ]);

        $imageUrl = $response->data[0]->url;

        // Step 2: Download the image
        $imageContents = file_get_contents($imageUrl);
        $fileName = 'generated_' . time() . '_' . Str::random(6) . '.png';
        $destinationPath = public_path('upload/generated_image');

        /// Step 3: Ensure the directory exists
        if (! File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Step 4: Save image to public folder
        file_put_contents($destinationPath . '/' . $fileName, $imageContents);

        GenerateImage::create([
            'user_id' => Auth::id(),
            'prompt' => $prompt,
            'image_path' => 'upload/generated_image/' . $fileName,
        ]);

        return response()->json([
            'status' => 'success',
            'image_local_path' => asset('upload/generated_image/' . $fileName),
            'message' => 'Image generated and saved successfully',
        ]);
    }

    public function createAudio()
    {
        return view('admin.backend.generate.generate-audio');
    }

    /**
     * Display a listing of the resource.
     */
    public function allGeneratedAudios()
    {
        $id = Auth::user()->id;
        $audios = GeneratedAudio::orderBy('id', 'desc')
            ->get();

        return view('admin.backend.generate.all-audios', compact('audios'));
    }

    /**
     * Display the specified resource.
     */
    public function storeAudio(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $text = $request->input('prompt');

        /// Step 1: Generate image using OpenAI
        $response = OpenAI::audio()->speech([
            'model' => 'tts-1',
            'input' => $text,
            'voice' => 'nova',
            'response_format' => 'mp3',
        ]);
        // Step 2: Download the image

        $fileName = 'tts_' . time() . '_' . Str::random(5) . '.mp3';
        $savePath = public_path('upload/generated_audio/');

        /// Step 3: Ensure the directory exists
        if (!File::exists($savePath)) {
            File::makeDirectory($savePath, 0755, true);
        }

        // Step 4: Save image to public folder
        file_put_contents($savePath . $fileName, $response);

        $audio = GeneratedAudio::create([
            'user_id' => Auth::id(),
            'prompt' => $text,
            'audio_path' => 'upload/generated_audio/' . $fileName,
        ]);

        return response()->json([
            'status' => 'success',
            'audio_url' => asset('upload/generated_audio/'.$fileName),
            'message' => 'Audio generated and saved successfully',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
