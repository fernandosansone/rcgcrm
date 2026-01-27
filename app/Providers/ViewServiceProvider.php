<?php

namespace App\Providers;

use App\Services\AgendaMetricsService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Inyectar variables SOLO al sidebar
        View::composer('components.sidebar', function ($view) {
            $user = auth()->user();

            $overdueCount = 0;

            if ($user && $user->can('agenda.view')) {
                $overdueCount = app(AgendaMetricsService::class)->overdueCountForUser($user->id);
            }

            $view->with('overdueCount', $overdueCount);
        });
    }
}
