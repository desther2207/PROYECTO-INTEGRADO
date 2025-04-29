<x-app-layout>
    <x-self.base>
        <head>
            <title>Inicio</title>
        </head>

        @if (Auth::user()->role == 'editor' || Auth::user()->role == 'admin')
            <div class="flex justify-between items-center mt-4">
                <h2 class="font-oswald-italic text-3xl">MIS TORNEOS</h2>
                <a href="{{ route('tournaments') }}" class="text-blue-500 hover:text-blue-700">Ver todos</a>
            </div>

            <div class="carousel carousel-center bg-gray-900 rounded-box mt-8 p-4 gap-4 flex overflow-x-auto scroll-smooth overflow-y-hidden scrollbar-thin scrollbar-thumb-indigo-500 scrollbar-track-neutral-700">
            @foreach ($tournaments as $tournament)
                    <div class="carousel-item">
                        <div class="bg-gray-800 p-4 rounded-box shadow-lg w-80 h-full flex-shrink-0 group relative">

                            <!-- Contenido clicable -->
                            <a href="{{ route('tournaments.show', $tournament->id) }}" class="block">
                                <img src="{{ asset('storage/' . $tournament->tournament_image) }}"
                                     alt="Imagen del torneo"
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
                            

                            <!-- Botón de 3 puntitos -->
                            <div class="absolute bottom-2 right-2 z-10">
                                <button onclick="toggleMenu(this)"
                                        class="text-white hover:text-gray-300 focus:outline-none">
                                    <i class="fa-solid fa-ellipsis-vertical m-2"></i>
                                </button>

                                <!-- Menú de opciones -->
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
    </x-self.base>
</x-app-layout>
