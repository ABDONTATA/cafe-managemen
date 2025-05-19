<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\LigneCommandeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::resource('categories', CategoryController::class);

    Route::resource('produits', ProduitController::class);

    Route::resource('tables', TableController::class);

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware(['auth', AdminMiddleware::class]);

    Route::get('/serveur/dashboard', function () {
        return view('serveur.dashboard'); 
    })->name('serveur.dashboard')->middleware('auth');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('auth');

    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
        Route::get('/user-add', [UserController::class, 'create'])->name('user-add');
        Route::post('/user-add', [UserController::class, 'store'])->name('user-store');
        Route::resource('commandes', CommandeController::class);
        Route::resource('ligne_commandes', LigneCommandeController::class);
        Route::resource('factures', FactureController::class)->except(['show']);
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('factures/{facture}', [FactureController::class, 'show'])->name('factures.show');
        
        // Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::resource('settings', \App\Http\Controllers\SettingController::class);
    });
});
