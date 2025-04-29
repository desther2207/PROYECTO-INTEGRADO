<x-app-layout>
    <x-self.base>
        <title>Inscribirse al Torneo</title>

        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-6 text-white">Inscripción a Torneo</h1>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-900 text-green-400 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('pairs.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campo oculto con el ID del torneo -->
                <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">

                <p class="text-white">
                    Estás a punto de inscribirte en el torneo: <br>
                    <span class="font-bold">{{ $tournament->tournament_name }}</span>
                </p>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded w-full">
                    Confirmar inscripción
                </button>
            </form>
        </div>
    </x-self.base>
</x-app-layout>
