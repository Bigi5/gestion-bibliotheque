<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;

class LogUserLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Lorsque l'utilisateur se déconnecte, mettre à jour l'heure de déconnexion
        if (Auth::check()) {
            $session = UserSession::where('user_id', Auth::id())
                                  ->whereNull('logout_time')
                                  ->first();

            if ($session) {
                // Mettre à jour l'heure de déconnexion
                $session->update([
                    'logout_time' => now(),
                ]);
            }
        }

        return $response;
    }
}

