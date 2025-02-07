<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendTestEmail()
    {
        Mail::raw('Ceci est un email de test envoyé avec Laravel.', function ($message) {
            $message->to('carlossabi64@gmail.com')
                    ->subject('Email de Test');
        });

        return 'Email envoyé avec succès !';
    }
}
