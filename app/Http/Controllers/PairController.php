<?php

namespace App\Http\Controllers;

use App\Models\Pair;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $request->validate([
            'tournament_id' => ['required', 'exists:tournaments,id']
        ]);

        $pair = Pair::create([
            'player_1_id' => Auth::id(),
            'tournament_id' => $request->tournament_id,
            'invite_code' => Str::random(32),
        ]);

        return redirect()->route('pairs.invite', ['pair' => $pair->id])->with('success', '¡Inscripción realizada! Comparte el enlace con tu compañero.');
    }

    public function invite(Pair $pair)
    {
        return view('pairs.invite', compact('pair'));
    }

    public function join(Request $request, Pair $pair){
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
