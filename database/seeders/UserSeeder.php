<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()
                    ->updateOrCreate(
                        ['email' => 'kperation@gmail.com'],
                        [
                            'name'     => 'Kevin Admin',
                            'password' => Hash::make('changeme'),
                        ]
                    );

        $role = Role::query()
                    ->where('name', Roles::SUPER_ADMIN)
                    ->first();

        if ($role) {
            $user->assignRole($role);
        }
    }
}
