<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\CreateEditGymRequest;
use App\Models\Department;
use App\Models\Gym;
use App\Traits\GymTrait;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
class GymController extends Controller
{
    use GymTrait;
    public function __construct()
    {
        $this->authorizeResource(Gym::class,'gym');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Gyms/Index',[
            'gyms' =>Gym::select('id','name','email','phone','deleted_at')->latest('created_at')->filter(request(['search','trashed']))
            ->paginate(5)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search','trashed']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Gyms/CreateEditGym',['departments' => Department::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEditGymRequest $request)
    {
        $gym = Gym::create($request->validated());

        return redirect()->route('gyms.show',$gym->id)->with([
            'level' => 'success',
            'message' => 'Gym Created Succesfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gym $gym)
    {
        return Inertia::render('User/Gyms/Show',[
            'gym' => $gym->load('department'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gym $gym)
    {
        return Inertia::render('User/Gyms/CreateEditGym',[
            'gym' => $gym,
            'departments' => Department::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEditGymRequest $request, Gym $gym)
    { 
        $gym->update($request->validated());

        return redirect()->route('gyms.show',$gym->id)->with([
            'level' => 'success',
            'message' => 'Gym Updated Succesfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gym $gym)
    {
        $gym->delete();

        if ($gym->id == request()->user()->gym_id) {
            Auth::guard('web')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect('/');
        }

        return redirect()->route('gyms.index')->with([
            'level' => 'success',
            'message' => 'Gym Disabled Succesfully!'
        ]);
    }

    public function restore(Gym $gym)
    {
        Gym::withTrashed()->find($gym->id)->restore();

        return redirect()->route('gyms.show',$gym->id)->with([
            'level' => 'success',
            'message' => 'Gym Restored Succesfully!'
        ]);
    }
}
