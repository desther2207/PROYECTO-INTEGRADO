<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class TournamentConfirmationMail extends Mailable
{
    public $tournament;
    public $user;

    public function __construct($user, $tournament)
    {
        $this->user = $user;
        $this->tournament = $tournament;
    }

    public function build()
    {
        return $this
            ->subject('Confirmación de inscripción')
            ->markdown('emails.tournament_confirmation');
    }
}
