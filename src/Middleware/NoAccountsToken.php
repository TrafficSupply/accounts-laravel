<?php

namespace TrafficSupply\AccountsLaravel\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use TrafficSupply\AccountsLaravel\Accounts;

class NoAccountsToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check health of accounts
        try {
            $response = Http::get(config('accounts.host') . '/up');
            if ($response->status() !== 200) {
                throw new Exception;
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Accounts is down'], 500);
        }

        if (! Accounts::user()) {
            if (! self::refreshToken()) {
                return $next($request);
            }
        }
        return redirect()->route(Accounts::home());

    }

    private static function refreshToken(): bool
    {
        $now = now()->timestamp;
        $refreshToken = Session::get('refresh_token');
        $response = Http::post(config('accounts.host') . '/oauth/token', [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id'     => config('accounts.client_id'),
            'client_secret' => config('accounts.client_secret'),
            'scopes'        => Accounts::scopes(),
        ]);
        $response = $response->json();

        if (array_key_exists('error', $response)) {
            Session::forget('access_token');
            Session::forget('refresh_token');
            Session::forget('expires_in');
            Session::save();

            return false;
        }

        Session::put('access_token', $response['access_token']);
        Session::put('refresh_token', $response['refresh_token']);
        Session::put('expires_in', $now + $response['expires_in']);
        Session::save();

        return true;

    }
}
