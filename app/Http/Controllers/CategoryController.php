<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Méthode pour afficher toutes les catégories dans le tableau de bord
    public function index()
    {
        // Récupère toutes les catégories
        $categories = Category::all();

        // Retourne la vue avec les catégories
        return view('dashboard', compact('categories'));
    }

    // Méthode pour afficher les détails d'une catégorie (les livres associés)
    public function showDetails($id)
    {
        $category = Category::findOrFail($id);
        $searchTerm = request('search', ''); // Terme de recherche

        // Si un terme de recherche est présent, on filtre les livres par titre
        if ($searchTerm) {
            $books = Book::where('category_id', $id)
                         ->where('title', 'like', '%' . $searchTerm . '%')
                         ->paginate(10);
        } else {
            // Si aucun terme de recherche, on affiche tous les livres de la catégorie
            $books = Book::where('category_id', $id)->paginate(10);
        }

        // Ajout du terme de recherche aux paramètres de pagination pour garder le filtre actif
        $books->appends(['search' => $searchTerm]);

        // Retourne la vue avec les données nécessaires
        return view('categories.details', compact('category', 'books', 'searchTerm'));
    }

    // Méthode pour afficher les statistiques des catégories et des livres
    public function showStats()
    {
        // Récupérer le nombre total de catégories
        $totalCategories = Category::count();
        
        // Récupérer le nombre total de livres
        $totalBooks = Book::count();
        
        // Récupérer le nombre de livres disponibles
        $availableBooks = Book::where('status', 'available')->count();
        
        // Récupérer le nombre de livres non disponibles
        $unavailableBooks = Book::where('status', 'unavailable')->count();
        
        // Récupérer les livres les plus populaires (par nombre d'emprunts)
        $popularBooks = Book::withCount('borrows')
            ->orderBy('borrows_count', 'desc')
            ->take(5)
            ->get();
    
        // Retourne la vue avec les statistiques
        return view('categories.stats', compact(
            'totalCategories',
            'totalBooks',
            'availableBooks',
            'unavailableBooks',
            'popularBooks'
        ));
    }

    // Méthode pour afficher les livres d'une catégorie avec recherche filtrée
    public function showCategoryDetails($categoryId, Request $request)
    {
        $category = Category::findOrFail($categoryId);
    
        // Récupérer le terme de recherche depuis la requête
        $searchTerm = $request->input('search', '');
    
        // Appliquer la pagination après le filtrage
        if ($searchTerm) {
            $books = $category->books()
                ->where('title', 'like', '%' . $searchTerm . '%')
                ->paginate(10); // Utilisation de paginate ici
        } else {
            // Affichage de tous les livres si aucun terme de recherche
            $books = $category->books()->paginate(10);
        }

        // Passer les données à la vue
        return view('categories.details', compact('category', 'books', 'searchTerm'));
    }

    // Méthode principale de la page d'affichage de la catégorie avec recherche
    public function show($id, Request $request)
    {
        $category = Category::findOrFail($id);
        
        // Terme de recherche depuis la requête
        $searchTerm = $request->get('search', '');

        // Recherche des livres dans la catégorie avec le terme de recherche
        if ($searchTerm) {
            $books = $category->books()
                ->where('title', 'like', '%' . $searchTerm . '%')
                ->paginate(10);
        } else {
            // Affichage de tous les livres si aucun terme de recherche
            $books = $category->books()->paginate(10);
        }

        return view('categories.show', compact('category', 'books', 'searchTerm'));
    }
    public function create()
    {
        return view('categories.create'); // Assurez-vous que la vue existe (categories.create.blade.php)
    }

    // Méthode pour enregistrer la catégorie
    public function store(Request $request)
    {
        // Validation de la demande
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        // Création de la catégorie
        $category = Category::create([
            'name' => $request->name,
        ]);
    
        // Redirection vers la page de création de livre avec un message de succès
        return redirect()->route('books.create')->with('success', 'Catégorie ajoutée avec succès!');
    }
    
    
}
