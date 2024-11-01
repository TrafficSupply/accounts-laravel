<x-accounts::guest-layout>
    <a href="{{route('accounts.login')}}" class="">
        <x-accounts::primary-button class="">
            {{trans('accounts::profile.login')}}
        </x-accounts::primary-button>
    </a>
</x-accounts::guest-layout>
