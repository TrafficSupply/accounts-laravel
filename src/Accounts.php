<?php

namespace TrafficSupply\AccountsLaravel;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Throwable;
use TrafficSupply\AccountsLaravel\Models\Accountsuser;

class Accounts
{

    public static string $scopes = 'edit-theme view-user edit-locale';

    public static function scopes(): string
    {
        return self::$scopes;
    }


    public static function setScopes(string $scopes): void
    {
        self::$scopes = $scopes;
    }

    /**
     * The user model class name.
     *
     * @var string
     */
    public static $userModel = Accountsuser::class;

    /**
     * Set the user model class name.
     *
     * @param  string  $userModel
     * @return void
     */
    public static function useUserModel($userModel)
    {
        static::$userModel = $userModel;
    }

    /**
     * Get the user model class name.
     *
     * @return string
     */
    public static function userModel()
    {
        return static::$userModel;
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ConnectionException
     */
    public static function post(string $path, array $data = []): Response
    {
        return Http::withToken(Session::get('access_token'))->post(Config::get('accounts.host') . $path, $data);
    }

    /**
     * @throws ConnectionException
     */
    public static function get(string $path): PromiseInterface|Response
    {
        return Http::withToken(Session::get('access_token'))->get(Config::get('accounts.host') . $path);

    }

    /**
     * @return false|array<string, mixed>
     */
    public static function user(): array|false
    {
        try {
            return self::get('/api/user')->json();
        } catch (Throwable) {
            return false;
        }
    }
}
