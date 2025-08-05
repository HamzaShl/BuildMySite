<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\CommentaireController;

Route::get('/', function () {
    return view('welcome');
});

//route pour l'authentification
Route::get('/register',[AuthController::class, 'showSignUp'])->name('register');
Route::post('/register',[AuthController::class, 'signUp'])->name('registration.register');

//route pour la connexion
Route::get('/login',[AuthController::class, 'showFormLogin'])->name('login');
Route::post('/login',[AuthController::class, 'login'])->name('login.submit');

//route pour la déconnexion
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// routes communes (consultation seulement)
Route::resource('entreprises', EntrepriseController::class)->only(['index', 'show']);
Route::resource('devs', DevController::class)->only(['index', 'show']);

// ROUTES ENTREPRISES
Route::middleware('auth:entreprise')->group(function () {
    // CRUD entreprises (création/modification/suppression)
    Route::resource('entreprises', EntrepriseController::class)->except(['index', 'show']);
    
    // CRUD missions complètes
    Route::resource('missions', MissionController::class);
    
    // Routes spécifiques entreprise
    Route::get('/entreprise/dashboard', [EntrepriseController::class, 'dashboard'])->name('entreprise.dashboard');
    Route::get('/liste-devis/{mission_id}', [EntrepriseController::class, 'listeDevis'])->name('entreprises.listeDevis');
    Route::put('/devis/{id}/acceptation', [EntrepriseController::class, 'updateDevisAcceptation'])->name('entreprises.updateDevisAcceptation');
    
    // ✅ Routes commentaires pour entreprises (DÉPLACÉ ICI)
    Route::get('/commentaire/create/{dev_id}', [CommentaireController::class, 'create'])->name('commentaires.create');
    Route::post('/commentaire/store', [CommentaireController::class, 'store'])->name('commentaires.store');
});

// ✅ ROUTES PROTÉGÉES DÉVELOPPEURS
Route::middleware('auth:dev')->group(function () {
    // CRUD développeurs (création/modification/suppression)
    Route::resource('devs', DevController::class)->except(['index', 'show']);
    
    // CRUD devis complètes
    Route::resource('devis', DevisController::class);
    
    // Routes spécifiques développeur
    Route::put('/missions/{id}/acceptation', [DevController::class, 'updateAcceptation'])->name('missions.updateAcceptation');
    Route::delete('/dev/delete-account', [DevController::class, 'deleteMyAccount'])->name('dev.deleteAccount');
    Route::get('/dev/missions/{mission_id}/gestion', [DevController::class, 'gestionMission'])->name('dev.gestion-mission');
    Route::put('/dev/missions/{id}/etat', [DevController::class, 'updateEtatMission'])->name('dev.updateEtatMission');
});

// ✅ Route publique pour voir les avis d'un dev
Route::get('/dev/{dev_id}/avis', [CommentaireController::class, 'show'])->name('commentaires.show'); 