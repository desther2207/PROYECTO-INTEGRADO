<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        // Aquí podrías guardar el mensaje o enviarlo por correo
        // Mail::to('admin@tuweb.com')->send(new ContactFormMail($validated));

        return back()->with('success', 'Mensaje enviado correctamente.');
    }
}

