<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\CreateEditTrainingSessionRequest;
use App\Models\Client;
use App\Models\Coach;
use App\Models\Exercise;
use App\Models\Gym;
use App\Models\TrainingSession;
use App\Traits\TrainingSessionTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class TrainingSessionController extends Controller
{
    use TrainingSessionTrait;
    public function __construct()
    {
        $this->authorizeResource(TrainingSession::class,'training_session');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Training Sessions/Index',[
            'training_sessions' => TrainingSession::select(['id','name','description','duration','starts_at','finish_at'])->latest('created_at')
            ->filter(request(['search','gym']), request()->user()->gym_id)->paginate(8)->withQueryString(),
            'gyms' => Gym::all(['id','name']),
            'exercises' => Exercise::all(['id','name','instructions' ,'created_at','updated_at']),
            'filters' => \Illuminate\Support\Facades\Request::only(['search','gym']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return Inertia::render('User/Training Sessions/CreateEditTrainingSession',[
            'coaches' => request()->user()->hasRole(['administrator','manager']) ?
                Coach::with(['gym:id,name'])->get() : Coach::with(['gym:id,name'])->where('gym_id',request()->user()->gym_id)->get(),
            'clients' =>  request()->user()->hasRole(['administrator','manager']) ? Client::with(['gym:id,name'])->get() : 
                Client::with(['gym:id,name'])->where('gym_id',request()->user()->gym_id)->get(),
            'gyms' => request()->user()->hasRole(['administrator','manager']) ?  Gym::all(['id','name']) : null,
            'exercises' => Exercise::all(['id','name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEditTrainingSessionRequest $request)
    {
        try{            
            $repetitions = collect([]);
            $attendance_dates = collect([]);
    
            foreach ($request->validatedRepetitions() as $id => $repetition) {
                if ($request->validatedExerciseIds()->contains($id)) {
                    $repetitions->put($id,['repetitions' => $repetition,]);
                }
            }
            foreach ($request->validatedAttendaceDates() as $id => $attendance_date) {
                if ($request->validatedClientIds()->contains($id)) {
                    $client_date = new \DateTime($attendance_date);
                    $starts_At = new \DateTime($request->starts_at);
                    $finish_At = new \DateTime($request->finish_at);
                    if(($client_date >= $starts_At )  &&  ($client_date <= $finish_At) ){
                        $attendance_dates->put($id,['attendance_date' => $attendance_date,]);
                    }else{
                        throw new \Exception('Clients Attendance Date Must be in the Interval [ starts_at, finish_at ] !!!');
                    }
                }
               
            }
            $attr = (request()->user()->hasRole(['administrator','manager']) ? 
                $request->validatedTrainingSessionAdmOrManger() : $request->validatedTrainingSessionUserReg());
            $attr['user_id'] = request()->user()->id;
            if(!request()->user()->hasRole('administrator') && !request()->user()->hasRole('manager')){
                $attr['gym_id'] = request()->user()->gym_id;
            }
            $this->clientCoachGymValidation($request,$attr);

            $training_session = TrainingSession::create($attr);
            $training_session->training_sessions_coaches()->sync($request->validatedCoachIds());
            $training_session->training_sessions_exercises()->sync($repetitions);
            $training_session->attendancesClients()->sync($attendance_dates); 
            
            return redirect()->route('training-sessions.show',$training_session->id)->with([
                'level' => 'success',
                'message' => 'Training Session Created Succesfully!'
            ]);
        }
        catch(\Exception $e){
            return back()->with([
                'level' => 'danger',
                'message' => $e->getMessage()
            ]);
        }
       
    }
    /**
     * Display the specified resource.
     */
    public function show(TrainingSession $training_session)
    {
        return Inertia::render('User/Training Sessions/Show',[
            'training_session' => $training_session->load(['attendancesClients','training_sessions_exercises','training_sessions_coaches']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingSession $training_session)
    {
        return Inertia::render('User/Training Sessions/CreateEditTrainingSession',[
            'training_session' => $training_session,
            'coaches' => request()->user()->hasRole(['administrator','manager']) ?
                Coach::with(['gym:id,name'])->get() : Coach::with(['gym:id,name'])->where('gym_id',request()->user()->gym_id)->get(),
            'clients' =>  request()->user()->hasRole(['administrator','manager']) ? Client::with(['gym:id,name'])->get() : 
                Client::with(['gym:id,name'])->where('gym_id',request()->user()->gym_id)->get(),
            'gyms' => request()->user()->hasRole(['administrator','manager']) ?  Gym::all(['id','name']) : null,
            'exercises' => Exercise::all(['id','name']),
            'selected_coaches' => $training_session->training_sessions_coaches()->pluck('id')->toArray(),
            'selected_clients' => $training_session->attendancesClients()->pluck('id')->toArray(),
            'selected_clients_attendance' => $training_session->attendancesClients()->select(['client_id','attendance_date'])->get()->pluck('attendance_date','client_id'),
            'selected_exercises' => $training_session->training_sessions_exercises()->pluck('id')->toArray(),
            'selected_exercises_reps' => $training_session->training_sessions_exercises()->select(['exercise_id','repetitions'])->get()->pluck('repetitions','exercise_id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEditTrainingSessionRequest $request ,TrainingSession $training_session)
    {
        try{
            $repetitions = collect([]);
            $attendance_dates = collect([]);
    
            foreach ($request->validatedRepetitions() as $id => $repetition) {
                if ($request->validatedExerciseIds()->contains($id)) {
                    $repetitions->put($id,['repetitions' => $repetition,]);
                }
            }
            foreach ($request->validatedAttendaceDates() as $id => $attendance_date) {
                if ($request->validatedClientIds()->contains($id)) {
                    $client_date = new \DateTime($attendance_date);
                    $starts_At = new \DateTime($request->starts_at);
                    $finish_At = new \DateTime($request->finish_at);
                    if(($client_date >= $starts_At )  &&  ($client_date <= $finish_At) ){
                        $attendance_dates->put($id,['attendance_date' => $attendance_date,]);
                    }else{
                        throw new \Exception('Clients Attendance Date Must be in the Interval [ starts_at, finish_at ] !!!');
                    }
                }
            }
            $attr = (request()->user()->hasRole(['administrator','manager']) ? 
                $request->validatedTrainingSessionAdmOrManger() : $request->validatedTrainingSessionUserReg());
            $attr['user_id'] = request()->user()->id;    
            if(!request()->user()->hasRole('administrator') && !request()->user()->hasRole('manager')){
                $attr['gym_id'] = request()->user()->gym_id;
            }

            $this->clientCoachGymValidation($request,$attr);

            $training_session->update($attr);
            $training_session->training_sessions_coaches()->sync($request->validatedCoachIds());
            $training_session->training_sessions_exercises()->sync($repetitions);
            $training_session->attendancesClients()->sync($attendance_dates);
    
            return redirect()->route('training-sessions.show',$training_session->id)->with([
                'level' => 'success',
                'message' => 'Training Session Updated Succesfully!'
            ]);

        }catch(\Exception $e){
            return back()->with([
                'level' => 'danger',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingSession $training_session)
    {
        $training_session->delete(); //supuestamente la base ya lo hace con cascadeOnDelete confirmado si xd

        return redirect()->route('training-sessions.index')->with([
            'level' => 'success',
            'message' => 'Training Session Deleted Succesfully!'
        ]);
    }
    public function disassociateAllCoaches(TrainingSession $training_session)
    {
        $training_session->training_sessions_coaches()->sync([]);
        
        return back()->with([
            'level' => 'success',
            'message' => 'All Coaches Disassociated Succesfully!'
        ]);
    }
    public function disassociateAllExercises(TrainingSession $training_session)
    {
        $training_session->training_sessions_exercises()->sync([]);
        
        return back()->with([
            'level' => 'success',
            'message' => 'All Exercises Disassociated Succesfully!'
        ]);
    }
    public function disassociateAllClients(TrainingSession $training_session)
    {
        $training_session->attendancesClients()->sync([]);

        return back()->with([
            'level' => 'success',
            'message' => 'All Clients Disassociated Succesfully!'
        ]);
    }

    private function clientCoachGymValidation($request, $attr) {
        /* if(!request()->user()->hasRole('administrator') && !request()->user()->hasRole('manager')){
            $attr['gym_id'] = request()->user()->gym_id;
        } */
        // Check if the selected coaches belong to the same gym
        if (request()->user()->hasRole(['administrator', 'manager'])) {
            $coaches = Coach::whereIn('id', $request->validatedCoachIds())->where('gym_id', $attr['gym_id'])->get();
            $clients = Client::whereIn('id', $request->validatedClientIds())->where('gym_id', $attr['gym_id'])->get();
        } else {
            $coaches = Coach::whereIn('id', $request->validatedCoachIds())->where('gym_id', request()->user()->gym_id)->get();
            $clients = Client::whereIn('id', $request->validatedClientIds())->where('gym_id', request()->user()->gym_id)->get();
        }

        if ($coaches->count() !== count($request->validatedCoachIds())) {
            throw new \Exception('Invalid coach selection. Coaches must belong to the same gym');
        }
        if ($clients->count() !== count($request->validatedClientIds())) {
            throw new \Exception('Invalid client selection. Clients must belong to the same gym');
        }
    }
}
