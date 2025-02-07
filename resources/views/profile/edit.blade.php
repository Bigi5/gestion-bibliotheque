@extends('layouts.app')

@section('content')
<div class="profile-form">
    <h2>Modifier Mon Profil</h2>
    
    <!-- Affichage des erreurs de validation -->
    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('profile.update') }}" method="POST" class="form-container">
        @csrf
        @method('PUT')

        <!-- Nom -->
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        
        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        
        <!-- Mot de passe -->
        <div class="form-group">
            <label for="password">Mot de passe (laisser vide pour ne pas modifier)</label>
            <input type="password" id="password" name="password">
        </div>
        
        <!-- Confirmation du mot de passe -->
        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>
        
        <!-- Bouton de sauvegarde -->
        <button type="submit">Sauvegarder les modifications</button>
    </form>
</div>

<style>
    /* Style général du body */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    /* Formulaire de profil */
    .profile-form {
        max-width: 600px;
        margin: 50px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Titre */
    .profile-form h2 {
        font-size: 24px;
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    /* Messages d'erreur */
    .error-messages {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #f5c6cb;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    /* Style des groupes de formulaire */
    .form-group {
        margin-bottom: 20px;
    }

    /* Labels */
    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    /* Champs de saisie */
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 2px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    /* Effet au focus des champs */
    .form-group input:focus {
        border-color: #4c51bf;
        outline: none;
    }

    /* Bouton */
    button {
        width: 100%;
        background-color: #4c51bf;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    /* Effet au survol du bouton */
    button:hover {
        background-color: #3a40a0;
    }
</style>
@endsection
