<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * ConfigurateurController
 *
 * Contrôleur responsable du configurateur de coffrets électriques BALS.
 *
 * Ce configurateur permet à un client de composer son coffret personnalisé
 * (chantier, étage, événementiel, industrie, prise industrielle) et d'obtenir
 * un devis.
 *
 * Méthodes d'affichage (GET) : index, chantier, etage, evenementiel, industrie, priseIndustrielle
 * Méthodes de traitement (POST) : generatePDF, saveQuote, sendQuote
 *

 */
class ConfigurateurController extends Controller
{
    /**
     * Page d'accueil du configurateur.
     * Affiche la liste des 5 types de coffrets disponibles.
     *
     * Route : GET /configurateur
     * Nom   : configurateur.index
     */
    public function index()
    {
        return view('configurateur.index');
    }

    /**
     * Configurateur — Coffret de Chantier Maçon (réf. 53 930).
     *
     * Route : GET /configurateur/chantier
     * Nom   : configurateur.chantier
     */
    public function chantier()
    {
        return view('configurateur.chantier', [
            'pageTitle' => 'Configurateur Coffret de Chantier',
            'type'      => 'chantier',
        ]);
    }

    /**
     * Configurateur — Coffret d'Étage (réf. 510 802).
     *
     * Route : GET /configurateur/etage
     * Nom   : configurateur.etage
     */
    public function etage()
    {
        return view('configurateur.etage', [
            'pageTitle' => 'Configurateur Coffret d\'Étage',
            'type'      => 'etage',
        ]);
    }

    /**
     * Configurateur — Coffret Événementiel EVOBOX (réf. 53 83).
     *
     * Route : GET /configurateur/coffret-evenementiel
     * Nom   : configurateur.evenementiel
     */
    public function evenementiel()
    {
        return view('configurateur.evenementiel', [
            'pageTitle' => 'Configurateur Coffret Événementiel',
            'type'      => 'evenementiel',
        ]);
    }

    /**
     * Configurateur — Coffret Industrie (réf. 512 399).
     *
     * Route : GET /configurateur/coffret-industrie
     * Nom   : configurateur.industrie
     */
    public function industrie()
    {
        return view('configurateur.industrie', [
            'pageTitle' => 'Configurateur Coffret Industrie',
            'type'      => 'industrie',
        ]);
    }

    /**
     * Configurateur — Prise Industrielle.
     *
     * Route : GET /configurateur/prise-industrielle
     * Nom   : configurateur.prise-industrielle
     */
    public function priseIndustrielle()
    {
        return view('configurateur.prise-industrielle', [
            'pageTitle' => 'Configurateur Prise Industrielle',
            'type'      => 'prise-industrielle',
        ]);
    }

    // =========================================================================
    // ROUTES POST — traitements de formulaires
    // =========================================================================

   
}
