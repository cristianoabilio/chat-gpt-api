<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatAssistant;
use App\Models\ChatConversation;
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

    public function chatAssistant($assistantId)
    {
        $assistant = ChatAssistant::findOrFail($assistantId);
        $messages = collect();

        $conversations = ChatConversation::where('chat_conversations.assistant_id', $assistantId)
            ->where('chat_conversations.user_id', Auth::id())
            ->select('latest.conversation_id', 'latest.id', 'latest.created_at', 'latest.message')
            ->join('chat_conversations as latest', function($join) {
                $join->on('latest.conversation_id', '=', 'chat_conversations.conversation_id')
                    ->whereColumn('latest.id', '=', \DB::raw('(
                            SELECT
                                MAX(id)
                            FROM chat_conversations as sub
                                WHERE sub.conversation_id = chat_conversations.conversation_id)')
                    );
            })
            ->groupBy('latest.conversation_id', 'latest.id', 'latest.created_at', 'latest.message')
            ->orderBy('latest.created_at')
            ->get()
            ->map(function($chat) {
                $chat->message_count = ChatConversation::where('conversation_id', $chat->conversation_id ?? $chat->id)
                    ->count();

                return $chat;
            });

        $selectedConversation = $conversations->first();

        if ($selectedConversation) {
            $messages = ChatConversation::where('assistant_id', $assistantId)
                ->where('user_id', Auth::id())
                ->where('conversation_id', $selectedConversation->conversation_id ?? $selectedConversation->id)
                ->orderBy('created_at', 'ASC')
                ->get();
        }

        return view('admin.backend.assistant.chat_assistant', compact('assistant', 'conversations', 'messages', 'selectedConversation'));
    }

    public function send(Request $request, $assistantId)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $assistant = ChatAssistant::findOrFail($assistantId);
        $userMessage = $request->message;

        $latestConversation = ChatConversation::where('user_id', Auth::id())
            ->where('assistant_id', $assistantId)
            ->first();

        $conversationId = $latestConversation ? $latestConversation->conversation_id ?? $latestConversation->id : null;

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => $assistant->instructions],
                ['role' => 'user', 'content' => $userMessage]
            ]
        ]);

        $aiResponse = $response->choices[0]->message->content;

        $conversation = ChatConversation::create([
            'user_id' => Auth::id(),
            'assistant_id' => $assistantId,
            'conversation_id' => $conversationId ?? null,
            'message' => $userMessage,
            'response' => $aiResponse,
        ]);

        if (! $conversationId) {
            $conversation->update([
                'conversation_id' => $conversation->id
            ]);
        }

        return redirect()->route('chat-assistant.chat', ['assistantId' => $assistantId]);

    }

    public function newConversation($assistantId)
    {
        $assistant = ChatAssistant::findOrFail($assistantId);
        $newConversation = ChatConversation::create([
            'user_id' => Auth::id(),
            'assistant_id' => $assistantId,
            'conversation_id' => null,
            'message' => 'New conversation started',
            'response' => $assistant->welcome_message,
        ]);

        $newConversation->conversation_id = $newConversation->id;
        $newConversation->save();

        return redirect()->route('chat-assistant.chat', ['assistantId' => $assistantId]);
    }

    public function SelectedConversation($assistantId, $conversationId)
    {
        $assistant = ChatAssistant::findOrFail($assistantId);
        $messages = collect();

        $conversations = ChatConversation::where('chat_conversations.assistant_id', $assistantId)
            ->where('chat_conversations.user_id', Auth::id())
            ->select('latest.conversation_id', 'latest.id', 'latest.created_at', 'latest.message')
            ->join('chat_conversations as latest', function($join) {
                $join->on('latest.conversation_id', '=', 'chat_conversations.conversation_id')
                    ->whereColumn('latest.id', '=', \DB::raw('(
                            SELECT
                                MAX(id)
                            FROM chat_conversations as sub
                                WHERE sub.conversation_id = chat_conversations.conversation_id)')
                    );
            })
            ->groupBy('latest.conversation_id', 'latest.id', 'latest.created_at', 'latest.message')
            ->orderBy('latest.created_at')
            ->get()
            ->map(function($chat) {
                $chat->message_count = ChatConversation::where('conversation_id', $chat->conversation_id ?? $chat->id)
                    ->count();

                return $chat;
            });

        $selectedConversation = ChatConversation::where('conversation_id', $conversationId)
            ->where('assistant_id', $assistantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $messages = ChatConversation::where('assistant_id', $assistantId)
            ->where('user_id', Auth::id())
            ->where('conversation_id', $selectedConversation->conversation_id ?? $selectedConversation->id)
            ->orderBy('created_at', 'asc')
            ->get();


        return view('admin.backend.assistant.chat_assistant', compact('assistant', 'conversations', 'messages', 'selectedConversation'));
    }
    private function deletePhoto(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/avatar/' . $oldPhotoPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
