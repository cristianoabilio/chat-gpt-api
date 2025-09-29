<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::latest()->get();

        return view('admin.backend.plan.all', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.backend.plan.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'monthly_word_limit' => 'required|numeric',
            'price' => 'required',
            'template' => 'required',
        ]);

        Plan::create([
            'name' => $request->name,
            'monthly_word_limit' => $request->monthly_word_limit,
            'price' => $request->price,
            'template' => $request->template,
        ]);

        $notification = [
            'type' => 'success',
            'message' => 'Plan added successfully.'
        ];

        return redirect()->route('admin.plans.all')->with($notification);


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
        $plan = Plan::find($id);
        return view('admin.backend.plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required',
            'monthly_word_limit' => 'required|numeric',
            'price' => 'required',
            'template' => 'required',
        ]);

        Plan::find($request->id)->update([
            'name' => $request->name,
            'monthly_word_limit' => $request->monthly_word_limit,
            'price' => $request->price,
            'template' => $request->template,
        ]);

        $notification = [
            'type' => 'success',
            'message' => 'Plan updated successfully.'
        ];

        return redirect()->route('admin.plans.all')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Plan::find($id)->delete();

        $notification = [
            'type' => 'success',
            'message' => 'Plan deleted successfully.'
        ];

        return redirect()->route('admin.plans.all')->with($notification);
    }
}
