<?php

namespace TelegramBot\Laravel;

use Illuminate\Support\ServiceProvider;
use TelegramBot\BotsManager;
use TelegramBot\TelegramAuth;

// use Illuminate\Contracts\Container\Container as Application;
// use Illuminate\Contracts\Support\DeferrableProvider; // Для использования отложенного вызова SP

class TelegramBotServiceProvider extends ServiceProvider
{
    /** @var bool Indicates if loading of the provider is deferred. */
     protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'telegramBot');
        $this->registerBotManager();
        $this->registerTelegramAuth();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $cfg_file = realpath(__DIR__.'/../config/telegrambot.php');
        $this->mergeConfigFrom($cfg_file, 'telegrambot');
        $this->publishes([$cfg_file => config_path('telegrambot.php')], 'config');
    }

    public function registerBotManager()
    {
        $this->app->singleton('telegramBot', function () {
            $config = app('config')->get('telegrambot');
            return (new BotsManager($config))->getBot();
        });
    }

    public function registerTelegramAuth()
    {
        $this->app->singleton('telegramAuth', function () {
            return (new TelegramAuth());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
//     public function provides(): array
//     {
//         return ['telegramBot', 'telegramBotApi', BotsManager::class, Api::class];
//     }
}
