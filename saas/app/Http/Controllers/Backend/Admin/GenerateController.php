<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
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
        $images = GenerateImage::where('user_id', $id)
            ->orderBy('id', 'desc')
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
