<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardCoachController extends Controller
{
    public function index(){
        return Inertia::render('Coach/CoachDashboard',[
            'coach' => Coach::with(['gym.department'])->find(auth()->user()->id),
            'coach_training_sessions' => auth()->user()->training_session_coaches()->when(\Illuminate\Support\Facades\Request::input('search') ?? false, function($query , $search) {
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

    public function showTrainingSessions(TrainingSession $training_session)
    {
        return Inertia::render('Coach/ShowTrainingSession',[
            'training_session' => $training_session->load(['attendancesClients','training_sessions_exercises','training_sessions_coaches']),
        ]);
    }
}
