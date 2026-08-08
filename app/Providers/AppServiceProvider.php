<?php

namespace App\Providers;

use App\Services\FinancialNotificationService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.app', function ($view): void {
            $notifications = auth()->check()
                ? app(FinancialNotificationService::class)->forUser(auth()->user())
                : ['count' => 0, 'items' => []];

            $view->with('financialNotifications', $notifications);
        });
    }
}
