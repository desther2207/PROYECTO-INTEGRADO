<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>e3Padel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">

    <style>
        .font-oswald {
            font-family: "Oswald", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: italic;
        }

        .font-roboto {
            font-family: "Roboto", sans-serif;
            font-optical-sizing: auto;
            font-weight: 340;
            font-style: normal;
            font-variation-settings: "wdth" 100;
        }

        .hover-button:hover {
            background-color: white;
            color: black;
            transition: all 0.3s ease;
        }

        /* Animación de aparición básica */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .title-appear {
            animation: fadeIn 1.5s ease;
        }

        /* Header sticky y completamente transparente */
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: transparent;
        }
    </style>

    <!-- Assets (asegúrate de haber compilado con Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen">
    <!-- Fondo: imagen y overlay -->
    <img src="{{ asset('storage/images/site/padel-background.webp') }}" class="absolute inset-0 w-full h-full object-cover" alt="Background">
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Contenido (header y main) -->
    <header class="sticky-header w-full p-6 flex justify-end">
        <div class="flex items-center gap-4">
            <a href="{{ url('/') }}">
                <img src="{{ asset('storage/images/logos/logo-escuela.png') }}" alt="Logo" class="h-20 w-auto" />
            </a>
        </div>
        <div class="container mx-auto flex justify-end items-center gap-6">
            <nav class="flex gap-6">
                <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-300">Inicio</a>
                <a href="#" class="text-white hover:text-gray-300">Torneos</a>
                <a href="#" class="text-white hover:text-gray-300">Resultados</a>
                <a href="#" class="text-white hover:text-gray-300">Contacto</a>
            </nav>
            <div class="flex gap-4">
                @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                    <a href="{{ url('/user/profile') }}" class="px-4 py-2 border rounded text-sm text-white hover-button">Mi perfil</a>
                    @else
                    <a href="{{ route('login') }}" class="px-4 py-2 border rounded text-sm text-white hover-button">Inicia sesión</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-4 py-2 border rounded text-sm text-white hover-button">Regístrate</a>
                    @endif
                    @endauth
                </nav>
                @endif
            </div>
        </div>
    </header>

    <main class="relative z-10  flex items-center justify-center">
        <div class="text-center text-white">
            <h1 class="text-6xl font-bold font-oswald title-appear">Welcome to e3Padel</h1>
            <p class="mt-4 text-xl font-roboto title-appear">Organiza y participa en torneos de pádel de manera sencilla</p>
        </div>
    </main>
</body>

</html>
