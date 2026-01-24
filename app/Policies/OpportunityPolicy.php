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
        return $user->can('opportunities.view');
    }

    public function create(User $user): bool
    {
        return $user->can('opportunities.create');
    }

    public function update(User $user, Opportunity $opportunity): bool
    {
        // MVP: permite editar si tiene permiso.
        // Más adelante podemos restringir a "solo las asignadas a mí".
        return $user->can('opportunities.update');
    }

    public function delete(User $user, Opportunity $opportunity): bool
    {
        return $user->can('opportunities.delete');
    }

    public function changeStatus(User $user, Opportunity $opportunity): bool
    {
        return $user->can('opportunities.change_status');
    }
}
