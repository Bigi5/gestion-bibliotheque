<?php

namespace App\Http\Middleware;

use App\Models\UserSession;
use Closure;
use Illuminate\Support\Facades\Auth;

class UpdateUserSessionLogout
{
    public function handle($request, Closure $next)
    {
        // Si l'utilisateur est authentifié et si le middleware de déconnexion est déclenché
        if (Auth::check()) {
            $userSession = UserSession::where('user_id', Auth::id())
                                      ->whereNull('logout_at') // Vérifie si l'utilisateur est encore connecté
                                      ->first();

            if ($userSession) {
                // Mise à jour de l'heure de déconnexion
                $userSession->update([
                    'logout_at' => now(),
                ]);
            }
        }

        return $next($request);
    }
}
