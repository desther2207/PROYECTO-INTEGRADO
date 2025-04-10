<x-app-layout>
    <x-self.base>
        <!-- Sección de filtros -->
        <div class="mb-6">
            <form action="{{ route('tournaments.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <!-- Búsqueda por texto -->
                <div>
                    <label for="q" class="block text-white font-medium">Buscar:</label>
                    <input
                        type="text"
                        name="q"
                        id="q"
                        value="{{ request('q') }}"
                        placeholder="Buscar torneos"
                        class="mt-1 px-3 py-2 rounded border border-gray-300"
                    >
                </div>

                <!-- Filtrar por estado -->
                <div>
                    <label for="status" class="block text-white font-medium">Estado:</label>
                    <select
                        name="status"
                        id="status"
                        class="mt-1 px-3 py-2 rounded border border-gray-300"
                    >
                        <option value="">Todos</option>
                        <option value="inscripcion" {{ request('status') == 'inscripcion' ? 'selected' : '' }}>Inscripción</option>
                        <option value="en curso" {{ request('status') == 'en curso' ? 'selected' : '' }}>En curso</option>
                        <option value="finalizado" {{ request('status') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                </div>

                <!-- Filtrar por nivel -->
                <div>
                    <label for="level" class="block text-white font-medium">Nivel:</label>
                    <select
                        name="level"
                        id="level"
                        class="mt-1 px-3 py-2 rounded border border-gray-300"
                    >
                        <option value="">Todos</option>
                        <option value="primera" {{ request('level') == 'primera' ? 'selected' : '' }}>Primera</option>
                        <option value="segunda" {{ request('level') == 'segunda' ? 'selected' : '' }}>Segunda</option>
                        <option value="tercera" {{ request('level') == 'tercera' ? 'selected' : '' }}>Tercera</option>
                        <option value="cuarta" {{ request('level') == 'cuarta' ? 'selected' : '' }}>Cuarta</option>
                    </select>
                </div>

                <!-- Filtrar por fecha de inicio -->
                <div>
                    <label for="start_date" class="block text-white font-medium">Fecha Inicio:</label>
                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        value="{{ request('start_date') }}"
                        class="mt-1 px-3 py-2 rounded border border-gray-300"
                    >
                </div>

                <!-- Filtrar por fecha de fin -->
                <div>
                    <label for="end_date" class="block text-white font-medium">Fecha Fin:</label>
                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        value="{{ request('end_date') }}"
                        class="mt-1 px-3 py-2 rounded border border-gray-300"
                    >
                </div>

                <!-- Botón de filtrar -->
                <div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Sección de torneos -->
        <div class="flex flex-wrap gap-4">
            @foreach($tournaments as $tournament)
            <a href="{{ route('tournaments.show', $tournament->id) }}" class="bg-gray-700 p-4 rounded-lg shadow-lg w-80 flex-shrink-0 cursor-pointer">
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
            @endforeach
        </div>
    </x-self.base>
</x-app-layout>
