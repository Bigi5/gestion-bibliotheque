@extends('layouts.app')

@section('title', 'Ajouter un Livre')

@section('content')
    <style>
        .form-container {
            background-color: #F9FAFB;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 89px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-label {
            color: #1a1a1a;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .form-input, .form-select {
            margin-top: 0.25rem;
            width: 100%;
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
            padding: 0.75rem;
            font-size: 1rem;
            color: #1a1a1a;
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #042888;
            box-shadow: 0 0 0 2px rgba(4, 40, 136, 0.4);
        }

        .form-button {
            width: 100%;
            background-color: #4c51bf;
            color: white;
            padding: 0.75rem 1.25rem;
            border-radius: 0.375rem;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
        }

        .form-button:hover {
            background-color: #4338ca;
        }

        .success-message {
            background-color: #38a169;
            color: white;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }

        .error-message {
            background-color: #e53e3e;
            color: white;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }

        .add-category-link {
            display: block;
            margin-top: 1.5rem;
            text-align: center;
            color: #042888;
            text-decoration: underline;
            font-weight: 600;
        }

        .add-category-link:hover {
            color: #4c51bf;
        }
    </style>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="form-container">
                <div class="text-gray-900">
                    @if($errors->any())
                        <div class="error-message">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="success-message">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" id="book-form">
                        @csrf
                        <div class="mb-6">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" placeholder="Entrez le titre du livre" required>
                            <div id="title-error" class="error-message" style="display: none;"></div>
                        </div>

                        <div class="mb-6">
                            <label for="author" class="form-label">Auteur</label>
                            <input type="text" name="author" id="author" class="form-input" value="{{ old('author') }}" placeholder="Entrez l'auteur du livre" required>
                            <div id="author-error" class="error-message" style="display: none;"></div>
                        </div>

                        <div class="mb-6">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-input" value="{{ old('isbn') }}" placeholder="Entrez le code ISBN" required>
                            <div id="isbn-error" class="error-message" style="display: none;"></div>
                        </div>

                        <div class="mb-6">
                            <label for="copies_total" class="form-label">Copies Totales</label>
                            <input type="number" name="copies_total" id="copies_total" class="form-input" value="{{ old('copies_total') }}" min="1" placeholder="Nombre de copies disponibles" required>
                            <div id="copies_total-error" class="error-message" style="display: none;"></div>
                        </div>

                        <div class="mb-6">
                            <label for="category_id" class="form-label">Catégorie</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="category_id-error" class="error-message" style="display: none;"></div>
                        </div>

                        <a href="{{ route('categories.create') }}" class="add-category-link">Ajouter une nouvelle catégorie</a>

                        <div class="mb-6">
                            <label for="status" class="form-label">Statut</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                                <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Indisponible</option>
                            </select>
                            <div id="status-error" class="error-message" style="display: none;"></div>
                        </div>

                        <div class="mb-6">
                            <label for="cover_image" class="form-label">Image de couverture</label>
                            <input type="file" name="cover_image" id="cover_image" class="form-input">
                            <div id="cover_image-error" class="error-message" style="display: none;"></div>
                        </div>

                        <button type="submit" class="form-button" id="submit-button" disabled>Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('book-form');
            const submitButton = document.getElementById('submit-button');

            // Validate a specific field and display errors if needed
            const validateField = (field, errorElement, validationFn) => {
                const error = validationFn(field.value);
                if (error) {
                    errorElement.textContent = error;
                    errorElement.style.display = 'block';
                    field.classList.add('border-red-500');
                    return false; // Invalid
                } else {
                    errorElement.style.display = 'none';
                    field.classList.remove('border-red-500');
                    return true; // Valid
                }
            };

            // Validations
            const isValidISBN = (isbn) => {
                const isbnRegex = /^(?:\d{9}[\dX]|\d{13})$/;
                return isbnRegex.test(isbn) ? null : 'L\'ISBN doit être valide.';
            };

            const isValidTitle = (title) => {
                const titleRegex = /^[a-zA-Z\s]+(\d{0,2}[a-zA-Z\s]*)*$/;
                return titleRegex.test(title) ? null : 'Le titre peut contenir uniquement des lettres et jusqu\'à 2 chiffres.';
            };

            const isValidAuthor = (author) => {
                const authorRegex = /^[a-zA-Z\s]+$/;
                return authorRegex.test(author) ? null : 'Le nom de l\'auteur ne peut pas contenir de chiffres.';
            };

            const isValidText = (text) => {
                const invalidCharsRegex = /([a-zA-Z0-9])\1{2,}/;
                return invalidCharsRegex.test(text) ? 'Caractères répétitifs non autorisés.' : null;
            };

            // Field event listeners for real-time validation
            const validateAllFields = () => {
                const titleValid = validateField(document.getElementById('title'), document.getElementById('title-error'), (value) => value.trim() === '' ? 'Le titre est requis.' : isValidTitle(value));
                const authorValid = validateField(document.getElementById('author'), document.getElementById('author-error'), (value) => value.trim() === '' ? 'L\'auteur est requis.' : isValidAuthor(value));
                const isbnValid = validateField(document.getElementById('isbn'), document.getElementById('isbn-error'), (value) => value.trim() === '' ? 'L\'ISBN est requis.' : isValidISBN(value));
                const categoryValid = validateField(document.getElementById('category_id'), document.getElementById('category_id-error'), (value) => value === '' ? 'La catégorie est requise.' : null);
                const statusValid = validateField(document.getElementById('status'), document.getElementById('status-error'), (value) => value === '' ? 'Le statut est requis.' : null);
                const coverImageValid = validateField(document.getElementById('cover_image'), document.getElementById('cover_image-error'), (value) => null);

                if (titleValid && authorValid && isbnValid && categoryValid && statusValid && coverImageValid) {
                    submitButton.disabled = false;
                } else {
                    submitButton.disabled = true;
                }
            };

            form.addEventListener('input', validateAllFields);
        });
    </script>
@endsection
