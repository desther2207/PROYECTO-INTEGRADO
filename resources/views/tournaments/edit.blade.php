<x-app-layout>
    <x-self.base>
        <title>Editar torneo</title>
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-6 text-white">Editar Nuevo Torneo</h1>

            <!-- Mostrar mensaje de error de validación -->
            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-900 text-red-400 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('tournaments.update', $tournament) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                <!-- Bloque: Información del Torneo -->
                <div class="space-y-12">
                    <!-- Bloque: Información del Torneo -->
                    <div class="border-b border-t mt-3 border-gray-700 pb-12">
                        <h2 class="text-base font-semibold text-white mt-2">Torneo</h2>
                        <p class="mt-1 text-sm text-gray-400">
                            This information will be displayed publicly so be careful what you share.
                        </p>

                        <!-- Grilla de 6 columnas: Izquierda (4 columnas) para Nombre y Descripción, Derecha (2 columnas) para Cartel -->
                        <div class="mt-10 grid grid-cols-6 gap-x-6 gap-y-8">
                            <!-- Columna Izquierda: Nombre y Descripción (4 columnas) -->
                            <div class="sm:col-span-4 space-y-8">
                                <!-- Nombre del torneo -->
                                <div>
                                    <label for="tournament_name" class="block text-sm font-medium text-white">
                                        Nombre del torneo
                                    </label>
                                    <div class="mt-2">
                                        <div class="flex items-center rounded-md bg-gray-800 outline-1 outline-gray-600 focus-within:outline-2 focus-within:outline-indigo-500">
                                            <input
                                                type="text"
                                                name="tournament_name"
                                                id="tournament_name"
                                                value="{{@old('tournament_name', $tournament->tournament_name)}}"
                                                placeholder="Nombre del torneo..."
                                                class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none">
                                        </div>
                                    </div>
                                </div>

                                <!-- Descripción -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-white">
                                        Descripción
                                    </label>
                                    <div class="mt-2">
                                        <textarea
                                            name="description"
                                            id="description"
                                            rows="3"
                                            placeholder="Descripción del torneo"
                                            class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none focus:outline-indigo-500">{{ old('description', $tournament->description) }}
                                        </textarea>
                                    </div>
                                    <p class="mt-3 text-sm text-gray-400">
                                        Escribe alguna información relevante sobre el torneo.
                                    </p>
                                </div>
                            </div>

                            <!-- Columna Derecha: Cartel del torneo (2 columnas) -->
                            <div class="sm:col-span-2">
                                <label for="cartel" class="block text-sm font-medium text-white">
                                    Cartel del torneo
                                </label>
                                <div class="mt-2 relative flex items-center justify-center rounded-lg border border-dashed border-gray-600 p-2" style="min-height: 220px;">
                                    <!-- Vista previa del Cartel -->
                                    <img id="cartel-preview"
                                        src="{{ Storage::url('images/tournaments/carteles/noimage.jpg') }}"
                                        alt="Vista previa del cartel"
                                        class="absolute inset-0 w-full h-full object-contain rounded-md"
                                        style="display: none;">

                                    <!-- Contenido por defecto -->
                                    <div id="cartel-placeholder" class="text-center">
                                        <img src="{{Storage::url($tournament->cartel)}}">

                                        <div class="mt-4 flex text-sm text-gray-400">
                                            <label for="cartel" class="relative cursor-pointer rounded-md bg-gray-800 font-semibold text-indigo-400 focus-within:ring-2 focus-within:ring-indigo-400 focus-within:ring-offset-2 hover:text-indigo-300">
                                                <span>Sube un archivo</span>
                                                <input
                                                    id="cartel"
                                                    name="cartel"
                                                    type="file"
                                                    accept="image/*"
                                                    class="sr-only"
                                                    onchange="updateCartelPreview(event)">
                                            </label>
                                            <p class="pl-1">o arrastra y suelta</p>
                                        </div>
                                        <p class="text-xs text-gray-400">PNG, JPG, GIF hasta 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Banner: ocupa todo el ancho -->
                        <div class="mt-10">
                            <div class="sm:col-span-6">
                                <label for="banner" class="block text-sm font-medium text-white">
                                    Banner del torneo
                                </label>
                                <!-- Contenedor para el Banner: que ocupe todo el ancho -->
                                <div class="mt-2 relative flex items-center justify-center rounded-lg border border-dashed border-gray-600" style="min-height: 300px;">
                                    <!-- Vista previa del Banner -->
                                    <img id="banner-preview"
                                        src="{{ Storage::url('images/tournaments/noimage.png') }}"
                                        alt="Vista previa del banner"
                                        class="absolute inset-0 w-full h-full object-contain rounded-md"
                                        style="display: none;">

                                    <!-- Contenido por defecto -->
                                    <div id="banner-placeholder" class="text-center w-full">
                                        <img src="{{Storage::url($tournament->tournament_image)}}">
                                        <div class="mt-4 flex text-sm text-gray-400 justify-center">
                                            <label for="tournament_image" class="relative cursor-pointer rounded-md bg-gray-800 font-semibold text-indigo-400 focus-within:ring-2 focus-within:ring-indigo-400 focus-within:ring-offset-2 hover:text-indigo-300">
                                                <span>Sube un archivo</span>
                                                <input
                                                    id="tournament_image"
                                                    name="tournament_image"
                                                    type="file"
                                                    accept="image/*"
                                                    class="sr-only"
                                                    onchange="updateBannerPreview(event)">
                                            </label>
                                            <p class="pl-1">o arrastra y suelta</p>
                                        </div>
                                        <p class="text-xs text-gray-400">PNG, JPG, GIF hasta 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bloque: Localización y sedes -->
                    <div class="border-b border-gray-700 pb-12">
                        <h2 class="text-base font-semibold text-white">Localización y sedes</h2>
                        <p class="mt-1 text-sm text-gray-400">Indica en qué club/es se jugará el torneo.</p>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <!-- Province -->
                            <div class="sm:col-span-3">
                                <label for="province" class="block text-sm font-medium text-white">Provincia</label>
                                <div class="mt-2 grid grid-cols-1">
                                    <select id="province_id" name="province_id" autocomplete="province-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-gray-800 py-1.5 pr-8 pl-3 text-base text-white focus:outline-indigo-500 sm:text-sm">
                                        <option value="">Seleccione una provincia</option>
                                        @foreach($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ old('province_id', $tournament->province_id) == $province->id ? 'selected' : '' }}>
                                            {{ $province->province_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 w-5 h-5 self-center justify-self-end text-gray-500" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 011.06 0L8 8.94l2.72-2.72a.75.75 0 011.06 1.06l-3.25 3.25a.75.75 0 01-1.06 0L4.22 7.28a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Sede -->
                            <div class="sm:col-span-3">
                                <label for="venue" class="block text-sm font-medium text-white">Sede</label>
                                <div class="mt-2">
                                    <select id="venue" name="venue[]" multiple class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white focus:outline-none focus:outline-indigo-500 sm:text-sm">
                                        <!-- Las opciones se cargarán dinámicamente -->
                                    </select>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="col-span-full">
                                <label for="street-address" class="block text-sm font-medium text-white">Dirección/es</label>
                                <div class="mt-2">
                                    <input disabled type="text" name="street-address" id="street-address" autocomplete="street-address" class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none focus:outline-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bloque: Fechas relevantes -->
                    <div class="border-b border-gray-700 pb-12">
                        <h2 class="text-base font-semibold text-white">Fechas relevantes</h2>
                        <p class="mt-1 text-sm text-gray-400">Indique las fechas de inscripción y de juego del torneo, así como cuántas parejas jugarán.</p>
                        <!--Por la forma en la que trato a las fechas, necesito asignar a una variable cada una de ellas para que se muestren bien-->
                        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8">
                            <!-- Rango de fechas del periodo de inscripción (izquierda) -->
                            @php
                            $insStart = old('inscription_start_date', $tournament->inscription_start_date);
                            $insEnd = old('inscription_end_date', $tournament->inscription_end_date);
                            @endphp
                            <div>
                                <label for="registration-range" class="block text-sm font-medium text-white">Fechas del periodo de inscripción</label>
                                <p class="mt-1 text-sm text-gray-400">Selecciona el rango de fechas para el período de inscripción.</p>
                                <!-- Este input también usa Flatpickr en modo range -->
                                <input id="registration-range" name="registration-range" type="text"
                                    value="{{ \Carbon\Carbon::parse($insStart)->format('d-m-Y') . ' a ' . \Carbon\Carbon::parse($insEnd)->format('d-m-Y') }}"
                                    placeholder="Selecciona rango de fechas"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <!-- Párrafo para mostrar el rango seleccionado para el período de inscripción -->
                                <p id="selectedRegistrationRange" class="mt-2 text-sm text-gray-400"></p>
                            </div>
                            <!-- Rango de fechas del torneo (derecha) -->
                            @php
                            $tournamentStart = old('start_date', $tournament->start_date);
                            $tournamentEnd = old('end_date', $tournament->end_date);
                            @endphp
                            <div>
                                <label for="tournament-range" class="block text-sm font-medium text-white">Fechas del torneo</label>
                                <p class="mt-1 text-sm text-gray-400">Selecciona el rango de fechas para el torneo.</p>
                                <!-- Este input de rango usa Flatpickr en modo range -->
                                <input id="tournament-range" name="tournament-range" type="text"
                                    value="{{ \Carbon\Carbon::parse($tournamentStart)->format('d-m-Y') . ' a ' . \Carbon\Carbon::parse($tournamentEnd)->format('d-m-Y') }}"
                                    placeholder="Selecciona rango de fechas"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <!-- Párrafo para mostrar el rango seleccionado para el torneo -->
                                <p id="selectedTournamentRange" class="mt-2 text-sm text-gray-400"></p>
                            </div>
                        </div>

                        <div>
                            <label for="inscription_price" class="block text-sm font-medium text-white">Precio de inscripción</label>
                            <p class="mt-1 text-sm text-gray-400">Indica el precio de inscripción por pareja.</p>
                            <div class="mt-2">
                                <input type="number" name="incription_price" value="{{ old('incription_price', $tournament->incription_price) }}" id="incription_price" min=0 class="col-start-1 row-start-1 w-1/6 appearance-none rounded-md bg-gray-800 py-1.5 pr-8 pl-3 text-base text-white focus:outline-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Jugadores y categorias -->
                    <div class="flex flex-col sm:flex-row gap-4 border-b border-gray-700 pb-12">

                        <div class="flex-1">
                            <h2 class="text-base font-semibold text-white">Número máximo de parejas</h2>
                            <p class="mt-1 text-sm text-gray-400">Indica cuantás podrá tener el torneo (mín. 4).</p>

                            <input type="number" name="max_pairs" id="max_pairs" value="{{ old('max_pairs', $tournament->max_pairs) }}" min=4 class="col-start-1 mt-4 row-start-1 w-1/6 appearance-none rounded-md bg-gray-800 py-1.5 pr-8 pl-3 text-base text-white focus:outline-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="mt-12 flex items-center justify-end gap-x-6">
                    <button type="button" class="text-sm font-semibold text-gray-300">Cancel</button>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </form>
        </div>
    </x-self.base>
</x-app-layout>


<!-- Script para seleccionar las sedes dinamicamente según Provincia-->
<script>
    // Inicializa Select2 al cargar la página
    $(document).ready(function() {
        $('#venue').select2({
            placeholder: "Seleccione una sede",
            allowClear: true,
            width: '100%'
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const provinceSelect = document.getElementById('province_id');
        if (provinceSelect.value) {
            provinceSelect.dispatchEvent(new Event('change'));

            setTimeout(() => {
                const selectedVenues = @json(old('venue', $tournament -> venues -> pluck('id') -> toArray()));
                $('#venue').val(selectedVenues).trigger('change');
            }, 300);
        }
    });

    // Cuando se cambia la provincia, se cargan las sedes correspondientes
    document.getElementById('province_id').addEventListener('change', function() {
        const provinceId = this.value;
        const $venue = $('#venue');

        // Limpia las opciones previas
        $venue.empty();
        // Agrega una opción vacía (para el placeholder)
        $venue.append(new Option("Seleccione una sede", ""));

        if (provinceId) {
            fetch(`/sedes/by-province/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(venue => {
                        // Crea la opción. Ajusta "venue.venue_name" y "venue.address" según tu modelo.
                        const option = new Option(venue.venue_name, venue.id, false, false);
                        $(option).attr('data-address', venue.address);
                        $venue.append(option);
                    });
                    // Actualiza Select2 para reflejar los cambios en las opciones
                    $venue.trigger('change');
                })
                .catch(error => console.error('Error fetching venues:', error));
        }
    });

    // Actualiza el campo "Dirección/es" cuando cambia la selección de sedes
    $('#venue').on('change', function() {
        let addresses = [];
        // Para cada opción seleccionada, se extrae el atributo 'data-address'
        $(this).find('option:selected').each(function() {
            const addr = $(this).attr('data-address');
            if (addr) {
                addresses.push(addr);
            }
        });
        // Actualiza el input de direcciones; usamos ' | ' como separador, puedes cambiarlo a coma o lo que prefieras
        $('#street-address').val(addresses.join(' | '));
    });

    // Actualiza la vista previa para el cartel
    function updateCartelPreview(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('cartel-preview');
        const placeholder = document.getElementById('cartel-placeholder');

        if (file) {
            preview.src = window.URL.createObjectURL(file);
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        } else {
            preview.style.display = 'none';
            placeholder.style.display = 'block';
        }
    }

    // Actualiza la vista previa para el banner
    function updateBannerPreview(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('banner-preview');
        const placeholder = document.getElementById('banner-placeholder');

        if (file) {
            preview.src = window.URL.createObjectURL(file);
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        } else {
            preview.style.display = 'none';
            placeholder.style.display = 'block';
        }
    }
</script>

<style>
    /* Estilo para el contenedor del Select2 en modo múltiple */
    .select2-container--default .select2-selection--multiple {
        background-color: #1f2937 !important;
        /* bg-gray-800 */
        border: 1px solid #374151 !important;
        /* border-gray-600 */
        border-radius: 0.375rem !important;
        /* rounded-md */
        color: #fff !important;
        padding: 0.375rem 0.75rem;
    }

    /* Estilo para cada una de las "tags" de opción seleccionada */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #4f46e5 !important;
        /* indigo-600 */
        border: none !important;
        color: #fff !important;
        padding: 0 1.5rem;
        margin: 0.125rem 0.25rem 0.125rem 0;
    }

    /* Opciones desplegadas en el dropdown */
    .select2-container--default .select2-results__option {
        background-color: #1f2937 !important;
        /* bg-gray-800 */
        color: #fff !important;
    }

    /* Opción resaltada (hover/selección) */
    .select2-container--default .select2-results__option--highlighted {
        background-color: #4f46e5 !important;
        color: #fff !important;
    }

    /* Renderizado interno de selección */
    .select2-container--default .select2-selection__rendered {
        color: #fff !important;
    }
</style>