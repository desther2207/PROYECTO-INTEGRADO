<div class="space-y-8">
    @foreach ($tournament->categories as $category)
    <div class="text-white">
        <h2 class="text-2xl font-semibold text-indigo-400 mb-2">{{ $category->category_name }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach (['principal' => 'Principal', 'consolacion' => 'Consolación'] as $type => $label)
            @php
            $bracket = $tournament->brackets->where('category_id', $category->id)->where('type', $type)->first();
            @endphp

            <div class="bg-gray-800 p-4 rounded-md shadow">
                <h3 class="text-lg text-white font-bold mb-2">{{ $label }}</h3>


                @if ($bracket && $bracket->games->count() === 0 && auth()->user()?->isOrganizerOf($tournament) && $tournament->pairs()->where('status', 'confirmada')->whereNotNull('player_2_id')->count() >= 3)

                <form action="{{ route('brackets.generateGames', $bracket) }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500 mb-4">
                        Generar partidos manualmente
                    </button>
                </form>

                @endif


                @if ($bracket && $bracket->games->count())
                <ul class="text-white space-y-2 text-sm">
                    @foreach ($bracket->games as $game)
                    <li class="border-b border-gray-700 pb-2">
                        <strong>Partido</strong>:

                        {{-- Mostrar pareja 1 --}}
                        @if ($game->pair_one_id)
                        {{ optional($game->pairOne->playerOne)->name ?? 'TBD' }}
                        y
                        {{ optional($game->pairOne->playerTwo)->name ?? 'TBD' }}
                        @else
                        <span class="italic text-gray-400">BYE</span>
                        @endif

                        vs

                        {{-- Mostrar pareja 2 --}}
                        @if ($game->pair_two_id)
                        {{ optional($game->pairTwo->playerOne)->name ?? 'TBD' }}
                        y
                        {{ optional($game->pairTwo->playerTwo)->name ?? 'TBD' }}
                        @else
                        <span class="italic text-gray-400">BYE</span>
                        @endif

                        {{-- Info extra --}}
                        @if($game->court || $game->start_game_date)
                        <div class="text-gray-400 mt-1 text-xs">
                            @if($game->court)
                            Pista: {{ $game->court->nombre ?? 'Sin asignar' }}
                            @endif
                            @if($game->start_game_date)
                            - Hora: {{ \Carbon\Carbon::parse($game->start_game_date)->format('H:i') }}
                            @endif
                        </div>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-gray-400 italic">No hay partidos generados.</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>