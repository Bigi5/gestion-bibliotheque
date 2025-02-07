@extends('layouts.app')

@section('title', 'Ajouter une Catégorie')

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Message de succès -->
            @if(session('success'))
                <div class="alert alert-success" style="background-color: #4caf50; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="form-container" style="margin-top: 85px; background-color: #f9fafb; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="name" class="form-label" style="display: block; font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 8px;">Nom de la catégorie</label>
                        <input type="text" name="name" id="name" class="form-input" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem; color: #333; box-sizing: border-box;">
                        @error('name')
                            <div class="error-message" style="color: #e64614; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="form-button" style="background-color: #4c51bf; color: #fff; padding: 12px 20px; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; transition: background-color 0.3s;">
                        Ajouter la catégorie
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .form-container {
            margin-top: 85px; /* Application de 85px de margin-top */
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            display: block;
            font-size: 1rem;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            color: #333;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            border-color: #4c51bf;
            outline: none;
        }

        .form-button {
            background-color: #4c51bf;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-button:hover {
            background-color: #3b40a1;
        }

        .error-message {
            color: #e64614;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .alert-success {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

    </style>
@endsection
