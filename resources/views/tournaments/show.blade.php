<x-app-layout>
    <x-self.base>
        <div class="container mx-auto px-4 py-6">
            <!-- Banner Superior (Opcional) -->
            @if($tournament->tournament_image)
            <div class="mb-4">
                <img
                    src="{{ Storage::url($tournament->tournament_image) }}"
                    alt="Banner del Torneo"
                    class="w-full h-64 object-cover rounded"
                    style="width: 100%; height: 250px; object-fit: cover;">
            </div>
            @endif

            <!-- Título principal del torneo -->
            <h1 class="text-3xl font-bold mb-4 font-oswald-italic">
                {{ strtoupper($tournament->tournament_name) }}
            </h1>

            <!-- Sección principal (Información e Inscripciones) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Columna de Información (ocupa 2 columnas en desktop) -->
                <div class="md:col-span-2">
                    <div class="bg-white shadow rounded p-4">
                        <h2 class="text-xl text-black font-semibold mb-2">Información</h2>
                        <div class="-mx-4">
                            <hr class="my-2">
                        </div>

                        <!-- Layout de dos columnas: imagen a la izquierda e información a la derecha -->
                        <div class="flex flex-col md:flex-row mt-2">
                            @if($tournament->cartel)
                            <!-- Columna de la imagen -->
                            <div class="md:w-1/3 flex justify-center items-center">
                                <img
                                    src="{{ Storage::url($tournament->cartel) }}"
                                    alt="Cartel del torneo"
                                    class="rounded max-h-64">
                            </div>
                            @endif

                            <!-- Columna de información -->
                            <div class="md:w-2/3 text-black md:pl-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p><strong>Nivel:</strong> {{ ucfirst($tournament->level) }}</p>
                                        <p><strong>Estado:</strong> {{ ucfirst($tournament->status) }}</p>
                                        <p><strong>Parejas:</strong> {{ $tournament->current_pairs }}/{{ $tournament->max_pairs }}</p>
                                        <p><strong>Categorías:</strong>
                                            @foreach ($tournament->categories as $category)
                                            @if ($category->category_name == 'Oro')
                                            <span class="bg-yellow-800 text-yellow-100 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-600 dark:text-yellow-100">
                                            {{ $category->category_name }}
                                            </span>
                                            @elseif ($category->category_name == 'Plata')
                                            <span class="bg-gray-300 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-300 dark:text-gray-800">
                                                {{ $category->category_name }}
                                            </span>
                                            @else
                                            <span class="bg-yellow-900 text-gray-100 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-gray-100">
                                                {{ $category->category_name }}
                                            </span>
                                            @endif

                                            @endforeach
                                        </p>

                                    </div>
                                    <div>
                                        <p>
                                            <strong>Fecha de inicio:</strong>
                                            {{ \Carbon\Carbon::parse($tournament->start_date)->format('d/m/Y') }}
                                        </p>
                                        <p>
                                            <strong>Fecha de fin:</strong>
                                            {{ \Carbon\Carbon::parse($tournament->end_date)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Columna de Inscripciones -->
                <div>
                    <div class="bg-white shadow rounded p-4 text-black">
                        <h2 class="text-xl font-semibold mb-2">Inscripciones</h2>
                        <div class="-mx-4">
                            <hr class="my-2">
                        </div>
                        <p class="mb-4 mt-2">
                            Para inscribirte, revisa los requisitos y haz clic en el botón:
                        </p>
                        <p>
                            <strong>Inicio inscripciones:</strong>
                            {{ \Carbon\Carbon::parse($tournament->inscription_start_date)->format('d/m/Y') }}
                        </p>
                        <p>
                            <strong>Fin inscripciones:</strong>
                            {{ \Carbon\Carbon::parse($tournament->inscription_end_date)->format('d/m/Y') }}
                        </p>
                        <p class="mb-4 mt-4">
                            <strong>Precio inscripción:</strong>
                            ${{ number_format($tournament->incription_price, 2) }}
                        </p>
                        <a
                            href="#"
                            class="block text-center bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                            Inscribirse
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sección de Descripción -->
            <div class="mt-6">
                <div class="bg-white shadow rounded p-4 text-black">
                    <h2 class="text-xl font-semibold mb-2 font-oswald">Descripción</h2>
                    <div class="-mx-4">
                        <hr class="my-2">
                    </div>
                    <p class="mt-2">{{ $tournament->description }}</p>
                </div>
            </div>
        </div>
    </x-self.base>
</x-app-layout>