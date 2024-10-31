<x-tsaccounts::app-layout>
    <x-slot name="title">
            {{ trans('tsacounts::profile.home') }}
    </x-slot>
    <p class="self-center">{{trans('tsacounts::profile.welcome', ['name'=> \TrafficSupply\TSAccountsLaravelPackage\TSAccounts::user()['name']])}}</p>
</x-tsaccounts::app-layout>
