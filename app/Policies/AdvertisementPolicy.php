<?php

namespace App\Policies;

use App\Models\Advertisement;
use App\Models\User;

class AdvertisementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function update(User $user, Advertisement $advertisement): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function delete(User $user, Advertisement $advertisement): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function restore(User $user, Advertisement $advertisement): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function forceDelete(User $user, Advertisement $advertisement): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }
}
