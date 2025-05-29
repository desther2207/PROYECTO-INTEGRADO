<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>e3Padel</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        .font-oswald {
            font-family: 'Oswald', sans-serif;
        }

        .font-roboto {
            font-family: 'Roboto', sans-serif;
        }

        .hover-button:hover {
            background-color: white;
            color: black;
            transition: all 0.3s ease;
        }

        .fade-in {
            animation: fadeIn 1.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: none;
            }

            from {
                opacity: 0;
                transform: translateY(20px);
            }
        }

        .sticky-header {
            position: sticky;
            top: 0;
            background-color: transparent;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-roboto m-0 p-0">
    <!-- Header original restaurado completamente transparente -->
    <header class="sticky top-0 z-50 bg-black bg-opacity-80 text-white" role="banner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('storage/images/logos/logo-escuela.png') }}" alt="Logo" class="h-16 w-auto" />
                    </a>
                </div>

                <!-- Botón del menú en móvil -->
                <div class="md:hidden">
                    <button id="nav-toggle" class="focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Menú de navegación -->
                <nav id="nav-menu" aria-label="Menu principal"
                    class="hidden md:flex flex-col md:flex-row gap-y-3 md:gap-y-0 md:gap-x-6 items-start md:items-center absolute md:static top-20 left-0 w-full md:w-auto bg-black bg-opacity-90 md:bg-transparent px-6 py-4 md:p-0">

                    <a href="{{ route('dashboard') }}" class="hover:text-indigo-300" aria-current="page">Inicio</a>
                    <a href="{{ route('tournaments') }}" class="hover:text-indigo-300">Torneos</a>
                    <a href="{{ route('ranking.index') }}" class="hover:text-indigo-300">Ranking</a>
                    <a href="{{ route('contacto.index') }}" class="hover:text-indigo-300">Contacto</a>

                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/user/profile') }}"
                        class="px-4 py-2 border rounded text-sm hover-button mt-2 md:mt-0">Mi perfil</a>
                    @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 border rounded text-sm hover-button mt-2 md:mt-0">Inicia sesión</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 border rounded text-sm hover-button mt-2 md:mt-0">Regístrate</a>
                    @endif
                    @endauth
                    @endif
                </nav>
            </div>
        </div>

        <!-- Script para toggle -->
        <script>
            const navToggle = document.getElementById('nav-toggle');
            const navMenu = document.getElementById('nav-menu');

            navToggle.addEventListener('click', () => {
                navMenu.classList.toggle('hidden');
            });
        </script>
    </header>


    <!-- Hero Section -->
    <section class="bg-cover bg-center h-screen text-white" aria-labelledby="bienvenida-heading" role="region" style="background-image: url('{{ asset('storage/images/site/padel-background.webp') }}')">
        <div class="bg-black bg-opacity-50 h-full flex items-center justify-center">
            <div class="text-center px-6 fade-in">
                <h1 id="bienvenida-heading" class="text-5xl md:text-7xl font-oswald font-bold">Bienvenido a e3Padel</h1>
                <p class="text-xl mt-4 text-gray-200">Organiza y participa en torneos de pádel de manera sencilla</p>
            </div>
        </div>
    </section>

    <!-- Funcionalidades -->
    <section id="funcionalidad" class="py-16 bg-white" aria-labelledby="funcionalidad-heading">
        <div class="container mx-auto px-6">
            <h2 id="funcionalidad-heading" class="text-3xl font-oswald text-center mb-12 text-black">¿Qué puedes hacer en e3Padel?</h2>
            <div class="grid md:grid-cols-3 gap-12 text-black">
                <div class="text-center">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>

                    <h3 class="text-xl font-bold">Fácil de usar</h3>
                    <p class="mt-2 text-gray-700">Crea torneos en minutos con inscripciones online y panel de gestión intuitivo.</p>
                </div>
                <div class="text-center">
                    <!-- formats.svg -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7l9 4 9-4-9-4-9 4zM3 12l9 4 9-4M3 17l9 4 9-4" />
                    </svg>
                    <h3 class="text-xl font-bold">Múltiples formatos</h3>
                    <p class="mt-2 text-gray-700">Ligas, torneos, liguillas o circuitos. Adáptate al estilo de tu comunidad.</p>
                </div>
                <div class="text-center">
                    <!-- professional.svg -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.905c.969 0 1.371 1.24.588 1.81l-3.974 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.974-2.89a1 1 0 00-1.175 0l-3.974 2.89c-.784.57-1.838-.197-1.54-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.974-2.89c-.784-.57-.38-1.81.588-1.81h4.905a1 1 0 00.95-.69l1.518-4.674z" />
                    </svg>
                    <h3 class="text-xl font-bold">Imagen profesional</h3>
                    <p class="mt-2 text-gray-700">Personaliza el sitio con tu logo, colores y haz que tu torneo luzca espectacular.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Llamado a la acción -->
    <section id="registro" class="py-20 bg-blue-600 text-white text-center" role="region" aria-labelledby="registro-heading">
        <h2 id="registro-heading" class="text-4xl font-bold mb-6">¿Estás listo para comenzar?</h2>
        <p class="mb-6">Regístrate como organizador o jugador y únete a la comunidad de e3Padel.</p>
        <div class="flex justify-center gap-6">
            <a href="{{ route('register') }}" class="bg-white text-blue-600 px-6 py-3 rounded hover:bg-gray-100">Soy Organizador</a>
            <a href="{{ route('register') }}" class="bg-white text-blue-600 px-6 py-3 rounded hover:bg-gray-100">Soy Jugador</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 text-center" role="contentinfo">
        <p>&copy; 2025 e3Padel. Todos los derechos reservados.</p>
    </footer>
</body>

</html>