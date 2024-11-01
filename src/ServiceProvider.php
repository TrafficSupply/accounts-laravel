<?php

namespace TrafficSupply\AccountsLaravel;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as ServiceProviderBase;
use TrafficSupply\AccountsLaravel\Middleware\NoAccountsToken;
use TrafficSupply\AccountsLaravel\Middleware\AccountsTokenIsValid;

final class ServiceProvider extends ServiceProviderBase
{
    /**
    * Bootstrap any package services.
    */
    public function boot(Router $router): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'accounts');
        $this->mergeConfigFrom(
            __DIR__.'/config/accounts.php', 'accounts'
        );
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/accounts'),
        ], 'accounts-views');
        $this->publishes([
            __DIR__ . '/accounts.php' => config_path('accounts.php'),
        ], 'accounts-config');
        $this->publishes([
            __DIR__.'/lang' => $this->app->langPath('vendor/accounts'),
        ], 'accounts-lang');

        $router->aliasMiddleware('token',
            AccountsTokenIsValid::class,
        );
        $router->aliasMiddleware('noToken',
            NoAccountsToken::class,
        );
        $this->publishesMigrations([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], 'accounts-migrations');

        Blade::componentNamespace('TrafficSupply\\AccountsLaravel\\Views\\Components', 'accounts');

        $this->loadTranslationsFrom(__DIR__.'/lang', 'accounts');
    }
}
