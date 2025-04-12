<x-self.base>
    <div class="p-4">
        <!-- Encabezado con título y botón para crear torneo (si el usuario es organizador) -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-oswald-italic text-3xl text-white">Torneos Disponibles</h2>
            @if (Auth::check() && Auth::user()->role == 'editor')
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
                    <select wire:model="status" id="status" class="mt-1 px-3 py-2 text-black rounded border border-gray-300">
                        <option value="">Todos</option>
                        <option value="inscripcion">Inscripción</option>
                        <option value="en curso">En curso</option>
                        <option value="finalizado">Finalizado</option>
                    </select>
                </div>

                <!-- Filtro por nivel -->
                <div>
                    <label for="level" class="block text-white font-medium">Nivel:</label>
                    <select wire:model="level" id="level" class="mt-1 px-3 py-2 rounded border text-black border-gray-300">
                        <option value="">Todos</option>
                        <option value="primera">Primera</option>
                        <option value="segunda">Segunda</option>
                        <option value="tercera">Tercera</option>
                        <option value="cuarta">Cuarta</option>
                    </select>
                </div>

                <!-- Filtro por fecha de inicio -->
                <div>
                    <label for="start_date" class="block text-white font-medium">Fecha Inicio:</label>
                    <input type="date" wire:model="start_date" id="start_date" class="mt-1 px-3 py-2 rounded border text-black border-gray-300">
                </div>

                <!-- Filtro por fecha de fin -->
                <div>
                    <label for="end_date" class="block text-white font-medium">Fecha Fin:</label>
                    <input type="date" wire:model="end_date" id="end_date" class="mt-1 px-3 py-2 rounded border text-black border-gray-300">
                </div>
            </form>
        </div>

        <!-- Listado de torneos -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($tournaments as $tournament)
            <a href="{{ route('tournaments.show', $tournament->id) }}" class="bg-gray-700 p-4 rounded-lg shadow-lg cursor-pointer">
                <img src="{{ asset('storage/' . $tournament->tournament_image) }}" alt="Imagen del torneo" class="w-full h-32 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-bold text-white">{{ $tournament->tournament_name }}</h2>
                <p class="text-gray-400">{{ $tournament->description }}</p>
                <p class="text-gray-300">Fecha inicio: {{ $tournament->start_date }}</p>
                <p class="text-gray-300">Fecha fin: {{ $tournament->end_date }}</p>
                <p class="text-gray-300">
                    Sedes:
                    @foreach($tournament->venues as $venue)
                    {{ $venue->venue_name }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </p>
            </a>
            @empty
            <div class="text-white col-span-3">No se encontraron torneos.</div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $tournaments->links() }}
        </div>
    </div>
</x-self.base>