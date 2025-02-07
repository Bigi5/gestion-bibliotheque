@extends('layouts.app')

@section('title', 'Créer un Prêt')

@section('content')
<div class="container" style="max-width: 500px; margin: 84px auto 0; padding: 2rem; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); color: #333333;">
    <h1 style="text-align: center; font-size: 24px; font-weight: bold; margin-bottom: 1.5rem; color: #4c51bf;">Formulaire de Prêt</h1>

    <!-- Zone des messages d'erreur -->
    @if ($errors->any())
    <div id="error-messages" style="padding: 1rem; margin-bottom: 1rem; border-radius: 5px; font-size: 14px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
        <span style="font-weight: bold;">Erreur :</span>
        <ul id="error-list" style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Formulaire de prêt -->
    <form id="borrow-form" action="{{ route('borrows.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf

        <!-- Champ pour rechercher le profil d'emprunteur -->
        <div>
            <label for="borrower_profile_id" style="display: block; font-size: 14px; margin-bottom: 0.5rem; color: #555555;">Profil d'Emprunteur</label>
            <select 
                name="borrower_profile_id" 
                id="borrower_profile_id" 
                style="width: 100%; padding: 0.75rem; font-size: 14px; color: #333333; border: 1px solid #cccccc; border-radius: 4px; background-color: #f9f9f9;">
                <option value="" disabled selected>Choisissez un profil</option>
                @foreach($borrowerProfiles as $profile)
                    <option value="{{ $profile->id }}" {{ old('borrower_profile_id') == $profile->id ? 'selected' : '' }}>
                        {{ $profile->first_name }} {{ $profile->last_name }}
                    </option>
                @endforeach
            </select>
            @error('borrower_profile_id')
                <div class="text-danger" style="font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Champ pour rechercher un livre -->
        <div>
            <label for="book_id" style="display: block; font-size: 14px; margin-bottom: 0.5rem; color: #555555;">Livre à Prêter</label>
            <select 
                name="book_id" 
                id="book_id" 
                style="width: 100%; padding: 0.75rem; font-size: 14px; color: #333333; border: 1px solid #cccccc; border-radius: 4px; background-color: #f9f9f9;">
                <option value="" disabled selected>Choisissez un livre</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                        {{ $book->title }} ({{ $book->copies_available }} disponible{{ $book->copies_available > 1 ? 's' : '' }})
                    </option>
                @endforeach
            </select>
            @error('book_id')
                <div class="text-danger" style="font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Champ pour la date d'emprunt (calendrier figé) -->
        <div>
            <label for="borrow_date" style="display: block; font-size: 14px; margin-bottom: 0.5rem; color: #555555;">Date d'Emprunt</label>
            <input 
                type="date" 
                name="borrow_date" 
                id="borrow_date" 
                value="{{ old('borrow_date', now()->toDateString()) }}" 
                style="width: 100%; padding: 0.75rem; font-size: 14px; color: #333333; border: 1px solid #cccccc; border-radius: 4px; background-color: #f9f9f9;" 
                required readonly>
            @error('borrow_date')
                <div class="text-danger" style="font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Bouton soumettre -->
        <button 
            type="submit" 
            style="display: inline-block; width: 100%; padding: 0.75rem; font-size: 16px; font-weight: bold; text-align: center; color: #ffffff; background-color: #4c51bf; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease;"
            onmouseover="this.style.backgroundColor='#3b46a6';" 
            onmouseout="this.style.backgroundColor='#4c51bf';">
            <span style="margin-right: 0.5rem;">📚</span> Prêter le Livre
        </button>
    </form>
</div>

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <script>
        $(document).ready(function() {
            // Activer Select2 pour le profil d'emprunteur
            $('#borrower_profile_id').select2({
                placeholder: "Rechercher un profil d'emprunteur...",
                allowClear: true,
                width: '100%',
            });

            // Activer Select2 pour le livre
            $('#book_id').select2({
                placeholder: "Rechercher un livre...",
                allowClear: true,
                width: '100%',
            });
        });
    </script>
@endsection

@endsection
