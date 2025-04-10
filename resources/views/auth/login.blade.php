<x-guest-layout>
    <!-- Página de login con fondo específico -->
    <body class="min-h-screen flex bg-gray-900 flex-col overflow-hidden relative z-0">

        <!-- Navbar (fondo oscuro) -->
        <header class="w-full p-6 bg-gray-900">
            <div class="container mx-auto flex justify-end items-center gap-6">
                <nav class="flex gap-6">
                    <a href="{{ url('/') }}" class="text-white hover:text-gray-300">Inicio</a>
                    <a href="#" class="text-white hover:text-gray-300">Torneos</a>
                    <a href="#" class="text-white hover:text-gray-300">Resultados</a>
                    <a href="#" class="text-white hover:text-gray-300">Contacto</a>
                </nav>
                <div class="flex gap-4">
                    @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 border rounded text-sm text-white hover:bg-white hover:text-black">Inicio</a>
                        @else
                        <a href="{{ route('login') }}" class="px-4 py-2 border rounded text-sm text-white hover:bg-white hover:text-black">Inicia sesión</a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 border rounded text-sm text-white hover:bg-white hover:text-black">Regístrate</a>
                        @endif
                        @endauth
                    </nav>
                    @endif
                </div>
            </div>
        </header>

        <!-- Contenedor central de login -->
        <x-authentication-card>
            <x-slot name="logo">
                <!-- Mantener el diseño original del logo -->
                <x-authentication-card-logo class="h-40 w-auto mx-auto" />
            </x-slot>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6 bg-gray-800 p-6 rounded-lg shadow-lg">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="text-white" />
                    <x-input id="email" class="block mt-1 w-full bg-gray-700 text-white rounded-md" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('Contraseña') }}" class="text-white" />
                    <x-input id="password" class="block mt-1 w-full bg-gray-700 text-white rounded-md" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="flex items-center mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" class="text-white" />
                        <span class="ms-2 text-sm text-gray-300">{{ __('Recordarme') }}</span>
                    </label>
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="flex items-center mt-4">
                    <x-checkbox name="terms" id="terms" class="text-green-500" required />
                    <label for="terms" class="ml-2 text-white text-sm">
                        {!! __('Acepto los :términos_de_servicio y la :política_de_privacidad', [
                            'términos_de_servicio' => '<a href="'.route('terms.show').'" class="text-green-300 hover:text-green-500 underline">'.__('términos de servicio').'</a>',
                            'política_de_privacidad' => '<a href="'.route('policy.show').'" class="text-green-300 hover:text-green-500 underline">'.__('política de privacidad').'</a>',
                        ]) !!}
                    </label>
                </div>
            @endif

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-300 hover:text-white" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif

                    <x-button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                        {{ __('Iniciar sesión') }}
                    </x-button>
                </div>
            </form>
        </x-authentication-card>
    </body>
</x-guest-layout>
