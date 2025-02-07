@extends('layouts.app')

@section('title', 'Liste des Utilisateurs')

@section('content')
    <style>
        /* Styles pour la table */
        .table-row:hover {
            background-color: #f3f4f6;
            color: #1a202c; /* Applique la couleur noire à tout le texte de la ligne */
            transition: all 0.3s ease-in-out;
        }

        .table-row:hover a {
            color: #1a202c; /* Applique la couleur noire aux liens de la ligne */
        }

        /* Styles pour les boutons */
        .btn-edit {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #16a34a;
            color: white;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-edit:hover {
            background-color: #15803d;
        }

        .btn-delete {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #dc2626;
            color: white;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #b91c1c;
        }

        /* Bouton pour créer un utilisateur */
        .btn-create {
            padding: 0.5rem 1rem;
            background-color: #4c51bf;
            color: white;
            border-radius: 0.375rem;
            text-decoration: none;
            margin-bottom: 1rem;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .btn-create:hover {
            background-color: #4338ca;
        }
    </style>

    <!-- Contenu principal -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-6">
                        Liste des Utilisateurs
                    </h2>

                    <!-- Bouton de création d'utilisateur -->
                    <a href="{{ route('users.create') }}" class="btn-create">
                        Créer un Utilisateur
                    </a>

                    <table class="min-w-full table-auto mb-6 text-left border-collapse border border-gray-300">
                        <thead class="bg-purple-600 text-white">
                            <tr>
                                <th class="px-12 py-4 font-medium border border-gray-300">Nom</th>
                                <th class="px-12 py-4 font-medium border border-gray-300">Email</th>
                                <th class="px-12 py-4 font-medium border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-black">
                            @foreach($users as $user)
                                <tr class="table-row">
                                    <td class="px-12 py-6 border border-gray-300">{{ $user->name }}</td>
                                    <td class="px-12 py-6 border border-gray-300">{{ $user->email }}</td>
                                    <td class="px-12 py-6 flex space-x-6 border border-gray-300">
                                        <!-- Bouton modifier avec couleur verte -->
                                        <a href="{{ route('users.edit', $user) }}" class="btn-edit">
                                            Modifier
                                        </a>

                                        <!-- Formulaire supprimer avec confirmation -->
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
