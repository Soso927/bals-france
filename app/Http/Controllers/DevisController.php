<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DevisController extends Controller
{
    /**
     * Reçoit le JSON du configurateur JS, sauvegarde le devis et retourne le PDF.
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'type_coffret' => ['required', 'string', 'in:chantier,industrie,prise-industrielle,etage,evenementiel'],
            'donnees'      => ['required', 'array'],
        ]);

        $devis = Devis::create([
            'type_coffret' => $request->type_coffret,
            'donnees'      => $request->donnees,
            'statut'       => 'nouveau',
        ]);

        $pdf = Pdf::loadView('pdf.devis', compact('devis'))
                  ->setPaper('A4', 'portrait');

        $chemin = "devis/{$devis->reference}.pdf";
        Storage::disk('local')->put($chemin, $pdf->output());
        $devis->update(['pdf_path' => $chemin]);

        return $pdf->download("Devis-{$devis->reference}.pdf");
    }

    /**
     * Télécharge ou régénère le PDF d'un devis depuis l'admin.
     */
    public function exportPdf(Devis $devis): \Illuminate\Http\Response
    {
        if ($devis->statut === 'nouveau') {
            $devis->update(['statut' => 'lu']);
        }

        return Pdf::loadView('pdf.devis', compact('devis'))
                  ->setPaper('A4', 'portrait')
                  ->download("Devis-{$devis->reference}.pdf");
    }
}
