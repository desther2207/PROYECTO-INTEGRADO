<x-guest-layout>
    <!-- Fondo general -->
    <div class="min-h-screen flex flex-col bg-gray-900 overflow-hidden">

        <!-- Navbar -->
        <header class="w-full p-4 bg-gray-900 text-white">
            <div class="container mx-auto flex justify-between items-center">
                <!-- Logo opcional -->
                <a href="{{ url('/') }}" class="text-lg font-bold">e3Padel</a>

                <!-- Botón hamburguesa -->
                <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Menú de navegación -->
                <nav id="mobile-menu"
                    class="hidden slide-up md:flex flex-col md:flex-row gap-4 md:gap-6 absolute md:static top-20 left-0 w-full md:w-auto bg-gray-900 md:bg-transparent px-6 py-4 md:p-0 z-40 text-white">
                    <a href="{{ url('/') }}" class="hover:text-gray-300">Inicio</a>
                    <a href="{{ route('tournaments') }}" class="hover:text-gray-300 mr-3">Torneos</a>
                    <a href="{{ route('ranking.index') }}" class="hover:text-gray-300 mr-3">Ranking</a>
                    <a href="{{ route('contacto.index') }}" class="hover:text-gray-300 mr-3">Contacto</a>

                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2 border rounded text-sm hover:bg-white hover:text-black">Inicio</a>
                    @else
                    <a href="{{ route('login') }}"
                        class="block md:inline px-4 py-2 border rounded text-sm hover:bg-white hover:text-black text-center">Inicia
                        sesión</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="block md:inline px-4 py-2 border rounded text-sm hover:bg-white hover:text-black text-center">Regístrate</a>
                    @endif
                    @endauth
                    @endif
                </nav>
            </div>

            <!-- Script toggle -->
            <script>
                const toggle = document.getElementById('menu-toggle');
                const menu = document.getElementById('mobile-menu');

                toggle.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });

                // Cierra el menú al hacer clic en un enlace
                document.querySelectorAll('#mobile-menu a').forEach(link => {
                    link.addEventListener('click', () => {
                        menu.classList.add('hidden');
                    });
                });
            </script>
        </header>


        <!-- Cuerpo dividido -->
        <div class="flex flex-col md:flex-row flex-1">
            <!-- Lado izquierdo visual -->
            <div class="relative w-full md:w-1/2 bg-gradient-to-br from-gray-800 to-gray-900 text-white flex justify-center items-center p-10 overflow-hidden">
                <div class="text-center z-10">
                    <x-authentication-card-logo class="h-28 mx-auto mb-6" />
                    <h2 class="text-3xl font-bold">¡Bienvenido!</h2>
                    <p class="mt-2 text-gray-300">Inicia sesión para acceder a tu cuenta.</p>
                </div>
                <div class="absolute -bottom-32 -left-40 w-80 h-80 border-4 border-white border-opacity-30 rounded-full border-t-8 z-0"></div>
                <div class="absolute -bottom-40 -left-20 w-80 h-80 border-4 border-white border-opacity-30 rounded-full border-t-8 z-0"></div>
                <div class="absolute -top-40 -right-0 w-80 h-80 border-4 border-white border-opacity-30 rounded-full border-t-8 z-0"></div>
                <div class="absolute -top-20 -right-20 w-80 h-80 border-4 border-white border-opacity-30 rounded-full border-t-8 z-0"></div>
            </div>

            <!-- Formulario login -->
            <div class="w-full md:w-1/2 flex items-center justify-center bg-white py-12">
                <form method="POST" action="{{ route('login') }}" class="w-80">
                    @csrf

                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Iniciar sesión</h2>

                    <x-validation-errors class="mb-4" />

                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="mb-4">
                        <x-label for="email" value="Correo electrónico" />
                        <x-input id="email" class="mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mb-4">
                        <x-label for="password" value="Contraseña" />
                        <x-input id="password" class="mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center mb-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                        @endif
                    </div>

                    <x-button class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                        Iniciar sesión
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
<style>
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50%);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .slide-up {
        animation: slideUp 0.4s ease-out forwards;
    }
</style>