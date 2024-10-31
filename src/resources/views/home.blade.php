<x-accounts::app-layout>
    <x-slot name="title">
        {{ trans('accounts::profile.home') }}
    </x-slot>
    <p class="self-center">{{trans('accounts::profile.welcome', ['name'=> \TrafficSupply\AccountsLaravel\Accounts::user()['name']])}}</p>
</x-accounts::app-layout>
