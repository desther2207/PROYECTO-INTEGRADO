<x-app-layout>
    <x-self.base>
        <title>Inscribirse al Torneo</title>

        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-6 text-white">Inscripción a Torneo</h1>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-900 text-green-400 rounded">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('pairs.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campo oculto con el ID del torneo -->
                <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">

                <p class="text-white">
                    Estás a punto de inscribirte en el torneo: <br>
                    <span class="font-bold">{{ $tournament->tournament_name }}</span>
                </p>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-white mb-2">
                        Selecciona 7 horarios en los que NO podrías jugar
                    </label>
                    <p class="text-gray-400 mb-4 text-sm">Según las fechas del torneo, selecciona 7 slots que no te vengan bien para jugar.</p>

                    <div class="calendar-grid">
                        @foreach ($tournament->slots as $slot)
                        <div class="calendar-cell" data-slot-id="{{ $slot->id }}">
                            {{ \Carbon\Carbon::parse($slot->slot_date)->format('d/m/Y') }}
                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                        </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="unavailable_slots" id="unavailable_slots">

                    <p class="text-sm mt-2 text-gray-400">* Debes seleccionar exactamente 7 horarios no disponibles.</p>
                </div>


                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded w-full">
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
</style>

<script>
    const selectedSlots = new Set();

    document.querySelectorAll('.calendar-cell').forEach(cell => {
        cell.addEventListener('click', () => {
            const slotId = cell.getAttribute('data-slot-id');

            if (selectedSlots.has(slotId)) {
                selectedSlots.delete(slotId);
                cell.classList.remove('selected');
            } else {
                if (selectedSlots.size >= 7) {
                    alert('Solo puedes seleccionar 7 horarios no disponibles.');
                    return;
                }
                selectedSlots.add(slotId);
                cell.classList.add('selected');
            }

            document.getElementById('unavailable_slots').value = Array.from(selectedSlots).join(',');
        });
    });
</script>