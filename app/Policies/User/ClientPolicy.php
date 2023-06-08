<?php

namespace App\Policies\User;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //dd('hola');
        return $user->hasPermissionTo('view clients');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Client $client): bool
    {
        //dd($user->hasPermissionTo('show client'));
        return $user->hasPermissionTo('show client');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create client');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Client $client): bool
    {
        return $user->hasPermissionTo('edit client');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        return $user->hasPermissionTo('delete client');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Client $client): bool
    {
        return $user->hasPermissionTo('restore client');
    }

    //CLIENT - SYSTEM 

    public function createSystem(User $user ,Client $client): bool
    {   
       if($user->hasPermissionTo('create client_system'))
       {
            return !$client->system_client()->exists();
       }
        return false;  
    }
    public function updateSystem(User $user,Client $client): bool
    {
        return $user->hasPermissionTo('edit client_system');
    }
    public function deleteSystem(User $user,Client $client): bool
    {
        return $user->hasPermissionTo('delete client_system');
    }


}
