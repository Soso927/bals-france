<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Modèle pour les emplacements BALS
 * Représente les distributeurs, installateurs et showrooms
 */
class Location extends Model
{
    use HasFactory;

    /**
     * Nom de la table dans la base de données
     */
    protected $table = 'locations';

    /**
     * Champs modifiables en masse (protection contre les failles)
     */
    protected $fillable = [
        'type',
        'nom',
        'adresse',
        'ville',
        'code_postal',
        'region',
        'latitude',
        'longitude',
        'telephone',
        'email',
        'site_web',
        'description',
        'produits_disponibles',
        'horaires',
        'actif',
        'reference_interne',
    ];

    /**
     * Conversion automatique des types de données
     */
    protected $casts = [
        'latitude' => 'decimal:8',  // 8 décimales pour la précision GPS
        'longitude' => 'decimal:8',
        'actif' => 'boolean',
        'produits_disponibles' => 'array', // Conversion JSON <-> Array automatique
        'horaires' => 'array',
    ];

    /**
     * Valeurs par défaut pour les nouveaux enregistrements
     */
    protected $attributes = [
        'actif' => true,
    ];

    // ========================================
    // SCOPES (Requêtes réutilisables)
    // ========================================

    /**
     * Récupérer uniquement les emplacements actifs
     * Usage : Location::actifs()->get()
     */
    public function scopeActifs(Builder $query): Builder
    {
        return $query->where('actif', true);
    }

    /**
     * Filtrer par type d'emplacement
     * Usage : Location::parType('distributeur')->get()
     */
    public function scopeParType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Rechercher par ville
     * Usage : Location::parVille('Paris')->get()
     */
    public function scopeParVille(Builder $query, string $ville): Builder
    {
        return $query->where('ville', 'LIKE', "%{$ville}%");
    }

    /**
     * Rechercher par région
     * Usage : Location::parRegion('Île-de-France')->get()
     */
    public function scopeParRegion(Builder $query, string $region): Builder
    {
        return $query->where('region', 'LIKE', "%{$region}%");
    }

    /**
     * Rechercher dans un rayon géographique (en km)
     * Utilise la formule de Haversine pour calculer la distance
     * 
     * Usage : Location::dansRayon(48.8566, 2.3522, 50)->get()
     *         (50km autour de Paris)
     */
    public function scopeDansRayon(Builder $query, float $lat, float $lng, float $rayonKm): Builder
    {
        // Formule de Haversine pour calculer la distance entre 2 points GPS
        // 6371 = rayon moyen de la Terre en km
        return $query->selectRaw("
            *,
            (
                6371 * acos(
                    cos(radians(?)) 
                    * cos(radians(latitude)) 
                    * cos(radians(longitude) - radians(?)) 
                    + sin(radians(?)) 
                    * sin(radians(latitude))
                )
            ) AS distance
        ", [$lat, $lng, $lat])
        ->having('distance', '<=', $rayonKm)
        ->orderBy('distance');
    }

    // ========================================
    // ACCESSEURS (Getters personnalisés)
    // ========================================

    /**
     * Obtenir l'adresse complète formatée
     * Usage : $location->adresse_complete
     */
    public function getAdresseCompleteAttribute(): string
    {
        return "{$this->adresse}, {$this->code_postal} {$this->ville}";
    }

    /**
     * Obtenir les coordonnées GPS au format tableau
     * Usage : $location->coordonnees => ['lat' => 48.8566, 'lng' => 2.3522]
     */
    public function getCoordonneesAttribute(): array
    {
        return [
            'lat' => (float) $this->latitude,
            'lng' => (float) $this->longitude,
        ];
    }

    /**
     * Obtenir une icône selon le type d'emplacement
     * Usage : $location->icone
     */
    public function getIconeAttribute(): string
    {
        return match($this->type) {
            'distributeur' => '🏢',
            'installateur' => '🔧',
            'showroom' => '🏪',
            default => '📍',
        };
    }

    /**
     * Formater le téléphone pour l'affichage
     * Usage : $location->telephone_formate
     */
    public function getTelephoneFormateAttribute(): ?string
    {
        if (!$this->telephone) {
            return null;
        }

        // Formater : 0123456789 => 01 23 45 67 89
        return chunk_split($this->telephone, 2, ' ');
    }

    // ========================================
    // MÉTHODES UTILES
    // ========================================

    /**
     * Générer l'URL Google Maps pour cet emplacement
     */
    public function urlGoogleMaps(): string
    {
        return "https://www.google.com/maps/search/?api=1&query={$this->latitude},{$this->longitude}";
    }

    /**
     * Vérifier si un produit est disponible
     */
    public function aProduit(string $produit): bool
    {
        return in_array($produit, $this->produits_disponibles ?? []);
    }

    /**
     * Exporter les données pour la carte (format JSON)
     */
    public function pourCarte(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'nom' => $this->nom,
            'adresse' => $this->adresse_complete,
            'ville' => $this->ville,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
            'icone' => $this->icone,
            'description' => $this->description,
            'produits' => $this->produits_disponibles,
        ];
    }
}