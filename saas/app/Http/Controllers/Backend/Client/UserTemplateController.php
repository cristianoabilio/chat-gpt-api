<?php

namespace App\Http\Controllers\Backend\Client;

use App\Http\Controllers\Controller;
use App\Models\GenerateContent;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;

class UserTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $plan = $user->plan;
        $templateLimit = $plan ? $plan->templates : 3;


        $templates = Template::latest()->take($templateLimit)->get();

        return view('client.backend.template.all_templates', compact('user', 'plan', 'templates'));
    }

    public function document()
    {
        $id = Auth::user()->id;
        $documents = GenerateContent::where('user_id', $id)->latest()->get();

        return view('client.backend.document.all_documents', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $template = Template::with('inputFields')->findOrFail($id);

        $inputFields = data_get($template, 'inputFields.0');

        $user = Auth::user();

        return view('client.backend.template.show', compact('template', 'inputFields', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function EditUserDocument(string $id)
    {
        ds('aqui');
        $document = GenerateContent::findOrFail($id);
        return view('client.backend.document.edit',compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function UpdateUserDocument(Request $request, string $id)
    {
        $document = GenerateContent::findOrFail($id);

        $validateData = $request->validate([
            'output' => 'required|string'
        ]);

        $document->update([
            'output' => $request->output
        ]);

        $notification = [
            'type' => 'success',
            'message' => 'Document updated successfully.'
        ];

        return redirect()->route('user.document')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function UserDocumentDestroy(string $id)
    {
        GenerateContent::find($id)->delete();

        $notification = [
            'type' => 'success',
            'message' => 'Document deleted successfully.'
        ];

        return redirect()->back()->with($notification);
    }

    public function content(Request $request, string $id)
    {
        $template = Template::with('inputFields')->findOrFail($id);
        $user = auth()->user();

        $request->validate([
            'language' => 'required|string|in:English (USA),Portuguese (pt-br),Spanish',
            'ai_model' => 'required|string|in:gpt-4o-mini,gpt-3.5-turbo',
            'result_length' => 'required|integer|min:50|max:500',
        ]);

        foreach($template->inputFields as $field) {
            $fieldName = str_replace(' ', '_', $field->title);
            $request->validate([
                $fieldName => 'required|string'
            ]);
        }

        $inputData = $request->except(['_token', 'language', 'ai_model', 'result_length']);

        $prompt = $template->prompt;

        foreach ($template->inputFields as $field) {
            $fieldName = str_replace(' ', '_', $field->title);
            $fieldValue = $inputData[$fieldName] ?? '';
            $prompt = str_replace('{' . str_replace(' ', '_', $field->title) . '}', $fieldValue, $prompt);
            $prompt = str_replace('{' . $field->title . '}', $fieldValue, $prompt);
        }

        $prompt = str_replace('{language}', $request->language, $prompt);
        $prompt = str_replace('{result_length}', $request->result_length, $prompt);

        $prompt = 'In ' . $request->language . ', ' . $prompt . ' Aim for approximately ' . $request->result_length . ' words.';

        $estimatedWordCount = $request->result_length;

        if ($user->word_usage + $estimatedWordCount > $user->current_word_usage) {
            return response()->json([
                'success' => false,
                'message' => 'Word limit exceeded'
            ], 400);
        }

        try {
            $response = OpenAI::chat()->create([
                'model' => $request->ai_model,
                'store' => true,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ]
            ]);

            $output = $response->choices[0]->message->content;
            $wordCount = str_word_count($output);

            $user->words_used += $wordCount;
            $user->save();

            GenerateContent::create([
                'user_id' => $user->id,
                'template_id' => $template->id,
                'input' => json_encode($inputData),
                'output' => $output,
                'word_count' => $wordCount,
            ]);

            return response()->json([
                'success' => true,
                'output' => $output
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fail to generate content: ' . $e->getMessage(),
            ], 500);
        }

    }
}
