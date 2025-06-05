<x-app-layout>
    <x-self.base>
        <title>Inscribirse al Torneo</title>

        <div class="container mx-auto p-4" role="main" aria-labelledby="inscripcion-title">
            <h1 id="inscripcion-title" class="text-2xl font-bold mb-6 text-white">Inscripción a Torneo</h1>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-900 text-green-400 rounded" role="status" aria-live="polite">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('pairs.store') }}" method="POST" class="space-y-6" aria-describedby="form-desc">
                @csrf

                <!-- Campo oculto con el ID del torneo -->
                <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">

                <p id="form-desc" class="text-white">
                    Estás a punto de inscribirte en el torneo: <br>
                    <span class="font-bold">{{ $tournament->tournament_name }}</span>
                </p>

                <div class="mt-6" role="group" aria-labelledby="slots-label">
                    <label id="slots-label" class="block text-sm font-medium text-white mb-2">
                        Selecciona 7 horarios en los que NO podrías jugar
                    </label>
                    <p class="text-gray-400 mb-4 text-sm">
                        Según las fechas del torneo, selecciona 7 slots que no te vengan bien para jugar.
                    </p>

                    <div class="mt-6 mb-6">
                        <label for="category_ids" class="block text-sm font-medium text-white mb-2">
                            Selecciona una o más categorías
                        </label>
                        <select name="category_ids[]" id="category_ids" multiple required
                            class="select2 w-full rounded p-2 bg-gray-800 text-white">
                            @foreach($tournament->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="calendar-grid" role="list" aria-label="Calendario de horarios disponibles">
                        @foreach ($tournament->slots as $slot)
                        <div
                            class="calendar-cell"
                            data-slot-id="{{ $slot->id }}"
                            role="listitem"
                            tabindex="0"
                            aria-pressed="false"
                            aria-label="Slot {{ \Carbon\Carbon::parse($slot->slot_date)->format('d/m/Y') }} de {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} a {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}">
                            {{ \Carbon\Carbon::parse($slot->slot_date)->format('d/m/Y') }}
                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                        </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="unavailable_slots" id="unavailable_slots">

                    @if(session('error'))
                    <div class="mb-4 mt-2 p-4 bg-red-900 text-red-400 rounded" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded w-full" aria-label="Confirmar inscripción al torneo">
                    Confirmar inscripción
                </button>
            </form>
        </div>
    </x-self.base>
</x-app-layout>

<style>
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 5px;
    }

    .calendar-cell {
        background-color: #183B4E;
        color: white;
        text-align: center;
        padding: 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .calendar-cell.selected {
        background-color: #4f46e5;
    }

    .select2-container--default .select2-selection--multiple {
        background-color: #1f2937 !important;
        border: 1px solid #374151 !important;
        border-radius: 0.375rem !important;
        color: #fff !important;
        padding: 0.375rem 0.75rem;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #4f46e5 !important;
        border: none !important;
        color: #fff !important;
        padding: 0 1.5rem;
        margin: 0.125rem 0.25rem 0.125rem 0;
    }

    .select2-container--default .select2-results__option {
        background-color: #1f2937 !important;
        color: #fff !important;
    }

    .select2-container--default .select2-results__option--highlighted {
        background-color: #4f46e5 !important;
        color: #fff !important;
    }

    .select2-container--default .select2-selection__rendered {
        color: #fff !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#category_ids').select2({
            placeholder: "Selecciona una o más categorías",
            width: 'resolve',
            theme: 'default'
        });
    });

    const selectedSlots = new Set();

    document.querySelectorAll('.calendar-cell').forEach(cell => {
        cell.addEventListener('click', () => {
            const slotId = cell.getAttribute('data-slot-id');

            if (selectedSlots.has(slotId)) {
                selectedSlots.delete(slotId);
                cell.classList.remove('selected');
                cell.setAttribute('aria-pressed', 'false');
            } else {
                if (selectedSlots.size >= 7) {
                    alert('Solo puedes seleccionar 7 horarios no disponibles.');
                    return;
                }
                selectedSlots.add(slotId);
                cell.classList.add('selected');
                cell.setAttribute('aria-pressed', 'true');
            }

            document.getElementById('unavailable_slots').value = Array.from(selectedSlots).join(',');
        });

        // Accesibilidad con teclado
        cell.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                cell.click();
            }
        });
    });
</script>