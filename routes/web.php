<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;




// ============================================
// ROUTE PAGE D'ACCUEIL
// ============================================
Route::get('/', function () {
    return view('livewire.home');
})->name('home');

// ============================================
// ROUTE PAGE ACTUALITÉS
// ============================================
// Route::get('/actualites', function () {
//     return view('livewire.layout.actualites');
// })->name('actualites');

// Volt::route('/', 'pages.index')->name('home');

