<x-accounts::guest-layout>
    <a href="{{route('accounts-login')}}" class="">
        <x-Accounts::primary-button class="">
            {{trans('tsacounts::profile.login')}}
        </x-Accounts::primary-button>
    </a>
</x-accounts::guest-layout>