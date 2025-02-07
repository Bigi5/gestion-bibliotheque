<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BooksImport;
use App\Exports\BooksExport;
use Barryvdh\DomPDF\Facade as PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Ods;

class BookController extends Controller
{
    // Afficher la liste des livres avec pagination
    public function index(Request $request)
    {
        $query = Book::with('category'); // On commence la requête en incluant la relation 'category'

        // Filtrage par catégorie
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filtrage par titre
        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Pagination des livres filtrés
        $books = $query->paginate(10);

        // Création des alertes à afficher
        $alertes = collect([
            'Vous avez ' . $books->total() . ' livres dans votre bibliothèque.',
        ]);

        // On récupère toutes les catégories pour le filtre
        $categories = Category::all();
        
        return view('books.index', compact('books', 'alertes', 'categories'));
    }

    // Afficher le formulaire pour créer un livre
    public function create()
    {
        $categories = Category::all(); // Récupérer toutes les catégories
        return view('books.create', compact('categories')); // Passer les catégories à la vue
    }

    // Enregistrer un nouveau livre
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:191',
            'author' => 'required|string|max:191',
            'isbn' => 'required|string|max:191|unique:books,isbn',
            'copies_total' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id', // Catégorie obligatoire
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation de l'image
            'status' => 'required|in:available,unavailable', // Statut obligatoire
        ]);

        $book = new Book($request->only([
            'title', 'author', 'isbn', 'copies_total', 'category_id', 'status'
        ]));

        // Gestion de l'image de couverture
        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $coverImagePath = $request->file('cover_image')->store('cover_images', 'public'); // Stocker dans public/cover_images
            $book->cover_image = $coverImagePath; // Enregistrer le chemin dans la base de données
        }

        // Sauvegarde du livre
        $book->save();

        // Alerte de succès
        session()->flash('success', 'Le livre "' . $book->title . '" a été ajouté avec succès!');

        return redirect()->route('books.index');
    }
    public function update(Request $request, Book $book)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'copies_total' => 'required|integer|min:1',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $book->update($request->all());

    return response()->json(['success' => true]);
}


    // Afficher un livre spécifique
    public function show($id)
    {
        $book = Book::with('category', 'borrows')->findOrFail($id); // Assurez-vous de charger 'borrows'

        // Calculer les statistiques spécifiques à ce livre
        $totalBorrows = $book->borrows->count(); // Nombre total d'emprunts
        $borrowedNotReturned = $book->borrows->whereNull('return_date')->count(); // Emprunts en cours
        $availableCopies = $book->copies_available; // Exemplaires disponibles
        $unavailableCopies = $book->copies_total - $availableCopies; // Exemplaires non disponibles

        // Récupérer toutes les catégories pour le formulaire de modification
        $categories = Category::all();

        // Définir les alertes pour ce livre
        $alertes = collect([
            'Le livre "' . $book->title . '" a été emprunté ' . $totalBorrows . ' fois.',
            'Actuellement, ' . $borrowedNotReturned . ' exemplaires sont encore empruntés.',
            'Il reste ' . $availableCopies . ' exemplaires disponibles.',
            'Nombre d’exemplaires non disponibles : ' . $unavailableCopies,
        ]);

        // Retourner la vue avec les statistiques du livre
        return view('books.show', [
            'book' => $book,
            'totalBorrows' => $totalBorrows,
            'borrowedNotReturned' => $borrowedNotReturned,
            'availableCopies' => $availableCopies,
            'unavailableCopies' => $unavailableCopies,
            'alertes' => $alertes,
            'categories' => $categories, // Passer les catégories à la vue
        ]);
    }

    // Supprimer un livre
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Supprimer l'image associée (si existe)
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Livre supprimé avec succès.');
    }

    // Exporter les livres
    public function export()
    {
        session()->flash('success', 'L\'exportation des livres a commencé...');
        return Excel::download(new BooksExport, 'livres.xlsx');
    }

    // Importer les livres
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new BooksImport, $request->file('file'));
        session()->flash('success', 'Les livres ont été importés avec succès!');
        return back();
    }

    // Afficher les statistiques d'un livre spécifique
    public function showStats($id)
    {
        // Récupérer le livre avec ses emprunts associés
        $book = Book::with('borrows')->findOrFail($id);

        // Calculer les statistiques spécifiques à ce livre
        $totalBorrows = $book->borrows()->count(); // Nombre total d'emprunts
        $borrowedNotReturned = $book->borrows()->whereNull('return_date')->count(); // Emprunts en cours
        $availableCopies = $book->copies_available; // Exemplaires disponibles
        $unavailableCopies = $book->copies_total - $availableCopies; // Exemplaires non disponibles

        // Définir les alertes pour ce livre
        $alertes = collect([
            'Le livre "' . $book->title . '" a été emprunté ' . $totalBorrows . ' fois.',
            'Actuellement, ' . $borrowedNotReturned . ' exemplaires sont encore empruntés.',
            'Il reste ' . $availableCopies . ' exemplaires disponibles.',
            'Nombre d’exemplaires non disponibles : ' . $unavailableCopies,
        ]);

        // Remplacer les emprunts sans livre associé par "Titre non disponible"
        $bookBorrows = $book->borrows->map(function ($borrow) {
            // Vérifier si l'emprunt a un livre associé
            if ($borrow->book) {
                $borrow->book_title = $borrow->book->title;
            } else {
                // Si pas de livre associé, utiliser "Titre non disponible"
                $borrow->book_title = 'Titre non disponible';
            }
            return $borrow;
        });

        // Retourner la vue avec les statistiques du livre
        return view('books.stats', [
            'book' => $book,
            'totalBorrows' => $totalBorrows,
            'borrowedNotReturned' => $borrowedNotReturned,
            'availableCopies' => $availableCopies,
            'unavailableCopies' => $unavailableCopies,
            'alertes' => $alertes,
            'bookBorrows' => $bookBorrows, // Passer les emprunts modifiés avec les titres
        ]);
    }

    // Exporter les livres au format ODS
    public function downloadOdf()
    {
        // Récupérer tous les livres
        $books = Book::all();

        // Créer une nouvelle feuille de calcul
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Ajouter les en-têtes de colonnes
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Titre');
        $sheet->setCellValue('C1', 'Auteur');
        $sheet->setCellValue('D1', 'ISBN');
        $sheet->setCellValue('E1', 'Exemplaires Totaux');
        $sheet->setCellValue('F1', 'Exemplaires Disponibles');
        $sheet->setCellValue('G1', 'Date de Création');
        $sheet->setCellValue('H1', 'Date de Mise à Jour');
        $sheet->setCellValue('I1', 'Catégorie ID');
        $sheet->setCellValue('J1', 'Statut');

        // Remplir les données des livres
        $row = 2;
        foreach ($books as $book) {
            $sheet->setCellValue('A' . $row, $book->id);
            $sheet->setCellValue('B' . $row, $book->title);
            $sheet->setCellValue('C' . $row, $book->author);
            $sheet->setCellValue('D' . $row, $book->isbn);
            $sheet->setCellValue('E' . $row, $book->copies_total);
            $sheet->setCellValue('F' . $row, $book->copies_available);
            $sheet->setCellValue('G' . $row, $book->created_at);
            $sheet->setCellValue('H' . $row, $book->updated_at);
            $sheet->setCellValue('I' . $row, $book->category_id);
            $sheet->setCellValue('J' . $row, $book->status);
            $row++;
        }

        // Créer le fichier ODS et le télécharger
        $writer = new Ods($spreadsheet);
        $filename = 'livres.ods';

        // Télécharger le fichier ODS
        $response = response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.oasis.opendocument.spreadsheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );

        return $response;
    }
}
