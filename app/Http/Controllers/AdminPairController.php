<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tournament;
use App\Models\Pair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPairController extends Controller
{
    public function index(Tournament $tournament)
    {
        $pairs = Pair::with(['playerOne', 'playerTwo', 'categories'])
            ->where('tournament_id', $tournament->id)
            ->get();

        return view('admin.pairs.index', compact('tournament', 'pairs'));
    }

    public function destroy(Pair $pair)
    {
        // Limpiar relaciones antes de borrar
        DB::table('category_pair')->where('pair_id', $pair->id)->delete();
        DB::table('pair_unavailable_slot')->where('pair_id', $pair->id)->delete();

        $pair->delete();

        return redirect()->back()->with('success', 'Pareja eliminada correctamente.');
    }

    public function detachCategory(Pair $pair, Category $category)
    {
        DB::table('category_pair')
            ->where('pair_id', $pair->id)
            ->where('category_id', $category->id)
            ->delete();

        return back()->with('success', 'Categoría eliminada de la pareja.');
    }
}
