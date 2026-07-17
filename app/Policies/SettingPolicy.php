<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;

class SettingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function view(User $user, Setting $setting): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function update(User $user, Setting $setting): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }
}
