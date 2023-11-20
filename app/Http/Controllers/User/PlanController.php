<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\CreateEditPlanRequest;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
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
    public function store(CreateEditPlanRequest $request)
    {
        $request->validated();
        $plan = Plan::create($request->validatedPlan());
        $plan->details()->createMany($request->validated()['details']);
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
        return Inertia::render('User/Suscriptions/Plans/Show',['plan'=> $plan->load('details')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return Inertia::render('User/Suscriptions/Plans/CreateEditPlan',['plan'=> $plan->load('details')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEditPlanRequest $request, Plan $plan)
    {
        $request->validated();
        $plan->update($request->validatedPlan());

        //delete all details and create new ones
        $plan->details()->delete();
        $plan->details()->createMany($request->validated()['details']);

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
        if($plan->suscriptions()->count() > 0){
            return back()->with([
                'level' => 'danger',
                'message' => 'Plan has suscriptions, you can not delete it!'
            ]);
        }
        $plan->delete();
        return redirect()->route('suscriptions.index')->with([
            'level' => 'success',
            'message' => 'Plan Deleted Succesfully!'
        ]);
    }
}
