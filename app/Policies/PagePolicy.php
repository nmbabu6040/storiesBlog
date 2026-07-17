<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
            'Editor',
        ]);
    }

    public function view(User $user, Page $page): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, Page $page): bool
    {
        return $this->viewAny($user);
    }

    public function delete(User $user, Page $page): bool
    {
        return $this->viewAny($user);
    }

    public function restore(User $user, Page $page): bool
    {
        return $this->viewAny($user);
    }

    public function forceDelete(User $user, Page $page): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
        ]);
    }
}
