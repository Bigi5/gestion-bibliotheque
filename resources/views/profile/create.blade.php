@extends('layouts.app')

@section('title', 'Créer un Profil')

@section('content')
<div class="container mx-auto p-6 bg-white text-black rounded-lg shadow-lg w-96">
    <h1 class="text-center text-2xl font-semibold mb-6">Créer un Profil</h1>

    <form action="{{ route('profiles.store') }}" method="POST">
        @csrf
        <div class="mb-6">
            <label for="first_name" class="block text-sm font-medium text-black mb-2">Prénom</label>
            <input type="text" name="first_name" id="first_name" class="w-full p-3 bg-white text-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-6">
            <label for="last_name" class="block text-sm font-medium text-black mb-2">Nom</label>
            <input type="text" name="last_name" id="last_name" class="w-full p-3 bg-white text-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-black mb-2">E-mail</label>
            <input type="email" name="email" id="email" class="w-full p-3 bg-white text-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <button type="submit" class="w-full py-3 mt-6 bg-purple-600 text-white font-semibold rounded-md hover:bg-purple-700 transition duration-300">
            Enregistrer
        </button>
    </form>
</div>
@endsection
