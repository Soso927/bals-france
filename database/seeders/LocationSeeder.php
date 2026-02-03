<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

/**
 * Seeder pour créer des emplacements BALS de démonstration
 * 
 * Utilisation : php artisan db:seed --class=LocationSeeder
 */
class LocationSeeder extends Seeder
{
    /**
     * Exécuter le seeder
     */
    public function run(): void
    {
        echo "🌱 Création d'emplacements BALS de démonstration...\n";

        // Liste de villes françaises avec coordonnées GPS
        $locations = [
            // DISTRIBUTEURS
            [
                'type' => 'distributeur',
                'nom' => 'BALS Distribution Paris',
                'adresse' => '123 Avenue des Champs-Élysées',
                'ville' => 'Paris',
                'code_postal' => '75008',
                'region' => 'Île-de-France',
                'latitude' => 48.8698,
                'longitude' => 2.3078,
                'telephone' => '0145852366',
                'email' => 'paris@bals-distribution.fr',
                'description' => 'Distributeur principal BALS pour la région parisienne',
                'produits_disponibles' => ['Coffrets de chantier', 'Coffrets industriels', 'Prises industrielles'],
                'horaires' => [
                    'lundi' => '9h-18h',
                    'mardi' => '9h-18h',
                    'mercredi' => '9h-18h',
                    'jeudi' => '9h-18h',
                    'vendredi' => '9h-17h',
                ],
                'actif' => true,
            ],
            [
                'type' => 'distributeur',
                'nom' => 'BALS Lyon Distribution',
                'adresse' => '45 Rue de la République',
                'ville' => 'Lyon',
                'code_postal' => '69002',
                'region' => 'Auvergne-Rhône-Alpes',
                'latitude' => 45.7640,
                'longitude' => 4.8357,
                'telephone' => '0478452233',
                'email' => 'lyon@bals-distribution.fr',
                'description' => 'Distributeur BALS pour le sud-est',
                'produits_disponibles' => ['Coffrets de chantier', 'Coffrets EVOBOX', 'Prises industrielles'],
                'actif' => true,
            ],
            [
                'type' => 'distributeur',
                'nom' => 'BALS Marseille',
                'adresse' => '78 La Canebière',
                'ville' => 'Marseille',
                'code_postal' => '13001',
                'region' => 'Provence-Alpes-Côte d\'Azur',
                'latitude' => 43.2965,
                'longitude' => 5.3698,
                'telephone' => '0491334455',
                'email' => 'marseille@bals-distribution.fr',
                'description' => 'Distributeur BALS Sud',
                'produits_disponibles' => ['Coffrets industriels', 'Prises industrielles'],
                'actif' => true,
            ],

            // INSTALLATEURS
            [
                'type' => 'installateur',
                'nom' => 'Électricité Pro Bordeaux',
                'adresse' => '12 Cours Victor Hugo',
                'ville' => 'Bordeaux',
                'code_postal' => '33000',
                'region' => 'Nouvelle-Aquitaine',
                'latitude' => 44.8378,
                'longitude' => -0.5792,
                'telephone' => '0556789012',
                'email' => 'contact@elec-pro-bordeaux.fr',
                'description' => 'Installateur agréé BALS - Spécialiste chantier',
                'produits_disponibles' => ['Installation coffrets', 'Maintenance'],
                'actif' => true,
            ],
            [
                'type' => 'installateur',
                'nom' => 'Installations Électriques Toulouse',
                'adresse' => '89 Rue Alsace Lorraine',
                'ville' => 'Toulouse',
                'code_postal' => '31000',
                'region' => 'Occitanie',
                'latitude' => 43.6047,
                'longitude' => 1.4442,
                'telephone' => '0561223344',
                'email' => 'contact@iet.fr',
                'description' => 'Installateur certifié BALS',
                'produits_disponibles' => ['Installation', 'Dépannage'],
                'actif' => true,
            ],
            [
                'type' => 'installateur',
                'nom' => 'Nord Électricité Services',
                'adresse' => '56 Rue Nationale',
                'ville' => 'Lille',
                'code_postal' => '59000',
                'region' => 'Hauts-de-France',
                'latitude' => 50.6292,
                'longitude' => 3.0573,
                'telephone' => '0320445566',
                'email' => 'contact@nes-lille.fr',
                'description' => 'Partenaire installateur BALS Nord',
                'produits_disponibles' => ['Installation industrielle', 'Maintenance'],
                'actif' => true,
            ],

            // SHOWROOMS
            [
                'type' => 'showroom',
                'nom' => 'BALS Showroom Nantes',
                'adresse' => '23 Place du Commerce',
                'ville' => 'Nantes',
                'code_postal' => '44000',
                'region' => 'Pays de la Loire',
                'latitude' => 47.2184,
                'longitude' => -1.5536,
                'telephone' => '0240556677',
                'email' => 'showroom.nantes@bals.fr',
                'site_web' => 'https://www.bals.com/showroom-nantes',
                'description' => 'Showroom BALS - Découvrez toute notre gamme',
                'produits_disponibles' => ['Tous produits BALS', 'Démonstration'],
                'horaires' => [
                    'lundi' => '10h-19h',
                    'mardi' => '10h-19h',
                    'mercredi' => '10h-19h',
                    'jeudi' => '10h-19h',
                    'vendredi' => '10h-19h',
                    'samedi' => '10h-18h',
                ],
                'actif' => true,
            ],
            [
                'type' => 'showroom',
                'nom' => 'BALS Experience Strasbourg',
                'adresse' => '34 Place Kléber',
                'ville' => 'Strasbourg',
                'code_postal' => '67000',
                'region' => 'Grand Est',
                'latitude' => 48.5734,
                'longitude' => 7.7521,
                'telephone' => '0388998877',
                'email' => 'showroom.strasbourg@bals.fr',
                'site_web' => 'https://www.bals.com/showroom-strasbourg',
                'description' => 'Espace d\'exposition BALS Grand Est',
                'produits_disponibles' => ['Gamme complète', 'Conseils personnalisés'],
                'actif' => true,
            ],

            // AUTRES VILLES
            [
                'type' => 'distributeur',
                'nom' => 'BALS Bretagne',
                'adresse' => '67 Rue de la Motte Fablet',
                'ville' => 'Rennes',
                'code_postal' => '35000',
                'region' => 'Bretagne',
                'latitude' => 48.1173,
                'longitude' => -1.6778,
                'telephone' => '0299112233',
                'email' => 'rennes@bals-distribution.fr',
                'description' => 'Distributeur BALS Bretagne',
                'produits_disponibles' => ['Coffrets événementiels', 'Coffrets de chantier'],
                'actif' => true,
            ],
            [
                'type' => 'installateur',
                'nom' => 'Électricité Montpellier Services',
                'adresse' => '101 Rue Foch',
                'ville' => 'Montpellier',
                'code_postal' => '34000',
                'region' => 'Occitanie',
                'latitude' => 43.6108,
                'longitude' => 3.8767,
                'telephone' => '0467334455',
                'email' => 'contact@ems-montpellier.fr',
                'description' => 'Installateur BALS Montpellier et environs',
                'produits_disponibles' => ['Installation', 'SAV'],
                'actif' => true,
            ],
        ];

        // Créer chaque emplacement
        foreach ($locations as $locationData) {
            Location::create($locationData);
            echo "  ✅ {$locationData['nom']} ({$locationData['ville']})\n";
        }

        $total = count($locations);
        echo "\n✅ {$total} emplacements créés avec succès !\n";
        
        // Afficher les statistiques
        echo "\n📊 Statistiques :\n";
        echo "   - Distributeurs : " . Location::where('type', 'distributeur')->count() . "\n";
        echo "   - Installateurs : " . Location::where('type', 'installateur')->count() . "\n";
        echo "   - Showrooms : " . Location::where('type', 'showroom')->count() . "\n";
    }
}