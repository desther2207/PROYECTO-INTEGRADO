<x-app-layout>
    <x-self.base>

        <head>
            <title>Inicio</title>
        </head>

        {{-- ====== CARDS PRINCIPALES GRANDES CON EFECTOS ====== --}}
        <div class="px-6 pt-6 flex items-start justify-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-screen-xl w-full px-4 mx-auto">

                <a href="{{ route('tournaments') }}"
                    class="lg:row-span-2 group rounded-3xl shadow-xl relative overflow-hidden transition-all duration-500 bg-white/10 backdrop-blur-md hover:scale-105 hover:bg-white/80 min-h-[280px] sm:min-h-[320px] lg:min-h-[420px]"
                    data-aos="fade-left"
                    data-aos-duration="1000"
                    data-aos-easing="ease-in-out"
                    data-aos-delay="200">

                    {{-- Imagen --}}
                    <img src="{{ asset('storage/images/cards/juega.png') }}"
                        class="absolute inset-0 w-full h-full object-cover opacity-20 group-hover:opacity-100 transition-opacity duration-500 z-0"
                        alt="Torneos">

                    {{-- Texto central (desaparece en hover) --}}
                    <div class="relative z-10 p-12 h-full flex flex-col justify-center items-center text-center text-white transition-all duration-500 group-hover:opacity-0">
                        <h2 class="text-4xl font-bold uppercase">Torneos</h2>
                        <p class="text-lg mt-6">Participa en competiciones activas</p>
                    </div>

                    {{-- Franja de texto al hacer hover --}}
                    <div class="absolute bottom-0 left-0 w-full bg-black/60 backdrop-blur-sm p-6 translate-y-full group-hover:translate-y-0 transition-all duration-500 z-10">
                        <h2 class="text-2xl font-bold text-white uppercase">Torneos</h2>
                        <p class="text-sm text-gray-300 mt-1">Participa en competiciones activas</p>
                    </div>
                </a>

                <!-- Ranking -->
                <a href="{{ route('ranking.index') }}"
                    class="group rounded-3xl shadow-xl relative overflow-hidden transition-all duration-500 bg-white/10 backdrop-blur-md hover:scale-105 hover:bg-white/80 min-h-[180px] sm:min-h-[200px]"
                    data-aos="fade-down"
                    data-aos-duration="1000"
                    data-aos-easing="ease-in-out"
                    data-aos-delay="100">

                    <img src="{{ asset('storage/images/cards/ranking.png') }}"
                        class="absolute inset-0 w-full h-full object-cover opacity-20 group-hover:opacity-100 transition-opacity duration-500 z-0"
                        alt="Ranking">

                    {{-- Texto central (oculto en hover) --}}
                    <div class="relative z-10 p-10 h-full flex items-center justify-center text-center text-white transition-all duration-500 group-hover:opacity-0">
                        <h2 class="text-3xl font-bold uppercase">Ranking</h2>
                    </div>

                    {{-- Franja en hover --}}
                    <div class="absolute bottom-0 left-0 w-full bg-black/60 backdrop-blur-sm p-5 translate-y-full group-hover:translate-y-0 transition-all duration-500 z-10 text-white">
                        <h2 class="text-xl font-bold uppercase">Ranking</h2>
                        <p class="text-sm text-gray-300 mt-1">Consulta la clasificación de los jugadores</p>
                    </div>
                </a>

                <!-- Contacto -->
                <a href="{{ route('contacto.index') }}"
                    class="group rounded-3xl shadow-xl relative overflow-hidden transition-all duration-500 bg-white/10 backdrop-blur-md hover:scale-105 hover:bg-white/80 min-h-[180px] sm:min-h-[200px]"
                    data-aos="fade-right"
                    data-aos-duration="1000"
                    data-aos-easing="ease-in-out"
                    data-aos-delay="300">

                    <img src="{{ asset('storage/images/cards/contacto.png') }}"
                        class="absolute inset-0 w-full h-full object-cover opacity-20 group-hover:opacity-100 transition-opacity duration-500 z-0"
                        alt="Contacto">

                    {{-- Texto central (oculto en hover) --}}
                    <div class="relative z-10 p-10 h-full flex items-center justify-center text-center text-white transition-all duration-500 group-hover:opacity-0">
                        <h2 class="text-3xl font-bold uppercase">Contacto</h2>
                    </div>

                    {{-- Franja en hover --}}
                    <div class="absolute bottom-0 left-0 w-full bg-black/60 backdrop-blur-sm p-5 translate-y-full group-hover:translate-y-0 transition-all duration-500 z-10 text-white">
                        <h2 class="text-xl font-bold uppercase">Contacto</h2>
                        <p class="text-sm text-gray-300 mt-1">¿Tienes dudas? ¡Escríbenos!</p>
                    </div>
                </a>

                <!-- Crear Torneo -->
                @if (Auth::user()->role == 'editor' || Auth::user()->role == 'admin')

                <a href="{{ route('tournaments.create') }}"
                    class="lg:col-span-2 group rounded-3xl shadow-xl relative overflow-hidden transition-all duration-500 bg-white/10 backdrop-blur-md hover:scale-105 hover:bg-white/80 min-h-[180px] sm:min-h-[200px]"
                    data-aos="fade-up"
                    data-aos-duration="1000"
                    data-aos-easing="ease-in-out"
                    data-aos-delay="400">

                    <img src="{{ asset('storage/images/cards/organiza.png') }}"
                        class="absolute inset-0 w-full h-full object-cover opacity-20 group-hover:opacity-100 transition-opacity duration-500 z-0"
                        alt="Crear torneo">

                    {{-- Texto central (oculto en hover) --}}
                    <div class="relative z-10 p-10 h-full flex items-center justify-center text-center text-white transition-all duration-500 group-hover:opacity-0">
                        <h2 class="text-3xl font-bold uppercase">Organizar</h2>
                    </div>

                    {{-- Franja en hover --}}
                    <div class="absolute bottom-0 left-0 w-full bg-black/60 backdrop-blur-sm p-5 translate-y-full group-hover:translate-y-0 transition-all duration-500 z-10 text-white">
                        <h2 class="text-xl font-bold uppercase">Organizar</h2>
                        <p class="text-sm text-gray-300 mt-1">Crea tu propio torneo de pádel</p>
                    </div>
                </a>
                @else
                <div class="lg:col-span-2 group rounded-3xl shadow-xl relative overflow-hidden transition-all duration-500 bg-white/10 backdrop-blur-md hover:scale-105 min-h-[180px] sm:min-h-[200px]">

                    <div class="absolute inset-0 flex items-center justify-center text-white text-5xl opacity-30">
                        <i class="fas fa-lock"></i>
                    </div>

                    <div class="relative z-10 p-10 h-full flex items-center justify-center text-center text-white transition-all duration-500 opacity-100">
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- ====== SECCIÓN DE "MIS TORNEOS" ====== --}}
        @if (Auth::user()->role == 'editor' || Auth::user()->role == 'admin')
        <div class="px-6 mt-20">
            <div class="flex justify-between items-center">
                <h2 class="font-oswald-italic text-3xl">MIS TORNEOS</h2>
                <a href="{{ route('tournaments') }}" class="text-blue-500 hover:text-blue-700">Ver todos</a>
            </div>

            <div class="carousel carousel-center bg-gray-900 rounded-box mt-8 p-4 gap-4 flex overflow-x-auto scroll-smooth overflow-y-hidden scrollbar-thin scrollbar-thumb-indigo-500 scrollbar-track-neutral-700">
                @foreach ($tournaments as $tournament)
                <div class="carousel-item">
                    <div class="bg-gray-800 p-4 rounded-box shadow-lg w-80 h-full flex-shrink-0 group relative">
                        <a href="{{ route('tournaments.show', $tournament->id) }}" class="block">
                            <img src="{{ asset('storage/' . $tournament->tournament_image) }}" alt="Imagen del torneo"
                                class="w-full h-32 object-cover rounded-lg mb-4">
                            <h2 class="text-xl font-bold text-white">{{ $tournament->tournament_name }}</h2>
                            <p class="text-gray-400 break-words">{{ $tournament->description }}</p>
                            <p class="text-gray-300">Fecha inicio: {{ $tournament->start_date }}</p>
                            <p class="text-gray-300">Fecha fin: {{ $tournament->end_date }}</p>
                            <p class="text-gray-300">Sedes:
                                @foreach ($tournament->venues as $venue)
                                {{ $venue->venue_name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                        </a>

                        <div class="absolute bottom-2 right-2 z-10">
                            <button onclick="toggleMenu(this)" class="text-white hover:text-gray-300 focus:outline-none">
                                <i class="fa-solid fa-ellipsis-vertical m-2"></i>
                            </button>
                            <div class="menu-options absolute right-0 bottom-8 w-32 bg-white rounded-md shadow-lg z-20 hidden">
                                <a href="{{ route('tournaments.edit', $tournament->id) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Editar</a>
                                <form method="POST" action="{{ route('tournaments.destroy', $tournament->id) }}"
                                    onsubmit="return confirm('¿Estás seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Borrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <script>
            function toggleMenu(button) {
                const menu = button.nextElementSibling;
                menu.classList.toggle('hidden');
                document.querySelectorAll('.menu-options').forEach(m => {
                    if (m !== menu) m.classList.add('hidden');
                });
                document.addEventListener('click', function handler(e) {
                    if (!button.parentElement.contains(e.target)) {
                        menu.classList.add('hidden');
                        document.removeEventListener('click', handler);
                    }
                });
            }
        </script>
        @endif

        {{-- AOS Animate On Scroll --}}
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 800,
                once: true,
            });
        </script>

    </x-self.base>
</x-app-layout>