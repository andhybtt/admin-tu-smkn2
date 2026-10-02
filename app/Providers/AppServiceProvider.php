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
        // Enforce HTTPS and Root URL behind Cloudflare Tunnel or Reverse Proxy
        if (
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
            || env('FORCE_HTTPS', false)
            || app()->environment('production')
        ) {
            URL::forceScheme('https');
            URL::forceRootUrl(env('APP_URL', 'https://simtu.sknddev.com'));
        }

        // Force disable ASSET_URL to prevent Vite from generating broken protocol-relative URLs (//build/assets...)
        config(['app.asset_url' => null]);
        putenv('ASSET_URL=');
        unset($_SERVER['ASSET_URL'], $_ENV['ASSET_URL']);
    }
}
