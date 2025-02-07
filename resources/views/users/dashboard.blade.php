<!-- resources/views/user/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
    <h2>Bienvenue, {{ auth()->user()->name }} !</h2>
    <p>Voici vos informations de prêt :</p>
    
    @if($borrows->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Date du prêt</th>
                    <th>Date de retour</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrows as $borrow)
                    <tr>
                        <td>{{ $borrow->book->title }}</td>
                        <td>{{ $borrow->borrow_date->format('d/m/Y') }}</td>
                        <td>{{ $borrow->return_date ? $borrow->return_date->format('d/m/Y') : 'Non retourné' }}</td>
                        <td>{{ $borrow->return_date ? 'Retourné' : 'Non retourné' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun livre emprunté pour le moment.</p>
    @endif
@endsection
