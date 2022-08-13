<?php

namespace ModernMcGuire\MailThief;

use Livewire\Livewire;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use ModernMcGuire\MailThief\MailThiefTransport;
use ModernMcGuire\MailThief\Http\Livewire\Inbox;


class MailThiefServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        config()->set('mail.mailers.mailthief', ['transport' => 'mailthief']);

        Mail::extend('mailthief', function (array $config = []) {
            return new MailThiefTransport();
        });

        if (!$this->app->runningInConsole()) {
            \Livewire\Livewire::component('mailthief::inbox', Inbox::class);
        }


        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'mailthief');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mailthief');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes/mailthief.php');

        $this->registerRoutes();




        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('mailthief.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/mailthief'),
            ], 'views');*/

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/mailthief'),
            ], 'assets');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/mailthief'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'mailthief');

        // Register the main class to use with the facade
        $this->app->singleton('mailthief', function () {
            return new MailThief;
        });
    }

    protected function registerRoutes()
    {
        $this->app['router']->group([
            'namespace' => 'ModernMcGuire\MailThief\Http\Controllers',
            'prefix' => config('mailthief.prefix'),
            'middleware' => config('mailthief.middleware'),
        ], function ($router) {
            require __DIR__.'/routes/mailthief.php';
        });
    }
}
