<x-app-layout>
    <x-self.base>
        <head>
            <title>Contacto</title>
        </head>

        <div class="max-w-2xl mx-auto px-6 py-16">
            <h1 class="text-4xl font-bold text-center mb-8 text-white">Contáctanos</h1>

            <form method="POST" action="{{ route('contact.send') }}" class="bg-white/10 backdrop-blur-md p-8 rounded-xl shadow-xl">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-white font-semibold mb-2">Nombre</label>
                    <input type="text" id="name" name="name" required
                           class="w-full p-3 rounded bg-white/80 text-gray-800 shadow-inner focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-white font-semibold mb-2">Correo electrónico</label>
                    <input type="email" id="email" name="email" required
                           class="w-full p-3 rounded bg-white/80 text-gray-800 shadow-inner focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-white font-semibold mb-2">Mensaje</label>
                    <textarea id="message" name="message" rows="5" required
                              class="w-full p-3 rounded bg-white/80 text-gray-800 shadow-inner focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded transition">
                        Enviar mensaje
                    </button>
                </div>
            </form>
        </div>
    </x-self.base>
</x-app-layout>
