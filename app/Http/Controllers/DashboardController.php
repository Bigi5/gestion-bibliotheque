<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowerProfile;
use App\Models\Borrow;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $userName = Auth::user()->name;

    // Vérifier si le message de bienvenue n'a pas encore été affiché dans la session
    if (!session()->has('welcomeShown')) {
        session()->flash('welcomeMessage', "Bienvenue, $userName !");
        session(['welcomeShown' => true]);
    }

    // Récupérer tous les livres
    $books = Book::all();

    // Statistiques sur les livres
    $totalBooks = Book::sum('copies_total');
    $availableBooks = Book::sum('copies_available'); // Somme de toutes les copies disponibles
    $borrowedBooks = Borrow::where('status', 'emprunte')->count(); 

    // Calcul des exemplaires totaux pour chaque livre (sommation des exemplaires)
    $exemplairesTotaux = $books->sum('exemplaires'); // 'exemplaires' étant le champ qui contient le nombre d'exemplaires pour chaque livre

    // Calcul du nombre total des emprunts pour chaque livre (sommation des emprunts)
    $totalEmprunts = Borrow::select('book_id', DB::raw('COUNT(*) as emprunt_count'))
                            ->groupBy('book_id')
                            ->get()
                            ->sum('emprunt_count'); // Empunt count est l'agrégation du nombre d'emprunts pour chaque livre

    // Statistiques sur les emprunts en cours
    $notReturnedBooks = Borrow::where('status', 'borrowed')->whereNull('return_date')->count(); // Emprunts non retournés

    // Statistiques sur les emprunts
    $borrowedBooksToday = Borrow::whereDate('borrow_date', Carbon::today())->count();
    $borrowedBooksThisWeek = Borrow::whereBetween('borrow_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    $borrowedBooksThisMonth = Borrow::whereBetween('borrow_date', [Carbon::now()->startOfMonth(), Carbon::now()])->count();
    $borrowedBooksThisYear = Borrow::whereBetween('borrow_date', [Carbon::now()->startOfYear(), Carbon::now()])->count();

    // Statistiques sur les profils d'emprunteurs
    $totalBorrowers = BorrowerProfile::count();
    $newBorrowersToday = BorrowerProfile::whereDate('created_at', Carbon::today())->count();
    $totalBorrowerProfiles = BorrowerProfile::count(); // Nombre total des profils emprunteurs

    // Statistiques sur les emprunts retournés
    $returnedBooks = Borrow::where('status', 'returned')->count();

    // Statistiques sur les catégories
    $categoriesCount = Category::count();

    // Calculer le nombre d'emprunts (livres prêtés)
    $borrowedBooksCount = Borrow::count(); // Nombre total de livres prêtés
    // Calculer le taux de retour des livres
    $returnRate = 0;
    if ($borrowedBooks > 0) {
        $returnRate = ($returnedBooks / $borrowedBooks) * 100;
    }

    // Récupérer les alertes d'emprunts en retard
    $alertes = Borrow::where('due_date', '<', Carbon::now())  // Si la date d'échéance est passée
                     ->whereNull('return_date') // Si le livre n'a pas été retourné
                     ->get();

    // Statistiques des emprunteurs
    $borrowers = Borrow::join('borrower_profiles', 'borrower_profiles.id', '=', 'borrows.borrower_id')
        ->select(
            'borrower_profiles.profile',
            DB::raw('COUNT(borrows.id) as total_borrowed'),
            DB::raw('MAX(borrows.borrowed_at) as most_borrowed_book'),
            DB::raw('SUM(borrows.returned_late) as late_returns'),
            DB::raw('SUM(borrows.returned_on_time) as on_time_returns'),
            DB::raw('SUM(borrows.other_stat) as other_stats')
        )
        ->groupBy('borrower_profiles.profile')
        ->get();

    // Récupérer les données statistiques pour les emprunts par mois
    $borrows = Borrow::selectRaw('MONTH(created_at) as month, COUNT(*) as total_borrows')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Préparer un tableau des données pour le graphique (total des emprunts pour chaque mois)
    $borrowData = [];
    for ($i = 1; $i <= 12; $i++) {
        // Recherche des emprunts pour chaque mois
        $borrowMonth = $borrows->firstWhere('month', $i);
        // Si aucun emprunt pour ce mois, ajouter 0
        $borrowData[] = $borrowMonth ? $borrowMonth->total_borrows : 0;
    }

    // Définir les variables manquantes pour le graphique
    $statsToday = $borrowedBooksToday;
    $statsWeek = $borrowedBooksThisWeek;
    $statsMonth = $borrowedBooksThisMonth;
    $statsYear = $borrowedBooksThisYear;

    // Passer toutes les données à la vue
    return view('dashboard', compact(
        'userName',
        'totalBooks',
        'borrowedBooks',
        'availableBooks',
        'notReturnedBooks', // Emprunts en cours
        'borrowedBooksToday',
        'borrowedBooksThisWeek',
        'borrowedBooksThisMonth',
        'borrowedBooksThisYear',
        'totalBorrowers',
        'newBorrowersToday',
        'returnedBooks',
        'books',
        'categoriesCount',
        'totalBorrowerProfiles',
        'borrowedBooksCount',
        'returnRate',
        'alertes',
        'borrowers',
        'borrowData',
        'statsToday',
        'statsWeek',
        'statsMonth',
        'statsYear',
        'exemplairesTotaux',
        'totalEmprunts' 
    ));
}


    public function filterBorrowersByDate(Request $request)
    {
        // Récupérer la date filtrée à partir de la requête
        $filterDate = $request->input('filterDate');

        // Vérifier si la date est fournie
        if ($filterDate) {
            // Récupérer les emprunts correspondant à la date
            $borrowers = Borrow::whereDate('borrow_date', $filterDate)
                                ->join('borrower_profiles', 'borrower_profiles.id', '=', 'borrows.borrower_id')
                                ->select('borrower_profiles.*')
                                ->get();

            // Si aucun emprunt n'est trouvé pour cette date, afficher un message
            if ($borrowers->isEmpty()) {
                return response()->json(['message' => 'Aucune donnée trouvée pour cette date'], 404);
            }

            // Retourner les emprunts filtrés sous forme de données JSON
            return response()->json($borrowers);
        }

        // Si aucune date n'est spécifiée, retourner tous les emprunts
        $borrowers = BorrowerProfile::all();
        return response()->json($borrowers);
    }

    public function getUpdatedData()
    {
        // Récupérer les données depuis la base de données ou un autre source
        $totalBooks = Book::count();
        $borrowedBooks = Book::where('status', 'unavailable')->count(); 
        $availableBooks = Book::where('status', 'available')->count();
        $returnedBooks = Borrow::where('status', 'returned')->count();

        // Retourner les données sous forme de JSON
        return response()->json([
            'totalBooks' => $totalBooks,
            'availableBooks' => $availableBooks,
            'notAvailableBooks' => $borrowedBooks,
            'borrowedBooks' => $borrowedBooks,
            'returnedBooks' => $returnedBooks
        ]);
    }
}