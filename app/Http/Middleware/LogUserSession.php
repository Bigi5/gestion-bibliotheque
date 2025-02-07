<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;

class LogUserSession
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
        // Vérifier si l'utilisateur est authentifié
        if (Auth::check()) {
            // Enregistrer la session de l'utilisateur
            UserSession::create([
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'browser' => $request->header('User-Agent'),
                'login_time' => now(),
            ]);
        }

        return $next($request);
    }
}
