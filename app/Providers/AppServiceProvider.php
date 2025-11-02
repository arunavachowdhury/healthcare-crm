<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        // Testing actions
        if (app()->environment('local')) {
            // Dynamically set the host based on the request
            URL::forceRootUrl(config('app.url'));
        }
    }
}
