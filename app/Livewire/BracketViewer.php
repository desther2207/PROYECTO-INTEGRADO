<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tournament;

class BracketViewer extends Component
{
    public Tournament $tournament;

    public function mount(Tournament $tournament)
    {
        $this->tournament->load('categories', 'brackets.games.pairs.players');
    }

    public function render()
    {
        return view('livewire.bracket-viewer');
    }
}
