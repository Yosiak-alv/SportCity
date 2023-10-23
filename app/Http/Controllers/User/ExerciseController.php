<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\CreateEditExerciseRequest;
use App\Models\Exercise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ExerciseController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Exercise::class,'exercise');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //No xd
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Training Sessions/Exercises/CreateEditExercise');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEditExerciseRequest $request)
    {
        $exercise = Exercise::create($request->validated());
        return redirect()->route('exercises.show',$exercise->id)->with([
            'level' => 'success',
            'message' => 'Exercise Created Succesfully!'
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
        return Inertia::render('User/Training Sessions/Exercises/Show',[
            'exercise' => $exercise,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exercise $exercise)
    {
        return Inertia::render('User/Training Sessions/Exercises/CreateEditExercise',[
            'exercise' => $exercise
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEditExerciseRequest $request, Exercise $exercise)
    {
        $exercise->update($request->validated());
        return redirect()->route('exercises.show',$exercise->id)->with([
            'level' => 'success',
            'message' => 'Exercise Updated Succesfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('training-sessions.index')->with([
            'level' => 'success',
            'message' => 'Exercise Deleted Succesfully!'
        ]);
    }
}
