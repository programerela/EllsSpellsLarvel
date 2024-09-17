<?php

namespace App\Policies;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ThemePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Theme $theme): bool
    {
        return $theme->approve_status === 'APPROVED' && !$theme->isBlockedBy($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->role === 'user') {
            return false;
        }
        if ($user->role === 'MODERATOR') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Theme $theme): bool
    {
        if ($user->role === 'user') {
            return false;
        }

        if ($user->role === 'MODERATOR'  && $theme->user_id === $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Theme $theme): bool
    {
        if ($user->role === 'user') {
            return false;
        }

        if ($user->role === 'MODERATOR'  && $theme->user_id === $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Theme $theme): bool
    {
        if ($user->role === 'user') {
            return false;
        }

        if ($user->role === 'MODERATOR'  && $theme->user_id === $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Theme $theme): bool
    {
        if ($user->role === 'user') {
            return false;
        }

        if ($user->role === 'MODERATOR'  && $theme->user_id === $user->id) {
            return true;
        }
        return false;
    }

    public function block(User $user, Theme $theme): bool
    {
        if ($user->role === 'user') {
            return false;
        }

        if ($user->role === 'MODERATOR'  && $theme->user_id === $user->id) {
            return true;
        }
        return false;
    }
}
