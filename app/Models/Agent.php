<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle représentant un agent commercial
 * 
 * @property int $id
 * @property int $region_id
 * @property string $nom
 * @property string $prenom
 * @property string|null $telephone
 * @property string|null $email
 * @property string|null $secteur
 * @property int $ordre
 * @property bool $actif
 */
class Agent extends Model
{
    use HasFactory;

    /**
     * Attributs assignables en masse
     */
    protected $fillable = [
        'region_id',
        'nom',
        'prenom',
        'telephone',
        'email',
        'secteur',
        'ordre',
        'actif',
    ];

    /**
     * Casts de types
     */
    protected $casts = [
        'actif' => 'boolean',
        'ordre' => 'integer',
    ];

    /**
     * Relation : Un agent appartient à une région
     * 
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Accesseur : Nom complet de l'agent
     * Utilisation : $agent->nom_complet
     */
    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    /**
     * Accesseur : Téléphone formaté
     * Utilisation : $agent->telephone_formate
     */
    public function getTelephoneFormateAttribute(): ?string
    {
        if (!$this->telephone) {
            return null;
        }

        // Format français : 01 23 45 67 89
        return chunk_split($this->telephone, 2, ' ');
    }

    /**
     * Scope : Uniquement les agents actifs
     */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }
}