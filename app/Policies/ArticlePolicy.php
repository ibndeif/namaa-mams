<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{

    public function before(User $user, string $ability): bool|null
    {
        // super admin and admins can do any thing with articles
        if ($user->role === UserRole::SuperAdmin || $user->role === UserRole::Admin) {
            return true;
        }

        return null;
    }


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // all users can see all articles
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {   // all users can create a article
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        // the editor can only update his own posts
        return $user->role === UserRole::Editor && $user->id === $article->author_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        // the editor can only delete his own posts (same permission like update)
        return $this->update($user, $article);
    }

    /**
     * Determine whether the user can publish the model.
     */
    public function publish(User $user, Article $article): bool
    {
        // only super admins and admins can publish
        return false;
    }

    /**
     * Determine whether the user can unpublish the model.
     */
    public function unpublish(User $user, Article $article): bool
    {
        // only super admins and admins can unpublish
        return false;
    }
}
