<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Editor']);
        Role::firstOrCreate(['name' => 'Author']);
        Role::firstOrCreate(['name' => 'Subscriber']);

        $user = User::where('email', 'nmbabu6040@gmail.com')->first();

        if ($user && !$user->hasRole('Super Admin')) {
            $user->assignRole('Super Admin');
        }
    }
}
