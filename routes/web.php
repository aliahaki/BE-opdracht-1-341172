<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KlantController;
use App\Http\Controllers\MagazijnController;
use App\Http\Controllers\MagazijnmedewerkerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin pagina (ALLEEN voor Admin -> Magazijnmedewerker krijgt 403)
Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin.index')
    ->middleware(['auth', 'role:admin']);

// Magazijn Overzicht & Details (Toegankelijk voor Admin en Magazijnmedewerker)
Route::middleware(['auth', 'role:admin,magazijnmedewerker'])->group(function () {
    Route::get('/magazijn', [MagazijnController::class, 'index'])->name('magazijn.index');
    Route::get('/magazijn/levering/{id}', [MagazijnController::class, 'levering'])->name('magazijn.levering');
    Route::get('/magazijn/allergenen/{id}', [MagazijnController::class, 'allergenen'])->name('magazijn.allergenen');
});

// Magazijnmedewerker Home (Toegankelijk voor Magazijnmedewerker en Admin)
Route::get('/magazijnmedewerker', [MagazijnmedewerkerController::class, 'index'])
    ->name('magazijnmedewerker.index')
    ->middleware(['auth', 'role:magazijnmedewerker,admin']);

// Klant Home (Toegankelijk voor Klant en Admin)
Route::get('/klant', [KlantController::class, 'index'])
    ->name('klant.index')
    ->middleware(['auth', 'role:klant,admin']);

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profielbeheer
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';