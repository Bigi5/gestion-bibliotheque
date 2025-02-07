@extends('layouts.app')

@section('title', 'Statistiques Générales')

@section('content')
    <div class="container">
        <h3>Statistiques Générales de la Bibliothèque</h3>

        <!-- Statistiques sous forme de cartes -->
        <div class="stat-box">
            <div class="stat-item blue">
                <h4>Nombre total de catégories</h4>
                <p>{{ $totalCategories }}</p>
            </div>

            <div class="stat-item green">
                <h4>Nombre total de livres</h4>
                <p>{{ $totalBooks }}</p>
            </div>

            <div class="stat-item yellow">
                <h4>Nombre total d'exemplaires</h4>
                <p>{{ $exemplairesTotaux }}</p>
            </div>

            <div class="stat-item red">
                <h4>Nombre d'exemplaires disponibles</h4>
                <p>{{ $exemplairesDisponibles }}</p>
            </div>

            <div class="stat-item purple">
                <h4>Total des emprunts</h4>
                <p>{{ $totalEmprunts }}</p>
            </div>
        </div>

        <!-- Liste des livres les plus populaires -->
        <div class="popular-books">
            <h4>Livres les plus populaires</h4>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Nombre de prêts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($popularBooks as $index => $book)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $book->title }}</td> <!-- Lien supprimé -->
                                <td>{{ $book->author }}</td>
                                <td class="text-yellow-600">{{ $book->borrows_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            margin-top: 53px;
        }

        h3 {
            text-align: center;
            font-size: 2rem;
            color: #4c51bf;
            margin-bottom: 30px;
        }

        /* Boîte des statistiques */
        .stat-box {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .stat-item {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(20% - 20px); /* 5 colonnes sur grand écran */
            min-width: 200px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            text-align: center;
        }

        .stat-item:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .stat-item h4 {
            font-size: 1.25rem;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .stat-item p {
            font-size: 2rem;
            font-weight: bold;
            color: #4c51bf;
        }

        /* Couleurs spécifiques pour chaque statistique */
        .stat-item.blue {
            background-color: #e6f0ff;
            border-left: 5px solid #4c51bf;
        }

        .stat-item.green {
            background-color: #e8f5e9;
            border-left: 5px solid #28a745;
        }

        .stat-item.red {
            background-color: #fbe9e7;
            border-left: 5px solid #dc3545;
        }

        .stat-item.yellow {
            background-color: #fff3cd;
            border-left: 5px solid #ffa500;
        }

        .stat-item.purple {
            background-color: #f3e5f5;
            border-left: 5px solid #6a1b9a;
        }

        /* Section des livres populaires */
        .popular-books {
            margin-top: 40px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: white;
        }

        table th, table td {
            padding: 12px 20px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 1rem;
        }

        table th {
            background-color: #4c51bf;
            color: #ffffff;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsivité */
        @media screen and (max-width: 768px) {
            .stat-item {
                flex: 1 1 calc(50% - 20px); /* 2 colonnes sur tablettes */
            }

            table th, table td {
                padding: 10px 15px;
            }
        }

        @media screen and (max-width: 576px) {
            .stat-item {
                flex: 1 1 100%; /* 1 seule colonne sur mobile */
            }

            .container {
                padding: 15px;
            }

            h3 {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection
