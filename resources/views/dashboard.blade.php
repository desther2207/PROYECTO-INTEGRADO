<x-app-layout>
    <x-self.base>

        <head>
            <title>Inicio</title>
            <!-- Carrousel de torneos -->
            <script>
                let currentIndex = 0;

                function nextSlide() {
                    const carousel = document.getElementById('tournament-carousel');
                    const cardWidth = carousel.querySelector('.w-80').offsetWidth + 14;
                    const totalSlides = carousel.children.length;
                    currentIndex = (currentIndex + 1) % totalSlides;
                    carousel.style.transform = `translateX(-${currentIndex * 14}rem)`;
                }

                function prevSlide() {
                    const carousel = document.getElementById('tournament-carousel');
                    const cardWidth = carousel.querySelector('.w-80').offsetWidth + 14;
                    const totalSlides = carousel.children.length;
                    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                    carousel.style.transform = `translateX(-${currentIndex * 14}rem)`;
                }
            </script>

            <style>
                #tournament-carousel {
                    display: flex;
                    gap: 1rem;
                    padding-right: 1rem;
                }

                .carousel-container {
                    overflow: hidden;
                    padding-left: 1rem;
                    padding-right: 1rem;
                }
            </style>
        </head>
        <div class="flex justify-between items-center mt-4">
            <h2 class="font-oswald-italic text-3xl">MIS TORNEOS</h2>
            <a href="{{ route('tournaments.index') }}" class="text-blue-500 hover:text-blue-700">Ver todos</a>
        </div>

        <div id="carouselExample" class="relative container mx-auto mt-8">
            <div class="carousel-container relative w-full overflow-hidden rounded-lg shadow-lg bg-gradient-to-r from-pink-500 to-purple-900 p-4">
                <div id="tournament-carousel" class="flex transition-transform duration-700 ease-in-out">
                    @foreach ($tournaments as $tournament)
                    <a href="{{route('tournaments.show', $tournament->id)}}" class="bg-gray-800 p-4 rounded-lg shadow-lg w-80 flex-shrink-0 cursor-pointer">

                        <img src="{{ asset('storage/' . $tournament->tournament_image) }}" alt="Imagen del torneo" class="w-full h-32 object-cover rounded-lg mb-4">
                        <h2 class="text-xl font-bold text-white">{{ $tournament->tournament_name }}</h2>
                        <p class="text-gray-400">{{ $tournament->description }}</p>
                        <p class="text-gray-300">Fecha inicio: {{ $tournament->start_date }}</p>
                        <p class="text-gray-300">Fecha fin: {{ $tournament->end_date }}</p>
                        <p class="text-gray-300">Sedes:
                            @foreach ($tournament->venues as $venue)
                            {{ $venue->venue_name }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </p>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Controls -->
            <button onclick="prevSlide()" class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-gray-600 text-white p-2 rounded-full">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button onclick="nextSlide()" class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-gray-600 text-white p-2 rounded-full">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </x-self.base>
</x-app-layout>