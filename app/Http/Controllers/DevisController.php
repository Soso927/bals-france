<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
     * Reçoit le JSON du configurateur JS, sauvegarde le devis et retourne le PDF.
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'type_coffret'  => ['required', 'string', 'in:chantier,industrie,prise-industrielle,etage,evenementiel'],
            'donnees'       => ['required', 'array'],
            'donnees.email' => ['nullable', 'email', 'max:255'],
        ]);

        $devis = Devis::create([
            'type_coffret' => $request->type_coffret,
            'donnees'      => $request->donnees,
            'statut'       => 'nouveau',
        ]);

        $html = view('pdf.devis', compact('devis'))->render();

        $mpdf = $this->creerMpdf();
        $mpdf->SetHTMLFooter($this->pied($devis->reference));
        $mpdf->WriteHTML($html);

        $contenuPdf    = $mpdf->Output('', 'S');
        $cheminRelatif = "devis/{$devis->reference}.pdf";
        Storage::disk('local')->put($cheminRelatif, $contenuPdf);
        $devis->update(['pdf_path' => $cheminRelatif]);

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
