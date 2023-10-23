<?php

namespace App\Policies;

use App\Models\Suscription;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SuscriptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view suscriptions');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Suscription $suscription): bool
    {
        return $user->hasPermissionTo('show suscription');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create suscription');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Suscription $suscription): bool
    {
        return ($suscription->canceled == true ? false : $user->hasPermissionTo('edit suscription'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Suscription $suscription): bool
    {
        return $user->hasRole('administrator') && $user->hasPermissionTo('delete suscription');
    }
    public function suscriptionInvoice(User $user): bool
    {
        return true;
    }
    public function cancelSuscription(User $user ,Suscription $suscription): bool
    {
        //dd($suscription->canceled == true ? false :$user->hasPermissionTo('cancel suscription'));
        return ($suscription->canceled == true ? false :$user->hasPermissionTo('cancel suscription')); 
    }

    /**cancelSuscription
     * Determine whether the user can restore the model.
     */
   /*  public function restore(User $user, Suscription $suscription): bool
    {
        //
    } */

    /**
     * Determine whether the user can permanently delete the model.
     */
   /*  public function forceDelete(User $user, Suscription $suscription): bool
    {
        //
    } */
}
