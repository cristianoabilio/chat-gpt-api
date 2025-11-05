<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Heading;
use Illuminate\Http\Request;

class HeadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headings = Heading::latest()->get();

        return view('admin.backend.heading.all_heading', compact('headings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.backend.heading.add_heading');
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

        Heading::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $notification = [
            'type' => 'success',
            'message' => 'Heading added successfully.'
        ];

        return redirect()->route('all.heading')->with($notification);
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
        $heading = Heading::find($id);
        return view('admin.backend.heading.edit_heading', compact('heading'));
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

        Heading::find($request->id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $notification = [
            'type' => 'success',
            'message' => 'Heading updated successfully.'
        ];

        return redirect()->route('all.heading')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Heading::find($id)->delete();

        $notification = [
            'type' => 'success',
            'message' => 'Heading deleted successfully.'
        ];

        return redirect()->route('all.heading')->with($notification);
    }
}
