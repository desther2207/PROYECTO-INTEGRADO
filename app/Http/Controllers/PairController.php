<?php

namespace App\Http\Controllers;

use App\Mail\TournamentConfirmationMail;
use App\Models\Pair;
use App\Models\PairUnavailableSlot;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PairController extends Controller
{
    public function create(Request $request)
    {
        $tournament_id = $request->tournament_id;
        $tournament = Tournament::findOrFail($tournament_id);

        return view('pairs.create', compact('tournament'));
    }


    public function store(Request $request)
    {
        // Convertir string a array manualmente
        $request->merge([
            'unavailable_slots' => explode(',', $request->unavailable_slots)
        ]);

        $tournamentId = $request->tournament_id;

        // Verificar si el usuario ya está inscrito en el torneo
        $alreadyInTournament = Pair::where('tournament_id', $tournamentId)
            ->where(function ($query) {
                $query->where('player_1_id', Auth::id())
                    ->orWhere('player_2_id', Auth::id());
            })->exists();

        if ($alreadyInTournament) {
            return redirect()->back()->with('error', 'Ya estás inscrito en este torneo.');
        }

        $request->validate([
            'tournament_id' => ['required', 'exists:tournaments,id'],
            'unavailable_slots' => ['array'],
        ]);

        $pair = Pair::create([
            'player_1_id' => Auth::id(),
            'tournament_id' => $request->tournament_id,
            'invite_code' => Str::random(32),
        ]);

        foreach ($request->unavailable_slots as $slotId) {
            PairUnavailableSlot::create([
                'pair_id' => $pair->id,
                'tournament_slot_id' => $slotId,
            ]);
        }

        $tournament = Tournament::with('venues')->find($request->tournament_id);
        $user = Auth::user();

        Mail::to($user->email)->send(new TournamentConfirmationMail($user, $tournament));
        return redirect()->route('pairs.invite', ['pair' => $pair->id])->with('success', '¡Inscripción realizada! Comparte el enlace con tu compañero.');
    }


    public function invite(Pair $pair)
    {
        return view('pairs.invite', compact('pair'));
    }

    public function join(Request $request, Pair $pair)
    {
        if ($pair->invite_code !== $request->code) {
            abort(403, 'Codigo inválido.');
        }

        if ($pair->player_2_id !== null) {
            return redirect()->route('tournaments')->with('error', 'Esta pareja ya está completa.');
        }

        if (Auth::id() === $pair->player_1_id) {
            return redirect()->route('tournaments')->with('error', 'No puedes unirte a tu propia pareja.');
        }

        $pair->update([
            'player_2_id' => Auth::id(),
            'status' => 'confirmada',
            'invite_code' => null,
        ]);

        return view('pairs.join-success', compact('pair'));
    }
}
