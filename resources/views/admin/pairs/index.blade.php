<x-app-layout>
    <x-self.base>
        <div class="container mx-auto p-6 text-white">
            <h1 class="text-2xl font-bold mb-4">
                Parejas inscritas en {{ $tournament->tournament_name }}
            </h1>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-900 text-green-300 rounded">
                {{ session('success') }}
            </div>
            @endif

            <table class="w-full table-auto bg-gray-800 text-left rounded shadow">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="p-3">Jugador 1</th>
                        <th class="p-3">Jugador 2</th>
                        <th class="p-3">Categorías</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pairs as $pair)
                    <tr class="border-b border-gray-600">
                        <td class="p-3">{{ $pair->playerOne->name }}</td>
                        <td class="p-3">{{ $pair->playerTwo->name ?? 'Sin confirmar' }}</td>
                        <td class="p-3">
                            @foreach($pair->categories as $category)
                            <form method="POST"
                                action="{{ route('admin.pairs.detachCategory', ['pair' => $pair->id, 'category' => $category->id]) }}"
                                onsubmit="return confirm('¿Eliminar solo esta categoría?')"
                                class="inline-flex items-center bg-indigo-600 hover:bg-indigo-500 text-white text-xs px-2 py-1 rounded mr-1 mb-1">
                                @csrf
                                @method('DELETE')
                                <span class="mr-1">{{ $category->category_name }}</span>
                                <button type="submit" class="text-white">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </form>

                            @endforeach
                        </td>

                        <td class="p-3">
                            <form method="POST" action="{{ route('admin.pairs.destroy', $pair) }}" onsubmit="return confirm('¿Eliminar esta pareja?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded text-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-self.base>
</x-app-layout>