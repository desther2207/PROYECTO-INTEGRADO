<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tournament;

class BracketViewer extends Component
{
    public Tournament $tournament;

    public function mount(Tournament $tournament)
    {
        $this->tournament->load('categories', 'brackets.games.pairOne.playerOne', 'brackets.games.pairOne.playerTwo', 'brackets.games.pairTwo.playerOne', 'brackets.games.pairTwo.playerTwo');
    }

    public function render()
    {
        return view('livewire.bracket-viewer');
    }
}
