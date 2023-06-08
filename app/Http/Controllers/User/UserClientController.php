<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ClientCreateEditRequest;
use App\Http\Requests\User\ClientSystemCreateEditRequest;
use App\Models\Gym;
use App\Models\System;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Client;

class UserClientController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Client::class,'client');
    }

    protected function resourceAbilityMap(): array
    {
        return array_merge(parent::resourceAbilityMap(), [
            // method in Controller => method in Policy
            'restore' => 'restore',
            'createSystem' => 'createSystem',
            'storeSystem' => 'createSystem',
            'editSystem' => 'updateSystem',
            'updateSystem' => 'updateSystem',
            'destroySystem' => 'deleteSystem'
        ]);
    }

    protected function resourceMethodsWithoutModels(): array
    {
        return array_merge(parent::resourceMethodsWithoutModels(), [
            // method in Controller
            /* 'addToOrder',
            'removeFromOrder', */
        ]);
    }
    /**
     * Display a listing of the resource.
     * Flash messages -> in get request flash.level => '', in post, patch, put, delete only level =>''
     */
    public function index()
    {
        //dd(request()->user()->hasPermissionTo('view clients'));
        return Inertia::render('User/User_Client/Index',[ 
            'clients' => Client::select(['id','dui','name','lastname','phone','deleted_at'])->where('gym_id',request()->user()->gym_id)->filter(request(['search','trashed']))
            ->paginate(5)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search','trashed']),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/User_Client/CreateEditClient',[
            'gyms' => Gym::all(['id','name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     */
    public function store(ClientCreateEditRequest $request)
    {
        $attr = $request->validated();
        $result = array_merge($attr,['password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        $client = Client::create($result);

        return to_route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Created Succesfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return Inertia::render('User/User_Client/Show',[
            'client' => $client->load(['suscriptions.plan','purchases','system_client','attendances_training_sessions','gym.department'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return Inertia::render('User/User_Client/CreateEditClient',[
            'client' => $client,
            'gyms' => Gym::all(['id','name'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientCreateEditRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Updated Succesfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with([
            'level' => 'success',
            'message' => 'Client Deleted Succesfully!'
        ]);
    }

    public function restore(Client $client)
    {
        Client::withTrashed()->find($client->id)->restore();

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Restored Succesfully!'
        ]);
    }

    //CLIENT - SYSTEM
    public function createSystem(Client $client)
    {
        return Inertia::render('User/User_Client/Partials/Client_System/CreateEditClientSystem',[
            'systems' => System::all(),
            'client' => ['id' => $client->id,'name'=> $client->name,'lastname' => $client->lastname],
        ]);
    }
    public function storeSystem(ClientSystemCreateEditRequest $request, Client $client)
    {
        $conditions = collect([]);
        
        foreach ($request->conditions() as $index => $condition) {
            if ($request->validatedSystemsId()->contains($index)) {
                $conditions->put($index, [ 'condition' => $condition ]);
            }
        }
        $client->system_client()->sync($conditions);

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client System Created Succesfully!'
        ]);
    }
    public function editSystem(Client $client)
    {
        return Inertia::render('User/User_Client/Partials/Client_System/CreateEditClientSystem',[
            'systems' => System::all(),
            'client' => ['id' => $client->id,'name'=> $client->name,'lastname' => $client->lastname],
            'selected_client_systems' => $client->system_client()->select('id')->get()->pluck('id'),
            'select_client_system_conditions' => $client->system_client()->select(['system_id','condition'])->get()->pluck('condition','system_id'),
        ]);
    }
    public function updateSystem(ClientSystemCreateEditRequest $request, Client $client)
    {
        $conditions = collect([]);
        
        foreach ($request->conditions() as $index => $condition) {
            if ($request->validatedSystemsId()->contains($index)) {
                $conditions->put($index, [ 'condition' => $condition ]);
            }
        }
        $client->system_client()->sync($conditions);

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client System Updated Succesfully!'
        ]);
    }
    public function destroySystem(Client $client)
    {
        $client->system_client()->sync([]);
        
        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client System Eliminated Succesfully!'
        ]);
    }

}
