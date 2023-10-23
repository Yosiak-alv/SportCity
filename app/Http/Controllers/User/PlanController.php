<?php

namespace App\Http\Controllers\User;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //NO
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Suscriptions/Plans/CreateEditPlan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|gt:0',
        ]);
        $plan = Plan::create($attr);
        return redirect()->route('plans.show', $plan->id)->with([
            'level' => 'success',
            'message' => 'Plan Created Succesfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return Inertia::render('User/Suscriptions/Plans/Show',['plan'=> $plan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return Inertia::render('User/Suscriptions/Plans/CreateEditPlan',['plan'=> $plan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|gt:0',
        ]);
        $plan->update($attr);
        return redirect()->route('plans.show', $plan->id)->with([
            'level' => 'success',
            'message' => 'Plan Updated Succesfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('suscriptions.index')->with([
            'level' => 'success',
            'message' => 'Plan Deleted Succesfully!'
        ]);
    }
}
