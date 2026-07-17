<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * View category list / trash.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
            'Editor',
        ]);
    }

    /**
     * View single category.
     */
    public function view(User $user, Category $category): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
            'Editor',
        ]);
    }

    /**
     * Create category.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
            'Editor',
        ]);
    }

    /**
     * Edit category.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
            'Editor',
        ]);
    }

    /**
     * Soft delete.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
            'Editor',
        ]);
    }

    /**
     * Restore.
     */
    public function restore(User $user, Category $category): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
            'Editor',
        ]);
    }

    /**
     * Permanent delete.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
        ]);
    }
}
