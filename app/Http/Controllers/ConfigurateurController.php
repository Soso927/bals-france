<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Contrôleur du Configurateur BALS
 * 
 * Gère l'affichage des différents configurateurs et la génération de devis
 */
class ConfigurateurController extends Controller
{
    /**
     * Affiche le configurateur de coffret de chantier
     * 
     * @return \Illuminate\View\View
     */
    public function chantier()
    {
        return view('configurateur.chantier', [
            'pageTitle' => 'Configurateur Coffret de Chantier',
            'type' => 'chantier'
        ]);
    }

    /**
     * Affiche le configurateur de coffret d'étage
     * 
     * @return \Illuminate\View\View
     */
    public function etage()
    {
        return view('configurateur.etage', [
            'pageTitle' => 'Configurateur Coffret d\'Étage',
            'type' => 'etage'
        ]);
    }

    /**
     * Affiche le configurateur de coffret industrie
     * 
     * @return \Illuminate\View\View
     */
    public function industrie()
    {
        return view('configurateur.industrie', [
            'pageTitle' => 'Configurateur Coffret Industrie',
            'type' => 'industrie'
        ]);
    }

    /**
     * Affiche le configurateur de coffret événementiel
     * 
     * @return \Illuminate\View\View
     */
    public function evenementiel()
    {
        return view('configurateur.evenementiel', [ 
            'pageTitle' => 'Configurateur Coffret Evenementiel',
            'type' => 'evenementiel'
        ]);
    }

    /**
     * Affiche le configurateur de prise industrielle
     * 
     * @return \Illuminate\View\View
     */
    public function priseIndustrielle()
    {
        return view('configurateur.prise-industrielle', [
            'pageTitle' => 'Configurateur Prise Industrielle',
            'type' => 'prise-industrielle'
        ]);
    }

    /**
     * Génère un devis au format PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function generatePDF(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:chantier,etage,industrie,evenementiel,prise-industrielle',
            'data' => 'required|array',
            'data.distributeur' => 'nullable|string|max:255',
            'data.contactDist' => 'nullable|string|max:255',
            'data.installateur' => 'nullable|string|max:255',
            'data.affaire' => 'nullable|string|max:255',
            'data.email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->input('data');
        $type = $request->input('type');

        // TODO: Implémenter la génération de PDF
        // 
        // Installation de DomPDF :
        // composer require barryvdh/laravel-dompdf
        //
        // Exemple d'utilisation :
        // use Barryvdh\DomPDF\Facade\Pdf;
        // 
        // $pdf = Pdf::loadView('pdf.devis', [
        //     'data' => $data,
        //     'type' => $type,
        //     'generatedAt' => now()
        // ]);
        // 
        // return $pdf->download('devis-bals-' . time() . '.pdf');

        // Réponse temporaire
        return response()->json([
            'success' => false,
            'message' => 'La génération de PDF doit être implémentée avec DomPDF ou Snappy',
            'data' => [
                'type' => $type,
                'received' => array_keys($data)
            ]
        ], 501);
    }

    /**
     * Génère un devis au format Excel
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function generateExcel(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:chantier,etage,industrie,evenementiel,prise-industrielle',
            'data' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->input('data');
        $type = $request->input('type');

        // TODO: Implémenter la génération Excel
        // 
        // Installation de PhpSpreadsheet :
        // composer require maatwebsite/excel
        //
        // Création d'une classe Export :
        // php artisan make:export DevisExport --model=Devis
        //
        // Exemple d'utilisation :
        // use Maatwebsite\Excel\Facades\Excel;
        // use App\Exports\DevisExport;
        // 
        // return Excel::download(
        //     new DevisExport($data, $type),
        //     'devis-bals-' . time() . '.xlsx'
        // );

        // Réponse temporaire
        return response()->json([
            'success' => false,
            'message' => 'La génération Excel doit être implémentée avec PhpSpreadsheet',
            'data' => [
                'type' => $type,
                'received' => array_keys($data)
            ]
        ], 501);
    }

    /**
     * Sauvegarde un devis en base de données (optionnel)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveQuote(Request $request)
    {
        // TODO: Implémenter la sauvegarde en base de données
        // 
        // 1. Créer une migration :
        // php artisan make:migration create_devis_table
        //
        // 2. Créer un modèle :
        // php artisan make:model Devis
        //
        // 3. Sauvegarder :
        // $devis = Devis::create([
        //     'type' => $request->input('type'),
        //     'data' => json_encode($request->input('data')),
        //     'user_id' => auth()->id(), // si authentification
        // ]);

        return response()->json([
            'success' => false,
            'message' => 'Sauvegarde à implémenter'
        ], 501);
    }

    /**
     * Liste tous les devis (optionnel)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function listQuotes()
    {
        // TODO: Implémenter la récupération des devis
        // 
        // $devis = Devis::where('user_id', auth()->id())
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);
        //
        // return response()->json($devis);

        return response()->json([
            'success' => false,
            'message' => 'Liste des devis à implémenter'
        ], 501);
    }
}