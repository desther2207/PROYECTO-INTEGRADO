<x-self.base>
    <div class="p-4" role="main" aria-labelledby="titulo-torneos">
        <!-- Encabezado con título y botón para crear torneo -->
        <div class="flex justify-between items-center mb-6">
            <h2 id="titulo-torneos" class="font-oswald-italic text-3xl text-transparent text-white pr-1">TORNEOS DISPONIBLES</h2>
            @if (Auth::check() && (Auth::user()->role == 'editor' || Auth::user()->role == 'admin'))
            <a href="{{ route('tournaments.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                aria-label="Crear nuevo torneo">
                Crear Torneo
            </a>
            @endif
        </div>

        <!-- Sección de filtros -->
        <div class="mb-6" role="search" aria-label="Filtrar torneos">
            <form wire:submit.prevent="render" class="flex flex-wrap gap-4 items-end">
                <!-- Búsqueda por texto -->
                <div>
                    <label for="texto" class="block text-white font-medium">Buscar:</label>
                    <input type="text" wire:model.live="texto" id="texto" placeholder="Buscar torneos"
                        class="mt-1 px-3 text-black py-2 rounded border border-gray-300"
                        aria-label="Buscar torneos por nombre o descripción">
                </div>

                <!-- Filtro por estado -->
                <div>
                    <label for="status" class="block text-white font-medium">Estado:</label>
                    <select wire:model.live="status" id="status"
                        class="mt-1 px-3 py-2 text-black rounded border border-gray-300"
                        aria-label="Filtrar por estado del torneo">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="inscripcion">Inscripción</option>
                        <option value="en curso">En curso</option>
                        <option value="finalizado">Finalizado</option>
                    </select>
                </div>

                <!-- Filtro por provincia -->
                <div>
                    <label for="province" class="block text-white font-medium">Provincia:</label>
                    <select wire:model.live="province_id" id="province_id"
                        class="mt-1 px-3 py-2 text-black rounded border border-gray-300"
                        aria-label="Filtrar por provincia">
                        <option value="">Todas</option>
                        @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Listado de torneos -->
        <section aria-label="Listado de torneos">
            @forelse($tournaments as $tournament)
            <article class="flex flex-col md:flex-row w-full my-6 bg-white shadow-sm border border-slate-200 rounded-lg min-h-[300px] relative" role="region" aria-labelledby="tournament-{{ $tournament->id }}">
                <!-- Imagen -->
                <div class="md:w-1/5 w-full h-80 p-2">
                    <img src="{{ asset('storage/' . $tournament->cartel) }}" alt="Cartel del torneo"
                        class="w-full h-full object-cover rounded-lg">
                </div>

                <!-- Contenido -->
                <div class="p-6 flex flex-col justify-between md:w-3/5 w-full">
                    <div>
                        <div class="mb-4 rounded-full bg-teal-600 py-0.5 px-2.5 text-xs text-white w-fit" aria-label="Estado: {{ $tournament->status }}">
                            {{ $tournament->status }}
                        </div>

                        <a href="{{ route('tournaments.show', $tournament->id) }}" id="tournament-{{ $tournament->id }}">
                            <h4 class="mb-2 text-slate-800 text-xl font-semibold hover:underline">
                                {{ $tournament->tournament_name }}
                            </h4>
                        </a>

                        <p class="mb-5 text-slate-600 font-light">
                            {{ \Illuminate\Support\Str::limit($tournament->description, 150, '...') }}
                        </p>

                        <p class="mb-2 text-slate-800">
                            <span class="font-bold">Provincia:</span> {{ $tournament->province->province_name }}
                        </p>

                        <p class="mb-2 text-slate-800">
                            <span class="font-bold">Fecha Inicio:</span> {{ $tournament->start_date }}
                        </p>

                        <p class="mb-2 text-slate-800">
                            <span class="font-bold">Fecha Fin:</span> {{ $tournament->end_date }}
                        </p>

                        <p class="mb-4 text-slate-800">
                            <span class="font-bold">Sedes:</span>
                            @foreach ($tournament->venues as $venue)
                            {{ $venue->venue_name }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </p>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <a href="{{ route('tournaments.show', $tournament->id) }}"
                            class="text-slate-800 font-semibold text-sm hover:underline flex items-center"
                            aria-label="Ver más sobre el torneo {{ $tournament->tournament_name }}">
                            Ver más
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>

                        @php
                        $user = Auth::user();
                        $isOrganizer = $tournament->organizers->contains($user);
                        $isAdmin = $user->role === 'admin';
                        @endphp

                        @if ($isOrganizer || $isAdmin)
                        <div class="relative md:hidden">
                            <button onclick="toggleMenu(this)" class="text-gray-700 hover:text-black focus:outline-none"
                                aria-label="Opciones del torneo {{ $tournament->tournament_name }}">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="menu-options absolute right-0 mt-2 w-32 bg-gray-200 rounded-md shadow-lg z-20 hidden"
                                role="menu" aria-label="Opciones del torneo">
                                <a href="{{ route('tournaments.edit', $tournament->id) }}" role="menuitem"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Editar</a>
                                <form method="POST" action="{{ route('tournaments.destroy', $tournament->id) }}"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" role="menuitem"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Borrar</button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>

                </div>

                @if ($isOrganizer || $isAdmin)
                <div class="absolute top-2 right-2 z-10 hidden sm:block">
                    <button onclick="toggleMenu(this)" class="text-gray-700 hover:text-black focus:outline-none" aria-label="Opciones del torneo {{ $tournament->tournament_name }}">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <div class="menu-options absolute right-0 mt-2 w-32 bg-gray-200 rounded-md shadow-lg z-20 hidden" role="menu" aria-label="Opciones del torneo">
                        <a href="{{ route('tournaments.edit', $tournament->id) }}" role="menuitem"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Editar</a>
                        <form method="POST" action="{{ route('tournaments.destroy', $tournament->id) }}" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" role="menuitem"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Borrar</button>
                        </form>
                    </div>
                </div>
                @endif
            </article>
            @empty
            <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800"
                role="alert" aria-live="polite">
                <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>No se encontraron torneos.</div>
            </div>
            @endforelse
        </section>
    </div>

    <!-- Paginación -->
    <div class="mt-6" role="navigation" aria-label="Paginación de torneos">
        {{ $tournaments->links() }}
    </div>
</x-self.base>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif

<script>
    function toggleMenu(button) {
        const menuOptions = button.nextElementSibling; // El div con las opciones del menú
        if (menuOptions) {
            // Cierra todos los otros menús abiertos
            document.querySelectorAll('.menu-options').forEach(function(menu) {
                if (menu !== menuOptions && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            });
            // Alterna la visibilidad del menú clicado
            menuOptions.classList.toggle('hidden');
        }
    }

    // Listener para cerrar cualquier menú abierto al hacer clic fuera
    document.addEventListener('click', function(event) {
        document.querySelectorAll('.menu-options').forEach(function(menu) {
            const buttonContainer = menu.parentElement; // El div que contiene el botón y el menú
            // Si el clic no fue dentro del contenedor del botón/menú y el menú no está oculto
            if (menu && !buttonContainer.contains(event.target) && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    });
</script>