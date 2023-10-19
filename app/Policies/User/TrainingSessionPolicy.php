<?php

namespace App\Policies\User;

use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TrainingSessionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view training sessions');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TrainingSession $trainingSession): bool
    {
        return $user->hasPermissionTo('show training session');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create training session');
    }
    public function createSyncClients(User $user): bool
    {
        return $user->hasPermissionTo('create training session');
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TrainingSession $trainingSession): bool
    {
        return $user->hasPermissionTo('edit training session');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TrainingSession $trainingSession): bool
    {
        return $user->hasPermissionTo('delete training session');
    }

    public function disassociateAllClients(User $user): bool
    {
        return $user->hasPermissionTo('delete training session');
    }
    public function disassociateAllExercises(User $user): bool
    {
        return $user->hasPermissionTo('delete training session');
    }
    public function disassociateAllCoaches(User $user): bool
    {
        return $user->hasPermissionTo('delete training session');
    }


    /**
     * Determine whether the user can restore the model.
     */
    /* public function restore(User $user, TrainingSession $trainingSession): bool
    {
        //
    } */

    /**
     * Determine whether the user can permanently delete the model.
     */
    /* public function forceDelete(User $user, TrainingSession $trainingSession): bool
    {
        //
    } */
}
