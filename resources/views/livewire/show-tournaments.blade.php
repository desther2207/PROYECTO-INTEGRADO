<x-self.base>
    <div class="p-4">
        <!-- Encabezado con título y botón para crear torneo (si el usuario es organizador) -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-oswald-italic text-3xl text-transparent text-white pr-1">TORNEOS DISPONIBLES</h2>
            @if (Auth::check() && Auth::user()->role == 'editor' || Auth::user()->role == 'admin')
            <a href="{{ route('tournaments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Torneo
            </a>
            @endif
        </div>

        <!-- Sección de filtros -->
        <div class="mb-6">
            <form wire:submit.prevent="render" class="flex flex-wrap gap-4 items-end">
                <!-- Búsqueda por texto -->
                <div>
                    <label for="q" class="block text-white font-medium">Buscar:</label>
                    <input type="text" wire:model.live="texto" id="texto" placeholder="Buscar torneos" class="mt-1 px-3 text-black py-2 rounded border border-gray-300">
                </div>

                <!-- Filtro por estado -->
                <div>
                    <label for="status" class="block text-white font-medium">Estado:</label>
                    <select wire:model.live="status" id="status" class="mt-1 px-3 py-2 text-black rounded border border-gray-300">
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
                    <select wire:model.live="province" id="province" class="mt-1 px-3 py-2 text-black rounded border border-gray-300">
                        <option value="">Todas</option>
                        @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
            </form>
        </div>

        <!-- Listado de torneos -->
        @forelse($tournaments as $tournament)
        <div class="flex flex-col md:flex-row w-full my-6 bg-white shadow-sm border border-slate-200 rounded-lg overflow-hidden min-h-[300px]">
            <!-- Imagen -->
            <div class="md:w-1/5 w-full h-80 p-2">
                <img
                    src="{{ asset('storage/' . $tournament->cartel) }}"
                    alt="cartel torneo"
                    class="w-full h-full object-cover rounded-lg">
            </div>

            <!-- Contenido -->
            <div class="p-6 flex flex-col justify-between md:w-3/5 w-full">
                <div>
                    <div class="mb-4 rounded-full bg-teal-600 py-0.5 px-2.5 text-xs text-white w-fit">
                        {{ $tournament->status }}
                    </div>

                    <a href="{{ route('tournaments.show', $tournament->id) }}">
                        <h4 class="mb-2 text-slate-800 text-xl font-semibold hover:underline">
                            {{ $tournament->tournament_name }}
                        </h4>
                    </a>

                    <p class="mb-5 text-slate-600 font-light">
                        <!-- Descripción corta del torneo para que no ocupe toda la página-->
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

                <div>
                    <a href="{{ route('tournaments.show', $tournament->id) }}" class="text-slate-800 font-semibold text-sm hover:underline flex items-center">
                        Ver más
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                No se encontraron torneos.
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $tournaments->links() }}
    </div>
    </div>
</x-self.base>