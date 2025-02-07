@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
    <style>
        /* Style général */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container-custom {
            max-width: 90%;
            margin: auto;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            color: #4c51bf;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        /* Style du tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #4c51bf;
            color: #fff;
            font-weight: bold;
        }

        table tr:hover {
            background-color: #f1f5ff;
            transition: 0.3s;
        }

        /* Boutons */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-add {
            background-color: #4c51bf;
            color: white;
        }

        .btn-add:hover {
            background-color:orangered;
            color: #fff;
        }

        .btn-return {
            background-color: #28a745;
            color: dark;
        }

        .btn-return:hover {
            background-color: #218838;
            color: #fff;
        }

        .btn-delete {
            background-color: #e53935;
            color: dark;
        }

        .btn-delete:hover {
            background-color: #c62828;
            color: #fff;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            background-color: #e0e0e0;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }

        .pagination a:hover {
            background-color: #4c51bf;
            color: white;
        }

        /* Graphique */
        .chart-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            margin-top: 61px;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            h2 {
                font-size: 1.4rem;
            }

            table th, table td {
                padding: 10px;
            }

            .pagination a {
                padding: 6px 12px;
                font-size: 0.8rem;
            }

            .btn {
                font-size: 0.8rem;
                padding: 6px 12px;
            }

            .container-custom {
                max-width: 100%;
                padding: 15px;
            }

            .chart-container {
                padding: 15px;
            }
        }

        @media screen and (max-width: 480px) {
            .btn {
                font-size: 0.75rem;
                padding: 6px 10px;
            }

            h2 {
                font-size: 1.2rem;
            }

            table th, table td {
                padding: 8px;
            }

            .pagination a {
                padding: 4px 8px;
                font-size: 0.7rem;
            }
        }
    </style>

    <div class="container-custom">
        <!-- Section Liste des emprunts -->
        <div class="card">
            <h2>📚 Liste des Emprunts</h2>

            @if($borrows->isEmpty())
                <p class="text-center text-gray-700">Aucun emprunt enregistré pour le moment.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nom de l'Emprunteur</th>
                            <th>Livre</th>
                            <th>Date d'Emprunt</th>
                            <th>Retour Attendu</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrows as $borrow)
                            <tr>
                                <td>{{ $borrow->borrowerProfile ? $borrow->borrowerProfile->first_name . ' ' . $borrow->borrowerProfile->last_name : 'Profil non trouvé' }}</td>
                                <td>{{ $borrow->book ? $borrow->book->title : 'Livre non trouvé' }}</td>
                                <td>{{ Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>
                                <td>{{ Carbon::parse($borrow->borrow_date)->addDays(7)->format('d/m/Y') }}</td>
                                <td>
                                    @if($borrow->return_date)
                                        <span class="text-green-500">✔ Retourné</span>
                                    @elseif(Carbon::parse($borrow->borrow_date)->addDays(7)->isPast())
                                        <span class="text-red-500">⏳ Retardé</span>
                                    @else
                                        <span class="text-yellow-500">📖 En cours</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 10px; justify-content: center;">
                                        @if(!$borrow->return_date)
                                            <form action="{{ route('borrow.return', $borrow->id) }}" method="POST" onsubmit="return confirm('Confirmer le retour de ce livre ?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-return">✔ Retourner</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('borrow.delete', $borrow->id) }}" method="POST" onsubmit="return confirm('Supprimer cet emprunt ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $borrows->links() }}
                </div>
            @endif

            <div class="text-center mt-4">
                <a href="{{ route('borrows.create') }}" class="btn btn-add">➕ Prêter un Livre</a>
            </div>
        </div>

        <!-- Section Statistiques -->
        <div class="chart-container">
            <h2>📊 Statistiques des Emprunts</h2>
            <canvas id="borrowChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var borrowData = {!! $borrowDataJson !!};

            if (!borrowData || borrowData.length === 0) {
                console.warn("Aucune donnée disponible pour le graphique.");
                return;
            }

            var borrowedCounts = borrowData.reduce((acc, item) => {
                acc[item.bookTitle] = (acc[item.bookTitle] || 0) + 1;
                return acc;
            }, {});

            var labels = Object.keys(borrowedCounts);
            var data = Object.values(borrowedCounts);

            var colors = labels.map((_, index) => {
                const palette = ['#002a86', '#e5410c', '#141414', '#0a67b4', '#ff9800', '#009688', '#673ab7'];
                return palette[index % palette.length];
            });

            var ctx = document.getElementById('borrowChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nombre d\'Emprunts par Livre',
                        data: data,
                        backgroundColor: colors,
                        borderColor: '#4c51bf',
                        borderWidth: 1,
                        barThickness: 20, 
                        categoryPercentage: 0.6, 
                        barPercentage: 0.9 
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return ` ${tooltipItem.raw} emprunts`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 0,
                                color: "#333",
                                font: {
                                    size: 12,
                                    weight: "bold"
                                }
                            },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            min: 0,
                            max: Math.max(...data) + 1,
                            ticks: {
                                stepSize: 1,
                                color: "#333",
                                font: {
                                    size: 12,
                                    weight: "bold"
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

@endsection
