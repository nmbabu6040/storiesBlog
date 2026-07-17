<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * View Users
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'Super Admin',
            'Admin',
        ]);
    }

    /**
     * Create User
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Update User
     */
    public function update(User $user, User $model): bool
    {
        // Super Admin can update everyone
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Admin can update everyone except Super Admin
        if ($user->hasRole('Admin')) {
            return ! $model->hasRole('Super Admin');
        }

        return false;
    }

    /**
     * Delete User
     */
    public function delete(User $user, User $model): bool
    {
        // Super Admin cannot delete himself
        if ($user->id === $model->id) {
            return false;
        }

        if ($model->hasRole('Super Admin')) {
            return false;
        }

        if ($user->hasRole('Super Admin')) {
            return true;
        }

        if ($user->hasRole('Admin')) {
            return ! $model->hasRole('Admin');
        }

        return false;
    }

    /**
     * Restore User
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Permanently Delete User
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole('Super Admin');
    }
}
