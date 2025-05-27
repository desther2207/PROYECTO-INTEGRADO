<x-app-layout>
    <x-self.base>
        <div class="max-w-5xl mx-auto py-10 px-2 sm:px-6">
            <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">🏆 Ranking de Jugadores</h1>

            <!-- Indicador para móvil -->
            <div class="sm:hidden text-sm text-gray-400 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19l-7-7 7-7" />
                </svg>
                Desliza horizontalmente para ver toda la tabla
            </div>

            <div class="overflow-x-auto shadow-md rounded-lg">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-300">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 sm:px-6 py-3">#</th>
                            <th class="px-4 sm:px-6 py-3">Jugador</th>
                            <th class="px-4 sm:px-6 py-3">Puntos</th>
                            <th class="px-4 sm:px-6 py-3">PJ</th>
                            <th class="px-4 sm:px-6 py-3">PG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rankings as $index => $ranking)
                        <tr class="{{ $index % 2 === 0 ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-900' }} border-b dark:border-gray-700">
                            <td class="px-4 sm:px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap flex items-center gap-2">
                                {{ $index + 1 }}
                                @if ($index === 0)
                                🥇
                                @elseif ($index === 1)
                                🥈
                                @elseif ($index === 2)
                                🥉
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-gray-800 dark:text-gray-300 whitespace-nowrap">{{ $ranking->user->name }}</td>
                            <td class="px-4 sm:px-6 py-4 font-semibold text-gray-800 dark:text-gray-300 whitespace-nowrap">{{ $ranking->points }}</td>
                            <td class="px-4 sm:px-6 py-4 text-gray-800 dark:text-gray-300 whitespace-nowrap">{{ $ranking->games_played }}</td>
                            <td class="px-4 sm:px-6 py-4 text-gray-800 dark:text-gray-300 whitespace-nowrap">{{ $ranking->games_won }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-self.base>
</x-app-layout>