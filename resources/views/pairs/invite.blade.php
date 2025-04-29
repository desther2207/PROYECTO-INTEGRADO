<x-app-layout>
    <x-self.base>
        <title>Invitar Compañero</title>

        <div class="container mx-auto p-4">
            @php
            $joinUrl = route('pairs.join', ['pair' => $pair->id]) . '?code=' . $pair->invite_code;
            @endphp

            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4 text-white">Invitación de Pareja</h2>
                <p class="mb-4 text-white">Comparte este enlace con tu compañero:</p>
                <input type="text" readonly value="{{ $joinUrl }}" class="w-full p-2 rounded bg-gray-800 text-white">
            </div>

    </x-self.base>
</x-app-layout>