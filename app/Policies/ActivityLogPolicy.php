<?php

namespace App\Policies;

use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
        ]);
    }

    public function delete(User $user, ActivityLog $activityLog): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function clear(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }
}
