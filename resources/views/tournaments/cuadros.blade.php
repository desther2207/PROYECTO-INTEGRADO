<x-app-layout>
    <x-self.base>
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-3xl font-bold text-white mb-6">Cuadros de {{ $tournament->tournament_name }}</h1>

            @livewire('bracket-viewer', ['tournament' => $tournament])
        </div>
    </x-self.base>
</x-app-layout>
