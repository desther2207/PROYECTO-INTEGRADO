<div class="space-y-8">

    {{-- MENSAJE DE GANADOR --}}
    @if (session('success'))
    <div class="bg-green-200 text-green-900 font-semibold px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    {{-- SELECTOR DE CUADROS --}}
    <div class="flex flex-col sm:flex-row sm:flex-wrap sm:gap-3 gap-2 mb-6">
        @foreach ($tournament->categories as $category)
        @foreach (["principal" => "Principal", "consolacion" => "Consolación"] as $type => $label)
        <button
            class="w-full sm:w-auto text-center px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-500 transition-all duration-200"
            wire:click="$set('selectedBracket', '{{ $category->id }}-{{ $type }}')">
            {{ $category->category_name }} - {{ $label }}
        </button>
        @endforeach
        @endforeach
    </div>

    {{-- VISOR DE CUADROS --}}
    @foreach ($tournament->categories as $category)
    @foreach (["principal" => "Principal", "consolacion" => "Consolación"] as $type => $label)
    @php
    $bracket = $tournament->brackets->where('category_id', $category->id)->where('type', $type)->first();
    @endphp

    @if ($selectedBracket === $category->id . '-' . $type)
    <div class="text-white">
        <h2 class="text-2xl font-semibold text-indigo-400 mb-4">
            {{ $category->category_name }} - {{ $label }}
        </h2>

        <div class="bg-gradient-to-r from-blue-900 to-blue-600 p-6 rounded shadow space-y-12">

            {{-- BOTONES DE GESTIÓN --}}
            @if ($bracket && $bracket->games->count() === 0 && $bracket->type != 'consolacion' && auth()->user()?->isOrganizerOf($tournament) || auth()->user()?->role === 'admin' && $bracket->games->count() === 0 && $bracket->type != 'consolacion')
            <form action="{{ route('brackets.generateGames', $bracket) }}" method="POST" class="inline-block mb-4" role="form" aria-label="Formulario para reiniciar el torneo completo">
                @csrf
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500" aria-label="Generar partidos manualmente del cuadro {{ $label }} de la categoría {{ $category->category_name }}">
                    Generar partidos manualmente
                </button>
            </form>
            @endif

            @if (auth()->user()?->isOrganizerOf($tournament) || auth()->user()?->role == 'admin' && $bracket && $bracket->games->count() > 0)
            <form action="{{ route('tournaments.reset', $tournament->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres reiniciar el torneo?');">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-500">
                    Reiniciar torneo
                </button>
            </form>
            @endif

            {{-- PARTIDOS --}}
            @if ($bracket && $bracket->games->count())
            @php
            $rounds = [];

            $totalRounds = $bracket->games->max('round_number');

            $roundLabels = [
            1 => 'Final',
            2 => 'Semifinales',
            3 => 'Cuartos',
            4 => 'Octavos',
            5 => 'Dieciseisavos',
            6 => 'Treintadosavos',
            7 => 'Sesentaycuatroavos',
            ];

            foreach ($bracket->games as $game) {
            $label = $roundLabels[$game->round_number] ?? 'Ronda ' . $game->round_number;
            $rounds[$game->round_number]['label'] = $label;
            $rounds[$game->round_number]['games'][] = $game;
            }

            // Ahora ordenamos por número de ronda descendente → primera ronda a la izquierda
            krsort($rounds);

            @endphp

            <div class="w-full overflow-x-auto pb-4">
                <div class="grid gap-8 overflow-x-auto sm:overflow-visible" style="grid-template-columns: repeat({{ count($rounds) }}, 1fr);">
                    @foreach ($rounds as $round)
                    <div class="space-y-6">
                        <h3 class="text-center text-lg font-bold uppercase">{{ $round['label'] }}</h3>

                        @foreach ($round['games'] as $game)
                        @php
                        $pairOne = $game->pairOne;
                        $pairTwo = $game->pairTwo;

                        $pairOneName = $pairOne && $pairOne->playerOne && $pairOne->playerTwo
                        ? "{$pairOne->playerOne->name} y {$pairOne->playerTwo->name}"
                        : 'Por definir';

                        $pairTwoName = $pairTwo && $pairTwo->playerOne && $pairTwo->playerTwo
                        ? "{$pairTwo->playerOne->name} y {$pairTwo->playerTwo->name}"
                        : 'Por definir';

                        $sets = [];
                        if ($game->result) {
                        foreach (explode(',', $game->result) as $set) {
                        [$s1, $s2] = array_map('trim', explode('-', $set));
                        $sets[] = ['one' => $s1, 'two' => $s2];
                        }
                        }
                        while (count($sets) < 3) {
                            $sets[]=['one'=> '', 'two' => ''];
                            }

                            // Estado visual
                            $estado = 'gris';
                            if ($game->pair_one_id && $game->pair_two_id && $game->result) {
                            $estado = 'verde';
                            } elseif ($game->pair_one_id && $game->pair_two_id) {
                            $estado = 'amarillo';
                            }

                            $bgColor = match($estado) {
                            'verde' => 'bg-green-100',
                            'amarillo' => 'bg-yellow-100',
                            default => 'bg-gray-100'
                            };
                            @endphp

                            <div class="{{ $bgColor }} text-gray-900 rounded-md shadow px-4 py-2 space-y-2 text-sm">
                                <form wire:submit.prevent="reportResult({{ $game->id }})">
                                    @csrf
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                        <p class="font-semibold">{{ $pairOneName }}</p>
                                        <div class="flex justify-end gap-2">
                                            @foreach ($sets as $i => $set)
                                            @if (auth()->user()?->isOrganizerOf($tournament) && $bgColor == 'bg-yellow-100' || auth()->user()?->role == 'admin' && $bgColor == 'bg-yellow-100')
                                            <input type="number"
                                                wire:model.defer="sets.{{ $game->id }}.{{ $i }}.one"
                                                class="w-10 text-center border rounded no-spinner"
                                                min="0" max="99" />
                                            @else
                                            <span class="w-10 text-center">{{ $set['one'] !== '' ? $set['one'] : '-' }}</span>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                        <p class="font-semibold">{{ $pairTwoName }}</p>
                                        <div class="flex justify-end gap-2">
                                            @foreach ($sets as $i => $set)
                                            @if (auth()->user()?->isOrganizerOf($tournament) && $bgColor == 'bg-yellow-100' || auth()->user()?->role == 'admin' && $bgColor == 'bg-yellow-100')
                                            <input type="number"
                                                wire:model.defer="sets.{{ $game->id }}.{{ $i }}.two"
                                                class="w-10 text-center border rounded no-spinner"
                                                min="0" max="99" /> @else
                                            <span class="w-10 text-center">{{ $set['two'] !== '' ? $set['two'] : '-' }}</span>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600 mt-2 space-y-1">
                                        <p><strong>Fecha:</strong> {{ $game->start_game_date ?? 'Por asignar' }}</p>
                                        <p><strong>Sede:</strong> {{ $game->venue->venue_name ?? 'Por asignar' }}</p>
                                        <p><strong>Pista:</strong> {{ $game->court->nombre ?? 'Por asignar' }}</p>
                                    </div>

                                    @if (auth()->user()?->isOrganizerOf($tournament) && $bgColor == 'bg-yellow-100' || auth()->user()?->role == 'admin' && $game->pair_one_id && $game->pair_two_id && $bgColor == 'bg-yellow-100')
                                    <button type="submit" class="mt-2 px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-500">
                                        Guardar resultado
                                    </button>
                                    @endif
                                </form>

                                @if (auth()->user()?->isOrganizerOf($tournament) && $bgColor == 'bg-yellow-100' || auth()->user()?->role === 'admin' && $game->pair_one_id && $game->pair_two_id && $bgColor == 'bg-yellow-100')
                                <button type="button" wire:click="startEdit({{ $game->id }})"
                                    class="mt-2 px-3 py-1 bg-gray-600 text-white text-sm rounded hover:bg-gray-500">
                                    Editar
                                </button>
                                @endif

                                @if ($editingGameId === $game->id)
                                <div class="mt-4 space-y-3 text-sm">

                                    @php
                                    $pairs = \App\Models\Pair::where('tournament_id', $tournament->id)
                                    ->whereHas('categories', fn($q) => $q->where('category_id', $category->id))
                                    ->where('status', 'confirmada')
                                    ->whereNotNull('player_2_id')
                                    ->get();
                                    @endphp
                                    {{-- Pareja 1 --}}
                                    <div>
                                        <label class="block mb-1">Pareja 1</label>
                                        <select wire:model="editData.{{ $game->id }}.pair_one_id" class="w-full rounded">
                                            @foreach ($pairs as $pair)
                                            <option value="{{ $pair->id }}">
                                                {{ $pair->playerOne->name }} y {{ $pair->playerTwo->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Pareja 2 --}}
                                    <div>
                                        <label class="block mb-1">Pareja 2</label>
                                        <select wire:model="editData.{{ $game->id }}.pair_two_id" class="w-full rounded">
                                            @foreach ($pairs as $pair)
                                            <option value="{{ $pair->id }}">
                                                {{ $pair->playerOne->name }} y {{ $pair->playerTwo->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Fecha y hora --}}
                                    <div>
                                        <label class="block mb-1">Fecha y hora</label>
                                        <input type="datetime-local" wire:model="editData.{{ $game->id }}.start_game_date"
                                            class="w-full rounded" />
                                    </div>

                                    {{-- Sede --}}
                                    <div>
                                        <label class="block mb-1">Sede</label>
                                        <select wire:model="editData.{{ $game->id }}.venue_id"
                                            wire:change="loadCourts({{ $game->id }})" class="w-full rounded">
                                            @foreach ($venues as $venue)
                                            <option value="{{ $venue->id }}">{{ $venue->venue_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Pista --}}
                                    <div>
                                        <label class="block mb-1">Pista</label>
                                        <select wire:model="editData.{{ $game->id }}.court_id" class="w-full rounded">
                                            @foreach ($availableCourts[$game->id] ?? [] as $court)
                                            <option value="{{ $court->id }}">{{ $court->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Guardar --}}
                                    <form wire:submit.prevent="saveEdit({{ $game->id }})">
                                        <button type="submit"
                                            class="mt-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-500">
                                            Guardar cambios
                                        </button>
                                        @error("editData.$game->id.pair_one_id") <div class="text-red-400 text-xs">{{ $message }}</div> @enderror
                                        @error("editData.$game->id.pair_two_id") <div class="text-red-400 text-xs">{{ $message }}</div> @enderror
                                        @error("editData.$game->id.start_game_date") <div class="text-red-400 text-xs">{{ $message }}</div> @enderror
                                        @error("editData.$game->id.venue_id") <div class="text-red-400 text-xs">{{ $message }}</div> @enderror
                                        @error("editData.$game->id.court_id") <div class="text-red-400 text-xs">{{ $message }}</div> @enderror

                                    </form>
                                </div>
                                @endif
                            </div>
                            @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <p class="text-gray-400 italic">No hay partidos generados.</p>
            @endif
        </div>
    </div>
    @endif
    @endforeach
    @endforeach

    <style>
        input[type=number].no-spinner::-webkit-inner-spin-button,
        input[type=number].no-spinner::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number].no-spinner {
            -moz-appearance: textfield;
        }

        .space-y-6 {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <script>
        document.addEventListener('bracket-winner', function(event) {
            const message = event.detail.message;

            Swal.fire({
                title: '¡Torneo ganado!',
                text: message,
                icon: 'success',
                confirmButtonText: 'Felicidades 🎉',
                didOpen: () => {
                    launchConfetti();
                }
            });
        });


        function launchConfetti() {
            const duration = 3 * 1000;
            const end = Date.now() + duration;

            (function frame() {
                confetti({
                    particleCount: 5,
                    angle: 60,
                    spread: 55,
                    origin: {
                        x: 0
                    }
                });
                confetti({
                    particleCount: 5,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1
                    }
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        };
    </script>

</div>