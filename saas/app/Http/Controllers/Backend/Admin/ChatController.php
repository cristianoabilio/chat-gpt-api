<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatAssistant;
use App\Models\GenerateContent;
use App\Models\Template;
use App\Models\TemplateInputFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function index()
    {
        $assistants = ChatAssistant::latest()->get();

        return view('admin.backend.assistant.all_assistant', compact('assistants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.backend.assistant.add_assistant');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role_description' => 'required',
            'welcome_message' => 'required',
            'category' => 'required',
        ]);
        $chatAssistant = new ChatAssistant();
        $chatAssistant->name = $request->name;
        $chatAssistant->role_description = $request->role_description;
        $chatAssistant->welcome_message = $request->welcome_message;
        $chatAssistant->category = $request->category;
        $chatAssistant->instructions = $request->instructions;
        $chatAssistant->is_active = $request->is_active ?? 0;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/avatar/'), $fileName);
            $chatAssistant->avatar = $fileName;
        }
        $chatAssistant->save();

        $notification = [
            'type' => 'success',
            'message' => 'Chat Assistant added successfully.'
        ];

        return redirect()->route('chat.assistants.all')->with($notification);
    }

    private function deletePhoto(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/avatar/' . $oldPhotoPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
