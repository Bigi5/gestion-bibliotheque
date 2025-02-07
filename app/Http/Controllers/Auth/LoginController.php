<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validation des données de connexion
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Connexion réussie, création de l'entrée dans la table user_sessions
            UserSession::create([
                'user_id' => Auth::id(),
                'login_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->intended('dashboard'); // Redirige vers le tableau de bord
        }

        return back()->withErrors(['email' => 'Les informations de connexion sont incorrectes.']);
    }

    public function logout(Request $request)
    {
        // Mise à jour de l'heure de déconnexion dans la table user_sessions
        $userSession = UserSession::where('user_id', Auth::id())
                                  ->whereNull('logout_at') // Si l'utilisateur est encore connecté
                                  ->first();

        if ($userSession) {
            // Mettre à jour l'heure de déconnexion
            $userSession->update([
                'logout_at' => now(),
            ]);
        }

        Auth::logout();
        return redirect('/');
    }
}
