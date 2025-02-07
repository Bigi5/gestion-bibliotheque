@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">Statistiques du livre</h1>
        <h2 class="subtitle">{{ $book->title }}</h2>

        <!-- Tableau des statistiques -->
        <div class="table-wrapper">
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Propriété</th>
                        <th>Valeur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Auteur</td>
                        <td>{{ $book->author }}</td>
                    </tr>
                    <tr>
                        <td>ISBN</td>
                        <td>{{ $book->isbn }}</td>
                    </tr>
                    <tr>
                        <td>Exemplaires totaux</td>
                        <td>{{ $book->copies_total }}</td>
                    </tr>
                    <tr>
                        <td>Exemplaires disponibles</td>
                        <td>
                            @php
                                // Calculer les copies disponibles en fonction des emprunts non retournés
                                $availableCopies = $book->copies_total - $book->borrows()->whereNull('return_date')->count();
                            @endphp
                            {{ max($availableCopies, 0) }}  <!-- Afficher la valeur ou 0 si négatif -->
                        </td>
                    </tr>
                    <tr>
                        <td>Nombre d'emprunts</td>
                        <td>{{ $book->borrows()->count() }}</td> <!-- Afficher le nombre d'emprunts -->
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bouton de retour -->
        <div class="button-wrapper">
            <a href="{{ route('categories.stats') }}" class="btn-return">Retour aux statistiques</a>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Conteneur principal */
        .container {
            max-width: 800px;
            margin: 80px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Titre principal */
        .title {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            color: #145fad;
            margin-bottom: 10px;
        }

        /* Sous-titre */
        .subtitle {
            font-size: 20px;
            font-style: italic;
            text-align: center;
            color: #1a1a1a;
            margin-bottom: 20px;
        }

        /* Tableaux des statistiques */
        .table-wrapper {
            overflow-x: auto;
            margin-top: 20px;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .stats-table th {
            background-color: #145fad;
            color: #ffffff;
            padding: 12px;
            font-size: 16px;
            text-align: left;
        }

        .stats-table td {
            background-color: #f9f9f9;
            padding: 12px;
            font-size: 14px;
            color: #333333;
        }

        .stats-table tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        .stats-table tr:hover td {
            background-color: #e2e8f0;
        }

        /* Bouton de retour */
        .button-wrapper {
            text-align: center;
            margin-top: 30px;
        }

        .btn-return {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4c51bf;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-return:hover {
            background-color: #3b40a1;
            transform: translateY(-2px);
        }

        .btn-return:active {
            background-color: #2c2f81;
            transform: translateY(1px);
        }

        /* Fond global */
        body {
            background-color: #f9fafb;
            font-family: Arial, sans-serif;
        }
    </style>
@endsection
