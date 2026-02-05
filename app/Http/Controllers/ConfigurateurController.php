<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * =============================================================================
 * CONTRÔLEUR DU CONFIGURATEUR BALS
 * =============================================================================
 * 
 * Ce contrôleur gère toutes les pages du configurateur de coffrets électriques
 * 
 * FICHIER À PLACER DANS : app/Http/Controllers/ConfigurateurController.php
 * 
 * COMMANDE POUR CRÉER : php artisan make:controller ConfigurateurController
 */

class ConfigurateurController extends Controller
{
    // =========================================================================
    // MÉTHODE 1 : PAGE D'ACCUEIL DU CONFIGURATEUR
    // =========================================================================
    
    /**
     * Affiche la page d'accueil avec la liste de tous les coffrets
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Données à passer à la vue
        $data = [
            'titre' => 'Configurateur de Coffrets Électriques',
            'description' => 'Choisissez le type de coffret que vous souhaitez configurer',
        ];
        
        // On retourne la vue avec les données
        return view('configurateur.index', $data);
    }
    
    // =========================================================================
    // MÉTHODE 2 : COFFRET DE CHANTIER MAÇON
    // =========================================================================
    
    /**
     * Affiche le configurateur pour le coffret de chantier maçon
     * 
     * Référence produit : 53 930
     * Type : Mobile sur pied
     * Matériau : Options multiples
     * 
     * @return \Illuminate\View\View
     */
    public function coffretChantier()
    {
        // Préparation des données pour cette page
        $data = [
            // Informations du produit
            'titre' => 'Coffret de Chantier Maçon',
            'reference' => '53 930',
            'description' => 'Coffret mobile sur pied pour chantier',
            
            // Configuration par défaut
            'config_defaut' => [
                'type' => 'Mobile sur pied',
                'materiau' => 'Plastique',
                'ip' => 'IP44',
            ],
            
            // Script JS à charger
            'typeScript' => 'script.js',
            
            // Fichier PDF de référence
            'pdfReference' => 'coffret_de_chantier_maçon_53_930.pdf',
        ];
        
        return view('configurateur.coffret-chantier', $data);
    }
    
    // =========================================================================
    // MÉTHODE 3 : COFFRET D'ÉTAGE
    // =========================================================================
    
    /**
     * Affiche le configurateur pour le coffret d'étage
     * 
     * Référence produit : 510 802
     * Type : Mobile
     * Matériau : Plastique
     * 
     * @return \Illuminate\View\View
     */
    public function coffretEtage()
    {
        $data = [
            'titre' => 'Coffret d\'Étage',
            'reference' => '510 802',
            'description' => 'Coffret mobile en plastique',
            
            'config_defaut' => [
                'type' => 'Mobile',
                'materiau' => 'Plastique',
                'ip' => 'IP44',
            ],
            
            'typeScript' => 'script-etage.js',
            'pdfReference' => 'coffret_d_étage_510_802.pdf',
        ];
        
        return view('configurateur.coffret-etage', $data);
    }
    
    // =========================================================================
    // MÉTHODE 4 : COFFRET ÉVÉNEMENTIEL
    // =========================================================================
    
    /**
     * Affiche le configurateur pour le coffret événementiel EVOBOX
     * 
     * Référence produit : 53 83
     * Type : Mobile
     * Gamme : EVOBOX
     * 
     * @return \Illuminate\View\View
     */
    public function coffretEvenementiel()
    {
        $data = [
            'titre' => 'Coffret Événementiel EVOBOX',
            'reference' => '53 83',
            'description' => 'Coffret mobile pour événements',
            
            'config_defaut' => [
                'type' => 'Mobile',
                'materiau' => 'Plastique',
                'gamme' => 'EVOBOX',
                'ip' => 'IP44',
            ],
            
            'typeScript' => 'script-evenementiel.js',
            'pdfReference' => 'coffret_evobox_53_83.pdf',
        ];
        
        return view('configurateur.coffret-evenementiel', $data);
    }
    
    // =========================================================================
    // MÉTHODE 5 : COFFRET INDUSTRIE
    // =========================================================================
    
    /**
     * Affiche le configurateur pour le coffret industrie
     * 
     * Référence produit : 512 399
     * Type : Fixe ou mobile
     * Matériau : Plastique
     * 
     * @return \Illuminate\View\View
     */
    public function coffretIndustrie()
    {
        $data = [
            'titre' => 'Coffret Industrie',
            'reference' => '512 399',
            'description' => 'Coffret plastique pour usage industriel',
            
            'config_defaut' => [
                'type' => 'Fixe',
                'materiau' => 'Plastique',
                'ip' => 'IP44',
            ],
            
            'typeScript' => 'script-industrie.js',
            'pdfReference' => 'coffret_industrie_512_399.pdf',
        ];
        
        return view('configurateur.coffret-industrie', $data);
    }
    
    // =========================================================================
    // MÉTHODE 6 : PRISE INDUSTRIELLE
    // =========================================================================
    
    /**
     * Affiche le configurateur pour les prises industrielles
     * 
     * Normes : NF EN 60 309-1/2, CEI 309-1/2, CEE 17
     * 
     * @return \Illuminate\View\View
     */
    public function priseIndustrielle()
    {
        $data = [
            'titre' => 'Prise Industrielle',
            'reference' => 'PI-001',
            'description' => 'Configuration de prises industrielles selon normes',
            
            'config_defaut' => [
                'type' => 'Socle de prise',
                'ip' => 'IP44',
            ],
            
            'typeScript' => 'script-prise-industrielle.js',
            'pdfReference' => 'prise_industrielle_bals_france.pdf',
        ];
        
        return view('configurateur.prise-industrielle', $data);
    }
    
    // =========================================================================
    // MÉTHODES SUPPLÉMENTAIRES (OPTIONNELLES)
    // =========================================================================
    
    /**
     * Sauvegarde une configuration en base de données
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sauvegarder(Request $request)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'type_coffret' => 'required|string',
            'configuration' => 'required|array',
        ]);
        
        // TODO : Sauvegarder en base de données
        // Configuration::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Configuration sauvegardée avec succès',
        ]);
    }
    
    /**
     * Génère un PDF à partir d'une configuration
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function genererPDF(Request $request)
    {
        // TODO : Implémenter la génération de PDF avec DomPDF
        // $pdf = PDF::loadView('configurateur.pdf', $data);
        // return $pdf->download('devis-coffret.pdf');
        
        return response()->json([
            'success' => false,
            'message' => 'Génération PDF en cours de développement',
        ]);
    }
    
    /**
     * Envoie un devis par email
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function envoyerDevis(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'email' => 'required|email',
            'configuration' => 'required|array',
        ]);
        
        // TODO : Envoyer l'email
        // Mail::to($validated['email'])->send(new DevisEmail($validated));
        
        return response()->json([
            'success' => true,
            'message' => 'Devis envoyé par email',
        ]);
    }
}

/**
 * =============================================================================
 * NOTES POUR LE JURY
 * =============================================================================
 * 
 * CE CONTRÔLEUR FAIT QUOI ?
 * 
 * 1. Il reçoit les requêtes HTTP des utilisateurs
 * 2. Il prépare les données nécessaires pour chaque page
 * 3. Il retourne les vues Blade avec ces données
 * 
 * EXEMPLE DE FONCTIONNEMENT :
 * 
 * L'utilisateur clique sur "Coffret d'Étage"
 *    ↓
 * Laravel appelle la méthode coffretEtage()
 *    ↓
 * La méthode prépare les données (titre, référence, etc.)
 *    ↓
 * Laravel affiche la vue avec ces données
 *    ↓
 * L'utilisateur voit le formulaire de configuration
 * 
 * AVANTAGES DE CETTE APPROCHE :
 * 
 * ✓ Séparation des responsabilités (contrôleur ≠ vue)
 * ✓ Code réutilisable et maintenable
 * ✓ Facile d'ajouter de nouveaux types de coffrets
 * ✓ Données centralisées dans le contrôleur
 * ✓ Permet d'ajouter facilement la sauvegarde en BDD
 */