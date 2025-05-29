<x-guest-layout>
    <div class="py-12 px-4 bg-gray-900 text-white min-h-screen flex flex-col items-center">
        <div class="mb-8" role="banner" aria-label="Logo principal">
            <x-authentication-card-logo class="w-40 h-40" />
        </div>

        <div class="w-full max-w-4xl bg-gray-800 p-8 rounded-xl shadow-md" role="main" aria-label="Contenido de la política de privacidad">
            <h1 class="text-3xl font-extrabold mb-6 text-center text-green-400" id="privacy-policy-title">Política de Privacidad</h1>

            <p class="mb-6 text-gray-300 leading-relaxed text-justify" aria-describedby="privacy-policy-title">
                En E3Pádel valoramos tu privacidad y nos comprometemos a proteger los datos personales que nos proporcionas. Esta política explica cómo recogemos, utilizamos y protegemos tu información.
            </p>

            <section aria-labelledby="info-recogida">
                <h2 id="info-recogida" class="text-xl font-bold mt-8 text-green-300">1. Información que recopilamos</h2>
                <ul class="list-disc list-inside text-gray-300 mt-2 ml-4 leading-relaxed">
                    <li>Nombre y apellidos</li>
                    <li>Correo electrónico</li>
                    <li>Número de teléfono (si lo proporcionas)</li>
                    <li>Participación en torneos y resultados</li>
                    <li>Disponibilidad horaria para partidos</li>
                </ul>
            </section>

            <section aria-labelledby="uso-info">
                <h2 id="uso-info" class="text-xl font-bold mt-8 text-green-300">2. Cómo usamos tu información</h2>
                <ul class="list-disc list-inside text-gray-300 mt-2 ml-4 leading-relaxed">
                    <li>Gestionar tu registro en torneos</li>
                    <li>Organizar partidos y cuadros</li>
                    <li>Asignar pistas y horarios</li>
                    <li>Mostrar clasificaciones y resultados</li>
                    <li>Comunicarnos contigo sobre partidos o cambios</li>
                </ul>
            </section>

            <section aria-labelledby="almacenamiento">
                <h2 id="almacenamiento" class="text-xl font-bold mt-8 text-green-300">3. Almacenamiento y seguridad</h2>
                <p class="text-gray-300 mt-2 text-justify leading-relaxed">
                    Tus datos se almacenan de forma segura en nuestros servidores. Aplicamos medidas técnicas y organizativas para evitar accesos no autorizados o usos indebidos.
                </p>
            </section>

            <section aria-labelledby="comparticion">
                <h2 id="comparticion" class="text-xl font-bold mt-8 text-green-300">4. Compartición de datos</h2>
                <p class="text-gray-300 mt-2 text-justify leading-relaxed">
                    No compartimos tus datos con terceros, salvo obligación legal o autorización expresa por tu parte.
                </p>
            </section>

            <section aria-labelledby="tus-derechos">
                <h2 id="tus-derechos" class="text-xl font-bold mt-8 text-green-300">5. Tus derechos</h2>
                <p class="text-gray-300 mt-2 text-justify leading-relaxed">
                    Puedes acceder, modificar o eliminar tus datos personales en cualquier momento desde tu perfil. También puedes contactarnos si deseas ejercer tus derechos sobre tus datos personales.
                </p>
            </section>

            <section aria-labelledby="cambios-politica">
                <h2 id="cambios-politica" class="text-xl font-bold mt-8 text-green-300">6. Cambios en esta política</h2>
                <p class="text-gray-300 mt-2 text-justify leading-relaxed">
                    Podemos actualizar esta política en cualquier momento. Te notificaremos si se producen cambios importantes.
                </p>
            </section>

            <p class="mt-8 text-sm text-gray-400 text-right" aria-label="Fecha de última actualización">
                Última actualización: {{ now()->format('d/m/Y') }}
            </p>
        </div>
    </div>
</x-guest-layout>
