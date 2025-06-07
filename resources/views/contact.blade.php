<x-app-layout>
    <!--<x-self.base>-->

    <head>
        <title>Contacto</title>
    </head>

    <div class="min-h-screen flex flex-col md:flex-row" role="main" aria-labelledby="contact-title">
        <!-- Lado amarillo -->
        <div class="relative w-full md:w-1/2 bg-[#b4cb2d] flex justify-around items-center py-12 overflow-hidden" role="region" aria-labelledby="info-contacto">
            <div class="text-center px-6 z-10">
                <h1 id="info-contacto" class="text-white font-bold text-4xl">Contáctanos</h1>
                <p class="text-white mt-2">¿Tienes dudas o sugerencias? ¿Quieres trabajar con nosotros? <br>Estamos aquí para ayudarte.</p>
                <a href="{{ route('dashboard') }}" aria-label="Volver al inicio"
                    class="inline-block mt-4 bg-white text-indigo-800 font-bold px-6 py-2 rounded-2xl">Volver</a>
            </div>

            <div class="absolute -bottom-32 -left-40 w-80 h-80 border-4 border-white border-opacity-30 rounded-full border-t-8 z-0" aria-hidden="true"></div>
            <div class="absolute -bottom-40 -left-20 w-80 h-80 border-4 border-white border-opacity-30 rounded-full border-t-8 z-0" aria-hidden="true"></div>
            <div class="absolute -top-40 -right-0 w-80 h-80 border-4 border-white border-opacity-30 rounded-full border-t-8 z-0" aria-hidden="true"></div>
            <div class="absolute -top-20 -right-20 w-80 h-80 border-4 border-white border-opacity-30 rounded-full border-t-8 z-0" aria-hidden="true"></div>
        </div>

        <!-- Formulario -->
        <div class="flex w-full md:w-1/2 justify-center items-center bg-white py-12" role="form" aria-labelledby="contact-title">
            <form method="POST" action="{{ route('contact.send') }}" class="w-80" aria-describedby="contact-desc">
                @csrf
                <h1 id="contact-title" class="text-gray-800 font-bold text-2xl mb-1">¡Escríbenos!</h1>
                <p id="contact-desc" class="text-sm text-gray-600 mb-5">Responderemos lo antes posible</p>

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 text-sm p-2 rounded mb-4" role="status" aria-live="polite">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <label for="name" class="sr-only">Nombre</label>
                    <input id="name" type="text" name="name" placeholder="Tu nombre" required autocomplete="off"
                        class="w-full px-4 py-2 text-black rounded-2xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        aria-required="true">
                </div>

                <div class="mb-4">
                    <label for="email" class="sr-only">Correo electrónico</label>
                    <input id="email" type="email" name="email" placeholder="Tu correo electrónico" required autocomplete="off"
                        class="w-full px-4 py-2 text-black rounded-2xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        aria-required="true">
                </div>

                <div class="mb-4">
                    <label for="message" class="sr-only">Mensaje</label>
                    <textarea id="message" name="message" rows="4" placeholder="Escribe tu mensaje..." required
                        class="w-full px-4 py-2 text-black rounded-2xl border border-gray-300 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        aria-required="true"></textarea>
                </div>

                <button type="submit"
                    class="block w-full bg-indigo-600 mt-4 py-2 rounded-2xl text-white font-semibold hover:bg-indigo-700 transition"
                    aria-label="Enviar mensaje del formulario de contacto">
                    Enviar mensaje
                </button>
            </form>
        </div>
    </div>

    <!--</x-self.base>-->
</x-app-layout>
