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
    <div class="min-h-screen flex flex-col justify-center items-center relative">

        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-3xl animate-float">
            </div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-cyan-400/20 to-blue-400/20 rounded-full blur-3xl animate-float"
                style="animation-delay: 2s;"></div>
        </div>

        <!-- Logo section -->
        <div class="relative z-10 animate-fade-in-down text-center">
            <a href="/" class="group inline-block">
                <img src="https://institutotraversari.edu.ec/wp-content/uploads/2025/01/ISTPET-ORIGINAL.png"
                    alt="Logo ISTPET"
                    class="w-64 h-64 object-contain transition-transform duration-300 group-hover:scale-110">
            </a>
            <h1 class="text-4xl font-extrabold text-gray-800 mt-2">Sistema de Gestión de Horarios</h1>
            <p class="text-gray-600 mt-1 text-lg">Accede a tu cuenta para continuar</p>
        </div>

        <!-- Form container -->
        <div
            class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-10 bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl border border-white/20 animate-fade-in-up">

            <!-- Slot para el formulario -->
            {{ $slot }}

            <!-- Ejemplo de inputs si quieres personalizarlos -->
            {{--
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6">
                    <input type="email" name="email" placeholder="Correo electrónico"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition outline-none">
                </div>
                <div class="mb-6">
                    <input type="password" name="password" placeholder="Contraseña"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition outline-none">
                </div>
                <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow-md hover:bg-indigo-700 transition-transform transform hover:scale-105">
                    Iniciar Sesión
                </button>
            </form>
            --}}
        </div>
    </div>
</body>

</html>
