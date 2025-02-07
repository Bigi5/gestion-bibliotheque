<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Afficher la vue de connexion.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Gérer la demande d'authentification.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentification de l'utilisateur
        $request->authenticate();

        // Regénération de la session pour éviter les attaques de fixation de session
        $request->session()->regenerate();

        // Redirection vers la page demandée ou vers le tableau de bord
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Détruire une session authentifiée.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Déconnexion de l'utilisateur
        Auth::guard('web')->logout();

        // Invalidations de la session actuelle
        $request->session()->invalidate();

        // Régénération du token CSRF
        $request->session()->regenerateToken();

        // Redirection vers la page d'accueil avec un message de succès
        return redirect('/')->with('status', 'Déconnexion réussie.');
    }
}
