<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\CreateEditCoachRequest;
use App\Models\Coach;
use App\Models\Gym;
use App\Models\TrainingSession;
use App\Traits\CoachTrait;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
class CoachController extends Controller
{
    use CoachTrait;
    public function __construct()
    {
        $this->authorizeResource(Coach::class,'coach');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Coaches/Index',[
            'coaches' => Coach::select(['id','dui','name','lastname','phone','deleted_at'])->latest('created_at')->where('gym_id',request()->user()->gym_id)->filter(request(['search','trashed']))
            ->paginate(5)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search','trashed']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Coaches/CreateEditCoach',[
            'gyms' => Gym::all(['id','name']),  
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEditCoachRequest $request)
    {
        $attr = $request->validated();
        $attr['password'] = Hash::make($attr['dui']);
        $coach = Coach::create($attr);

        return redirect()->route('coaches.show',$coach->id)->with([
            'level' => 'success',
            'message' => 'Coach Created Succesfully!'
        ]);
    }
    public function updatePassword(Request $request,Coach $coach)
    {
        $attr = $request->validate([
            'password' => ['required', Password::default()->min(8), 'confirmed'],
        ]);

        $coach->update([
            'password' => Hash::make($attr['password']),
        ]);

        return back()->with([
            'level' => 'success',
            'message' => 'Coach Password has been Reseted Succesfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coach $coach)
    {
        return Inertia::render('User/Coaches/Show',[
            'coach' => $coach->load(['gym.department']),
            'coach_training_sessions' => $coach->training_session_coaches()->when(\Illuminate\Support\Facades\Request::input('search') ?? false, function($query , $search) {
                $query->where(fn($query) =>
                    $query->where('name','like','%'.$search.'%')
                        ->orWhere('description','like','%'.$search.'%')
                        ->orWhere('duration','like','%'.$search.'%')
                        ->orWhere('starts_at','like','%'.$search.'%')
                        ->orWhere('finish_at','like','%'.$search.'%')
                );
            })->paginate(8)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only('search'),
        ]);
    }
    public function showTrainingSessions(Coach $coach,int $id)
    {
        $training_session = TrainingSession::find($id);
        return Inertia::render('User/Coaches/Partials/Training_Sessions/CoachTrainingSessionShow',[
            'coach_training_session' => $coach->training_session_coaches()->where('training_session_id',$id)->first(),
            'training_session_coaches' => $training_session->training_sessions_coaches->makeHidden(['phone','gym_id','email_verified_at','dui','address','created_at','updated_at']),
            'training_session_exercises' => $training_session->training_sessions_exercises,
            'training_session_clients' => $training_session->attendancesClients->makeHidden(['weight','height','birth_date','genre','phone','gym_id','email_verified_at','dui','address','created_at','updated_at']),
            'coach' => ['id' => $coach->id,'name'=> $coach->name,'lastname' => $coach->lastname],
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coach $coach)
    {
        $gyms = Gym::with('department')->get();
        return Inertia::render('User/Coaches/CreateEditCoach',[
            'coach' => $coach,
            'gyms' => $gyms->makeHidden(['email','phone','department_id','deleted_at','created_at','updated_at']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEditCoachRequest $request, Coach $coach)
    {
        $coach->update($request->validated());

        return redirect()->route('coaches.show',$coach->id)->with([
            'level' => 'success',
            'message' => 'Coach Updated Succesfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coach $coach)
    {
        $coach->delete();

        return redirect()->route('coaches.index')->with([
            'level' => 'success',
            'message' => 'Coach Deleted Succesfully!'
        ]);
    }

    public function restore(Coach $coach)
    {
        Coach::withTrashed()->find($coach->id)->restore();

        return redirect()->route('coaches.show',$coach->id)->with([
            'level' => 'success',
            'message' => 'Coach Restored Succesfully!'
        ]);
    }
}
