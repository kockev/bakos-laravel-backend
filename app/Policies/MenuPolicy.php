<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use App\Support\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasAnyPermission(
            [
                Permissions::VIEW_ANY_MENU,
                Permissions::VIEW_MENU,
            ])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Menu $menu): bool
    {
        if ($user->hasPermissionTo(
            Permissions::VIEW_MENU,
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
            Permissions::CREATE_MENU,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Menu $menu): bool
    {
        if ($user->hasPermissionTo(
            Permissions::UPDATE_MENU,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Menu $menu): bool
    {
        if ($user->hasPermissionTo(
            Permissions::DELETE_MENU,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Menu $menu): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Menu $menu): bool
    {
        if ($user->hasPermissionTo(
            Permissions::FORCE_DELETE_MENU,
        )
        ) {
            return true;
        }

        return false;
    }

    public function replicate(User $user, Menu $menu):bool
    {
        return false;
    }
}
