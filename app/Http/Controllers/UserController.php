<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::all(); // Récupère tous les utilisateurs
        return view('users.index', compact('users')); // Passe les utilisateurs à la vue
    }

    // Afficher le formulaire pour créer un utilisateur
    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validation des champs
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Ajout de la confirmation de mot de passe
            'role' => 'required|in:admin,user',
        ], [
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'Veuillez entrer un email valide.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'role.required' => 'Veuillez sélectionner un rôle.',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Assurez-vous de hacher le mot de passe
            'role' => $validatedData['role'],
        ]);

        // Envoi de l'e-mail avec les identifiants
        Mail::send('emails.user_created', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'Mot de passe sécurisé : Changez-le après connexion', // Message de sécurité
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Vos identifiants de connexion');
        });

        // Redirection avec message de succès
        return redirect()->route('users.index')->with('success', 'Utilisateur créé et e-mail envoyé.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // Validation du mot de passe si présent
        ], [
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'Veuillez entrer un email valide.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        // Mise à jour des informations de l'utilisateur
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Mise à jour du mot de passe si présent
        if ($request->filled('password')) {
            if (Hash::check($request->input('password'), $user->password)) {
                return back()->withErrors(['password' => 'Le nouveau mot de passe doit être différent de l\'ancien.']);
            }
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour');
    }

    public function destroy(User $user)
    {
        // Vérifier si l'utilisateur est un administrateur
        if ($user->role === 'admin' && auth()->user()->role !== 'admin') {
            return redirect()->route('users.index')->with('error', 'Vous ne pouvez pas supprimer un administrateur.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé');
    }
}
