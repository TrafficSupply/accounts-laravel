<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route(\TrafficSupply\AccountsLaravel\Accounts::home()) }}">
                        <x-accounts::application-logo class="block h-9 w-auto fill-current" />
                    </a>
                </div>
                @isset($title)
                    <header>
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-center gap-2">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ $title }}
                            </h2>
                        </div>
                    </header>
                @endisset
                <!-- Navigation Links -->
                <div class="space-x-8 -my-px ms-10 flex">
                    <x-accounts::nav-link :href="route(\TrafficSupply\AccountsLaravel\Accounts::home())" :active="request()->route(\TrafficSupply\AccountsLaravel\Accounts::home())">
                        {{ trans('accounts::profile.home') }}
                    </x-accounts::nav-link>
                    <x-accounts::nav-link :href="route('accounts.logout')">
                        {{ trans('accounts::profile.logout') }}
                    </x-accounts::nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
