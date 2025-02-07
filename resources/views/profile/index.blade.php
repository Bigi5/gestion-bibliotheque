@extends('layouts.app')

@section('content')
<!-- Contenu directement dans le body, sans le container -->
<h2 class="text-2xl font-semibold mb-6">Mon Profil</h2>

@if($user)
    <div class="profile-card">
        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        
        <!-- Bouton d'édition avec une icône -->
        <a href="{{ route('profile.edit') }}" class="profile-btn">
            <i class="fas fa-edit"></i> Modifier le profil
        </a>
    </div>
@else
    <p>Utilisateur non trouvé. Veuillez vous connecter.</p>
@endif

<!-- CSS traditionnel -->
<style>
    /* Retirer la classe container et s'assurer que le contenu est directement sur le body */
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f7fafc;
    }

    h2 {
        font-size: 2rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 20px;
        text-align: center;
    }

    .profile-card {
        background-color: #ffffff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        width: 80%; /* Ajuste la largeur à 80% du body */
        max-width: 800px; /* Optionnel : limite la largeur à 800px */
    }

    .profile-card p {
        font-size: 1.1rem;
        color: #2d3748;
        margin-bottom: 15px;
    }

    .profile-card strong {
        color: #4c51bf;
    }

    .profile-btn {
        display: inline-block;
        background-color: #4c51bf;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        font-size: 1.1rem;
        font-weight: 500;
        margin-top: 20px;
        transition: background-color 0.3s ease;
        display: flex;
        align-items: center;
    }

    .profile-btn:hover {
        background-color: #3b47a2;
    }

    .profile-btn i {
        margin-right: 8px;
    }

    .profile-btn:focus {
        outline: none;
        border: 2px solid #4c51bf;
    }

    .profile-btn:active {
        background-color: #2e3a8c;
    }

    /* Responsivité pour les écrans mobiles */
    @media (max-width: 768px) {
        h2 {
            font-size: 1.5rem;
        }

        .profile-btn {
            font-size: 1rem;
            padding: 8px 18px;
        }
    }
</style>

<!-- Inclusion de Font Awesome pour l'icône -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
