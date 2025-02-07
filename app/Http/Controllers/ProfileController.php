<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;



class ProfileController extends Controller
{
    /**
     * Affiche le profil de l'utilisateur connecté.
     */
    public function show(): View
    {
        $user = Auth::user(); // Récupère l'utilisateur connecté

        // Vérifie si l'utilisateur est connecté
        if ($user) {
            return view('profile.show', compact('user')); // Affiche le profil de l'utilisateur connecté
        }

        // Si l'utilisateur n'est pas connecté, il sera redirigé vers la page de connexion
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à votre profil.');
    }

    /**
     * Affiche le formulaire d'édition du profil.
     */
    public function edit(): View
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Passe l'utilisateur à la vue d'édition
        return view('profile.edit', compact('user'));
    }

    /**
     * Met à jour le profil de l'utilisateur.
     */
    public function update(Request $request)
{
    // Valide les données envoyées par le formulaire
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Récupère l'utilisateur actuellement connecté
    $user = Auth::user();

    // Vérifie que l'utilisateur est une instance du modèle User
    if (!$user instanceof User) {
        return redirect()->route('login')->with('error', 'Utilisateur non valide.');
    }

    // Met à jour les informations de l'utilisateur
    $user->name = $request->input('name');
    $user->email = $request->input('email');

    // Si un mot de passe est fourni, il est mis à jour
    if ($request->filled('password')) {
        $user->password = bcrypt($request->input('password'));
    }

    // Sauvegarde les modifications
    $user->save();

    // Redirige vers le profil avec un message de succès
    return redirect()->route('profile.show')
        ->with('success', 'Votre profil a été mis à jour avec succès.');
}

}
