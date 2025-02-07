@extends('layouts.app')

@section('content')
<div class="profile-container">
    <h2>Mon Profil</h2>

    @if($user)
        <div class="profile-card">
            <p><strong>Nom :</strong> {{ $user->name }}</p>
            <p><strong>Email :</strong> {{ $user->email }}</p>
            <p><strong>Date d'ajout du compte :</strong> {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y, H:i') }}</p>

            @if ($user->sessions && $user->sessions->count() > 0)
                <p><strong>Dernière connexion :</strong> {{ \Carbon\Carbon::parse($user->sessions->last()->last_activity)->format('d M Y, H:i') }}</p>
            @else
                <p><strong>Dernière connexion :</strong> Aucune connexion.</p>
            @endif

            <a href="{{ route('profile.edit') }}" class="edit-btn">
                <i class="fas fa-edit"></i> Modifier le profil
            </a>
        </div>
    @else
        <p>Utilisateur non trouvé. Veuillez vous connecter.</p>
    @endif
</div>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9fafb;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .profile-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 20px;
        text-align: center;
    }

    h2 {
        font-size: 2rem;
        color: #333;
        font-weight: 600;
        margin-bottom: 30px;
    }

    .profile-card {
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        text-align: left;
        max-width: 600px;
        margin: 0 auto;
    }

    .profile-card p {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 18px;
    }

    .profile-card strong {
        color: #4c51bf;
        font-weight: bold;
    }

    .edit-btn {
        display: inline-flex;
        align-items: center;
        background-color: #4c51bf;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        font-size: 1.1rem;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin-top: 20px;
    }

    .edit-btn i {
        margin-right: 8px;
    }

    .edit-btn:hover {
        background-color: #3b47a2;
        transform: scale(1.05);
    }

    .edit-btn:focus {
        outline: none;
        box-shadow: 0 0 5px 2px #4c51bf;
    }

    @media (max-width: 768px) {
        .profile-card {
            padding: 20px;
        }

        .edit-btn {
            width: 100%;
            padding: 14px;
        }
    }
</style>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
