<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin      = Role::firstOrCreate(['name' => 'Admin']);
        $editor     = Role::firstOrCreate(['name' => 'Editor']);
        $author     = Role::firstOrCreate(['name' => 'Author']);
        $subscriber = Role::firstOrCreate(['name' => 'Subscriber']);

        // Super Admin → All Permissions
        $superAdmin->syncPermissions(Permission::all());

        // Admin
        $admin->syncPermissions([
            'dashboard',
            'manage-posts',
            'manage-categories',
            'manage-tags',
            'manage-pages',
            'manage-menus',
            'manage-comments',
            'manage-gallery',
            'manage-media',
            'manage-messages',
            'manage-subscribers',
            'manage-advertisements',
            'manage-activity',
            'manage-profile',
        ]);

        // Editor
        $editor->syncPermissions([
            'dashboard',
            'manage-posts',
            'manage-categories',
            'manage-tags',
            'manage-gallery',
            'manage-media',
            'manage-comments',
            'manage-profile',
        ]);

        // Author
        $author->syncPermissions([
            'dashboard',
            'manage-posts',
            'manage-media',
            'manage-profile',
        ]);

        // Subscriber
        $subscriber->syncPermissions([
            'manage-profile',
        ]);
    }
}
