<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\GenerateContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = GenerateContent::latest()->get();

        return view('admin.backend.document.all', compact('documents'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $document = GenerateContent::findOrFail($id);

        return view('admin.backend.document.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

        return redirect()->route('admin.documents.all')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        GenerateContent::find($id)->delete();

        $notification = [
            'type' => 'success',
            'message' => 'Document deleted successfully.'
        ];

        return redirect()->back()->with($notification);
    }
}
