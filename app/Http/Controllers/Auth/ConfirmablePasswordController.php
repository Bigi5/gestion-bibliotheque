<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Afficher la vue de confirmation du mot de passe.
     *
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirmer le mot de passe de l'utilisateur.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation de la présence du mot de passe
        $request->validate([
            'password' => 'required|string',
        ]);

        // Validation du mot de passe de l'utilisateur
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            // Lancer une exception avec un message d'erreur personnalisé
            throw ValidationException::withMessages([
                'password' => __('auth.password'), // Message d'erreur pour mot de passe incorrect
            ]);
        }

        // Enregistrement de la confirmation du mot de passe dans la session
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirection après confirmation vers le tableau de bord ou la destination prévue
        return redirect()->intended(route('dashboard'));
    }
}
