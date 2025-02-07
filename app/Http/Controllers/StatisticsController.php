<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use App\Models\Borrow; // Pour gérer les emprunts
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class StatisticsController extends Controller
{
    // Méthode pour afficher les statistiques
    public function showStatistics()
    {
        
        // Nombre total de catégories
        $totalCategories = Category::count();
    
        // Nombre total de livres (différents titres)
        $totalBooks = Book::count();
    
        // Calcul des exemplaires totaux et disponibles
        $exemplairesTotaux = Book::sum('copies_total'); // Total des exemplaires
        $exemplairesDisponibles = Book::sum('copies_available'); // Total des exemplaires encore disponibles
    
        // Nombre total d’emprunts enregistrés
        $totalEmprunts = Borrow::count();
    
        // Livres les plus empruntés
        $popularBooks = Book::withCount('borrows')
            ->orderBy('borrows_count', 'desc')
            ->take(5)
            ->get();
    
        return view('categories.stats', [
            'totalCategories' => $totalCategories,
            'totalBooks' => $totalBooks,
            'exemplairesTotaux' => $exemplairesTotaux,
            'exemplairesDisponibles' => $exemplairesDisponibles,
            'totalEmprunts' => $totalEmprunts,
            'popularBooks' => $popularBooks,
        ]);
    }
    


    // Méthode pour télécharger les statistiques en PDF
    public function downloadPdf()
    {
        // Récupérer les mêmes données que pour l'affichage
        $totalCategories = Category::count();
        $totalBooks = Book::count();
        
        // Comptage des livres disponibles et non disponibles
        $availableBooks = Book::where('copies_available', '>', 0)->count();
        $unavailableBooks = Book::where('copies_available', 0)->count();
        
        $borrowedNotReturned = Borrow::whereNull('return_date')->count();

        // Récupérer les livres populaires (par exemple, ceux qui ont le plus de prêts)
        $popularBooks = Book::withCount('borrows')
            ->orderBy('borrows_count', 'desc')
            ->take(5)
            ->get();

        // Générer le PDF à partir de la vue
        $pdf = PDF::loadView('statistics.pdf', compact(
            'totalCategories',
            'totalBooks',
            'availableBooks',
            'unavailableBooks',
            'borrowedNotReturned',
            'popularBooks'
        ));

        // Télécharger le PDF
        return $pdf->download('statistiques_bibliotheque.pdf');
    }

    // Méthode pour afficher les détails d'un livre spécifique
    public function showBookStats($id)
    {
        $book = Book::with('borrows')->findOrFail($id);

        // Retourner la vue avec les statistiques du livre
        return view('statistics.book', compact('book'));
    }
    
}
