<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::latest()->get();

        return view('admin.backend.questions.all_questions', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.backend.questions.add_question');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Question::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $notification = [
            'type' => 'success',
            'message' => 'Question added successfully.'
        ];

        return redirect()->route('all.questions')->with($notification);
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
        $question = Question::find($id);
        return view('admin.backend.questions.edit_questions', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Question::find($request->id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $notification = [
            'type' => 'success',
            'message' => 'Question updated successfully.'
        ];

        return redirect()->route('all.questions')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Question::find($id)->delete();

        $notification = [
            'type' => 'success',
            'message' => 'Question deleted successfully.'
        ];

        return redirect()->route('all.questions')->with($notification);
    }
}
