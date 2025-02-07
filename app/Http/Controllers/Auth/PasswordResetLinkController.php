<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Afficher la vue de demande de réinitialisation de mot de passe.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Gérer la demande de lien de réinitialisation de mot de passe.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation de l'email
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'Veuillez fournir une adresse e-mail valide.',
        ]);

        // Tentative d'envoi du lien de réinitialisation
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Vérifier si l'envoi a réussi
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __('Un lien de réinitialisation a été envoyé à votre adresse e-mail.'));
        } else {
            // Gestion des erreurs si l'envoi échoue
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => __('Impossible d\'envoyer un lien de réinitialisation à cette adresse e-mail.')]);
        }
    }
}
