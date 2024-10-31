<?php

namespace TrafficSupply\TSAccountsLaravelPackage\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;
use TrafficSupply\TSAccountsLaravelPackage\TSAccounts;

class TSAccountsController
{

    public function login(Request $request): RedirectResponse
    {
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id'     => Config::get('tsaccounts.client_id'),
            'redirect_uri'  => route('callback'),
            'response_type' => 'code',
            'state'         => $state,
            'scopes'        => TSAccounts::scopes(),
        ]);

        return Redirect::to(Config::get('tsaccounts.url') . '/oauth/authorize?' . $query);

    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('access_token');
        $request->session()->forget('refresh_token');
        $request->session()->forget('expires_in');
        Session::save();

        return Redirect::to(route('login'));
    }

    /**
     * @throws Throwable
     */
    public function callback(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'state' => 'required|string',
            'code'  => 'required|string',
        ]);

        $state = $request->session()->pull('state');

        if (! $state || $state !== $validated['state']) {
            throw new InvalidArgumentException('Invalid state');
        }

        $response = Http::asForm()->post(Config::get('tsaccounts.host') . '/oauth/token', [
            'grant_type'    => 'authorization_code',
            'client_id'     => Config::get('tsaccounts.client_id'),
            'client_secret' => Config::get('tsaccounts.client_secret'),
            'redirect_uri'  => route('callback'),
            'code'          => $validated['code'],
        ]);

        // save access_token, refresh_token, and expires_in to the local storage
        $request->session()->put('access_token', $response->json()['access_token']);
        $request->session()->put('refresh_token', $response->json()['refresh_token']);
        $request->session()->put('expires_in', $response->json()['expires_in']);
        Session::save();

        return Redirect::to(route('home'));

    }
}
