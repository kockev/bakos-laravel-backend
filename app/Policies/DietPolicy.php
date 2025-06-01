<?php

namespace App\Policies;

use App\Models\Diet;
use App\Models\User;
use App\Support\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;

class DietPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasAnyPermission(
            [
                Permissions::VIEW_ANY_DIET,
                Permissions::VIEW_DIET,
            ])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Diet $diet): bool
    {
        if ($user->hasPermissionTo(
            Permissions::VIEW_DIET,
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
            Permissions::CREATE_DIET,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Diet $diet): bool
    {
        if ($user->hasPermissionTo(
            Permissions::UPDATE_DIET,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Diet $diet): bool
    {
        if ($user->hasPermissionTo(
            Permissions::DELETE_DIET,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Diet $diet): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Diet $diet): bool
    {
        if ($user->hasPermissionTo(
            Permissions::FORCE_DELETE_DIET,
        )
        ) {
            return true;
        }

        return false;
    }

    public function replicate(User $user, Diet $diet):bool
    {
        return false;
    }
}
