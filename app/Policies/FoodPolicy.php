<?php

namespace App\Policies;

use App\Models\Food;
use App\Models\User;
use App\Support\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasAnyPermission(
            [
                Permissions::VIEW_ANY_FOOD,
                Permissions::VIEW_FOOD,
            ])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Food $food): bool
    {
        if ($user->hasPermissionTo(
            Permissions::VIEW_FOOD,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasPermissionTo(
            Permissions::CREATE_FOOD,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Food $food): bool
    {
        if ($user->hasPermissionTo(
            Permissions::UPDATE_FOOD,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Food $food): bool
    {
        if ($user->hasPermissionTo(
            Permissions::DELETE_FOOD,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Food $food): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Food $food): bool
    {
        if ($user->hasPermissionTo(
            Permissions::FORCE_DELETE_FOOD,
        )
        ) {
            return true;
        }

        return false;
    }

    public function replicate(User $user, Food $food):bool
    {
        return false;
    }
}
