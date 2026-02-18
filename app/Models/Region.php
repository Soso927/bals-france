<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant une région commerciale française
 * 
 * @property int $id
 * @property string $nom
 * @property string $code
 * @property string $couleur
 * @property string|null $description
 * @property bool $actif
 */
class Region extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse
     * Sécurité : définit quels champs peuvent être remplis via create() ou update()
     */
    protected $fillable = [
        'nom',
        'code',
        'couleur',
        'description',
        'actif',
    ];

    /**
     * Les attributs qui doivent être castés (convertis) en types natifs
     * Exemple : 'actif' sera automatiquement converti en booléen
     */
    protected $casts = [
        'actif' => 'boolean',
    ];

    /**
     * Relation : Une région a plusieurs agents commerciaux
     * 
     * @return HasMany
     */
    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class)
                    ->where('actif', true)      // Uniquement les agents actifs
                    ->orderBy('ordre');         // Triés par ordre d'affichage
    }

    /**
     * Scope : Récupérer uniquement les régions actives
     * Utilisation : Region::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Accesseur : Obtenir le nom en majuscules
     * Utilisation : $region->nom_majuscules
     */
    public function getNomMajusculesAttribute(): string
    {
        return strtoupper($this->nom);
    }
}