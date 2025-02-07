<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Modifier le Livre') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Style pour les champs de saisie */
        input, select {
            background-color: #ffffff;
            color: #4B5563;
            border: 2px solid #D1D5DB;
            padding: 10px;
            border-radius: 8px;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        /* Focus sur les champs */
        input:focus, select:focus {
            background-color: #F3F4F6;
            border-color: #4C51BF;
            outline: none;
        }

        /* Styles pour les labels */
        label {
            font-size: 1rem;
            font-weight: 600;
            color: #4B5563;
            margin-bottom: 0.5rem;
        }

        /* Bouton de soumission */
        button[type="submit"] {
            background-color: #4C51BF;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #042888;
        }

        /* Section de la page Modifier le Livre */
        .modifier-livre-section {
            background-color: #dad9dc;
            padding: 2rem;
            border-radius: 12px;
        }

        /* Alerte de succès */
        .alert-success {
            background-color: #D1E7DD;
            color: #0F5132;
            border: 1px solid #A3D9A5;
            padding: 12px;
            margin-top: 20px;
            border-radius: 8px;
        }

        /* Centrer le formulaire */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Pagination et autres liens */
        .pagination a {
            margin: 0 4px;
            padding: 8px 14px;
            background-color: #4C51BF;
            color: white;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #042888;
        }
    </style>
</head>
<body class="bg-gray-100">

    @extends('layouts.app')

    @section('content')

    <!-- Titre -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <h2 class="font-semibold text-2xl text-gray-900">{{ __('Modifier le Livre') }}</h2>
    </div>

    <!-- Formulaire principal -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="text-gray-900">
                    <form action="{{ route('books.update', $book->id) }}" method="POST" class="form-container">
                        @csrf
                        @method('PUT')

                        <!-- Titre -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" class="mt-1 block w-full p-3 border border-gray-300 rounded-md" required>
                        </div>

                        <!-- Auteur -->
                        <div class="mb-6">
                            <label for="author" class="block text-sm font-medium text-gray-700">Auteur</label>
                            <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}" class="mt-1 block w-full p-3 border border-gray-300 rounded-md" required>
                        </div>

                        <!-- ISBN -->
                        <div class="mb-6">
                            <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                            <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="mt-1 block w-full p-3 border border-gray-300 rounded-md" required>
                        </div>

                        <!-- Copies Disponibles -->
                        <div class="mb-6">
                            <label for="copies_available" class="block text-sm font-medium text-gray-700">Copies Disponibles</label>
                            <input type="number" id="copies_available" name="copies_available" value="{{ old('copies_available', $book->copies_available) }}" class="mt-1 block w-full p-3 border border-gray-300 rounded-md" required>
                        </div>

                        <!-- Catégorie -->
                        <div class="mb-6">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full border border-gray-300 rounded-md p-3">
                                <option value="" disabled selected>Choisir une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Bouton de sauvegarde -->
                        <div class="flex justify-center">
                            <button type="submit" class="bg-violet-600 text-white p-3 rounded-md hover:bg-violet-700">Sauvegarder</button>
                        </div>
                    </form>

                    <!-- Message de succès -->
                    @if (session('success'))
                        <div class="alert-success mt-4">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @endsection

</body>
</html>
