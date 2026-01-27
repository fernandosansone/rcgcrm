<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Opportunity;

class OpportunityPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('opportunities.view');
    }

    public function view(User $user, Opportunity $opportunity): bool
    {
        if (!$user->can('opportunities.view')) {
            return false;
        }

        // Si querés un permiso explícito para "ver todo"
        if ($user->can('opportunities.view_all')) {
            return true;
        }

        // Regla normal: solo mis oportunidades
        return (int)$opportunity->assigned_user_id === (int)$user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('opportunities.create');
    }

    public function update(User $user, Opportunity $opportunity): bool
    {
        if (!$user->can('opportunities.update')) {
            return false;
        }

        if ($user->can('opportunities.update_all')) {
            return true;
        }

        return (int)$opportunity->assigned_user_id === (int)$user->id;
    }

    public function delete(User $user, Opportunity $opportunity): bool
    {
        if (!$user->can('opportunities.delete')) {
            return false;
        }

        if ($user->can('opportunities.delete_all')) {
            return true;
        }

        return (int)$opportunity->assigned_user_id === (int)$user->id;
    }

    public function changeStatus(User $user, Opportunity $opportunity): bool
    {
        if (!$user->can('opportunities.change_status')) {
            return false;
        }

        if ($user->can('opportunities.change_status_all')) {
            return true;
        }

        return (int)$opportunity->assigned_user_id === (int)$user->id;
    }
}
