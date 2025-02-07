<?php

namespace App\Http\Controllers;

use App\Models\BorrowerProfile;
use Illuminate\Http\Request;
use App\Notifications\BorrowerProfileAdded;

class BorrowerProfileController extends Controller
{
    public function index()
    {
        // Récupérer les profils avec pagination
        $profiles = BorrowerProfile::paginate(10);
        $borrowerProfiles = BorrowerProfile::all();

        // Récupérer les alertes depuis la session et les convertir en collection si c'est un tableau
        $alertes = collect(session()->get('alertes', [])); // Conversion en collection si nécessaire
    
        return view('borrower_profiles.index', compact('borrowerProfiles', 'alertes'));
    }
    
    public function create()
    {
        return view('borrower_profiles.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => [
            'required',
            'string',
            'max:255',
            'regex:/^(?!.*(.)\1{2,})[A-Za-zÀ-ÿéèàç]+$/', 
        ],
        'last_name' => [
            'required',
            'string',
            'max:255',
            'regex:/^(?!.*(.)\1{2,})[A-Za-zÀ-ÿéèàç]+$/', 
        ],
        'email' => 'required|email|unique:borrower_profiles,email|max:255', 
    ]);

    // Création du profil emprunteur
    $borrowerProfile = BorrowerProfile::create([
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'email' => $validated['email'],
    ]);

    // Envoi d'un e-mail au nouvel emprunteur
    try {
        $borrowerProfile->notify(new BorrowerProfileAdded($borrowerProfile));
    } catch (\Exception $e) {
        return redirect()->route('borrower_profiles.index')->with('error', 'Profil ajouté, mais l\'e-mail n\'a pas pu être envoyé. Erreur: ' . $e->getMessage());
    }

    // Redirection avec message de succès
    return redirect()->route('borrower_profiles.index')->with('success', 'Profil emprunteur ajouté avec succès et e-mail envoyé!');
}

    public function show($id, Request $request)
    {
        $borrowerProfile = BorrowerProfile::with(['borrows.book'])->findOrFail($id);

        // Récupérer la période sélectionnée ou utiliser "monthly" comme valeur par défaut
        $period = $request->input('period', 'monthly');

        // Définir la période de filtrage selon le choix de l'utilisateur
        if ($period == 'monthly') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } elseif ($period == 'weekly') {
            $startDate = now()->startOfWeek();
            $endDate = now()->endOfWeek();
        } elseif ($period == 'yearly') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
        }

        // Récupérer les emprunts dans la période choisie
        $totalBorrowed = $borrowerProfile->borrows()->whereBetween('borrow_date', [$startDate, $endDate])->count();
        $totalReturned = $borrowerProfile->borrows()->whereNotNull('return_date')->whereBetween('return_date', [$startDate, $endDate])->count();
        $currentBorrows = $totalBorrowed - $totalReturned;

        // Statistiques des emprunts par période
        $borrowedThisMonth = $borrowerProfile->borrows()
            ->whereMonth('borrow_date', now()->month)
            ->count();

        $returnedThisMonth = $borrowerProfile->borrows()
            ->whereMonth('return_date', now()->month)
            ->count();

        $borrowedThisYear = $borrowerProfile->borrows()
            ->whereYear('borrow_date', now()->year)
            ->count();

        $returnedThisYear = $borrowerProfile->borrows()
            ->whereYear('return_date', now()->year)
            ->count();

        // Statistique pour la semaine actuelle
        $borrowedThisWeek = $borrowerProfile->borrows()
            ->whereBetween('borrow_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Statistique pour aujourd'hui
        $borrowedToday = $borrowerProfile->borrows()
            ->whereDate('borrow_date', now()->toDateString())
            ->count();

        // Préparer les statistiques à afficher
        $stats = [
            'total_borrowed' => $totalBorrowed,
            'total_returned' => $totalReturned,
            'current_borrows' => $currentBorrows,
            'borrowed_this_month' => $borrowedThisMonth,
            'returned_this_month' => $returnedThisMonth,
            'borrowed_this_year' => $borrowedThisYear,
            'returned_this_year' => $returnedThisYear,
            'total_borrowed_week' => $borrowedThisWeek, // Ajout de la statistique hebdomadaire
            'total_borrowed_today' => $borrowedToday,   // Ajout de la statistique quotidienne
        ];

        return view('borrower_profiles.show', compact('borrowerProfile', 'stats', 'period'));
    }
    public function edit($id)
    {
        $borrowerProfile = BorrowerProfile::findOrFail($id);
        return response()->json($borrowerProfile);
    }
    
    public function update(Request $request, $id)
    {
        // Valider les données du formulaire
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
    
        // Trouver le profil à mettre à jour
        $profile = BorrowerProfile::findOrFail($id);
    
        // Mettre à jour les informations du profil
        $profile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
    
        // Rediriger avec un message de succès
        return redirect()->route('borrower_profiles.index')->with('success', 'Profil mis à jour avec succès !');
    }
    
    
public function destroy($id)
{
    $profile = BorrowerProfile::find($id);
    
    // Si le profil existe, on le supprime
    if ($profile) {
        $profile->delete();
        return response()->json([
            'success' => true,
            'message' => 'Profil supprimé avec succès!'
        ]);
    }

    // Si le profil n'existe pas, on retourne une réponse d'erreur
    return response()->json([
        'success' => false,
        'message' => 'Profil non trouvé.'
    ]);
}

}



