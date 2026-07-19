<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // Dashboard
            'dashboard',

            // Users & Roles
            'manage-users',

            // Posts
            'manage-posts',

            // Categories
            'manage-categories',

            // Tags
            'manage-tags',

            // Pages
            'manage-pages',

            // Menus
            'manage-menus',

            // Comments
            'manage-comments',

            // Gallery
            'manage-gallery',

            // Media Library
            'manage-media',

            // Messages
            'manage-messages',

            // Subscribers
            'manage-subscribers',

            // Advertisements
            'manage-advertisements',

            // Settings
            'manage-settings',

            // Activity Log
            'manage-activity',

            // Backup
            'manage-backup',

            // Profile
            'manage-profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }
    }
}
