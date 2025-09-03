<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-indigo-50 via-white to-cyan-50 min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Background decoration -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-3xl animate-float"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-cyan-400/20 to-blue-400/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
            </div>

            <!-- Logo section -->
            <div class="relative z-10 animate-fade-in-down">
                <a href="/" class="group">
                    <div class="w-24 h-24 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-2xl group-hover:shadow-indigo-500/25 transition-all duration-300 group-hover:scale-105">
                        <x-application-logo class="w-12 h-12 fill-current text-white" />
                    </div>
                </a>
                <h1 class="text-2xl font-bold text-gray-800 mt-4 text-center">Sistema de Gestión de Horarios</h1>
                <p class="text-gray-600 text-center mt-2">Accede a tu cuenta para continuar</p>
            </div>

            <!-- Form container -->
            <div class="relative z-10 w-full sm:max-w-md mt-8 px-6 py-8 bg-white/80 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20 animate-fade-in-up">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
