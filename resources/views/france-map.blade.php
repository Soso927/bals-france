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

    </div>


    {{-- Tooltip : bulle d'information qui suit la souris au survol des départements --}}
    <div id="tooltip"></div>

    {{-- Pied de page du site (composant réutilisable) --}}
    @include('livewire.layout.footer')

    {{-- Logique JavaScript de la carte (chargé après le DOM pour accéder aux éléments HTML) --}}
    <script src="/js/france-map.js"></script>

</body>

</html>
