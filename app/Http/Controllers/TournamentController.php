<?php

namespace App\Http\Controllers;

use App\Models\Bracket;
use App\Models\Category;
use App\Models\Province;
use App\Models\Tournament;
use App\Models\TournamentSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{

    public function cuadros(Tournament $tournament)
    {
        $tournament->load([
            'categories',
            'brackets.games.pairOne.playerOne',
            'brackets.games.pairOne.playerTwo',
            'brackets.games.pairTwo.playerOne',
            'brackets.games.pairTwo.playerTwo'
        ]);
        return view('tournaments.cuadros', compact('tournament'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $provinces = Province::orderBy('province_name')->get();
        $categories = Category::orderBy('category_name')->get();
        return view('tournaments.create', compact('provinces', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        // Separar fechas del torneo, porque FlatPickr devuelve un rango de fechas en un solo campo
        if ($request->filled('tournament-range')) {
            $dates = explode(' a ', $request->input('tournament-range'));
            $request->merge([
                'start_date' => isset($dates[0]) ? Carbon::createFromFormat('d-m-Y', $dates[0])->format('Y-m-d') : null,
                'end_date' => isset($dates[1]) ? Carbon::createFromFormat('d-m-Y', $dates[1])->format('Y-m-d') : null,
            ]);
        }

        // Lo mismo para las fechas de inscripción
        if ($request->filled('registration-range')) {
            $regDates = explode(' a ', $request->input('registration-range'));
            $request->merge([
                'inscription_start_date' => isset($regDates[0]) ? Carbon::createFromFormat('d-m-Y', $regDates[0])->format('Y-m-d') : null,
                'inscription_end_date' => isset($regDates[1]) ? Carbon::createFromFormat('d-m-Y', $regDates[1])->format('Y-m-d') : null,
            ]);
        }

        // Después de separar las fechas, se valida el resto de los campos, ya que no recibo el request completo del formulario
        // y no puedo validar los campos de fechas como lo haría normalmente.
        $validated = $request->validate($this->rules());

        // Validaciones manuales adicionales para fechas de torneo
        if (!$request->filled('start_date') || !$request->filled('end_date')) {
            return back()->withErrors(['start_date' => 'Debes seleccionar el rango de fechas del torneo.'])->withInput();
        }

        if (strtotime($request->start_date) < strtotime(now()->toDateString())) {
            return back()->withErrors(['start_date' => 'La fecha de inicio debe ser igual o posterior a hoy.'])->withInput();
        }

        if (strtotime($request->end_date) < strtotime($request->start_date)) {
            return back()->withErrors(['end_date' => 'La fecha de fin debe ser igual o posterior a la de inicio.'])->withInput();
        }

        // Validaciones manuales adicionales para fechas de inscripción
        if ($request->filled('inscription_start_date') && $request->filled('inscription_end_date')) {
            if (strtotime($request->inscription_start_date) < strtotime(now()->toDateString())) {
                return back()->withErrors(['inscription_start_date' => 'La fecha de inicio de inscripción debe ser igual o posterior a hoy.'])->withInput();
            }

            if (strtotime($request->inscription_end_date) < strtotime($request->inscription_start_date)) {
                return back()->withErrors(['inscription_end_date' => 'La fecha de fin de inscripción debe ser igual o posterior a la de inicio.'])->withInput();
            }
        }

        // Validaciones del cartel y banner del torneo

        if ($request->hasFile('cartel')) {
            $validated['cartel'] = $request->file('cartel')->store('images/tournaments/carteles', 'public');
        }

        if ($request->hasFile('tournament_image')) {
            $validated['tournament_image'] = $request->file('tournament_image')->store('images/tournaments');
        }

        $validated['start_date'] = $request->start_date;
        $validated['end_date'] = $request->end_date;
        $validated['inscription_start_date'] = $request->inscription_start_date;
        $validated['inscription_end_date'] = $request->inscription_end_date;

        // Validación: las fechas de inscripción no deben ser posteriores a las fechas del torneo
        if (
            $request->filled('inscription_end_date') && $request->filled('start_date') &&
            strtotime($request->inscription_end_date) > strtotime($request->start_date)
        ) {
            return back()->withErrors([
                'inscription_end_date' => 'La fecha de fin de inscripción no puede ser posterior a la fecha de inicio del torneo.'
            ])->withInput();
        }

        //Validaciones para status
        $today = now()->toDateString();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            if ($today < $request->inscription_start_date) {
                $validated['status'] = 'pendiente';
            } elseif ($today >= $request->inscription_start_date && $today <= $request->inscription_end_date) {
                $validated['status'] = 'inscripcion';
            } elseif ($today >= $request->start_date && $today <= $request->end_date) {
                $validated['status'] = 'en curso';
            } elseif ($today > $request->end_date) {
                $validated['status'] = 'finalizado';
            } else {
                $validated['status'] = 'pendiente';
            }
        }

        $tournament = Tournament::create($validated);

        $tournament->organizers()->attach(Auth::id());

        // Se añaden las sedes al torneo (N:M) 

        if ($request->has('venue')) {
            $tournament->venues()->sync($request->venue);
        }

        // Asociar categorías seleccionadas
        if ($request->has('categories')) {
            $selectedCategoryIds = $request->input('categories');

            $tournament->categories()->attach($selectedCategoryIds);

            foreach ($selectedCategoryIds as $categoryId) {
                foreach (['principal', 'consolacion'] as $type) {
                    $bracket = Bracket::create([
                        'tournament_id' => $tournament->id,
                        'category_id' => $categoryId,
                        'status' => 'En curso',
                        'type' => $type,
                    ]);
                }
            }

            // Crear los slots de disponibilidad (1 por cada día del torneo y en cada franja horaria típica de un torneo)
            $start = Carbon::parse($tournament->start_date);
            $end = Carbon::parse($tournament->end_date);


            $slots = [
                ['start' => '09:00', 'end' => '10:30'],
                ['start' => '10:30', 'end' => '12:00'],
                ['start' => '12:00', 'end' => '13:30'],
                ['start' => '17:00', 'end' => '18:30'],
                ['start' => '18:30', 'end' => '20:00'],
                ['start' => '20:00', 'end' => '21:30'],
            ];

            for ($date = $start; $date->lte($end); $date->addDay()) {
                foreach ($slots as $slot) {
                    TournamentSlot::create([
                        'tournament_id' => $tournament->id,
                        'slot_date' => $date->format('Y-m-d'),
                        'start_time' => $slot['start'],
                        'end_time' => $slot['end'],
                    ]);
                }
            }
        } else {
            // Si no se selecciona ninguna categoría, se redirige al formulario con un error
            return back()->withErrors(['categories' => 'Debes seleccionar al menos una categoría.'])->withInput();
        }


        return redirect()->route('tournaments')->with('success', 'Torneo creado correctamente');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */

    // Además, revisa si el torneo tiene brackets y si la fecha de inscripción ha pasado. Si es así, genera los partidos automáticamente.
    // Si no, simplemente muestra la vista del torneo.

    public function show($id)
    {
        $tournament = Tournament::with('brackets.category.pairs', 'brackets.games')->findOrFail($id);

        foreach ($tournament->brackets as $bracket) {
            if (
                $tournament->inscription_end_date < now()->toDateString() &&
                $bracket->games()->count() === 0
            ) {
                $bracket->generateGames();
            }
        }
        return view('tournaments.show', compact('tournament'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tournament = Tournament::findOrFail($id);
        $provinces = Province::with('venues')->orderBy('province_name')->get();
        $tournament->load('venues', 'categories', 'brackets', 'payments');

        return view('tournaments.edit', compact('tournament', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);

        if ($request->filled('tournament-range')) {
            $dates = explode(' a ', $request->input('tournament-range'));
            $request->merge([
                'start_date' => isset($dates[0]) ? Carbon::createFromFormat('d-m-Y', $dates[0])->format('Y-m-d') : null,
                'end_date' => isset($dates[1]) ? Carbon::createFromFormat('d-m-Y', $dates[1])->format('Y-m-d') : null,
            ]);
        }

        if ($request->filled('registration-range')) {
            $regDates = explode(' a ', $request->input('registration-range'));
            $request->merge([
                'inscription_start_date' => isset($regDates[0]) ? Carbon::createFromFormat('d-m-Y', $regDates[0])->format('Y-m-d') : null,
                'inscription_end_date' => isset($regDates[1]) ? Carbon::createFromFormat('d-m-Y', $regDates[1])->format('Y-m-d') : null,
            ]);
        }

        if ($request->filled('inscription_start_date') && $request->filled('start_date')) {
            if ($request->input('inscription_start_date') > $request->input('start_date')) {
                return back()->withErrors([
                    'inscription_start_date' => 'La fecha de inicio de inscripción no puede ser posterior a la del torneo.'
                ])->withInput();
            }
        }

        if ($request->filled('inscription_end_date') && $request->filled('start_date')) {
            if ($request->input('inscription_end_date') > $request->input('start_date')) {
                return back()->withErrors([
                    'inscription_end_date' => 'La fecha de fin de inscripción no puede ser posterior a la del torneo.'
                ])->withInput();
            }
        }

        $validated = $request->validate($this->rules());

        $validated['start_date'] = $request->input('start_date');
        $validated['end_date'] = $request->input('end_date');
        $validated['inscription_start_date'] = $request->input('inscription_start_date');
        $validated['inscription_end_date'] = $request->input('inscription_end_date');

        if ($request->hasFile('cartel')) {
            $validated['cartel'] = $request->file('cartel')->store('images/tournaments/carteles', 'public');
        }

        if ($request->hasFile('tournament_image')) {
            $validated['tournament_image'] = $request->file('tournament_image')->store('images/tournaments', 'public');
        }

        $today = now()->toDateString();

        if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
            if (!empty($validated['inscription_start_date']) && $today < $validated['inscription_start_date']) {
                $validated['status'] = 'pendiente';
            } elseif (
                !empty($validated['inscription_start_date']) &&
                !empty($validated['inscription_end_date']) &&
                $today >= $validated['inscription_start_date'] && $today <= $validated['inscription_end_date']
            ) {
                $validated['status'] = 'inscripcion';
            } elseif ($today >= $validated['start_date'] && $today <= $validated['end_date']) {
                $validated['status'] = 'en curso';
            } elseif ($today > $validated['end_date']) {
                $validated['status'] = 'finalizado';
            } else {
                $validated['status'] = 'pendiente';
            }
        }

        $tournament->update($validated);

        // Sincronizar categorías seleccionadas
        if ($request->has('categories')) {
            $selectedCategoryIds = $request->input('categories');

            // Actualiza las categorías del torneo
            $tournament->categories()->sync($selectedCategoryIds);

            // Elimina brackets existentes y vuelve a crearlos
            $tournament->brackets()->delete();

            foreach ($selectedCategoryIds as $categoryId) {
                foreach (['principal', 'consolacion'] as $type) {
                    Bracket::create([
                        'tournament_id' => $tournament->id,
                        'category_id' => $categoryId,
                        'status' => 'En curso',
                        'type' => $type,
                    ]);
                }
            }
        }

        return redirect()->route('tournaments')->with('success', 'Torneo actualizado correctamente');
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->delete();
        return redirect()->route('dashboard')->with('success', 'Tournament deleted successfully');
    }

    public function rules()
    {
        return [
            'tournament_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'cartel' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
            'tournament_name' => ['required', 'string', 'max:255'],
            'inscription_start_date' => ['nullable', 'date', 'after_or_equal:today'],
            'inscription_end_date' => ['nullable', 'date', 'after_or_equal:inscription_start_date'],
            'incription_price' => ['required', 'numeric', 'min:0'],
            'max_pairs' => ['required', 'integer', 'min:1'],
            'current_pairs' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function resetTournament($tournamentId)
    {
        $tournament = Tournament::findOrFail($tournamentId);
    
        foreach ($tournament->brackets as $bracket) {
            // Borrar todos los partidos asociados al bracket
            $bracket->games()->delete();
        }
    
        return back()->with('success', 'Torneo reiniciado correctamente.');
    }
    
}
