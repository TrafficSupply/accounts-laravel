<?php

namespace TrafficSupply\TSAccountsLaravelPackage;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as ServiceProviderBase;
use TrafficSupply\TSAccountsLaravelPackage\Middleware\NoTSAccountsToken;
use TrafficSupply\TSAccountsLaravelPackage\Middleware\TSAccountsTokenIsValid;

final class ServiceProvider extends ServiceProviderBase
{
    /**
    * Bootstrap any package services.
    */
    public function boot(Router $router): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'TSAccounts');
        $this->mergeConfigFrom(
            __DIR__.'/../config/tsaccounts.php', 'tsaccounts'
        );
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/tsaccounts'),
        ], 'tsaccounts-views');
        $this->publishes([
            __DIR__ . '/../config/tsaccounts.php' => config_path('tsaccounts.php'),
        ], 'tsaccounts-config');
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/tsaccounts'),
        ], 'tsaccounts-lang');

        $router->aliasMiddleware('token',
            TSAccountsTokenIsValid::class,
        );
        $router->aliasMiddleware('noToken',
            NoTSAccountsToken::class,
        );
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'tsaccounts-migrations');

        Blade::componentNamespace('TrafficSupply\\TSAccountsLaravelPackage\\Views\\Components', 'tsaccounts');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'tsacounts');
    }
}
