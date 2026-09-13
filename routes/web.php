<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KlantController;
use App\Http\Controllers\MagazijnmedewerkerController;
use App\Http\Controllers\MagazijnController;

Route::get('/', function () {
    return view('welcome');
});

// Publiek toegankelijke magazijn routes (geen login nodig voor docent / testen)
Route::get('/magazijn', [MagazijnController::class, 'index'])->name('magazijn.index');
Route::get('/magazijn/levering/{id}', [MagazijnController::class, 'levering'])->name('magazijn.levering');   
Route::get('/magazijn/allergenen/{id}', [MagazijnController::class, 'allergenen'])->name('magazijn.allergenen');

Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin.index')
    ->middleware(['auth', 'role:admin']);

// Zowel klant als admin krijgen toegang tot de klant homepage:
Route::get('/klant', [KlantController::class, 'index'])
    ->name('klant.index')
    ->middleware(['auth', 'role:klant,admin']);     
