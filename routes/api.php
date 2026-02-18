<?php

use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

/**
 * API Routes pour les données de la carte
 */

// Obtenir toutes les régions avec leurs agents
Route::get('/regions', [MapController::class, 'getRegionsData'])
     ->name('api.regions');

// Obtenir les agents d'une région spécifique
Route::get('/regions/{id}/agents', [MapController::class, 'getRegionAgents'])
     ->name('api.region.agents');

// Rechercher un agent
Route::get('/agents/search', [MapController::class, 'searchAgent'])
     ->name('api.agents.search');

// Statistiques
Route::get('/stats', [MapController::class, 'getStats'])
     ->name('api.stats');