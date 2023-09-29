<?php

namespace App\Http\Controllers\User;

use App\Models\Coach;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
class CoachController extends Controller
{

    public function __construct()
    {

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
