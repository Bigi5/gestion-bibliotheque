@extends('layouts.app')  <!-- Étendre le layout app.blade.php -->

@section('title', 'Tableau de Bord ')  <!-- Définir le titre de la page -->


@section('styles')  <!-- Section pour les styles spécifiques à cette vue -->

    <style>
        /* Styles spécifiques au tableau de bord */
        .dashboard-container {
            padding: 20px;
            margin-left: 250px; /* Ajustement pour la sidebar */
            margin-top: 80px; /* Ajustement pour le header */
            margin-left: 10px;
        }

        .dashboard-container h1 {
            color: #434a95;
            margin-bottom: 20px;
            text-align: center; /* Centrer le titre */
        }

        .blocks-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .block {
            flex: 1 1 calc(50% - 20px); /* Deux blocs par ligne avec un espace de 20px */
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animation de hover */
        }

        .block:hover {
            transform: translateY(-5px); /* Effet de levée au survol */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée */
        }

        .block h2 {
            color: #7d0c9d;
            margin-bottom: 20px;
        }

        .sub-block-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .sub-block {
            flex: 1;
            height: 150px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animation de hover */
        }

        .sub-block:hover {
            transform: scale(1.05); /* Effet de zoom au survol */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Ombre plus prononcée */
        }

        .sub-block strong {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #fff;
        }

        .sub-block-content {
            font-size: 43px;
            font-weight: bold;
            color: #fff;
        }

        .block-1 { background-color: #434a95; }
        .block-2 { background-color: #7d0c9d; }
        .block-3 { background-color: #ef0000; }
        .block-4 { background-color: #f9be0d; color: #000; }

        .table-block {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animation de hover */
        }

        .table-block:hover {
            transform: translateY(-5px); /* Effet de levée au survol */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée */
        }

        .table-block h2 {
            color: #7d0c9d;
            margin-bottom: 20px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #434a95;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        tfoot tr {
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                margin-left: 0;
                padding: 10px;
            }

            .blocks-container {
                flex-direction: column;
            }

            .block {
                flex: 1 1 100%;
                text-size:10px;
            }

            .sub-block-container {
                flex-direction: column;
            }

            .sub-block {
                width: 100%;
                margin-bottom: 10px;
            }
            
        }
        .main-content {
    margin-left: 250px;
    padding: 0px;
    margin-top: 67px;
}
/* Style pour le message de bienvenue */
#welcome-message {
    padding: 1rem;
    color: black;
    border-radius: 5px;
    text-align: center;
    margin-bottom: -6rem;
    font-size: 16px;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: opacity 0.5s ease-out; /* Pour une disparition douce */
}

#welcome-message.hidden {
    opacity: 0;
}

    </style>
@endsection

@section('content')  <!-- Section pour le contenu principal -->
@if(session('welcomeMessage'))
        <div id="welcome-message" >
            Bienvenue, {{ Auth::user()->name }} !
        </div>
    @endif

    <div class="dashboard-container">
        <h1><strong>Tableau de Bord </strong></h1>

        <!-- Blocs de statistiques -->
        <div class="blocks-container">
            <div class="block">
                <h2><strong>Statistiques des Livres</strong></h2>
                <div class="sub-block-container">
                    <div class="sub-block block-1">
                        <strong>Total Livres</strong>
                        <div class="sub-block-content" id="total-livres">{{ $totalBooks }}</div>
                    </div>
                    <div class="sub-block block-2">
                        <strong>Exemplaires Disponibles</strong>
                        <div class="sub-block-content" id="exemplaires-disponibles">{{ $availableBooks }}</div>
                    </div>
                </div>
                <div class="sub-block-container">
                    <div class="sub-block block-3">
                        <strong>Emprunts en cours</strong>
                        <div class="sub-block-content" id="emprunts-en-cours">{{  $borrowedBooks }}</div>
                    </div>
                    <div class="sub-block block-4">
                        <strong>Profils emprunteurs</strong>
                        <div class="sub-block-content" id="profils-emprunteurs">{{ $totalBorrowers }}</div>
                    </div>
                </div>
            </div>

            <!-- Graphique pour les profils emprunteurs -->
            <div class="block">
                <h2><strong>Emprunts par Profil Emprunteur</strong></h2>
                <canvas id="borrowerChart"></canvas>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="blocks-container">
            <div class="block">
                <h2><strong>Emprunts par Mois</strong></h2>
                <canvas id="borrowChart"></canvas>
            </div>
            <div class="block">
                <h2><strong>Répartition des Livres</strong></h2>
                <canvas id="bookPieChart"></canvas>
            </div>
        </div>

        <!-- Tableau des statistiques -->
        <div class="table-block">
            <h2><strong>Statistiques par période</strong></h2>
            <div class="table-container">
                <table id="stats-table">
                    <thead>
                        <tr>
                            <th>Période</th>
                            <th>Profils emprunteurs</th>
                            <th>Livres Empruntés</th>
                            <th>Livres Disponibles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Données dynamiques ici -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total</td>
                            <td>{{ $totalBorrowers }}</td>
                            <td>{{ $borrowedBooks }}</td>
                            <td>{{ $availableBooks }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        // Si le message de bienvenue est affiché, on le fait disparaître après 3 secondes
        if ($('#welcome-message').length > 0) {
            setTimeout(function() {
                $('#welcome-message').addClass('hidden');
            }, 3000); // 3000ms = 3 secondes
        }
    });
</script>
    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script pour initialiser les graphiques -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Données pour le graphique des emprunts par mois
            const borrowData = @json($borrowData); // Données passées depuis le contrôleur
            const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

            // Graphique des emprunts par mois
            const borrowCtx = document.getElementById('borrowChart').getContext('2d');
            new Chart(borrowCtx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Emprunts par Mois',
                        data: borrowData,
                        backgroundColor: 'rgba(67, 74, 149, 0.5)', // Couleur des barres
                        borderColor: 'rgba(67, 74, 149, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Données pour le graphique en camembert (livres disponibles vs empruntés)
            const bookPieCtx = document.getElementById('bookPieChart').getContext('2d');
            new Chart(bookPieCtx, {
                type: 'pie',
                data: {
                    labels: ['Disponibles', 'Empruntés'],
                    datasets: [{
                        label: 'Répartition des Livres',
                        data: [{{ $availableBooks }}, {{ $borrowedBooks }}],
                        backgroundColor: [
                            'rgba(67, 74, 149, 0.5)', // Couleur pour les livres disponibles
                            'rgba(125, 12, 157, 0.5)' // Couleur pour les livres empruntés
                        ],
                        borderColor: [
                            'rgba(67, 74, 149, 1)',
                            'rgba(125, 12, 157, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Répartition des Livres'
                        }
                    }
                }
            });

            // Données pour le graphique des emprunts par profil emprunteur
            const borrowers = @json($borrowers); // Données passées depuis le contrôleur
            const borrowerLabels = borrowers.map(b => b.profile);
            const borrowerData = borrowers.map(b => b.total_borrowed);

            // Graphique des emprunts par profil emprunteur
            const borrowerCtx = document.getElementById('borrowerChart').getContext('2d');
            new Chart(borrowerCtx, {
                type: 'bar',
                data: {
                    labels: borrowerLabels,
                    datasets: [{
                        label: 'Emprunts par Profil',
                        data: borrowerData,
                        backgroundColor: 'rgba(239, 0, 0, 0.5)', // Couleur des barres
                        borderColor: 'rgba(239, 0, 0, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection