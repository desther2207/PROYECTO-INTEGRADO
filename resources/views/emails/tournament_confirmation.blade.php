@component('mail::message')
# ¡Hola {{ $user->name }}!

Te confirmamos que te has **inscrito correctamente** al torneo:

## 🏆 {{ $tournament->tournament_name }}

**📅 Fecha de inicio:** {{ \Carbon\Carbon::parse($tournament->start_date)->format('d/m/Y') }}

---

Gracias por participar en la competición.  
Recibirás más detalles próximamente.  
¡Mucha suerte en la pista! 🎾
@endcomponent
