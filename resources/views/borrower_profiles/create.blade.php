@extends('layouts.app')

@section('title', 'Ajouter un Profil d\'Emprunteur')

@section('content')
<div class="flex justify-center items-start min-h-screen bg-gray-100 pt-8">
    <div class="container p-6 bg-white text-black rounded-lg shadow-lg w-full sm:w-96">
        @if(session('success'))
            <div class="mb-4 p-4 text-white bg-green-500 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 text-white bg-red-500 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->has('email'))
            <div class="mb-4 p-4 text-white bg-red-500 rounded-lg">
                {{ $errors->first('email') }}
            </div>
        @endif

        <h1 class="text-center text-2xl font-semibold mb-6 text-blue-700">Ajouter un Profil d'Emprunteur</h1>

        <form action="{{ route('borrower_profiles.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('first_name')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('last_name')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Ajouter Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Style global du formulaire */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f9fafb;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Container principal */
.container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 24px;
    width: 100%;
    max-width: 400px;
    margin-top: 83px;
}

/* Titre principal */
h1 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #4c51bf;
    margin-bottom: 1.5rem;
}

/* Formulaire */
form {
    display: flex;
    flex-direction: column;
}

/* Champs de saisie */
input[type="text"], input[type="email"] {
    padding: 12px;
    margin-top: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1rem;
    width: 100%;
    outline: none;
    transition: all 0.3s ease;
}

input[type="text"]:focus, input[type="email"]:focus {
    border-color: #4c51bf;
    box-shadow: 0 0 5px rgba(76, 81, 191, 0.5);
}

/* Message de succès et erreur */
.mb-4 {
    margin-bottom: 1rem;
}

.bg-green-500 {
    background-color: #38a169;
}

.bg-red-500 {
    background-color: #e53e3e;
}

.text-white {
    color: white;
}

.rounded-lg {
    border-radius: 8px;
}

/* Bouton */
button {
    background-color: #4c51bf;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.2s;
    border: none;
    width: 100%;
}

button:hover {
    background-color: #3b42a4;
    transform: scale(1.05);
}

/* Effet de focus sur le bouton */
button:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(76, 81, 191, 0.5);
}

/* Effets de messages d'erreur */
.text-red-500 {
    color: #e53e3e;
}

/* Responsivité */
@media (max-width: 768px) {
    .container {
        padding: 16px;
    }

    h1 {
        font-size: 1.25rem;
    }

    input[type="text"], input[type="email"], button {
        font-size: 0.9rem;
        padding: 10px;
    }
}
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const firstNameField = document.getElementById('first_name');
    const lastNameField = document.getElementById('last_name');
    const emailField = document.getElementById('email');

    // Ajouter des événements de saisie sur chaque champ
    firstNameField.addEventListener('input', function() {
        validateName(firstNameField);
    });

    lastNameField.addEventListener('input', function() {
        validateName(lastNameField);
    });

    emailField.addEventListener('input', function() {
        validateEmail(emailField);
    });

    form.addEventListener('submit', function(event) {
        let valid = true;

        // Réinitialiser les messages d'erreur
        removeErrorMessages();

        // Validation du prénom
        if (!validateName(firstNameField.value)) {
            showError(firstNameField, "Le prénom ne doit pas contenir de chiffres et ne peut pas être répétitif.");
            valid = false;
        }

        // Validation du nom
        if (!validateName(lastNameField.value)) {
            showError(lastNameField, "Le nom ne doit pas contenir de chiffres et ne peut pas être répétitif.");
            valid = false;
        }

        // Validation de l'email
        if (!validateEmail(emailField.value)) {
            showError(emailField, "Veuillez entrer un e-mail valide.");
            valid = false;
        }

        // Si l'une des validations échoue, empêcher l'envoi du formulaire
        if (!valid) {
            event.preventDefault();
        }
    });

    // Fonction de validation pour les noms (prénom et nom)
    function validateName(nameValue) {
        const regex = /^[A-Za-zÀ-ÿ\s]+$/; 
        const repetitionRegex = /(.)\1{2,}/; // Vérifie les répétitions de caractères (ex : aaa, 111, etc.)
        
        // Vérifier si le nom contient des chiffres ou des caractères spéciaux
        if (/\d/.test(nameValue) || /[^A-Za-zÀ-ÿ\s]/.test(nameValue)) {
            showError(nameField, "Le nom ne peut pas contenir de chiffres ou de caractères spéciaux.");
            return false;
        }

        // Vérifier la répétition des caractères
        if (repetitionRegex.test(nameValue)) {
            showError(nameField, "Le prénom ou le nom ne peut pas être répétitif.");
            return false;
        }

        // Enlever les messages d'erreur s'ils sont valides
        removeErrorMessages();
        return regex.test(nameValue);
    }

    // Fonction de validation pour l'email
    function validateEmail(emailValue) {
        const email = emailValue.value;
        const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/; // Vérifie l'email au format standard

        // Enlever les messages d'erreur s'il est valide
        removeErrorMessages();
        return regex.test(email);
    }

    // Afficher un message d'erreur
    function showError(field, message) {
        const errorElement = document.createElement('p');
        errorElement.classList.add('text-red-500', 'text-xs', 'mt-2');
        errorElement.textContent = message;

        field.classList.add('border-red-500');
        field.parentElement.appendChild(errorElement);
    }

    // Retirer les messages d'erreur
    function removeErrorMessages() {
        const errorMessages = document.querySelectorAll('.text-red-500');
        errorMessages.forEach(message => message.remove());

        const fieldsWithErrors = document.querySelectorAll('.border-red-500');
        fieldsWithErrors.forEach(field => field.classList.remove('border-red-500'));
    }
});


</script>
@endsection
