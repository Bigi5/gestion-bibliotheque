@extends('layouts.app')

@section('title', 'Liste des Livres')

@section('content')
<style>
    /* Conteneur principal avec fond et margin-top ajouté */
    .content {
        background-color: #f8f9fa;
        padding: 50px 0;
        margin-top: 30px;
    }

    /* Titre principal spécifique à la page des livres */
    .list-title {
        text-align: center;
        color: #4c51bf;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 40px;
        text-transform: uppercase;
    }

    /* Conteneur des livres avec flexbox pour une disposition élégante */
    .books-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start; /* Aligner les livres à gauche */
        gap: 30px;
        padding: 0 20px;
    }

    /* Carte de livre avec bordure, ombre et effets de survol */
    .book-card {
        width: 250px;
        height: 250px; /* Forme carrée */
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
        position: relative;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Image de couverture du livre */
    .book-card img {
        width: 100%;
        height: 60%;
        object-fit: cover;
    }

    /* Titre du livre */
    .book-card h3 {
        font-size: 1.4rem;
        color: #343a40;
        margin: 10px 0;
    }

    /* Description de l'auteur */
    .book-card p {
        color: #777;
        font-size: 0.9rem;
        margin: 0 10px 10px;
    }

    /* Catégorie avec texte coloré sans fond */
    .book-card .category {
        color: #4c51bf; /* Couleur du texte */
        font-size: 0.9rem;
        display: inline-block;
        margin-bottom: 15px;
    }

    /* Bouton d'action "Voir Détails" stylisé et réduit */
    .book-card .btn-action {
        display: none;
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #6c757d;
        color: #fff;
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 25px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .book-card:hover .btn-action {
        display: inline-block;
    }

    .book-card .btn-action:hover {
        background-color: #e64614; /* Orange pur au survol */
    }

    /* Pagination avec des boutons de style élégant */
    .pagination {
        text-align: center;
        margin-top: 50px;
    }

    .pagination a {
        padding: 10px 20px;
        margin: 0 5px;
        background-color: #4c51bf;
        color: white;
        font-size: 1rem;
        border-radius: 30px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .pagination a:hover {
        background-color: #3e44b8;
    }

    /* Bouton Ajouter un Livre stylisé */
    .add-book-btn {
        display: inline-block;
        background-color: #dad9dc; /* Fond neutre mais discret */
        color: #343a40; /* Texte en couleur sombre pour contraste */
        font-size: 1.1rem;
        padding: 8px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: bold;
        text-align: center;
        margin-bottom: 30px;
        transition: background-color 0.3s ease;
    }

    .add-book-btn:hover {
        background-color: #e64614; /* Orange pur au survol */
        color: white;
    }

    /* Formulaire de filtre */
    .filter-form {
        margin-bottom: 30px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .filter-form select,
    .filter-form input {
        padding: 10px;
        border-radius: 25px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .filter-form button {
        padding: 10px 20px;
        background-color: #4c51bf;
        color: white;
        border-radius: 25px;
        border: none;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .filter-form button:hover {
        background-color: #3e44b8;
    }

    /* Espacement pour le bouton de téléchargement */
    .export-btn-container {
        text-align: center;
        margin-top: 30px;
    }
</style>

<div class="content">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="list-title">Liste des Livres</h2>

            <!-- Message de succès -->
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulaire de filtre -->
            <div class="filter-form">
                <form method="GET" action="{{ route('books.index') }}">
                    <select name="category" class="form-control">
                        <option value="">Choisir une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="text" name="title" placeholder="Titre du livre" value="{{ request('title') }}" />

                    <button type="submit">Filtrer</button>
                </form>
            </div>

            <!-- Bouton Ajouter un Livre -->
            <div class="text-center">
                <a href="{{ route('books.create') }}" class="add-book-btn">Ajouter un Livre</a>
            </div>

            @if($books->isEmpty())
                <p class="text-center text-gray-500">Aucun livre enregistré pour le moment.</p>
            @else
                <div class="books-container">
                    @foreach($books as $book)
                        <div class="book-card">
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover img of {{ $book->title }}">
                            <h3>{{ $book->title }}</h3>
                            <p>Auteur: {{ $book->author }}</p>
                            <p class="category">{{ $book->category->name ?? 'Non catégorisé' }}</p>

                            <!-- Bouton "Voir Détails" -->
                            <a href="{{ route('books.show', $book->id) }}" class="btn-action">Voir Détails</a>
                        </div>
                    @endforeach
                </div>

                <!-- Ajouter le bouton de téléchargement ODF -->
                <div class="export-btn-container">
                    <a href="{{ route('books.export.odf') }}" class="btn btn-primary">Télécharger la liste des livres</a>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
