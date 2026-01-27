<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Opportunity;
use App\Models\OpportunityFollowup;

class OpportunityFollowupPolicy
{
    /**
     * Listar/Ver pantalla de seguimientos (historial / admin)
     */
    public function viewAny(User $user): bool
    {
        return $user->can('followups.view');
    }

    /**
     * Ver un seguimiento puntual (historial)
     * Regla: si tiene permiso y el followup pertenece a una oportunidad del usuario (o es admin/supervisor)
     */
    public function view(User $user, OpportunityFollowup $followup): bool
    {
        if (!$user->can('followups.view')) {
            return false;
        }

        // Admin/Supervisor pueden ver todo
        if ($user->can('followups.view_all')) {
            return true;
        }

        // Caso normal: solo si la oportunidad está asignada a él
        return (int) $followup->opportunity?->assigned_user_id === (int) $user->id;
    }

    /**
     * Crear seguimiento sobre una oportunidad específica.
     * Se usa así:
     *   Gate::authorize('create', [OpportunityFollowup::class, $opportunity]);
     */
    public function create(User $user, Opportunity $opportunity): bool
    {
        if (!$user->can('followups.create')) {
            return false;
        }

        // Solo sobre oportunidades asignadas a él (salvo admin/supervisor)
        if (!$user->can('followups.create_all') && (int)$opportunity->assigned_user_id !== (int)$user->id) {
            return false;
        }

        // No permitir si está finalizada (ganada/perdida)
        $status = $opportunity->status;

        // Si es enum con allowsFollowUp()
        if (is_object($status) && method_exists($status, 'allowsFollowUp')) {
            return $status->allowsFollowUp();
        }

        // Si es string
        if (is_string($status)) {
            return !in_array($status, ['ganada', 'perdida'], true);
        }

        return true;
    }

    /**
     * Editar un seguimiento (historial / admin)
     * Normalmente lo restringimos a admin/supervisor.
     */
    public function update(User $user, OpportunityFollowup $followup): bool
    {
        return $user->can('followups.update');
    }

    /**
     * Borrar un seguimiento (historial / admin)
     */
    public function delete(User $user, OpportunityFollowup $followup): bool
    {
        return $user->can('followups.delete');
    }
}
