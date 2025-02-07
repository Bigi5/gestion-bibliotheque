<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\BorrowerProfileController;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\LogUserSession;
use App\Http\Middleware\LogUserLogout;
use App\Http\Controllers\Auth\LoginController;

Route::get('/filter-borrowers', [DashboardController::class, 'filterBorrowersByDate'])->name('filter.borrowers');
Route::get('/get-period-stats', [DashboardController::class, 'getPeriodStats']);
Route::get('/getUpdatedData', [DashboardController::class, 'getUpdatedData']);
// Pour l'importation et l'exportation des livres
Route::post('books/import', [BookController::class, 'import'])->name('books.import');
Route::get('books/export', [BookController::class, 'export'])->name('books.export');

// Appliquer 'log.session' sur la route de connexion
Route::post('/login', [LoginController::class, 'login'])
     ->middleware(LogUserSession::class);

// Appliquer 'log.logout' sur la route de déconnexion
Route::post('/logout', [LoginController::class, 'logout'])
     ->middleware(LogUserLogout::class);

// Routes pour les profils utilisateur
Route::get('/profiles/{profile}/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
Route::delete('/profiles/{profile}', [ProfileController::class, 'destroy'])->name('profiles.destroy');

// Profil utilisateur connecté
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Routes pour les statistiques
Route::get('statistics/download-pdf', [StatisticsController::class, 'downloadPdf'])->name('statistics.downloadPdf');
Route::get('/statistics', [StatisticsController::class, 'showStatistics'])->name('statistics.general');
Route::get('/statistics/book/{id}', [StatisticsController::class, 'showBookStats'])->name('statistics.book');

// Routes pour gérer les catégories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}/details', [CategoryController::class, 'showDetails'])->name('categories.details');
Route::get('/categories/stats', [CategoryController::class, 'showStats'])->name('categories.stats');
Route::get('/categories/download-pdf', [CategoryController::class, 'downloadPdf'])->name('categories.downloadPdf');
Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');

// Routes pour gérer les livres
Route::resource('books', BookController::class);
Route::get('books/stats/{id}', [BookController::class, 'showStats'])->name('books.stats');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/download-pdf', [BookController::class, 'downloadPdf'])->name('books.downloadPdf');
Route::get('/export-books-odf', [BookController::class, 'downloadOdf'])->name('books.export.odf');


Route::middleware(['auth'])->group(function () {
    // Liste des emprunts
    Route::get('/borrows', [BorrowController::class, 'index'])->name('borrows.index');

    // Formulaire de création d'emprunt
    Route::get('/borrows/create', [BorrowController::class, 'create'])->name('borrows.create');

    // Enregistrer un emprunt
    Route::post('/borrows', [BorrowController::class, 'store'])->name('borrows.store');

    Route::put('borrow/return/{id}', [BorrowController::class, 'returnBook'])->name('borrow.return');


    // Supprimer un emprunt
    Route::delete('/borrow/{id}', [BorrowController::class, 'destroy'])->name('borrow.delete');
    Route::get('/borrows/auto-return', [BorrowController::class, 'autoReturnOverdueBorrows'])->name('borrows.autoReturn');
    Route::get('/borrow/return/{id}', [BorrowController::class, 'return'])->name('borrow.return');
    Route::get('/check-overdue-borrows', [BorrowController::class, 'checkOverdueBorrows']);
});

    

// Routes pour gérer les utilisateurs
Route::resource('users', UserController::class);

// Routes pour l'authentification
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');


// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes pour gérer les profils des emprunteurs
Route::resource('borrower_profiles', BorrowerProfileController::class);
Route::get('/borrower_profiles/{profile}', [BorrowerProfileController::class, 'show'])->name('borrower_profiles.show');
Route::put('/borrower_profiles/{id}', [BorrowerProfileController::class, 'update'])->name('borrower_profiles.update');
Route::delete('/borrower-profile/{id}', [BorrowerProfileController::class, 'destroy']);



// Test de l'envoi d'un email via Gmail
Route::get('/test-email', function () {
    Mail::raw('Ceci est un test d\'envoi d\'email via Gmail.', function ($message) {
        $message->to('carlossabi64@gmail.com')
                ->subject('Test avec Gmail');
    });
    return 'Email envoyé avec succès !';
});

