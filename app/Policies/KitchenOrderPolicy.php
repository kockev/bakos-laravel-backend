<?php

namespace App\Policies;

use App\Models\KitchenOrder;
use App\Models\User;
use App\Support\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;

class KitchenOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasAnyPermission(
            [
                Permissions::VIEW_ANY_KITCHEN_ORDER,
                Permissions::VIEW_KITCHEN_ORDER,
            ])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, KitchenOrder $kitchenOrder): bool
    {
        if ($user->hasPermissionTo(
            Permissions::VIEW_KITCHEN_ORDER,
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
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KitchenOrder $kitchenOrder): bool
    {
        if ($user->hasPermissionTo(
            Permissions::UPDATE_KITCHEN_ORDER,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KitchenOrder $kitchenOrder): bool
    {
        if ($user->hasPermissionTo(
            Permissions::DELETE_KITCHEN_ORDER,
        )
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KitchenOrder $kitchenOrder): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KitchenOrder $kitchenOrder): bool
    {
        if ($user->hasPermissionTo(
            Permissions::FORCE_DELETE_KITCHEN_ORDER,
        )
        ) {
            return true;
        }

        return false;
    }

    public function replicate(User $user, KitchenOrder $kitchenOrder): bool
    {
        return false;
    }
}
