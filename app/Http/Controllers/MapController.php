<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * MapController
 *
 * Contrôleur responsable de la carte interactive du réseau commercial BALS.
 *
 * Rôle : afficher la page france-map.blade.php.
 * Les données des agents (contacts par région) sont gérées côté client
 * via localStorage — aucune base de données n'est nécessaire pour l'instant.
 *
 * Si l'on souhaite passer à une vraie base de données plus tard,
 * il faudra :
 *   1. Créer un modèle Agent (php artisan make:model Agent -m)
 *   2. Ajouter une migration avec les colonnes (nom, region, tel, email…)
 *   3. Alimenter la table via les Seeders
 *   4. Modifier index() pour passer les agents à la vue
 */
class MapController extends Controller
{
    /**
     * Afficher la page de la carte interactive.
     *
     * Route : GET /france-map
     * Nom   : map.index
     *
     * Les agents sont chargés depuis localStorage par JavaScript (france-map.js).
     * Cette méthode ne fait donc que retourner la vue.
     */
    public function index(): View
    {
        return view('france-map');
    }
}
