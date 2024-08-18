<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;

class TodoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Permitir que todos los usuarios vean todos los modelos
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Permitir que cualquier usuario cree tareas
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }
}
