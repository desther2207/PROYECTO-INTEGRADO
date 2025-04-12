<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Tournament;

class ShowTournaments extends Component
{
    use WithPagination, WithFileUploads;

    public $texto = '';
    public $status = '';
    public $level = '';
    public $start_date = '';
    public $end_date = '';

    public function render()
    {
        $query = Tournament::selectRaw("*, datediff(end_date, start_date) as duracion");

        if ($this->texto) {
            $query->where(function ($q) {
                $q->where('tournament_name', 'like', '%' . $this->texto . '%')
                  ->orWhere('description', 'like', '%' . $this->texto . '%');
            });
        }

        // Filtros adicionales
        if ($this->status) {
            $query->where('status', $this->status);
        }
        if ($this->level) {
            $query->where('level', $this->level);
        }
        if ($this->start_date) {
            $query->whereDate('start_date', '>=', $this->start_date);
        }
        if ($this->end_date) {
            $query->whereDate('end_date', '<=', $this->end_date);
        }

        $tournaments = $query->paginate(6);

        return view('livewire.show-tournaments', compact('tournaments'));
    }
}
