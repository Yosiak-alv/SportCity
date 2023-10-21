<?php

namespace App\Policies\User;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view users');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo('view users') ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return ($model->trashed() ? false: $user->hasPermissionTo('edit user'));
    }
    public function updatePassword(User $user, User $model): bool
    {
        return ($model->trashed() ? false: $user->hasPermissionTo('update user password'));
    }
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return ($model->trashed() ? false: ($user->hasPermissionTo('delete user') && ($user->id != $model->id)));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasPermissionTo('restore user');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
   /*  public function forceDelete(User $user, User $model): bool
    {
        //
    } */
}
