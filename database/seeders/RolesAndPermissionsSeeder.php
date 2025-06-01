<?php

namespace Database\Seeders;

use App\Support\Permissions;
use App\Support\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use ReflectionClass;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles       = $this->createRoles(collect((new ReflectionClass(Roles::class))->getConstants()));
        $permissions = $this->createPermissions(collect((new ReflectionClass(Permissions::class))->getConstants()));

        $this->addPermissionsToRoles($roles, $permissions);
    }

    protected function addPermissionsToRoles(Collection $roles, Collection $permissions): void
    {
        $roles->each(function (Role $role) use ($permissions) {
            $permissionsFunctions = [
                Roles::SUPER_ADMIN => 'addSuperAdminPermissions',
                Roles::ADMIN       => 'addAdminPermissions',
                Roles::GUEST       => 'addGuestPermissions',
            ];

            if (isset($permissionsFunctions[$role->name])) {
                $function = $permissionsFunctions[$role->name];
                $this->{$function}($role, $permissions);
            }
        });
    }

    protected function createRoles(Collection $constants): Collection
    {
        return $constants->map(function (string $permissionName) {
            return Role::updateOrCreate(['name' => $permissionName]);
        })->values();
    }

    protected function createPermissions(Collection $constants): Collection
    {
        return $constants->map(function (string $permissionName) {
            return Permission::updateOrCreate(['name' => $permissionName]);
        })->values();
    }

    protected function addSuperAdminPermissions(Role $role, Collection $permissions): void
    {
        $permissions->each(function (Permission $permission) use ($role) {
            $permission->assignRole($role);
        });
    }

    protected function addAdminPermissions(Role $role, Collection $permissions): void
    {
        $shouldHavePermissions = array_flip(
            [
                Permissions::VIEW_DASHBOARD,

                Permissions::VIEW_ANY_STUDENT,
                Permissions::VIEW_STUDENT,
                Permissions::CREATE_STUDENT,
                Permissions::UPDATE_STUDENT,
                Permissions::DELETE_STUDENT,
                Permissions::RESTORE_STUDENT,
                Permissions::FORCE_DELETE_STUDENT,

                Permissions::VIEW_ANY_MENU,
                Permissions::VIEW_MENU,
                Permissions::CREATE_MENU,
                Permissions::UPDATE_MENU,
                Permissions::DELETE_MENU,
                Permissions::RESTORE_MENU,
                Permissions::FORCE_DELETE_MENU,

                Permissions::VIEW_ANY_STUDENT_MEAL,
                Permissions::VIEW_STUDENT_MEAL,
                Permissions::CREATE_STUDENT_MEAL,
                Permissions::UPDATE_STUDENT_MEAL,
                Permissions::DELETE_STUDENT_MEAL,
                Permissions::RESTORE_STUDENT_MEAL,
                Permissions::FORCE_DELETE_STUDENT_MEAL,

                Permissions::VIEW_ANY_DIET,
                Permissions::VIEW_DIET,
                Permissions::CREATE_DIET,
                Permissions::UPDATE_DIET,
                Permissions::DELETE_DIET,
                Permissions::RESTORE_DIET,
                Permissions::FORCE_DELETE_DIET,

                Permissions::VIEW_ANY_FOOD,
                Permissions::VIEW_FOOD,
                Permissions::CREATE_FOOD,
                Permissions::UPDATE_FOOD,
                Permissions::DELETE_FOOD,
                Permissions::RESTORE_FOOD,
                Permissions::FORCE_DELETE_FOOD,

                Permissions::VIEW_ANY_ORDER,
                Permissions::VIEW_ORDER,
                Permissions::CREATE_ORDER,
                Permissions::UPDATE_ORDER,
                Permissions::DELETE_ORDER,
                Permissions::RESTORE_ORDER,
                Permissions::FORCE_DELETE_ORDER,

                Permissions::VIEW_ANY_KITCHEN_ORDER,
                Permissions::VIEW_KITCHEN_ORDER,
                Permissions::CREATE_KITCHEN_ORDER,
                Permissions::UPDATE_KITCHEN_ORDER,
                Permissions::DELETE_KITCHEN_ORDER,
                Permissions::RESTORE_KITCHEN_ORDER,
                Permissions::FORCE_DELETE_KITCHEN_ORDER,
            ]
        );

        $this->applyPermissions($role, $permissions, $shouldHavePermissions);
    }

    protected function addGuestPermissions(Role $role, Collection $permissions): void
    {
        $shouldHavePermissions = array_flip(
            [
                Permissions::VIEW_ANY_STUDENT,
                Permissions::VIEW_STUDENT,
                Permissions::UPDATE_STUDENT,
            ]
        );

        $this->applyPermissions($role, $permissions, $shouldHavePermissions);
    }

    protected function applyPermissions(
        Role       $role,
        Collection $permissions,
        array      $shouldHavePermissions = []
    ): void
    {
        $permissions->each(function (Permission $permission) use ($role, $shouldHavePermissions) {
            if (isset($shouldHavePermissions[$permission->name])) {
                if (!$permission->hasRole($role)) {
                    $permission->assignRole($role);
                }
            }
        });
    }
}
