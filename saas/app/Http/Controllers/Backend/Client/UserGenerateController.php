<?php

namespace App\Http\Controllers\Backend\Client;

use App\Http\Controllers\Controller;
use App\Models\GeneratedAudio;
use App\Models\GenerateImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserGenerateController extends Controller
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

        return view('client.backend.generate.all-images', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.backend.generate.create');
    }

    /**
     * Display a listing of the resource.
     */
    public function allGeneratedAudiosByUser()
    {
        $id = Auth::user()->id;
        $audios = GeneratedAudio::where('user_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        return view('client.backend.generate.all-audios', compact('audios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createAudio()
    {
        return view('client.backend.generate.create-audio');
    }
}
