<?php

namespace App\Providers;

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
        if (!session()->has('location')) {
            $ip = request()->ip();

            $location = getLocationByIp($ip);

            session()->put('location', $location);
        }

        if (!session()->has('timezone')) {
            $user = request()->user();
            $timezoneFromLocation = $location['geoplugin_timezone'] ?? config('app.timezone');

            if ($user) {
                $timezone = $user->timezone ?? $timezoneFromLocation;
            } else {
                $timezone = $timezoneFromLocation;
            }

            session()->put('timezone', $timezone);
        }

        if (!session()->has('fallback_timezone')) {
            session()->put('fallback_timezone', config('app.timezone'));
        }
    }
}
