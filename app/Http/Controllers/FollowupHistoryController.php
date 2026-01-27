<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class FollowupHistoryController extends Controller
{
    public function index(Request $request, Opportunity $opportunity)
    {
        // Regla: solo dueño de la oportunidad o alguien con permiso “ver oportunidades” y que el sistema permita (simplificado)
        $this->authorize('view', $opportunity);

        $followups = $opportunity->followups()
            ->orderByDesc('contact_date')
            ->get(['id','contact_date','contact_method','response','next_contact_date','created_by','created_at']);

        return response()->json([
            'opportunity' => [
                'id' => $opportunity->id,
                'detail' => $opportunity->detail,
                'status' => $opportunity->status,
            ],
            'followups' => $followups,
        ]);
    }
}
