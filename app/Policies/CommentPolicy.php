<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{

    public function before(User $user, string $ability): bool|null
    {
        // super admin and admins can do any thing with comments
        if ($user->role === UserRole::SuperAdmin || $user->role === UserRole::Admin) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // all users can create comments
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        // editors can delete their comments only
        return $user->role === UserRole::Editor && $user->id === $comment->author_id;
    }
}
