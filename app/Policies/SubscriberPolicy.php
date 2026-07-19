<?php

namespace App\Policies;

use App\Models\Subscriber;
use App\Models\User;

class SubscriberPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
        ]);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
        ]);
    }

    public function delete(User $user, Subscriber $subscriber): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
        ]);
    }

    public function restore(User $user, Subscriber $subscriber): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
        ]);
    }

    public function forceDelete(User $user, Subscriber $subscriber): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
        ]);
    }
}
