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


    public static function setScopes(string $scopes): Accounts
    {
        self::$scopes = $scopes;
        return new static;

    }

    public static string $home = 'accounts.home';

    public static function home(): string
    {
        return self::$home;
    }

    public static function setHomeNamedRoute(string $home): Accounts
    {
        self::$home = $home;
        return new static;

    }
    /**
     * The user model class name.
     *
     * @var string
     */
    public static string $userModel = Accountsuser::class;

    /**
     * Set the user model class name.
     *
     * @param string $userModel
     * @return Accounts
     */
    public static function useUserModel(string $userModel): Accounts
    {
        static::$userModel = $userModel;
        return new static;

    }

    /**
     * Get the user model class name.
     *
     * @return string
     */
    public static function userModel(): string
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
