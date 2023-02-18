<?php

namespace Lunacms\Forums;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ForumsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerMorphMap();
        $this->registerPolicies();

        /*
         * Optional methods to load your package assets
         */
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('forums.php'),
            ], 'forums-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'forums');

        // Register the main class to use with the facade
        $this->app->singleton('forums', function () {
            return new Forums;
        });
    }

    public function registerMorphMap()
    {
        \Illuminate\Database\Eloquent\Relations\Relation::morphMap(config('forums.morph_map'));
    }

    public function registerPolicies()
    {
        foreach (config('forums.policies') as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    public function registerModels()
    {
        foreach (config('forums.models') as $key => $value) {
            $class = Str::of($key)
                        ->singular()
                        ->append('Model')
                        ->studly()
                        ->prepend('\Lunacms\Forums\Contracts\\')
                        ->toString();

            if (interface_exists($class) && class_exists($value)) {
                $this->app->singleton($class, function () use($value) {
                    return new $value();
                });
            }
        }
    }
}
