<?php

namespace App\Policies\User;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //dd('hola');
        return $user->hasPermissionTo('view products');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        if($user->hasRole('administrator') || $user->hasRole('manager'))
        {
            return $user->hasPermissionTo('show product');
        }
        return $user->gym_id == $product->gym_id ? $user->hasPermissionTo('show product'): false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create product');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        if ($product->trashed()) {
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('edit product');
        }
        return $user->gym_id == $product->gym_id && $user->hasPermissionTo('edit product');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        if($product->trashed()) {
            return false;
        }
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('delete product');
        }
        return $user->gym_id == $product->gym_id && $user->hasPermissionTo('delete product');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        if ($user->hasRole('administrator') || $user->hasRole('manager')) {
            return $user->hasPermissionTo('restore product');
        }
        return $user->gym_id == $product->gym_id && $user->hasPermissionTo('restore product');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product)
    {
        //
    }
}
