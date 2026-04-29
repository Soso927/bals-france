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
 * TODO pour aller plus loin :
 *   - Installer DomPDF : composer require barryvdh/laravel-dompdf
 *   - Installer PhpSpreadsheet : composer require maatwebsite/excel
 *   - Créer un modèle Devis et une migration pour stocker les configs
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

    /**
     * Générer un devis au format PDF.
     *
     * Route : POST /configurateur/generer-pdf
     * Nom   : configurateur.pdf
     *
     * À implémenter avec : composer require barryvdh/laravel-dompdf
     *
     * @param  Request  $request
     */
    public function generatePDF(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'                 => 'required|string|in:chantier,etage,industrie,evenementiel,prise-industrielle',
            'data'                 => 'required|array',
            'data.distributeur'    => 'nullable|string|max:255',
            'data.contactDist'     => 'nullable|string|max:255',
            'data.installateur'    => 'nullable|string|max:255',
            'data.affaire'         => 'nullable|string|max:255',
            'data.email'           => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // TODO : implémenter avec DomPDF
        // use Barryvdh\DomPDF\Facade\Pdf;
        // $pdf = Pdf::loadView('pdf.devis', ['data' => $request->data, 'type' => $request->type]);
        // return $pdf->download('devis-bals-' . time() . '.pdf');

        return response()->json([
            'success' => false,
            'message' => 'Génération PDF à implémenter (installer barryvdh/laravel-dompdf)',
        ], 501);
    }

    /**
     * Sauvegarder un devis en base de données.
     *
     * Route : POST /configurateur/sauvegarder
     * Nom   : configurateur.sauvegarder
     *
     * À implémenter : créer une table `devis` via une migration Laravel.
     *
     * @param  Request  $request
     */
    public function saveQuote(Request $request)
    {
        // TODO : implémenter la sauvegarde
        // php artisan make:model Devis -m
        // $devis = Devis::create(['type' => $request->type, 'data' => json_encode($request->data)]);

        return response()->json([
            'success' => false,
            'message' => 'Sauvegarde à implémenter (créer le modèle Devis)',
        ], 501);
    }

    /**
     * Soumettre le configurateur et générer un PDF téléchargeable.
     *
     * Route : POST /configurateur/soumettre
     * Nom   : configurateur.soumettre
     *
     * @param  Request  $request
     */
    public function soumettre(Request $request)
    {
        // TODO : générer un vrai PDF avec barryvdh/laravel-dompdf
        // Pour l'instant on retourne un JSON de confirmation
        return response()->json([
            'success' => false,
            'message' => 'Génération PDF à implémenter (installer barryvdh/laravel-dompdf)',
        ], 501);
    }

    /**
     * Envoyer un devis par email.
     *
     * Route : POST /configurateur/envoyer-devis
     * Nom   : configurateur.email
     *
     * À implémenter avec Laravel Mail + un Mailable dédié.
     *
     * @param  Request  $request
     */
    public function sendQuote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'type'  => 'required|string',
            'data'  => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // TODO : implémenter l'envoi email
        // use Illuminate\Support\Facades\Mail;
        // use App\Mail\DevisMail;
        // Mail::to($request->email)->send(new DevisMail($request->data));

        return response()->json([
            'success' => false,
            'message' => 'Envoi email à implémenter (créer un Mailable Laravel)',
        ], 501);
    }
}
