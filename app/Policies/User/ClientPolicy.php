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
        
        return ($client->trashed() ? false : $user->hasPermissionTo('edit client'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        return ($client->trashed() ? false : $user->hasPermissionTo('delete client'));
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
        if($client->trashed() == false)
        {
            if($user->hasPermissionTo('create client_system'))
            {
                return !$client->system_client()->exists();
            }
            return false;  
        }
        return false;  
       
    }
    public function updateSystem(User $user,Client $client): bool
    {
        return ($client->trashed() ? false : $user->hasPermissionTo('edit client_system'));
    }
    public function deleteSystem(User $user,Client $client): bool
    {
        return ($client->trashed() ? false :  $user->hasPermissionTo('delete client_system'));
    }

    //CLIENT - SUSCRIPTION

    public function createSuscription(User $user,Client $client): bool
    {
        return ($client->trashed() ? false :  $user->hasPermissionTo('create client suscription'));
    }
    public function updateSuscription(User $user,Client $client): bool
    {
        return ($client->trashed() ? false :  $user->hasPermissionTo('update client suscription'));
    }
    public function deleteSuscription(User $user,Client $client): bool
    {
        return ($client->trashed() ? false :  $user->hasPermissionTo('delete client suscription'));
    }
    public function suscriptionInvoice(User $user,Client $client): bool
    {
        return true;
    }
    //CLIENT TRAINING SESSIONS

    public function assignAttendance(User $user,Client $client): bool
    {
        return ($client->trashed() ? false :  $user->hasPermissionTo('assign client training_sessions'));
    }
    public function attendaceShow(User $user,Client $client): bool
    {
        return true;
    }
    public function registerAttendanceDate(User $user,Client $client): bool
    {
        return ($client->trashed() ? false :  $user->hasPermissionTo('register client atendance_date training_session')); 
    }
    public function destroyAttendace(User $user,Client $client): bool
    {
        return ($client->trashed() ? false :  $user->hasPermissionTo('delete client training_session'));
    }
}
