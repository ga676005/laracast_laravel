<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
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
        // Set default pagination view - choose one:
        // Note: Use 'pagination::viewname' (with double colons) to use Laravel's default views from vendor
        // Use 'vendor.pagination.viewname' (with dots) only if you've published views to resources/views/vendor/pagination/
        Paginator::defaultView('pagination::tailwind'); // Full Tailwind (recommended)
        // Paginator::defaultView('pagination::default'); // Basic HTML
        // Paginator::defaultView('pagination::simple-tailwind'); // Simple Tailwind (Previous/Next only)
        // Paginator::defaultView('pagination::bootstrap-5'); // Bootstrap 5
        // Paginator::defaultView('pagination::simple-default'); // Simple basic

        // Rate limiter for email verification resend: 1 per minute and 3 per day
        RateLimiter::for('verification.resend', function (Request $request) {
            $key = $request->user()?->id ?: $request->ip();

            return [
                Limit::perMinute(1)->by($key),
                Limit::perDay(3)->by($key),
            ];
        });
    }
}
