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
        //dd($client->gym()->exists());
        if($user->hasRole('administrator') || $user->hasRole('manager'))
        {
            return $user->hasPermissionTo('show client');
        }
        return $user->gym_id == $client->gym_id ? $user->hasPermissionTo('show client'): false;
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
        if ($client->trashed()) {
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('edit client');
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('edit client');
    }
    public function updatePassword(User $user, Client $client): bool
    {
        if ($client->trashed()) {
            return false;
        }
        if ($user->hasRole('administrator')) {
            return ($user->hasPermissionTo('update client password'));
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        if ($client->trashed()) {
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('delete client');
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('delete client');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Client $client): bool
    {
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('restore client');
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('restore client');
    }

    //CLIENT - SYSTEM 

    public function createSystem(User $user ,Client $client): bool
    {   
        if ($client->trashed()) { 
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('create client_system') ? !$client->system_client()->exists() : false;
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('create client_system') ? !$client->system_client()->exists() : false;
       
    }
    public function updateSystem(User $user,Client $client): bool
    {
        if ($client->trashed()) { 
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('edit client_system');
        }
        return $user->gym_id == $client->gym_id &&  $user->hasPermissionTo('edit client_system');
    }
    public function deleteSystem(User $user,Client $client): bool
    {
        if ($client->trashed()) { 
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('delete client_system');
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('delete client_system');
    }

    //CLIENT - SUSCRIPTION

    public function createSuscription(User $user,Client $client): bool
    {
        if ($client->trashed()) { 
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('create client suscription');
        }
        return $user->gym_id == $client->gym_id &&  $user->hasPermissionTo('create client suscription');
    }
    public function showSuscription(User $user,Client $client): bool
    {
        return true;
    }
    public function cancelSuscription(User $user,Client $client): bool
    {
        if ($client->trashed()) { 
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('cancel client suscription');
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('cancel client suscription');
    }
    
    public function suscriptionInvoice(User $user,Client $client): bool
    {
        return true;
    }
    //CLIENT TRAINING SESSIONS

    public function assignAttendance(User $user,Client $client): bool
    {
        if ($client->trashed()) { 
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('assign client training_sessions');
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('assign client training_sessions');
    }
    public function attendaceShow(User $user,Client $client): bool
    {
        return true;
    }
    public function registerAttendanceDate(User $user,Client $client): bool
    {
        if ($client->trashed()) { 
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('register client atendance_date training_session');
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('register client atendance_date training_session');
    }
    public function destroyAttendace(User $user,Client $client): bool
    {
        if ($client->trashed()) { 
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('delete client training_session');
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('delete client training_session');
    }

    //CLIENT - PURCHASE

    public function createPurchase(User $user,Client $client): bool
    {
        if ($client->trashed()) { 
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('create client purchase');
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('create client purchase');
    }
    public function showPurchase(User $user,Client $client): bool
    {
        return true;
    }
    public function cancelPurchase(User $user,Client $client): bool
    {
        if ($client->trashed()) { 
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('cancel client purchase');
        }
        return $user->gym_id == $client->gym_id && $user->hasPermissionTo('cancel client purchase');
    }
}
