<?php

namespace App\Http\Controllers;

use App\Mail\BookBorrowedMail;
use App\Models\Borrow;
use App\Models\Book;
use App\Models\BorrowerProfile;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    // Création d'un nouvel emprunt
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrower_profile_id' => 'required|exists:borrower_profiles,id',
            'borrow_date' => 'required|date',
        ]);
        // On définit le statut initial à "emprunte"
        $validated['status'] = 'emprunte';

        $book = Book::findOrFail($validated['book_id']);
        $borrowerProfile = BorrowerProfile::findOrFail($validated['borrower_profile_id']);

        // Vérifier si l'utilisateur a déjà emprunté ce livre sans le retourner
        $existingBorrow = Borrow::where('book_id', $book->id)
            ->where('borrower_profile_id', $borrowerProfile->id)
            ->whereNull('return_date')
            ->first();

        if ($existingBorrow) {
            return back()->withErrors(['error' => 'Vous avez déjà emprunté ce livre et ne l\'avez pas retourné.']);
        }

        // Vérifier si l'utilisateur a déjà emprunté 3 livres sans les retourner
        $borrowCount = Borrow::where('borrower_profile_id', $borrowerProfile->id)
            ->whereNull('return_date')
            ->count();

        if ($borrowCount >= 3) {
            return back()->withErrors(['error' => 'Un profil ne peut pas emprunter plus de trois livres.']);
        }

        // Vérifier si le livre est disponible
        if (!$book->canBorrow()) {
            return back()->withErrors(['error' => 'Ce livre n\'est pas disponible pour le prêt.']);
        }

        // Définir la date de retour prévue (7 jours après la date d'emprunt)
        $borrowDate = Carbon::parse($validated['borrow_date']);
        $expectedReturnDate = $borrowDate->copy()->addDays(7);

        // Créer l'emprunt
        $borrow = Borrow::create([
            'book_id' => $book->id,
            'borrower_profile_id' => $borrowerProfile->id,
            'borrower_name' => $borrowerProfile->first_name . ' ' . $borrowerProfile->last_name,
            'borrow_date' => $validated['borrow_date'],
            'expected_return_date' => $expectedReturnDate,
            'return_date' => null,
            'status' => $validated['status'], // "emprunte"
        ]);

        // Décrémenter les copies disponibles
        $book->decrementCopies();

        // Envoyer un email de confirmation
        Mail::to($borrowerProfile->email)->send(new BookBorrowedMail($borrowerProfile, $book, $borrow, $expectedReturnDate));

        return redirect()->route('borrows.index')->with('success', 'L\'emprunt a été enregistré avec succès.');
    }

    // Retourner un livre emprunté
    public function returnBook(Request $request, $id)
    {
        $borrow = Borrow::findOrFail($id);

        if ($borrow->return_date) {
            return back()->withErrors(['error' => 'Ce livre a déjà été retourné.']);
        }

        // Mettre à jour le retour du livre et le statut
        $borrow->update([
            'return_date' => now(),
            'status' => 'retourne',
        ]);

        // Incrémenter les copies disponibles
        $borrow->book->incrementCopies();

        return redirect()->back()->with('success', 'Le livre a été retourné avec succès.');
    }

    // Afficher la liste des emprunts avec pagination
    public function index()
{
    $borrows = Borrow::with('borrowerProfile', 'book')->paginate(10);

    // Utilisation de 'items()' pour obtenir la collection sous-jacente
    $borrowData = $borrows->items(); // Cela retourne une collection d'éléments

    // Transformation des données pour l'affichage
    $borrowData = collect($borrowData)->map(function ($borrow) {
        // Vérification et mise à jour dynamique du statut
        if (!$borrow->return_date) {
            // Si le livre n'est pas retourné et la date de retour prévue est passée
            if (Carbon::parse($borrow->expected_return_date)->isPast()) {
                $borrow->status = 'Retardé';
            } else {
                $borrow->status = 'Emprunté';
            }
        } else {
            // Si le livre a été retourné
            $borrow->status = 'Retourné';
        }

        return [
            'bookTitle' => $borrow->book->title,
            'borrowDate' => $borrow->borrow_date,
            'returnDate' => $borrow->return_date,
            'borrowerName' => $borrow->borrowerProfile
                ? $borrow->borrowerProfile->first_name . ' ' . $borrow->borrowerProfile->last_name
                : 'Profil non trouvé',
            'status' => $borrow->status, // Affiche le statut mis à jour
        ];
    });

    return view('borrows.index', [
        'borrows' => $borrows,
        'borrowDataJson' => $borrowData->toJson(),
    ]);
}


    // Afficher le formulaire de création d'un emprunt
    public function create()
    {
        $borrowerProfiles = BorrowerProfile::all();
        $books = Book::all();

        return view('borrows.create', compact('borrowerProfiles', 'books'));
    }

    // Supprimer un emprunt
    public function destroy($id)
    {
        $borrow = Borrow::findOrFail($id);
        $book = $borrow->book;

        $borrow->delete();

        // Incrémenter les copies disponibles après suppression
        $book->incrementCopies();

        return redirect()->route('borrows.index')->with('success', 'Emprunt supprimé avec succès.');
    }

    // (Optionnel) Vérifier les emprunts en retard
    // Si vous souhaitez conserver uniquement "emprunte" et "retourne", vous pouvez supprimer ou modifier cette méthode.
    public function checkOverdueBorrows()
    {
        $overdueBorrows = Borrow::whereNull('return_date')
            ->where('expected_return_date', '<=', Carbon::now())
            ->get();

        // Ici, on ne modifie pas le statut (on peut éventuellement ajouter une logique pour marquer comme "en retard" sans modifier le statut)
        // Par exemple, on peut ajouter un champ "is_overdue" ou simplement utiliser la date prévue pour l'affichage.

        return response()->json(['message' => 'Vérification des emprunts en retard effectuée.']);
    }
}
