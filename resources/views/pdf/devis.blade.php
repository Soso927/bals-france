<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'dejavusans', sans-serif;
            font-size: 10px;
            color: #1e293b;
            background: #fff;
        }

        /* ── En-tête ── */
        .entete {
            background-color: #1a3a6b;
            color: white;
            padding: 16px 20px;
            width: 100%;
        }
        .entete-inner { width: 100%; border-collapse: collapse; }
        .entete-inner td { vertical-align: middle; }
        .entete-inner td.droite { text-align: right; width: 50%; }
        .logo-text { font-size: 24px; font-weight: bold; letter-spacing: 4px; color: white; }
        .sous-titre { font-size: 10px; margin-top: 3px; color: white; }
        .reference  { font-size: 15px; font-weight: bold; color: white; }
        .date-gen   { font-size: 9px; color: #93c5fd; margin-top: 3px; }
        /* mPDF ne supporte pas rgba() — couleur pleine à la place */
        .badge {
            background-color: #2d5a9e;
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* ── Corps ── */
        .corps { padding: 14px 4px 0 4px; }

        /* ── Sections ── */
        .section { margin-bottom: 12px; }
        .section-titre {
            background-color: #e8f0fb;
            border-left: 4px solid #1a3a6b;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1a3a6b;
            margin-bottom: 6px;
        }

        /* ── Grille contact / caractéristiques ── */
        table.grille { width: 100%; border-collapse: collapse; }
        table.grille td {
            padding: 5px 8px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }
        table.grille td.label {
            width: 22%;
            font-weight: bold;
            background-color: #f8fafc;
            color: #475569;
        }

        /* ── Tableaux prises / alimentation ── */
        table.tableau { width: 100%; border-collapse: collapse; }
        table.tableau td.th {
            background-color: #1a3a6b;
            color: white;
            padding: 5px 8px;
            font-size: 10px;
            font-weight: bold;
            text-align: left;
        }
        table.tableau td {
            padding: 5px 8px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
        }
        /* mPDF ne supporte pas nth-child — on applique le fond pair via inline style dans la vue */
        table.tableau td.pair { background-color: #f8fafc; }

        /* ── Observations ── */
        .obs {
            background-color: #fefce8;
            border: 1px solid #fde68a;
            padding: 8px 12px;
            font-style: italic;
            color: #78350f;
            font-size: 9px;
        }

        /* ── Mention légale ── */
        .mention {
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
            font-size: 8.5px;
            color: #94a3b8;
            text-align: center;
            margin-top: 8px;
        }
    </style>
</head>
<body>

{{-- ══════════════════════════════════════
     EN-TÊTE BALS
     Tableau HTML pour la mise en page — plus fiable que flexbox dans mPDF.
══════════════════════════════════════ --}}
<div class="entete">
    <table class="entete-inner">
        <tr>
            <td>
                <div class="logo-text">BALS</div>
                <div class="sous-titre">
                    Demande de Devis &mdash;
                    {{ ucfirst(str_replace('-', ' ', $devis->type_coffret)) }}
                </div>
            </td>
            <td class="droite">
                <div class="reference">Réf. {{ $devis->reference }}</div>
                <div class="date-gen">Généré le {{ $devis->created_at->format('d/m/Y à H:i') }}</div>
                <div style="margin-top:5px;"><span class="badge">{{ strtoupper($devis->type_coffret) }}</span></div>
            </td>
        </tr>
    </table>
</div>

{{-- ══════════════════════════════════════
     CORPS
══════════════════════════════════════ --}}
<div class="corps">

@php $d = $devis->donnees; @endphp

{{-- 01 · Contact --}}
<div class="section">
    <div class="section-titre">01 &middot; Informations de contact</div>
    <table class="grille">
        @if (!empty($d['societe']) || !empty($d['distributeur']))
        <tr>
            <td class="label">Société / Distributeur</td>
            <td>{{ $d['societe'] ?? $d['distributeur'] ?? '—' }}</td>
            <td class="label">Contact</td>
            <td>{{ $d['contact'] ?? $d['contact_distributeur'] ?? '—' }}</td>
        </tr>
        @endif
        @if (!empty($d['installateur']))
        <tr>
            <td class="label">Installateur</td>
            <td>{{ $d['installateur'] }}</td>
            <td class="label">Contact installateur</td>
            <td>{{ $d['contact_installateur'] ?? '—' }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Réf. affaire</td>
            <td>{{ $d['affaire'] ?? '—' }}</td>
            <td class="label">Téléphone</td>
            <td>{{ $d['telephone'] ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td colspan="3">{{ $d['email'] ?? '—' }}</td>
        </tr>
    </table>
</div>

{{-- 02 · Caractéristiques --}}
@if (!empty($d['montage']) || !empty($d['materiau']) || !empty($d['ip']))
<div class="section">
    <div class="section-titre">02 &middot; Caractéristiques générales</div>
    <table class="grille">
        @if (!empty($d['montage']))
        <tr>
            <td class="label">Type de montage</td>
            <td>{{ $d['montage'] }}</td>
            <td class="label">Matériau</td>
            <td>{{ $d['materiau'] ?? '—' }}</td>
        </tr>
        @endif
        @if (!empty($d['ip']))
        <tr>
            <td class="label">Indice de protection</td>
            <td>{{ $d['ip'] }}</td>
            <td class="label">Tension / Ampérage</td>
            <td>
                {{ $d['tension'] ?? '' }}
                @if (!empty($d['amp'])) &nbsp;&middot;&nbsp; {{ $d['amp'] }} @endif
                @if (!empty($d['pol'])) &nbsp;&middot;&nbsp; {{ $d['pol'] }} @endif
            </td>
        </tr>
        @endif
    </table>
</div>
@endif

{{-- 03 · Alimentation --}}
@if (!empty($d['alim']) && count($d['alim']) > 0)
<div class="section">
    <div class="section-titre">03 &middot; Alimentation</div>
    <table class="tableau">
        <tr>
            <td class="th">Type</td>
            <td class="th">Brochage</td>
            <td class="th" style="text-align:center;">Quantité</td>
            <td class="th" style="text-align:center;">Tension</td>
        </tr>
        @foreach ($d['alim'] as $i => $alim)
        @php $pair = ($i % 2 === 1) ? 'pair' : ''; @endphp
        <tr>
            <td class="{{ $pair }}">{{ $alim['type'] ?? '—' }}</td>
            <td class="{{ $pair }}">{{ $alim['brochage'] ?? '—' }}</td>
            <td class="{{ $pair }}" style="text-align:center; font-weight:bold;">{{ $alim['qte'] ?? 0 }}</td>
            <td class="{{ $pair }}" style="text-align:center;">{{ $alim['tension'] ?? '—' }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endif

{{-- 04 · Prises --}}
@if (!empty($d['prises']) && count($d['prises']) > 0)
<div class="section">
    <div class="section-titre">04 &middot; Prises de courant</div>
    <table class="tableau">
        <tr>
            <td class="th">Type</td>
            <td class="th">Brochage</td>
            <td class="th" style="text-align:center;">Quantité</td>
            <td class="th" style="text-align:center;">Tension</td>
        </tr>
        @foreach ($d['prises'] as $i => $prise)
        @php $pair = ($i % 2 === 1) ? 'pair' : ''; @endphp
        <tr>
            <td class="{{ $pair }}">{{ $prise['type'] ?? '—' }}</td>
            <td class="{{ $pair }}">{{ $prise['brochage'] ?? '—' }}</td>
            <td class="{{ $pair }}" style="text-align:center; font-weight:bold;">{{ $prise['qte'] ?? 0 }}</td>
            <td class="{{ $pair }}" style="text-align:center;">{{ $prise['tension'] ?? '—' }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endif

{{-- 05 · Protections --}}
@if (!empty($d['prot_tete']) || !empty($d['prot_prises']))
<div class="section">
    <div class="section-titre">05 &middot; Protections</div>
    <table class="grille">
        @if (!empty($d['prot_tete']))
        <tr>
            <td class="label">Protection de tête</td>
            <td colspan="3">{{ is_array($d['prot_tete']) ? implode(', ', $d['prot_tete']) : $d['prot_tete'] }}</td>
        </tr>
        @endif
        @if (!empty($d['prot_prises']))
        <tr>
            <td class="label">Protection des prises</td>
            <td colspan="3">{{ is_array($d['prot_prises']) ? implode(', ', $d['prot_prises']) : $d['prot_prises'] }}</td>
        </tr>
        @endif
    </table>
</div>
@endif

{{-- 06 · Observations --}}
@if (!empty($d['observations']))
<div class="section">
    <div class="section-titre">06 &middot; Observations</div>
    <div class="obs">{{ $d['observations'] }}</div>
</div>
@endif

{{-- Mention légale --}}
<div class="mention">
    Ce document est une demande de devis générée automatiquement. Il ne constitue pas un engagement contractuel.
    Notre équipe commerciale vous contactera sous 48h.
</div>

</div>

</body>
</html>
