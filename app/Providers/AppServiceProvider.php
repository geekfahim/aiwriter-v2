<?php

namespace App\Providers;

use Helper;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!\App::environment('local')) {
            \URL::forceScheme('https');
        }

        try {
            // Check if the database connection works
            DB::connection()->getPdo();
            
            // Set the sitekey and secret if the connection is successful
            Config::set('recaptchav3.sitekey', Helper::config('recaptcha_site_key'));
            Config::set('recaptchav3.secret', Helper::config('recaptcha_secret_key'));
        } catch (\Exception $e) {
            // Log the error if the database connection fails
            //Log::error('Failed to connect to the database: ' . $e->getMessage());
        }
    }
}
