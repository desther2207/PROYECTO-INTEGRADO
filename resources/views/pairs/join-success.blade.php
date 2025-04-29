<x-app-layout>
    <x-self.base>
        <div class="container mx-auto p-6 text-center text-white">

            <h1 class="text-3xl font-bold mb-6">¡Te has unido correctamente!</h1>

            <div class="bg-green-900 p-6 rounded-lg shadow-md">
                <p class="text-xl mb-4">Ahora formas parte de una pareja en el torneo.</p>
                <p class="text-lg mb-4">Jugador 1: <span class="font-bold">{{ $pair->playerOne->name }}</span></p>
                <p class="text-lg mb-4">Jugador 2: <span class="font-bold">{{ Auth::user()->name }}</span></p>

                <a href="{{ route('tournaments') }}" class="mt-6 inline-block bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded">
                    Volver a Torneos
                </a>
            </div>

        </div>
    </x-self.base>
</x-app-layout>
