@extends('layouts.app')

@section('title', 'Détails de la Catégorie')

@section('content')
    <div class="p-6 bg-whitesmoke shadow-md rounded-lg space-y-6">
        <h3 class="text-3xl font-semibold text-orange-600 mb-6 text-center">Détails de la Catégorie : {{ $category->name }}</h3>

        <!-- Formulaire de recherche -->
        <div class="mb-4">
            <form action="{{ route('categories.details', $category->id) }}" method="GET" class="flex justify-center">
                <input type="text" name="search" value="{{ old('search', $searchTerm) }}" placeholder="Rechercher par titre..." class="p-2 border border-gray-300 rounded-l-lg w-1/2">
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
                <thead class="bg-violet-600 text-white">
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
                            <td class="border border-gray-300 px-4 py-2">{{ $book->title }}</td>
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
            {{ $books->appends(['search' => $searchTerm])->links() }}
        </div>

        <!-- Bouton Retour -->
        <div class="flex justify-center mt-8">
            <a href="{{ route('dashboard') }}" class="btn-global">Retour</a>
        </div>
    </div>
@endsection

<style>
    :root {
        --whitesmoke: #f5f5f5;
        --orange: #e74f1d;
        --violet: #6b46c1;
    }

    .bg-whitesmoke {
        background-color: var(--whitesmoke);
    }

    .text-orange-600 {
        color: var(--orange);
    }

    .bg-violet-600 {
        background-color: var(--violet);
    }

    .hover\:bg-violet-700:hover {
        background-color: #5a3791;
    }

    .focus\:ring-violet-400:focus {
        border-color: #a3a4f7;
    }

    .btn-global {
        display: inline-block;
        padding: 10px 20px;
        background-color: var(--violet);
        color: white;
        font-weight: 500;
        font-size: 14px;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-global:hover {
        background-color: #5a3791; /* Violet légèrement plus sombre */
        transform: translateY(-2px);
    }

    .btn-global:focus {
        outline: none;
        box-shadow: 0 0 5px 2px rgba(107, 70, 193, 0.5);
    }
</style>
