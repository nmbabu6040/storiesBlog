<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $editor = Role::firstOrCreate(['name' => 'Editor']);
        $author = Role::firstOrCreate(['name' => 'Author']);
        $subscriber = Role::firstOrCreate(['name' => 'Subscriber']);

        $superAdmin->syncPermissions(Permission::all());

        $admin->syncPermissions([
            'dashboard',
            'manage-posts',
            'manage-categories',
            'manage-pages',
            'manage-comments',
            'manage-gallery',
        ]);

        $editor->syncPermissions([
            'manage-posts',
            'manage-categories',
            'manage-pages',
            'manage-menus',
            'manage-gallery',
            'manage-comments',
        ]);

        $author->syncPermissions([
            'dashboard',
            'manage-posts',
        ]);

        $subscriber->syncPermissions([
            'dashboard',
        ]);

        $user = User::where('email', 'nmbabu6040@gmail.com')->first();

        if ($user) {

            $user->syncRoles(['Super Admin']);
        }
    }
}
