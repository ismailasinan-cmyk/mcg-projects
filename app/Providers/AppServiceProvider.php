<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Automatically create storage symlink if it doesn't exist
        $publicStoragePath = public_path('storage');
        if (!file_exists($publicStoragePath)) {
            try {
                $this->app->make('files')->link(
                    storage_path('app/public'),
                    $publicStoragePath
                );
            } catch (\Exception $e) {
                // Fail silently but log if needed in future
            }
        }
    }
}
