<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\TemplateInputFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //
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
}
