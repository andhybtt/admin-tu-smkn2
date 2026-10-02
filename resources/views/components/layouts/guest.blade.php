<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#1d4ed8">

    <title>Login - SMKN Karanganyar</title>

    <!-- PWA Manifest & App Icons -->
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">

    <!-- Tailwind & Livewire Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        svg {
            max-width: 1.5rem;
            max-height: 1.5rem;
            display: inline-block;
            flex-shrink: 0;
        }
    </style>
</head>
<body class="flex h-full flex-col font-sans text-slate-800 bg-slate-50">
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
