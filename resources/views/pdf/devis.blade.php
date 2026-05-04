<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    @include('pdf._style')
</head>
<body>

{{-- EN-TÊTE --}}
<div class="entete">
    <table>
        <tr>
            <td>
                <div class="logo-text">BALS</div>
                <div class="sous-titre">
                    Demande de Devis &mdash;
                    {{ ucfirst(str_replace('-', ' ', $devis->type_coffret)) }}
                </div>
            </td>
            <td class="col-droite">
                <div class="reference">Réf. {{ $devis->reference }}</div>
                <div class="date-gen">Généré le {{ $devis->created_at->format('d/m/Y à H:i') }}</div>
                <div><span class="badge">{{ strtoupper($devis->type_coffret) }}</span></div>
            </td>
        </tr>
    </table>
</div>

{{-- CORPS --}}
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
                @if (!empty($d['amp'])) &nbsp;·&nbsp; {{ $d['amp'] }} @endif
                @if (!empty($d['pol'])) &nbsp;·&nbsp; {{ $d['pol'] }} @endif
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
            <th>Type</th>
            <th>Brochage</th>
            <th style="text-align:center;">Quantité</th>
            <th style="text-align:center;">Tension</th>
        </tr>
        @foreach ($d['alim'] as $alim)
        <tr>
            <td>{{ $alim['type'] ?? '—' }}</td>
            <td>{{ $alim['brochage'] ?? '—' }}</td>
            <td style="text-align:center;font-weight:bold;">{{ $alim['qte'] ?? 0 }}</td>
            <td style="text-align:center;">{{ $alim['tension'] ?? '—' }}</td>
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
            <th>Type</th>
            <th>Brochage</th>
            <th style="text-align:center;">Quantité</th>
            <th style="text-align:center;">Tension</th>
        </tr>
        @foreach ($d['prises'] as $prise)
        <tr>
            <td>{{ $prise['type'] ?? '—' }}</td>
            <td>{{ $prise['brochage'] ?? '—' }}</td>
            <td style="text-align:center;font-weight:bold;">{{ $prise['qte'] ?? 0 }}</td>
            <td style="text-align:center;">{{ $prise['tension'] ?? '—' }}</td>
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
            <td>{{ is_array($d['prot_tete']) ? implode(', ', $d['prot_tete']) : $d['prot_tete'] }}</td>
        </tr>
        @endif
        @if (!empty($d['prot_prises']))
        <tr>
            <td class="label">Protection des prises</td>
            <td>{{ is_array($d['prot_prises']) ? implode(', ', $d['prot_prises']) : $d['prot_prises'] }}</td>
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

{{-- PIED DE PAGE --}}
<div class="pied">
    <strong>BALS</strong> &middot; Demande de devis n° {{ $devis->reference }} &middot; {{ now()->format('Y') }}
</div>

</body>
</html>
