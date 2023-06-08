<?php

namespace App\Policies\User;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SystemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user ,Client $client): bool
    {   
       if($user->hasPermissionTo('create client_system'))
       {
            return !$client->system_client()->exists();
       }
        return false;  
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('edit client_system');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete client_system');
    }

   
}
