<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KlantController;
use App\Http\Controllers\MagazijnmedewerkerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin.index')
    ->middleware(['auth', 'role:admin']);

// Zowel klant als admin krijgen toegang tot de klant homepage:
Route::get('/klant', [KlantController::class, 'index'])
    ->name('klant.index')
    ->middleware(['auth', 'role:klant,admin']);    

Route::get('/magazijnmedewerker', [MagazijnmedewerkerController::class, 'index'])
    ->name('magazijnmedewerker.index')
    ->middleware(['auth', 'role:magazijnmedewerker']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
