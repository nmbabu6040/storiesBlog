<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage-posts');
    }

    public function view(User $user, Post $post): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('manage-posts');
    }

    public function update(User $user, Post $post): bool
    {
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            return true;
        }

        if ($user->hasRole('Editor')) {
            return true;
        }

        return $post->user_id === $user->id;
    }

    public function delete(User $user, Post $post): bool
    {
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            return true;
        }

        if ($user->hasRole('Editor')) {
            return true;
        }

        return $post->user_id === $user->id;
    }
}
