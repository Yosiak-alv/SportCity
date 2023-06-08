<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\ClientSystemCreateEditRequest;
use App\Models\Client;
use App\Models\System;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ClientSystemController extends Controller
{

    public function create(Client $client)
    {
        
        if(request()->user()->cannot('create',[System::class,$client])){ //asi porque es en $client lo arriuna
            abort(403,'THIS ACTION IS UNAUTHORIZED. '); // es igual $this->authorize()
        }
        return Inertia::render('User/User_Client/Partials/Client_System/CreateEditClientSystem',[
            'systems' => System::all(),
            'client' => ['id' => $client->id,'name'=> $client->name,'lastname' => $client->lastname],
        ]);
    }

    public function store(ClientSystemCreateEditRequest $request, Client $client)
    {
        if(request()->user()->cannot('create',[System::class,$client])){ //asi porque es en $client lo arriuna
            abort(403,'THIS ACTION IS UNAUTHORIZED. '); // es igual $this->authorize()
        }
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

    public function edit(Client $client)
    {
        if(request()->user()->cannot('update',[System::class])){ //asi porque es en $client lo arriuna
            abort(403,'THIS ACTION IS UNAUTHORIZED. '); // es igual $this->authorize()
        }
        return Inertia::render('User/User_Client/Partials/Client_System/CreateEditClientSystem',[
            'systems' => System::all(),
            'client' => ['id' => $client->id,'name'=> $client->name,'lastname' => $client->lastname],
            'selected_client_systems' => $client->system_client()->select('id')->get()->pluck('id'),
            'select_client_system_conditions' => $client->system_client()->select(['system_id','condition'])->get()->pluck('condition','system_id'),
        ]);
    }

    public function update(ClientSystemCreateEditRequest $request, Client $client)
    {
        if(request()->user()->cannot('update',[System::class])){ //asi porque es en $client lo arriuna
            abort(403,'THIS ACTION IS UNAUTHORIZED. '); // es igual $this->authorize()
        }
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

    public function destroy(Client $client)
    {
        if(request()->user()->cannot('delete',[System::class])){ //asi porque es en $client lo arriuna
            abort(403,'THIS ACTION IS UNAUTHORIZED. '); // es igual $this->authorize()
        }
        $client->system_client()->sync([]);
        
        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client System Eliminated Succesfully!'
        ]);
    }
}
