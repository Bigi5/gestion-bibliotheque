@extends('layouts.app') <!-- Extension du layout app.blade.php -->

@section('title', __('Modifier l\'Utilisateur'))

@section('content') <!-- Début de la section 'content' -->
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-gray-200 via-gray-300 to-gray-200 p-8 rounded-lg shadow-xl">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-8 text-center">
                Modifier l'utilisateur
            </h2>

            <!-- Formulaire de mise à jour de l'utilisateur -->
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT') <!-- Pour spécifier que c'est une mise à jour -->

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full px-4 py-2 border border-gray-400 rounded-md shadow-sm text-gray-800 bg-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full px-4 py-2 border border-gray-400 rounded-md shadow-sm text-gray-800 bg-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select id="role" name="role" class="mt-1 block w-full px-4 py-2 border border-gray-400 rounded-md shadow-sm text-gray-800 bg-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Utilisateur</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-md shadow-sm hover:bg-purple-700 transition duration-300">Mettre à jour l'utilisateur</button>
            </form>

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-md mt-6 text-center">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection <!-- Fin de la section 'content' -->
