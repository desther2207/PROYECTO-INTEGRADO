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

                        @if ($bracket && $bracket->games->count())
                            <ul class="text-white space-y-2 text-sm">
                                @foreach ($bracket->games as $game)
                                    <li class="border-b border-gray-700 pb-2">
                                        <strong>Partido #{{ $game->game_number }}</strong>:
                                        {{ $game->pairs[0]->players->pluck('name')->join(' y ') ?? 'TBD' }}
                                        vs
                                        {{ $game->pairs[1]->players->pluck('name')->join(' y ') ?? 'TBD' }}

                                        @if($game->court || $game->start_time)
                                            <div class="text-gray-400 mt-1 text-xs">
                                                @if($game->court)
                                                    Pista: {{ $game->court }}
                                                @endif
                                                @if($game->start_time)
                                                    - Hora: {{ \Carbon\Carbon::parse($game->start_time)->format('H:i') }}
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
