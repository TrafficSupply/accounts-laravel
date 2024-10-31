<x-accounts::app-layout>
    <x-slot name="title">
        {{ trans('tsacounts::profile.home') }}
    </x-slot>
    <p class="self-center">{{trans('tsacounts::profile.welcome', ['name'=> \TrafficSupply\AccountsLaravel\Accounts::user()['name']])}}</p>
</x-accounts::app-layout>
