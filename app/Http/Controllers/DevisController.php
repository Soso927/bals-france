<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class DevisController extends Controller
{
    private function creerMpdf(): Mpdf
    {
        $defaultConfig     = (new ConfigVariables())->getDefaults();
        $defaultFontConfig = (new FontVariables())->getDefaults();

        return new Mpdf([
            'format'            => 'A4',
            'orientation'       => 'P',
            'margin_top'        => 10,
            'margin_right'      => 12,
            'margin_bottom'     => 20,
            'margin_left'       => 12,
            'default_font'      => 'dejavusans',
            'default_font_size' => 10,
            'tempDir'           => storage_path('app/mpdf-temp'),
            'fontDir'           => $defaultConfig['fontDir'],
            'fontdata'          => $defaultFontConfig['fontdata'],
        ]);
    }

    private function pied(string $reference): string
    {
        return '
            <table width="100%" style="border-top:2px solid #1a3a6b; font-size:9px; color:#94a3b8; padding-top:4px;">
                <tr>
                    <td style="text-align:left;"><strong style="color:#1a3a6b;">BALS</strong></td>
                    <td style="text-align:center;">Demande de devis n° ' . $reference . '</td>
                    <td style="text-align:right;">Page {PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ';
    }

    /**
 * Reçoit le JSON du configurateur JS et retourne le PDF directement,
 * sans passer par la base de données.
 */
public function store(Request $request): \Illuminate\Http\Response
{
    $request->validate([
        'type_coffret'  => ['required', 'string', 'in:chantier,industrie,prise-industrielle,etage,evenementiel'],
        'donnees'       => ['required', 'array'],
        'donnees.email' => ['nullable', 'email', 'max:255'],
    ]);

    // On génère une référence unique basée sur la date et un identifiant aléatoire,
    // exactement comme le ferait la base de données, mais sans y toucher.
    $reference = 'DEV-' . strtoupper(date('Ymd')) . '-' . strtoupper(substr(uniqid(), -5));

    // On crée un objet générique qui se comporte comme un modèle Eloquent
    // aux yeux de la vue PDF — même structure, zéro base de données.
    $devis = (object) [
        'type_coffret' => $request->type_coffret,
        'donnees'      => $request->donnees,
        'reference'    => $reference,
        'statut'       => 'nouveau',
    ];

    // On génère le PDF exactement comme avant — la vue ne voit aucune différence.
    $html = view('pdf.devis', compact('devis'))->render();

    $mpdf = $this->creerMpdf();
    $mpdf->SetHTMLFooter($this->pied($devis->reference));
    $mpdf->WriteHTML($html);

    $contenuPdf = $mpdf->Output('', 'S');

    // On retourne directement le PDF au navigateur sans rien stocker.
    return response($contenuPdf, 200, [
        'Content-Type'        => 'application/pdf',
        'Content-Disposition' => "attachment; filename=\"Devis-{$devis->reference}.pdf\"",
    ]);
}
    /**
     * Télécharge ou régénère le PDF d'un devis depuis l'admin.
     */
    public function exportPdf(Devis $devis): \Illuminate\Http\Response
    {
        if ($devis->statut === 'nouveau') {
            $devis->update(['statut' => 'lu']);
        }

        $html = view('pdf.devis', compact('devis'))->render();

        $mpdf = $this->creerMpdf();
        $mpdf->SetHTMLFooter($this->pied($devis->reference));
        $mpdf->WriteHTML($html);

        $pdf = $mpdf->Output('', 'S');

        return response($pdf, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"Devis-{$devis->reference}.pdf\"",
        ]);
    }
}
