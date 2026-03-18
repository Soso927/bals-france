<?php

/*
|==========================================================================
| MODÈLE : User
|==========================================================================
|
| Un modèle, c'est une classe PHP qui représente une table de la base de
| données. Grâce au modèle, on peut manipuler les données de la table
| "users" sans écrire de SQL.
|
| EXEMPLES D'UTILISATION :
|   User::all()                     → Récupère TOUS les utilisateurs
|   User::find(1)                   → Récupère l'utilisateur avec l'id 1
|   User::where('email', '...')->first()  → Cherche par email
|   User::create([...])            → Crée un nouvel utilisateur
|
| EMPLACEMENT : app/Models/User.php
|
*/

namespace App\Models;

// On importe les classes nécessaires de Laravel
use Illuminate\Foundation\Auth\User as Authenticatable;

/*
| IMPORTANT : on étend "Authenticatable" et non pas "Model"
| Authenticatable = un modèle spécial qui gère l'authentification
| Il ajoute des méthodes comme getAuthIdentifier(), getAuthPassword(), etc.
| que Laravel utilise en interne pour gérer les sessions de connexion.
*/

class User extends Authenticatable
{
    /*
    |----------------------------------------------------------------------
    | $fillable — Les champs qu'on peut remplir en masse
    |----------------------------------------------------------------------
    |
    | Quand on fait User::create([...]), Laravel vérifie que les champs
    | envoyés sont dans cette liste. C'est une protection de sécurité
    | appelée "Mass Assignment Protection".
    |
    | EXEMPLE :
    |   User::create(['name' => 'Jean', 'email' => '...', 'password' => '...'])
    |   → Fonctionne car name, email et password sont dans $fillable
    |
    |   User::create(['is_admin' => true])
    |   → NE FONCTIONNE PAS car is_admin n'est PAS dans $fillable
    |   → C'est voulu ! Un utilisateur ne doit pas pouvoir se rendre admin
    |     lui-même via un formulaire
    |
    */
    protected $fillable = [
        'name',
        'email',
        'password',
        // On ne met PAS 'is_admin' ici volontairement
        // Pour passer quelqu'un en admin, on le fera manuellement
        // via Tinker ou directement en base de données
    ];

    /*
    |----------------------------------------------------------------------
    | $hidden — Les champs cachés lors de la sérialisation
    |----------------------------------------------------------------------
    |
    | Quand on convertit un User en JSON (par exemple pour une API),
    | ces champs ne seront PAS inclus. Le mot de passe ne doit jamais
    | être visible, même chiffré.
    |
    */
    protected $hidden = [
        'password',
    ];

    /*
    |----------------------------------------------------------------------
    | $casts — Comment Laravel doit interpréter chaque champ
    |----------------------------------------------------------------------
    |
    | 'hashed' → Laravel chiffre automatiquement le mot de passe avec bcrypt
    |             quand on fait $user->password = 'monMotDePasse'
    |             On n'a plus besoin d'appeler bcrypt() nous-mêmes
    |
    | 'boolean' → Laravel convertit 0/1 en false/true
    |             Pratique pour écrire : if ($user->is_admin) { ... }
    |
    */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',    // Chiffrement automatique du mot de passe
            'is_admin' => 'boolean',   // Conversion en vrai/faux
        ];
    }
}
