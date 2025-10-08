<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\GenerateContent;
use App\Models\Template;
use App\Models\TemplateInputFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Template::latest()->get();

        return view('admin.backend.template.all', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.backend.template.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'prompt' => 'required|string',
            'is_active' => 'required|in:0,1',
            'input_fields' => 'required|array|size:1',
            'input_fields.*.title' => 'required|string|max:255',
            'input_fields.*.description' => 'required|string',
            'input_fields.*.type' => 'required|in:text,textarea',
        ]);

        $template = new Template();
        $template->title = $request->title;
        $template->description = $request->description;
        $template->category = $request->category;
        $template->prompt = $request->prompt;
        $template->is_active = $request->is_active;
        $template->icon = $request->icon;
        $template->created_by = Auth::id();
        $template->save();

        $inputFields = $request->input_fields[0];
        TemplateInputFields::create([
            'template_id' => $template->id,
            'title' => $inputFields['title'],
            'description' => $inputFields['description'],
            'type' => $inputFields['type'],
            'is_required' => true,
            'order' => 0,
        ]);

        $notification = [
            'type' => 'success',
            'message' => 'Template added successfully.'
        ];

        return redirect()->route('admin.template')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $template = Template::with('inputFields')->findOrFail($id);

        $inputFields = data_get($template, 'inputFields.0');

        $user = Auth::user();

        ds($user);

        return view('admin.backend.template.show', compact('template', 'inputFields', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = Template::with('inputFields')->findOrFail($id);

        $inputFields = data_get($template, 'inputFields.0');

        return view('admin.backend.template.edit', compact('template', 'inputFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'prompt' => 'required|string',
            'is_active' => 'required|in:0,1',
            'input_fields' => 'required|array|size:1',
            'input_fields.*.title' => 'required|string|max:255',
            'input_fields.*.description' => 'required|string',
            'input_fields.*.type' => 'required|in:text,textarea',
        ]);

        $template = Template::find($request->id);
        $template->title = $request->title;
        $template->description = $request->description;
        $template->category = $request->category;
        $template->prompt = $request->prompt;
        $template->is_active = $request->is_active;
        $template->icon = $request->icon;
        $template->created_by = Auth::id();
        $template->save();

        $inputFields = $request->input_fields[0];
        $templateInputField = TemplateInputFields::whereTemplateId($template->id)->first();

        if ($templateInputField) {
            $templateInputField->template_id = $template->id;
            $templateInputField->title = $inputFields['title'];
            $templateInputField->description = $inputFields['description'];
            $templateInputField->type = $inputFields['type'];
            $templateInputField->is_required = true;
            $templateInputField->order = 0;
            $templateInputField->save();
        }

        $notification = [
            'type' => 'success',
            'message' => 'Template updated successfully.'
        ];

        return redirect()->route('admin.template')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
        ds($inputData);

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

        ds($prompt);

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
