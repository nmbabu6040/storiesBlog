<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            'dashboard',

            'manage-users',

            'manage-settings',

            'manage-posts',

            'manage-menus',

            'manage-categories',

            'manage-pages',

            'manage-comments',

            'manage-gallery',

        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }
    }
}
