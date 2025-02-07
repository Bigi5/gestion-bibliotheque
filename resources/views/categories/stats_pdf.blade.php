<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h4 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .section p {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="title">
        <h1>Statistiques Générales de la Bibliothèque</h1>
    </div>

    <div class="section">
        <h4>Nombre total de catégories</h4>
        <p>{{ $totalCategories }}</p>
    </div>

    <div class="section">
        <h4>Nombre total de livres</h4>
        <p>{{ $totalBooks }}</p>
    </div>

    <div class="section">
        <h4>Nombre de livres disponibles</h4>
        <p>{{ $availableBooks }}</p>
    </div>

    <div class="section">
        <h4>Nombre de livres non disponibles</h4>
        <p>{{ $unavailableBooks }}</p>
    </div>

    <div class="section">
        <h4>Livres les plus populaires</h4>
        <ul>
            @foreach ($popularBooks as $book)
                <li>{{ $book->title }} ({{ $book->borrows_count }} emprunts)</li>
            @endforeach
        </ul>
    </div>
</body>
</html>
