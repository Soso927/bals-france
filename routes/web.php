<?php

/**
 * routes/web.php
 *
 * Ce fichier définit toutes les URLs (routes) du site BALS France.
 * Chaque route fait le lien entre une URL et un contrôleur (ou une vue directe).
 *
 * Syntaxe :
 *   Route::get('/url', action) → répond aux requêtes GET (affichage de page)
 *   Route::post('/url', action) → répond aux requêtes POST (envoi de formulaire)
 *   ->name('nom') → donne un nom à la route pour l'utiliser dans les vues :
 *                   {{ route('nom') }} au lieu de coder l'URL en dur
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ConfigurateurController;


// ── Page d'accueil ──────────────────────────────────────────────────────────
Route::get('/', fn () => view('livewire.home'))->name('home');


// ── Carte interactive du réseau commercial ──────────────────────────────────
// MapController@index affiche la carte avec D3.js et les agents par région.
Route::get('/france-map', [MapController::class, 'index'])->name('map.index');


// ── Page de présentation de la gamme produits ───────────────────────────────
Route::get('/gamme', fn () => view('gamme'))->name('gamme');



// ── Configurateur de coffrets électriques ────────────────────────────────────
// Route::prefix() regroupe toutes les URLs sous /configurateur/...
// Route::name()   préfixe tous les noms : configurateur.index, configurateur.chantier, etc.
Route::prefix('configurateur')->name('configurateur.')->group(function () {

    // Page d'accueil du configurateur (liste des 5 types de coffrets)
    Route::get('/', [ConfigurateurController::class, 'index'])->name('index');

    // ── Pages configurateur par type de coffret ──────────────────────────
    Route::get('/chantier',            [ConfigurateurController::class, 'chantier'])->name('chantier');
    Route::get('/etage',               [ConfigurateurController::class, 'etage'])->name('etage');
    Route::get('/coffret-evenementiel',[ConfigurateurController::class, 'evenementiel'])->name('evenementiel');
    Route::get('/coffret-industrie',   [ConfigurateurController::class, 'industrie'])->name('industrie');
    Route::get('/prise-industrielle',  [ConfigurateurController::class, 'priseIndustrielle'])->name('prise-industrielle');

    // // ── Routes POST (traitements de formulaires) ─────────────────────────
    // // Ces routes reçoivent les données du configurateur et les traitent.
    // // À implémenter : DomPDF pour le PDF, PhpSpreadsheet pour l'Excel.
    // Route::post('/generer-pdf',   [ConfigurateurController::class, 'generatePDF'])->name('pdf');
    // Route::post('/sauvegarder',   [ConfigurateurController::class, 'saveQuote'])->name('sauvegarder');
    // Route::post('/envoyer-devis', [ConfigurateurController::class, 'sendQuote'])->name('email');
    // Route::post('/soumettre',     [ConfigurateurController::class, 'soumettre'])->name('soumettre');
});
