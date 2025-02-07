@extends('layouts.app')

@section('title', 'Détails du Profil')

@section('content')
<div class="main-container">
    <!-- Section Profil -->
    <div class="profile-section">
        <div class="profile-header">
            <h2>Informations du Profil - {{ $borrowerProfile->first_name }} {{ $borrowerProfile->last_name }}</h2>
        </div>

        <div class="profile-info-card">
            <div class="profile-photo">
            <img src="{{ asset('images/avatar.avif') }}" alt="Profile Photo" class="profile-pic">
            </div>
            <div class="profile-details">
                <p><strong>Nom : </strong>{{ $borrowerProfile->first_name }} {{ $borrowerProfile->last_name }}</p>
                <p><strong>E-mail : </strong>{{ $borrowerProfile->email }}</p>
                <p><strong>Statut : </strong>
                    @if(isset($stats['current_borrows']) && $stats['current_borrows'] > 0)
                        <span class="status-active">Actif</span>
                    @else
                        <span class="status-inactive">Inactif</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Section Statistiques des Emprunts et Récapitulatif -->
    <div class="stats-section">
        <div class="section-title">
            <h2>Statistiques des Emprunts et Récapitulatif</h2>
        </div>

        <div class="stat-cards">
            <div class="stat-card dark-blue">
                <p><strong>Total Emprunté : </strong>{{ $stats['total_borrowed'] ?? 'N/A' }}</p>
            </div>
            <div class="stat-card dark-gray">
                <p><strong>Total Retourné : </strong>{{ $stats['total_returned'] ?? 'N/A' }}</p>
            </div>
            <div class="stat-card dark-green">
                <p><strong>Emprunt en Cours : </strong>{{ $stats['current_borrows'] ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="period-cards">
            <div class="period-card dark-teal">
                <p><strong>Emprunt Ce Mois : </strong>{{ $stats['borrowed_this_month'] ?? 'N/A' }}</p>
            </div>
            <div class="period-card dark-orange">
                <p><strong>Emprunt Le Mois Dernier : </strong>{{ $stats['borrowed_last_month'] ?? 'N/A' }}</p>
            </div>
            <div class="period-card dark-purple">
                <p><strong>Emprunt Cette Année : </strong>{{ $stats['borrowed_this_year'] ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Historique des Emprunts et Retours -->
    <div class="borrow-history-section">
        <div class="section-title">
            <h2>Historique des Emprunts et Retours</h2>
        </div>
        <div class="history-table">
            <table>
                <thead>
                    <tr>
                        <th>Date de l'Emprunt</th>
                        <th>Nom du Livre</th>
                        <th>Date du Retour</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                @if($borrowerProfile->borrows)
                    @forelse($borrowerProfile->borrows as $borrow)
                        <tr>
                            <td>{{ $borrow->borrowed_at ? $borrow->borrowed_at->format('d/m/Y') : 'Date non définie' }}</td>
                            <td>{{ $borrow->book->title }}</td>
                            <td>{{ $borrow->returned_at ? $borrow->returned_at->format('d/m/Y') : 'Non retourné' }}</td>
                            <td>
                                @if($borrow->returned_at)
                                    <span class="status-returned">Retourné</span>
                                @else
                                    <span class="status-not-returned">Non retourné</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Aucun emprunt enregistré pour cet emprunteur.</td>
                        </tr>
                    @endforelse
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bouton Retour -->
    <!-- Bouton Retour -->
<div class="back-button">
    <a href="{{ route('borrower_profiles.index') }}" class="btn-back">Retour aux Profils Emprunteurs</a>
</div>

</div>
@endsection

@section('styles')
<style>
    .main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        margin-top: 35px;
    }

    .profile-section, .stats-section, .borrow-history-section {
        margin-bottom: 3rem;
        background-color: #fff;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .profile-header h2, .section-title h2 {
        text-align: center;
        font-size: 2rem;
        font-weight: 700;
        color: #333;
    }

    .profile-info-card {
        display: flex;
        justify-content: center;
        gap: 2rem;
        align-items: center;
    }

    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-pic {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-details p {
        font-size: 1.2rem;
        color: #444;
    }

    .status-active {
        color: #4caf50;
        font-weight: bold;
    }

    .status-inactive {
        color: #f44336;
        font-weight: bold;
    }

    .stat-cards, .period-cards {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .stat-card, .period-card {
        width: 250px;
        height: 120px;
        padding: 1.5rem;
        text-align: center;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .stat-card:hover, .period-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .dark-blue { background-color: #1e3a8a; color: #fff; }
    .dark-gray { background-color: #4b5563; color: #fff; }
    .dark-green { background-color: #16a34a; color: #fff; }
    .dark-teal { background-color: #14b8a6; color: #fff; }
    .dark-orange { background-color: #ea580c; color: #fff; }
    .dark-purple { background-color: #8b5cf6; color: #fff; }

    .history-table {
        margin-top: 2rem;
        overflow-x: auto;
    }

    .history-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .history-table th, .history-table td {
        padding: 1rem;
        text-align: left;
        border: 1px solid #ddd;
    }

    .history-table th {
        background-color: #f3f4f6;
        font-weight: bold;
    }

    .status-returned {
        color: #4caf50;
        font-weight: bold;
    }

    .status-not-returned {
        color: #f44336;
        font-weight: bold;
    }

    .back-button {
        text-align: center;
        margin-top: 2rem;
    }

   /* Style spécifique au bouton de retour */
.btn-back {
    background-color: #145fad;
    color: white;
    padding: 1rem 2rem;
    text-decoration: none;
    border-radius: 8px;
    font-size: 1.2rem;
    transition: background-color 0.3s;
}

.btn-back:hover {
    background-color: #0b4772;
}

</style>
@endsection
