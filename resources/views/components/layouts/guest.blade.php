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
    <!-- Fallback CDN: Ensures styling works instantly even if Vite fails on Dokploy -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-slate-800 bg-white">
    {{ $slot }}
    @livewireScripts
</body>
</html>
