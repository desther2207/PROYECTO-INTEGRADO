<?php

namespace App\Livewire;

use App\Models\Province;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Tournament;

class ShowTournaments extends Component
{
    use WithPagination, WithFileUploads;

    public $texto = '';
    public $status = '';
    public $province_id = '';
    public $inscription_price_min = '';
    public $inscription_price_max = '';

    public function render()
    {
        $query = Tournament::with('province')
            ->selectRaw("*, datediff(end_date, start_date) as duracion");

        if ($this->texto) {
            $query->where(function ($q) {
                $q->where('tournament_name', 'like', '%' . $this->texto . '%')
                    ->orWhere('description', 'like', '%' . $this->texto . '%');
            });
        }
        
        // Filtro por estado
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Filtro por provincia
        if ($this->province_id) {
            $query->where('province_id', $this->province_id);
        }

        $tournaments = $query->paginate(6);
        $provinces = Province::orderBy('province_name')->get();

        return view('livewire.show-tournaments', compact('tournaments', 'provinces'));
    }

    public function updatingTexto()
    {
        $this->resetPage();
    }
}
