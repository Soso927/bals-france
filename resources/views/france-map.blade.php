{{--
    france-map.blade.php
    ─────────────────────────────────────────────────────────────
    Vue : Carte interactive du réseau commercial BALS France.

    Route associée : GET /france-map  (MapController@index)

    Ce fichier contient uniquement la structure HTML (le squelette
    de la page). Les styles et le JavaScript sont dans des fichiers
    séparés pour garder le code lisible et maintenable :

      Styles     → public/css/france-map.css
      JavaScript → public/js/france-map.js

    Fonctionnement :
      - D3.js dessine la carte SVG à partir de /data/france.json
      - Un clic sur un département affiche les contacts de la région
      - Les contacts sont lus depuis localStorage (gérés par le back-office)
      - Le back-office est accessible via le lien "Gérer les agents"
--}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte interactive — Bals France</title>

    {{-- Police Exo 2 (Google Fonts) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS (framework utilitaire pour le style rapide) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- D3.js v7 (bibliothèque de visualisation de données, utilisée pour dessiner la carte SVG) --}}
    {{-- ⚠ Doit être chargé AVANT france-map.js car il expose la variable globale `d3` --}}
    <script src="https://cdn.jsdelivr.net/npm/d3@7"></script>

    {{-- Styles spécifiques à cette page --}}
    <link rel="stylesheet" href="/css/france-map.css">
</head>

<body>

    {{-- Barre bleue→rouge (identité visuelle BALS) --}}
    <div class="brand-bar"></div>

    {{-- En-tête du site (composant réutilisable inclus depuis livewire/layout/header.blade.php) --}}
    @include('livewire.layout.header')


    <div class="page-wrapper">

        {{-- ══════════════ EN-TÊTE DE LA PAGE ══════════════ --}}
        <header class="page-header">

            {{-- Label "RÉSEAU COMMERCIAL" --}}
            <div class="eyebrow">Réseau commercial</div>

            {{-- Titre principal --}}
            <h1>Notre réseau d'agents <span>commerciaux</span></h1>

            {{-- Sous-titre et numéro de téléphone siège --}}
            <p class="tagline">
                Cliquez sur un département pour afficher l'agent local de votre région.
                Pour toute question&nbsp;: <a href="tel:+33164786080">01&nbsp;64&nbsp;78&nbsp;60&nbsp;80</a>
            </p>


        {{-- ══════════════ GRILLE : CARTE + PANNEAU LATÉRAL ══════════════ --}}
        <div class="map-grid">

            {{-- COLONNE GAUCHE : Carte de France (rendue par D3.js) --}}
            <div class="map-card">
                <div class="map-card-header">
                    <span class="map-card-title">France métropolitaine</span>
                    {{-- Le contenu de ce badge est mis à jour par JavaScript --}}
                    <span class="map-card-badge" id="region-count">— régions</span>
                </div>
                {{-- Conteneur vide — D3.js y injectera le SVG de la carte --}}
                <div id="map-container"></div>
                <p class="map-hint">Cliquez sur un département · Double-clic pour réinitialiser</p>
            </div>


            {{-- COLONNE DROITE : Panneau latéral --}}
            <div class="side-panel">

                {{-- Info-box : affiche les contacts de la région cliquée.
                     Contenu mis à jour par selectRegion() dans france-map.js --}}
                <div class="info-box" id="info-box">
                    <div class="placeholder">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>Cliquez sur un département<br>pour afficher l'agent local</span>
                    </div>
                </div>

                {{-- Bouton de réinitialisation (caché par défaut, affiché par JS) --}}
                <button class="reset-btn" id="reset-btn" onclick="resetMap()">
                    ↺ &nbsp; Réinitialiser la sélection
                </button>

                {{-- Liste de toutes les régions (générée par JavaScript) --}}
                <div class="region-list-card">
                    <div class="region-list-header">Toutes les régions</div>
                    <ul class="region-list" id="region-list"></ul>
                </div>

            </div>
        </div>

        {{-- ══════════════ SECTION CONFIGURATEURS DE DEVIS ══════════════ --}}
        <section class="configurateurs-section">
            <div class="eyebrow">Devis personnalisé</div>
            <h2 class="configurateurs-title">Configurez votre <span>devis</span> en ligne</h2>
            <p class="configurateurs-sub">Sélectionnez le type de coffret adapté à votre projet et obtenez un devis personnalisé en quelques minutes.</p>

            <div class="configurateurs-grid">

                {{-- Coffret Chantier --}}
                <a href="{{ route('configurateur.chantier') }}" class="config-card">
                    <div class="config-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="config-name">Coffret Chantier</div>
                    <div class="config-desc">Distribution électrique mobile ou fixe pour chantiers BTP.</div>
                    <span class="config-cta">Configurer →</span>
                </a>

                {{-- Coffret d'Étage --}}
                <a href="{{ route('configurateur.etage') }}" class="config-card">
                    <div class="config-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div class="config-name">Coffret d'Étage</div>
                    <div class="config-desc">Distribution par niveau pour immeubles et bâtiments tertiaires.</div>
                    <span class="config-cta">Configurer →</span>
                </a>

                {{-- Coffret Industrie --}}
                <a href="{{ route('configurateur.industrie') }}" class="config-card">
                    <div class="config-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="config-name">Coffret Industrie</div>
                    <div class="config-desc">Solutions robustes pour environnements industriels exigeants.</div>
                    <span class="config-cta">Configurer →</span>
                </a>

                {{-- Coffret Événementiel --}}
                <a href="{{ route('configurateur.evenementiel') }}" class="config-card">
                    <div class="config-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div class="config-name">Coffret Événementiel</div>
                    <div class="config-desc">Distribution électrique pour spectacles, concerts et événements.</div>
                    <span class="config-cta">Configurer →</span>
                </a>

                {{-- Prise Industrielle --}}
                <a href="{{ route('configurateur.prise-industrielle') }}" class="config-card">
                    <div class="config-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="config-name">Prise Industrielle</div>
                    <div class="config-desc">Prises CEE et connecteurs pour applications industrielles.</div>
                    <span class="config-cta">Configurer →</span>
                </a>

            </div>
        </section>

    </div>


    {{-- Tooltip : bulle d'information qui suit la souris au survol des départements --}}
    <div id="tooltip"></div>

    
    {{-- Logique JavaScript de la carte (chargé après le DOM pour accéder aux éléments HTML) --}}
    <script src="/js/france-map.js"></script>

</body>

</html>
