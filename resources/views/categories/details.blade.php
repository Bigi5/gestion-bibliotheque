@extends('layouts.app')

@section('title', 'Détails de la Catégorie')

@section('content')
    <div class="p-6 bg-whitesmoke shadow-md rounded-lg space-y-6">
        <h3 class="text-3xl font-semibold text-orange-600 mb-6 text-center">Détails de la Catégorie : {{ $category->name }}</h3>

        <!-- Formulaire de recherche -->
        <div class="mb-4">
            <form action="{{ route('categories.details', $category->id) }}" method="GET" class="flex justify-center">
                <input type="text" name="search" value="{{ old('search', $searchTerm ?? '') }}" placeholder="Rechercher par titre..." class="p-2 border border-gray-300 rounded-l-lg w-40">
                <button type="submit" class="btn-global rounded-r-lg">Rechercher</button>
            </form>
        </div>

        <!-- Compteur de livres -->
        <div class="text-center mb-4">
            <p class="text-lg text-gray-800">Nombre total de livres : {{ $books->total() }}</p>
        </div>

        <!-- Tableau des livres -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border-collapse border border-gray-300 shadow-md rounded-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">#</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Titre</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Auteur</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $index => $book)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <!-- Rendre le titre cliquable -->
                                <a href="{{ route('books.show', $book->id) }}" class="text-blue-600 hover:underline">{{ $book->title }}</a>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $book->author }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                Aucun livre trouvé pour cette catégorie.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-4">
            {{ $books->appends(['search' => $searchTerm ?? ''])->links() }}
        </div>

        <!-- Bouton Retour -->
        <div class="flex justify-center mt-8">
            <a href="{{ route('dashboard') }}" class="btn-global">Retour au tableau de bord</a>
        </div>
    </div>

    <!-- Style CSS intégré -->
    <style>
        .btn-global {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #4c51bf;
            color: white;
            text-decoration: none;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-global:hover {
            background-color: #434190;
            transform: scale(1.05);
        }
    </style>
@endsection
