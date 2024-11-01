# tsaccounts-laravel-package

This package was made to make connecting with https://accounts.trafficsupply.nl easier, but can be used for any OAuth2 server.

### Installation
Require this package with composer.
```bash
composer require trafficsupply/accounts-laravel
```

#### Laravel without auto-discovery:

If you don't use auto-discovery, add the ServiceProvider to the providers list. For Laravel 11 or newer, add the ServiceProvider in bootstrap/providers.php. For Laravel 10 or older, add the ServiceProvider in config/app.php.

```php
TrafficSupply\AccountsLaravel\ServiceProvider::class,
```

Add the following to your .env file:
```dotenv
ACCOUNTS_CLIENT_ID=<your client id>
ACCOUNTS_CLIENT_SECRET=<your client secret>
ACCOUNTS_HOST=https://accounts.trafficsupply.nl
ACCOUNTS_URL=https://accounts.trafficsupply.nl
```

Optionally you can publish the views, translations, config and migrations:

Publish the views:
```bash
php artisan vendor:publish --tag="accounts-views"
```

Publish the translations:
```bash
php artisan vendor:publish --tag="accounts-translations"
```

Publish the config file:
```bash
php artisan vendor:publish --tag="accounts-config"
```

Publish and run the migrations:
```bash
php artisan vendor:publish --tag="accounts-migrations"
php artisan migrate
```

### Configuration
You can change the configuration in the config file. The config file is located at config/accounts.php.
You can change the client id, client secret, host and url in the config file.

You can also change the User model, the User model is used to store the user data from the OAuth2 server. You may also change the home route and API scopes this way.

Add the following to a ServiceProvider:
```php
use TrafficSupply\AccountsLaravel\Accounts;
use TrafficSupply\AccountsLaravel\Models\Accountsuser;

public function boot()
{
    Accounts::useUserModel(Accountsuser::class)
        ->setHomeNamedRoute('accounts.home')
        ->setScopes('edit-theme view-user edit-locale');
}
```
