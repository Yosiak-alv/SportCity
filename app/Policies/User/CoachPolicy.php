<?php

namespace App\Policies\User;

use App\Models\Coach;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoachPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view coaches');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Coach $coach): bool
    {
        return $user->hasPermissionTo('show coach');
    }
    public function showTrainingSession(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create coach');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Coach $coach): bool
    {
        return ($coach->trashed() ? false : $user->hasPermissionTo('edit coach'));
    }
    public function updatePassword(User $user, Coach $coach): bool
    {
        return ($coach->trashed() ? false : $user->hasRole('administrator') && $user->hasPermissionTo('edit coach'));
    }   
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Coach $coach): bool
    {
        return ($coach->trashed() ? false : $user->hasPermissionTo('delete coach'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Coach $coach): bool
    {
        return $user->hasPermissionTo('restore coach');
    }

    /*
    public function forceDelete(User $user, Coach $coach): bool
    {
        
    } */
}
