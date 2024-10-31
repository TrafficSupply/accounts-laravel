<?php

namespace TrafficSupply\TSAccountsLaravelPackage\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use TrafficSupply\TSAccountsLaravelPackage\TSAccounts;

class NoTSAccountsToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check health of tsaccounts
        try {
            $response = Http::get(config('tsaccounts.host') . '/up');
            if ($response->status() !== 200) {
                throw new Exception;
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'TSAccounts is down'], 500);
        }

        if (! TSAccounts::user()) {
            if (! self::refreshToken()) {
                return $next($request);
            }
        }
        return redirect()->route('home');

    }

    private static function refreshToken(): bool
    {
        $now = now()->timestamp;
        $refreshToken = Session::get('refresh_token');
        $response = Http::post(config('tsaccounts.host') . '/oauth/token', [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id'     => config('tsaccounts.client_id'),
            'client_secret' => config('tsaccounts.client_secret'),
            'scopes'        => TSAccounts::scopes(),
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
