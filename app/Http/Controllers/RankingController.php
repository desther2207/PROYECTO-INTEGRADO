<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ranking;

class RankingController extends Controller
{

    public function index()
    {
        $rankings = Ranking::with('user')
            ->orderByDesc('points')
            ->get();

        return view('ranking.index', compact('rankings'));
    }


    public function show($id)
    {
        return view('ranking.show', ['id' => $id]);
    }
}
