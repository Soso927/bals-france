<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

/**
 * Contrôleur pour gérer la carte interactive BALS
 */
class MapController extends Controller
{
    /**
     * Afficher la page avec la carte interactive
     * 
     * Route : GET /carte
     */
    public function index(): View
    {
        // Récupérer les statistiques pour l'affichage
        $stats = [
            'total' => Location::actifs()->count(),
            'distributeurs' => Location::actifs()->parType('distributeur')->count(),
            'installateurs' => Location::actifs()->parType('installateur')->count(),
            'showrooms' => Location::actifs()->parType('showroom')->count(),
        ];



        // Récupérer les régions uniques pour le filtre
        $regions = Location::actifs()
            ->distinct()
            ->pluck('region')
            ->filter() // Enlever les valeurs nulles
            ->sort()
            ->values();

        return view('france-map', compact('stats', 'regions'));
    }

    /**
     * Récupérer tous les emplacements pour la carte (API JSON)
     * 
     * Route : GET /api/locations
     * 
     * Paramètres optionnels :
     * - type : filtrer par type (distributeur, installateur, showroom)
     * - ville : rechercher par ville
     * - region : filtrer par région
     * - rayon : recherche dans un rayon (nécessite lat, lng, rayon_km)
     */
    public function getLocations(Request $request): JsonResponse
    {
        // Démarrer la requête avec les emplacements actifs
        $query = Location::actifs();

        // FILTRE PAR TYPE
        if ($request->has('type') && $request->type !== 'all') {
            $query->parType($request->type);
        }

        // FILTRE PAR VILLE
        if ($request->filled('ville')) {
            $query->parVille($request->ville);
        }

        // FILTRE PAR RÉGION
        if ($request->filled('region')) {
            $query->parRegion($request->region);
        }

        // RECHERCHE PAR RAYON GÉOGRAPHIQUE
        if ($request->filled(['lat', 'lng', 'rayon_km'])) {
            $query->dansRayon(
                (float) $request->lat,
                (float) $request->lng,
                (float) $request->rayon_km
            );
        }

        // RECHERCHE PAR CODE POSTAL
        if ($request->filled('code_postal')) {
            $query->where('code_postal', 'LIKE', $request->code_postal . '%');
        }

        // RECHERCHE PAR PRODUIT DISPONIBLE
        if ($request->filled('produit')) {
            $query->whereJsonContains('produits_disponibles', $request->produit);
        }

        // Exécuter la requête et formater pour la carte
        $locations = $query->get()->map(function ($location) {
            return $location->pourCarte();
        });

        return response()->json([
            'success' => true,
            'count' => $locations->count(),
            'locations' => $locations,
        ]);
    }

    /**
     * Récupérer les détails d'un emplacement spécifique
     * 
     * Route : GET /api/locations/{id}
     */
    public function show(int $id): JsonResponse
    {
        $location = Location::actifs()->findOrFail($id);

        return response()->json([
            'success' => true,
            'location' => [
                ...$location->pourCarte(),
                'horaires' => $location->horaires,
                'site_web' => $location->site_web,
                'url_google_maps' => $location->urlGoogleMaps(),
            ],
        ]);
    }

    /**
     * Rechercher l'emplacement le plus proche
     * 
     * Route : GET /api/locations/closest
     * Paramètres : lat, lng
     */
    public function findClosest(Request $request): JsonResponse
    {
        // Validation des coordonnées GPS
        $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ]);

        // Chercher dans un rayon de 100 km
        $closest = Location::actifs()
            ->dansRayon($request->lat, $request->lng, 100)
            ->first();

        if (!$closest) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun emplacement trouvé dans un rayon de 100 km',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'location' => $closest->pourCarte(),
            'distance_km' => round($closest->distance, 2),
        ]);
    }

    /**
     * Exporter les emplacements en JSON (pour backup ou API externe)
     * 
     * Route : GET /api/locations/export
     */
    public function export(): JsonResponse
    {
        $locations = Location::actifs()->get();

        return response()->json([
            'success' => true,
            'export_date' => now()->toIso8601String(),
            'count' => $locations->count(),
            'locations' => $locations,
        ]);
    }

    /**
     * Obtenir les statistiques détaillées
     * 
     * Route : GET /api/locations/stats
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'stats' => [
                'total' => Location::actifs()->count(),
                'par_type' => [
                    'distributeurs' => Location::actifs()->parType('distributeur')->count(),
                    'installateurs' => Location::actifs()->parType('installateur')->count(),
                    'showrooms' => Location::actifs()->parType('showroom')->count(),
                ],
                'par_region' => Location::actifs()
                    ->selectRaw('region, COUNT(*) as count')
                    ->groupBy('region')
                    ->get()
                    ->pluck('count', 'region'),
                'derniere_mise_a_jour' => Location::max('updated_at'),
            ],
        ]);
    }
}