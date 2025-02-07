<?php

namespace App\Http\Controllers\Auth;

use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    // Méthode de connexion
    public function login(HttpRequest $request)
    {
        // Validation des données de connexion
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Tentative de connexion
        if (Auth::attempt($request->only('email', 'password'))) {
            // Appeler la méthode authenticated après une connexion réussie
            return $this->authenticated();
        }

        // En cas d'échec de la connexion
        return back()->withErrors(['email' => 'Identifiants incorrects']);
    }

    // Méthode qui est appelée après une connexion réussie
    public function authenticated()
    {
        // Créer une nouvelle session après la connexion de l'utilisateur
        Session::create([
            'user_id' => Auth::id(),  // ID de l'utilisateur connecté
            'ip_address' => Request::ip(),  // Adresse IP de l'utilisateur
            'user_agent' => Request::userAgent(),  // Le navigateur et appareil utilisé
            'payload' => json_encode(['additional_info' => 'exemple']),  // Informations supplémentaires
            'last_activity' => time(),  // L'heure de la dernière activité
        ]);

        // Ajouter un message flash de bienvenue
        session()->flash('welcome_message', 'Bienvenue ' . Auth::user()->name . ' !');

        // Rediriger vers le tableau de bord
        return redirect()->route('dashboard');
    }
}
