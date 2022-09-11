<?php

namespace SoftHouse\AuthTracker;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use SoftHouse\AuthTracker\Models\PersonalAccessToken;

class AuthTrackerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/authtracker.php' => config_path('authtracker.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations/update_personal_access_tokens_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . 'update_personal_access_tokens_table.php'),
                // you can add any number of migrations here
              ], 'migrations');

        }

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/authtracker.php', 'authtracker');

        $this->app->singleton('authtracker', function () {
            return new Authtracker;
        });
    }
}
