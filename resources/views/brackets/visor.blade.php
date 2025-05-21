<div class="flex space-x-8 overflow-auto">

    @php
        $rounds = [];
        $games = $bracket->games->sortBy('game_number')->values();

        // Agrupar por ronda
        foreach ($games as $game) {
            $rounds[$game->game_number][] = $game;
        }
    @endphp

    @foreach ($rounds as $roundNumber => $gamesInRound)
        <div class="flex-1 min-w-[200px] space-y-6">
            <h3 class="text-center text-indigo-400 text-xl font-bold">
                @if ($roundNumber == 1)
                    Primera Ronda
                @elseif ($roundNumber == 2)
                    Cuartos de Final
                @elseif ($roundNumber == 3)
                    Semifinal
                @elseif ($roundNumber == 4)
                    Final
                @else
                    Ronda {{ $roundNumber }}
                @endif
            </h3>

            @foreach ($gamesInRound as $game)
                <div class="bg-gray-700 rounded-lg p-4 text-white shadow">

                    {{-- Pareja 1 --}}
                    @if ($game->pair_one_id)
                        <div>
                            {{ optional($game->pairOne->playerOne)->name ?? 'TBD' }} y {{ optional($game->pairOne->playerTwo)->name ?? 'TBD' }}
                        </div>
                    @else
                        <div class="italic text-gray-400">BYE</div>
                    @endif

                    <div class="text-center font-bold my-2">VS</div>

                    {{-- Pareja 2 --}}
                    @if ($game->pair_two_id)
                        <div>
                            {{ optional($game->pairTwo->playerOne)->name ?? 'TBD' }} y {{ optional($game->pairTwo->playerTwo)->name ?? 'TBD' }}
                        </div>
                    @else
                        <div class="italic text-gray-400">BYE</div>
                    @endif

                    {{-- Extra info --}}
                    <div class="text-xs text-gray-300 mt-2">
                        @if ($game->court)
                            Pista: {{ $game->court->nombre }}
                        @endif

                        @if ($game->start_game_date)
                            - Hora: {{ \Carbon\Carbon::parse($game->start_game_date)->format('H:i') }}
                        @endif
                    </div>

                    {{-- Resultado --}}
                    <div class="text-xs mt-1 text-green-400">
                        @if($game->result)
                            Resultado: {{ $game->result }}
                        @else
                            <span class="italic text-yellow-400">Pendiente</span>
                        @endif
                    </div>

                </div>
            @endforeach

        </div>
    @endforeach

</div>
