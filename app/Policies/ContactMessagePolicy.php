<?php

namespace App\Policies;

use App\Models\ContactMessage;
use App\Models\User;

class ContactMessagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function delete(User $user, ContactMessage $message): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function restore(User $user, ContactMessage $message): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }

    public function forceDelete(User $user, ContactMessage $message): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin'
        ]);
    }
}
