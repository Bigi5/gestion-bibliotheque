@extends('layouts.app')

@section('title', 'Modifier le Profil d\'Emprunteur')

@section('content')
<div class="flex justify-center items-start min-h-screen bg-gray-100 pt-8">
    <div class="container p-6 bg-white text-black rounded-lg shadow-lg w-full sm:w-96">
        @if(session('success'))
            <div class="mb-4 p-4 text-white bg-green-500 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 text-white bg-red-500 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-center text-2xl font-semibold mb-6 text-blue-700">Modifier le Profil d'Emprunteur</h1>

        <form action="{{ route('borrower_profiles.update', $borrowerProfile->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $borrowerProfile->first_name) }}" class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $borrowerProfile->last_name) }}" class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email', $borrowerProfile->email) }}" class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4 text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transform hover:scale-105 transition-all">
                    Mettre à jour le Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Style global du formulaire */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f9fafb;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Container principal */
.container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 24px;
    width: 100%;
    max-width: 400px;
    margin-top: 83px;
}

/* Titre principal */
h1 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #4c51bf;
    margin-bottom: 1.5rem;
}

/* Formulaire */
form {
    display: flex;
    flex-direction: column;
}

/* Champs de saisie */
input[type="text"], input[type="email"] {
    padding: 12px;
    margin-top: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1rem;
    width: 100%;
    outline: none;
    transition: all 0.3s ease;
}

input[type="text"]:focus, input[type="email"]:focus {
    border-color: #4c51bf;
    box-shadow: 0 0 5px rgba(76, 81, 191, 0.5);
}

/* Message de succès et erreur */
.mb-4 {
    margin-bottom: 1rem;
}

.bg-green-500 {
    background-color: #38a169;
}

.bg-red-500 {
    background-color: #e53e3e;
}

.text-white {
    color: white;
}

.rounded-lg {
    border-radius: 8px;
}

/* Bouton */
button {
    background-color: #4c51bf;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.2s;
    border: none;
    width: 100%;
}

button:hover {
    background-color: #3b42a4;
    transform: scale(1.05);
}

/* Effet de focus sur le bouton */
button:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(76, 81, 191, 0.5);
}

/* Responsivité */
@media (max-width: 768px) {
    .container {
        padding: 16px;
    }

    h1 {
        font-size: 1.25rem;
    }

    input[type="text"], input[type="email"], button {
        font-size: 0.9rem;
        padding: 10px;
    }
}
</style>
@endsection
