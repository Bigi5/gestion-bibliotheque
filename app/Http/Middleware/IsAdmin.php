<?php


// app/Http/Middleware/IsAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        // Vérifier si l'utilisateur est authentifié et s'il a le rôle "admin"
        if (Auth::check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Si l'utilisateur n'est pas admin, rediriger vers une autre page (par exemple la page d'accueil)
        return redirect('/')->with('error', 'Accès non autorisé');
    }
}

