<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AgendaMetricsService
{
    public function overdueCountForUser(int $userId, ?Carbon $date = null): int
    {
        $today = ($date ?? Carbon::today())->toDateString();

        // Subquery: último followup por oportunidad (MAX(contact_date))
        $latestFollowup = DB::table('opportunity_followups as f')
            ->select('f.opportunity_id', DB::raw('MAX(f.contact_date) as last_contact_date'))
            ->groupBy('f.opportunity_id');

        // Subquery: next_contact_date del followup más reciente
        $lastFollowupData = DB::table('opportunity_followups as f')
            ->joinSub($latestFollowup, 'lf', function ($join) {
                $join->on('lf.opportunity_id', '=', 'f.opportunity_id')
                    ->on('lf.last_contact_date', '=', 'f.contact_date');
            })
            ->select('f.opportunity_id', 'f.next_contact_date');

        return (int) DB::table('opportunities as o')
            ->leftJoinSub($lastFollowupData, 'lfd', function ($join) {
                $join->on('lfd.opportunity_id', '=', 'o.id');
            })
            ->where('o.assigned_user_id', $userId)
            ->whereNotNull('lfd.next_contact_date')
            ->whereDate('lfd.next_contact_date', '<', $today)
            ->count();
    }
}
