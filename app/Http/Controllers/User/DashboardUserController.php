<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Coach;
use App\Models\Exercise;
use App\Models\Plan;
use App\Models\Purchase;
use App\Models\Suscription;
use App\Models\TrainingSession;
use App\Models\Gym;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardUserController extends Controller
{
    
    public function index() {
        $purchases = Purchase::where('canceled','0')->get();
        $suscriptions = Suscription::where('canceled','0')->with('plan')->get();
        if(request()->user()->hasRole(['administrator','manager'])){
            return Inertia::render('User/Dashboard',[
                'clients' => count(Client::all()),
                'coaches' => count(Coach::all()),
                'users' => count(User::all()),
                'plans' => count(Plan::all()),
                'suscriptions' => number_format((float)($suscriptions->sum('plan.price')), 2, '.', ''),
                'purchases' => number_format((float)($purchases->sum('total')), 2, '.', ''),
                'training_sessions' => count(TrainingSession::all()),
                'exercises' => count(Exercise::all()),
                'gyms' => count(Gym::all()),
                'products' => count(Product::all()),
            ]);
        }
        return Inertia::render('User/Dashboard',[
            'clients' => count(Client::all()->where('gym_id',request()->user()->gym_id)),
            'coaches' => count(Coach::all()->where('gym_id',request()->user()->gym_id)),
            'plans' => count(Plan::all()),
            'suscriptions' => $suscriptions->sum('plan.price'),
            'purchases' => $purchases->sum('total'),
            'training_sessions' => count(TrainingSession::all()->where('gym_id',request()->user()->gym_id)),
            'exercises' => count(Exercise::all()),
            'products' => count(Product::all()->where('gym_id',request()->user()->gym_id)),
        ]);
    }
}
