<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Opportunity;
use App\Policies\OpportunityPolicy;
use App\Models\OpportunityFollowup;
use App\Policies\OpportunityFollowupPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Opportunity::class, OpportunityPolicy::class);
        Gate::policy(OpportunityFollowup::class, OpportunityFollowupPolicy::class);
    }
}
