<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('users.view');
    }

    public function create(User $user): bool
    {
        return $user->can('users.create');
    }

    public function update(User $user, User $model): bool
    {
        // Permiso global
        if ($user->can('users.update_all')) {
            return true;
        }

        // Permiso básico: puede editar solo usuarios NO Admin
        if ($user->can('users.update')) {
            return !$model->hasRole('Admin');
        }

        return false;
    }

    public function delete(User $user, User $model): bool
    {
        // Nunca borrarse a sí mismo
        if ($user->id === $model->id) {
            return false;
        }

        // Permiso global
        if ($user->can('users.delete_all')) {
            return true;
        }

        // Permiso básico: no puede borrar Admin
        if ($user->can('users.delete')) {
            return !$model->hasRole('Admin');
        }

        return false;
    }
}
