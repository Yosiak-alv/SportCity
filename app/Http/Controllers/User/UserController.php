<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\CreateEditUserRequest;
use App\Models\Gym;
use App\Models\User;
use App\Traits\UserTrait;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
class UserController extends Controller
{
    use UserTrait;
    public function __construct()
    {
        $this->authorizeResource(User::class,'user');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Users/Index',[
            'users' => User::select(['id','dui','name','lastname','phone','deleted_at'])->latest('created_at')->where('gym_id',request()->user()->gym_id)
            ->filter(request(['search','trashed']))->paginate(5)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search','trashed']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Users/CreateEditUser',[
            'gyms' => Gym::all(['id','name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEditUserRequest $request)
    {
        $user = User::create($request->validated());
        
        return redirect()->route('users.show',$user->id)->with([
            'level' => 'success',
            'message' => 'User Created Succesfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Inertia::render('User/Users/Show',['user'=> $user->load(['gym.department'])]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render('User/Users/CreateEditUser',['user'=> $user, 'gyms' => Gym::all(['id','name'])]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEditUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()->route('users.show',$user->id)->with([
            'level' => 'success',
            'message' => 'User Updated Succesfully!'
        ]);
    }
    public function updatePassword(Request $request,User $user)
    {
        $attr = $request->validate([
            'password' => ['required', Password::default()->min(8), 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($attr['password']),
        ]);

        return back()->with([
            'level' => 'success',
            'message' => 'User Password has been Reseted Succesfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with([
            'level' => 'success',
            'message' => 'User Deleted Succesfully!'
        ]);
    }

    public function restore(User $user)
    {
        User::withTrashed()->find($user->id)->restore();

        return redirect()->route('users.show',$user->id)->with([
            'level' => 'success',
            'message' => 'User Restored Succesfully!'
        ]);
    }
}
