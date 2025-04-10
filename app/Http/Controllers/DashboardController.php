<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
public function index()
{
    $tournaments = User::find(Auth::id())->tournaments()->with('venues')->get();
    return view('dashboard', compact('tournaments'));
}
}
