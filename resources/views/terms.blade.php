<x-guest-layout>
    <div class="py-12 px-4 bg-gray-900 text-white min-h-screen flex flex-col items-center">
        <div class="mb-8" role="banner" aria-label="Logo principal">
            <x-authentication-card-logo class="w-40 h-40" />
        </div>

        <div class="w-full max-w-4xl bg-gray-800 p-8 rounded-xl shadow-md" role="main" aria-label="Contenido de términos y condiciones">
            <h1 class="text-3xl font-extrabold mb-6 text-center text-green-400" id="terms-title">Términos y Condiciones</h1>

            <p class="mb-6 text-gray-300 leading-relaxed text-justify" aria-describedby="terms-title">
                Al utilizar nuestra plataforma para participar en torneos de pádel, aceptas los siguientes términos y condiciones. Te recomendamos que los leas detenidamente.
            </p>

            @foreach ([
                ['Registro y cuenta', 'Para inscribirte en un torneo, debes crear una cuenta válida con información veraz. Eres responsable de mantener la confidencialidad de tu contraseña.'],
                ['Inscripción a torneos', 'La inscripción puede tener un coste, que deberá ser abonado por uno de los miembros de la pareja. Las plazas se asignan por orden de inscripción y se confirman al recibir el pago.'],
                ['Formación de parejas', 'Puedes registrarte con pareja o de forma individual. En este último caso, el organizador podrá asignarte un compañero. Las parejas pueden ser modificadas por la organización si es necesario.'],
                ['Cuadros y partidos', 'Los cuadros del torneo se generan automáticamente y se pueden modificar por la organización. Los ganadores de cada ronda avanzan, y los perdedores pueden entrar en el cuadro de consolación.'],
                ['Disponibilidad', 'Debes indicar tus horarios no disponibles. La organización intentará respetarlos al máximo al asignar los partidos, pero no puede garantizar que se cumplan en todos los casos.'],
                ['Conducta', 'Se espera un comportamiento respetuoso en todo momento. La organización se reserva el derecho de excluir a cualquier jugador por conductas inapropiadas.'],
                ['Cancelaciones', 'Si no puedes participar en un torneo ya inscrito, notifícalo con antelación. Las devoluciones, si proceden, estarán sujetas a los plazos establecidos por la organización.'],
                ['Protección de datos', 'Tus datos serán tratados de acuerdo con nuestra <a href="' . route('policy.show') . '" class="underline text-green-400 hover:text-green-500">Política de Privacidad</a>.'],
                ['Modificaciones', 'Nos reservamos el derecho de modificar estos términos en cualquier momento. Se te notificará si hay cambios importantes.'],
            ] as [$title, $text])
                <section aria-labelledby="term-{{ $loop->iteration }}">
                    <h2 id="term-{{ $loop->iteration }}" class="text-xl font-bold mt-8 text-green-300">{{ $loop->iteration }}. {{ $title }}</h2>
                    <p class="text-gray-300 mt-2 text-justify leading-relaxed">{!! $text !!}</p>
                </section>
            @endforeach

            <p class="mt-8 text-sm text-gray-400 text-right" aria-label="Fecha de última actualización">
                Última actualización: {{ now()->format('d/m/Y') }}
            </p>
        </div>
    </div>
</x-guest-layout>
