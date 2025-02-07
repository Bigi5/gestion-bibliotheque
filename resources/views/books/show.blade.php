@extends('layouts.app')

@section('title', 'Détails du Livre')

@section('content')
    <div class="book-detail-container">
        @if ($book) <!-- Vérification si $book existe -->
            <div class="book-header">
                <h3 class="book-title">{{ $book->title }}</h3>
                <p class="book-author">par {{ $book->author }}</p>
            </div>

            <div class="book-info">
                <div class="book-info-left">
                    <h4 class="section-title">Informations</h4>
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td class="label">Catégorie :</td>
                                <td>{{ $book->category ? $book->category->name : 'Non attribuée' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Exemplaires :</td>
                                <td>{{ $book->copies_total }}</td>
                            </tr>
                            <tr>
                                <td class="label">Prêts :</td>
                                <td>{{ $totalBorrows }}</td>
                            </tr>
                            <tr>
                                <td class="label">Prêts non retournés :</td>
                                <td class="status {{ $borrowedNotReturned > 0 ? 'overdue' : 'returned' }}">
                                    {{ $borrowedNotReturned > 0 ? $borrowedNotReturned : 'Aucun' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="book-info-right">
                    <h4 class="section-title">Statut</h4>
                    <p class="status-text {{ $availableCopies > 0 ? 'available' : 'unavailable' }}">
                        @if ($availableCopies > 0)
                            <strong>Disponible</strong>
                        @else
                            <strong>Indisponible</strong>
                        @endif
                    </p>
                    <p class="status-subtext">
                        {{ $availableCopies > 0 ? 'Ce livre peut être prêté.' : 'Ce livre n\'est actuellement pas disponible pour le prêt.' }}
                    </p>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('books.index') }}" class="btn-return">Retour à la liste</a>
                <button class="btn-edit" onclick="openEditModal({{ json_encode($book) }})">Modifier</button>
                <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirmDelete()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Supprimer</button>
                </form>
            </div>
        @else
            <p class="text-center error-message">Le livre n'existe pas.</p>
        @endif
    </div>

   <!-- Modal de modification -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2 class="modal-title">Modifier le Livre</h2>
        <form id="editForm" method="POST" action="{{ route('books.update', $book->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="author">Auteur :</label>
                <input type="text" id="author" name="author" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="copies_total">Exemplaires :</label>
                <input type="number" id="copies_total" name="copies_total" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category_id">Catégorie :</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-save">Sauvegarder</button>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
    // Fonction pour ouvrir le modal et pré-remplir les champs
    function openEditModal(book) {
        const modal = document.getElementById('editModal');
        modal.style.display = 'block';

        document.getElementById('title').value = book.title;
        document.getElementById('author').value = book.author;
        document.getElementById('copies_total').value = book.copies_total;
        document.getElementById('category_id').value = book.category_id || '';
    }

    // Fonction pour fermer le modal
    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.style.display = 'none';
    }

    // Fermer le modal si on clique en dehors de celui-ci
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    // Confirmation de suppression
    function confirmDelete() {
        return confirm('Êtes-vous sûr de vouloir supprimer ce livre ? Cette action est irréversible.');
    }

    // Ajouter un écouteur d'événement pour fermer le modal après la soumission du formulaire
    document.getElementById('editForm').addEventListener('submit', function() {
        closeEditModal();
    });
</script>

    <style>
        /* Style général */
        .book-detail-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 0 auto;
            font-family: 'Arial', sans-serif;
        }

        /* Header du livre */
        .book-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .book-title {
            font-size: 2.5rem;
            color: #333;
            font-weight: 600;
        }
        .book-author {
            font-size: 1.2rem;
            color: #777;
            margin-top: 10px;
        }

        /* Informations sur le livre */
        .book-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .book-info-left, .book-info-right {
            width: 48%;
        }
        .section-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #f76c47;
            padding-bottom: 5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 12px 20px;
            font-size: 1rem;
            color: #555;
        }
        .info-table .label {
            font-weight: 600;
            color: #333;
        }
        .status {
            font-weight: bold;
        }
        .status.overdue {
            color: #f44336;
        }
        .status.returned {
            color: #4caf50;
        }
        .status.available {
            color: #4caf50;
        }
        .status.unavailable {
            color: #f44336;
        }

        /* Textes de statut */
        .status-text {
            font-size: 1.3rem;
            font-weight: 600;
        }
        .status-subtext {
            font-size: 1rem;
            color: #777;
        }

        /* Boutons */
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn-return, .btn-edit, .btn-delete, .btn-save {
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .btn-return {
            background-color: #007bff;
            color: #fff;
            border: none;
        }
        .btn-return:hover {
            background-color: #0056b3;
        }
        .btn-edit {
            background-color: #ffc107;
            color: #fff;
            border: none;
        }
        .btn-edit:hover {
            background-color: #e0a800;
        }
        .btn-delete {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .btn-save {
            background-color: #28a745;
            color: #fff;
            border: none;
        }
        .btn-save:hover {
            background-color: #218838;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .modal-content {
            background-color: #ffffff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .modal-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
        }
        .main-content {
    margin-left: 250px;
    padding: 20px;
    margin-top: 64px;
}
    </style>
@endsection
