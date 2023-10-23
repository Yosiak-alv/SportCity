<?php

namespace App\Policies;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExercisePolicy
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
    public function view(User $user, Exercise $exercise): bool
    {
        return $user->hasPermissionTo('show exercise');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create exercise');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Exercise $exercise): bool
    {
        return $user->hasPermissionTo('edit exercise');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Exercise $exercise): bool
    {
        return $user->hasPermissionTo('delete exercise');
    }

    /**
     * Determine whether the user can restore the model.
     */
   /*  public function restore(User $user, Exercise $exercise): bool
    {
        //
    } */

    /**
     * Determine whether the user can permanently delete the model.
     */
   /*  public function forceDelete(User $user, Exercise $exercise): bool
    {
        //
    } */
}
