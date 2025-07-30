<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\UserTypeController;

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

//route pour entreprise et dev
Route::resource('entreprises', EntrepriseController::class);
Route::resource('devs', DevController::class);

//route pour la page d'accueil de l'entreprise
Route::get('/entreprise/dashboard', [EntrepriseController::class, 'dashboard'])->name('entreprise.dashboard')->middleware('auth');
