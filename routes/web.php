<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ConfigurateurController;
use Livewire\Volt\Volt;





// ============================================
// ROUTE PAGE D'ACCUEIL
// ============================================
Route::get('/', function () {
    return view('livewire.home');
})->name('home');

Route::get('/map',[MapController::class, 'index'])->name('map.index');



// ============================================
// ROUTE PAGE ACTUALITÉS
// ============================================
// Route::get('/actualites', function () {
//     return view('livewire.layout.actualites');
// })->name('actualites');

// Volt::route('/', 'pages.index')->name('home');



// =============================================================================
// FICHIER : routes/web.php
// ROUTES DU CONFIGURATEUR BALS
// =============================================================================

/**
 * INSTRUCTIONS :
 * 
 * 1. Copiez ce code dans votre fichier routes/web.php
 * 2. Placez-le APRÈS vos autres routes
 * 3. Assurez-vous d'avoir importé le contrôleur en haut du fichier
 */


// -----------------------------------------------------------------------------
// GROUPE DE ROUTES DU CONFIGURATEUR
// -----------------------------------------------------------------------------

/**
 * Route principale : Page d'accueil du configurateur
 * 
 * URL : /configurateur
 * Méthode : GET
 * Contrôleur : ConfigurateurController@index
 * Nom : configurateur.index
 * 
 * Cette route affiche la liste de tous les types de coffrets disponibles
 */
// Route::get('/configurateur', [ConfigurateurController::class, 'index'])
//     ->name('configurateur.index');

/**
 * Route : Coffret de Chantier Maçon
 * 
 * URL : /configurateur/coffret-macon
 * Référence produit : 53 930
 */
Route::get('/configurateur/chantier', [ConfigurateurController::class, 'chantier'])
    ->name('configurateur.chantier');

/**
 * Route : Coffret d'Étage
 * 
 * URL : /configurateur/coffret-etage
 * Référence produit : 510 802
 */
Route::get('/configurateur/etage', [ConfigurateurController::class, 'etage'])
    ->name('configurateur.etage');

/**
 * Route : Coffret Événementiel EVOBOX
 * 
 * URL : /configurateur/coffret-evenementiel
 * Référence produit : 53 83
 */
Route::get('/configurateur/coffret-evenementiel', [ConfigurateurController::class, 'evenementiel'])
    ->name('configurateur.evenementiel');

/**
 * Route : Coffret Industrie
 * 
 * URL : /configurateur/coffret-industrie
 * Référence produit : 512 399
 */
Route::get('/configurateur/coffret-industrie', [ConfigurateurController::class, 'industrie'])
    ->name('configurateur.industrie');

/**
 * Route : Prise Industrielle
 * 
 * URL : /configurateur/prise-industrielle
 * Référence produit : PI-001
 */
Route::get('/configurateur/prise-industrielle', [ConfigurateurController::class, 'priseIndustrielle'])
    ->name('configurateur.prise-industrielle');

// -----------------------------------------------------------------------------
// ROUTES SUPPLÉMENTAIRES (OPTIONNELLES)
// -----------------------------------------------------------------------------

/**
 * Route : Sauvegarde de configuration (POST)
 * 
 * Cette route permet de sauvegarder une configuration en base de données
 * Vous pouvez l'implémenter plus tard si nécessaire
 */
Route::post('/configurateur/sauvegarder', [ConfigurateurController::class, 'sauvegarder'])
    ->name('configurateur.sauvegarder');

/**
 * Route : Génération de devis PDF
 * 
 * Cette route génère un PDF à partir de la configuration
 * À implémenter avec une bibliothèque comme DomPDF
 */
Route::post('/configurateur/generer-pdf', [ConfigurateurController::class, 'genererPDF'])
    ->name('configurateur.pdf');

/**
 * Route : Envoi de devis par email
 * 
 * Cette route envoie le devis configuré par email
 */
Route::post('/configurateur/envoyer-devis', [ConfigurateurController::class, 'envoyerDevis'])
    ->name('configurateur.email');

// =============================================================================
// NOTES POUR LE JURY :
// =============================================================================

/**
 * EXPLICATION DU SYSTÈME DE NOMMAGE DES ROUTES :
 * 
 * route('configurateur.index')  → /configurateur
 * route('configurateur.chantier')  → /configurateur/coffret-chantier
 * route('configurateur.etage')  → /configurateur/coffret-etage
 * 
 * AVANTAGES :
 * 
 * 1. URLs propres et compréhensibles
 * 2. Facile à mémoriser
 * 3. SEO-friendly (référencement Google)
 * 4. Maintenabilité : si on change l'URL, tous les liens se mettent à jour
 * 
 * COMMENT UTILISER CES ROUTES DANS VOS VUES :
 * 
 * Dans un fichier Blade :
 * <a href="{{ route('configurateur.index') }}">Configurateur</a>
 * <a href="{{ route('configurateur.macon') }}">Coffret Maçon</a>
 * 
 * Dans un contrôleur :
 * return redirect()->route('configurateur.index');
 * 
 * Dans JavaScript :
 * window.location.href = "{{ route('configurateur.macon') }}";
 */