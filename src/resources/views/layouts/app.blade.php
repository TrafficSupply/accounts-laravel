<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{$title}}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Scripts -->
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased">
<div class="min-h-screen text-black dark:text-white bg-gray-100 dark:bg-gray-900 flex flex-col">
    <!-- Page Heading -->
    @include('Accounts::layouts.navigation')


    <!-- Page Content -->
    <main class="grow flex flex-col">
        {{ $slot }}
    </main>
</div>
@vite('resources/js/app.js')
</body>
</html>