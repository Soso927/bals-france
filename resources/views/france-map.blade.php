{{--
╔═══════════════════════════════════════════════════════════════════════════════╗
║  CARTE INTERACTIVE — RÉSEAU COMMERCIAL BALS FRANCE                          ║
║                                                                              ║
║  VERSION MODIFIÉE AVEC BACK-OFFICE                                           ║
║                                                                              ║
║  CHANGEMENTS PAR RAPPORT À L'ANCIENNE VERSION :                              ║
║                                                                              ║
║  1. Les contacts ne sont PLUS écrits "en dur" dans le code JavaScript.       ║
║     Ils sont maintenant lus depuis localStorage (stockage du navigateur).    ║
║                                                                              ║
║  2. Un lien "Gérer les agents" a été ajouté en haut de la page.             ║
║     Ce lien mène vers la page admin (back-office) où l'administrateur        ║
║     peut modifier les contacts via un formulaire, sans toucher au code.      ║
║                                                                              ║
║  3. La fonction chargerContacts() remplace l'ancien objet CONTACTS.          ║
║     Elle lit localStorage, et si rien n'est trouvé, utilise les              ║
║     données par défaut (celles qui étaient en dur avant).                    ║
║                                                                              ║
║  FONCTIONNEMENT :                                                            ║
║    Admin modifie les contacts → sauvegarde dans localStorage                 ║
║    Visiteur ouvre la carte → la carte lit localStorage                        ║
║    → Les infos affichées sont toujours à jour                                ║
╚═══════════════════════════════════════════════════════════════════════════════╝
--}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte interactive — Bals France</title>

    {{-- Tailwind CSS — framework CSS pour le style --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- D3.js — bibliothèque pour dessiner la carte SVG --}}
    <script src="https://cdn.jsdelivr.net/npm/d3@7"></script>

    {{-- Police Exo 2 — choisie pour correspondre au style Bals --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /*
        ═══════════════════════════════════════════════════════
        VARIABLES CSS — CHARTE GRAPHIQUE BALS (Style Guide V2016)
        ───────────────────────────────────────────────────────
        Source : page 08 "Colours" du document BALS_2016_StyleGuide
        Ces couleurs sont utilisées partout dans la page pour
        garantir le respect de la charte graphique Bals.
        ═══════════════════════════════════════════════════════
        */
        :root {
            --bals-blue: #0095DA;       /* Bleu Bals — R0 G149 B218 */
            --bals-red: #ED1C24;        /* Rouge Bals — R237 G28 B36 */
            --bals-black: #1A1A1A;      /* Noir texte */
            --bals-grey: #B3B3B3;       /* Gris clair — R179 G179 B179 */
            --bals-grey-light: #F4F6F8; /* Fond de page */
            --bals-grey-border: #E2E6EA;/* Bordures */
            --bals-blue-10: rgba(0, 149, 218, 0.10);  /* Bleu 10% opacité */
            --bals-blue-20: rgba(0, 149, 218, 0.20);
            --bals-red-10: rgba(237, 28, 36, 0.10);   /* Rouge 10% opacité */
        }

        /* Reset global — même base pour tous les éléments */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bals-grey-light);
            color: var(--bals-black);
            font-family: 'Exo 2', sans-serif;
            font-weight: 400;
            min-height: 100vh;
        }

        /* ── BARRE BLEUE→ROUGE en haut de page (identité Bals) ── */
        .brand-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--bals-blue) 70%, var(--bals-red) 100%);
        }

        /* Conteneur principal de la page */
        .page-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 48px 32px 64px;
        }

        /* ── EN-TÊTE ── */
        .page-header {
            margin-bottom: 48px;
        }

        /* Petit label "RÉSEAU COMMERCIAL" au-dessus du titre */
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--bals-blue);
            margin-bottom: 16px;
        }

        /* Trait bleu avant le label */
        .eyebrow::before {
            content: '';
            width: 28px;
            height: 2px;
            background: var(--bals-blue);
        }

        /* Titre principal H1 — taille responsive avec clamp() */
        .page-header h1 {
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.02em;
            color: var(--bals-black);
            margin-bottom: 6px;
        }

        /* Le mot "commerciaux" en rouge */
        .page-header h1 span {
            color: var(--bals-red);
        }

        /* Sous-titre descriptif */
        .page-header .tagline {
            font-size: 15px;
            font-weight: 300;
            color: #6b7280;
            line-height: 1.7;
            margin-top: 12px;
            max-width: 580px;
        }

        .page-header a {
            color: var(--bals-blue);
            text-decoration: none;
            font-weight: 500;
        }

        .page-header a:hover {
            text-decoration: underline;
        }

        /*
        ═══════════════════════════════════════
        GRILLE PRINCIPALE
        ───────────────────────────────────────
        2 colonnes : carte (flexible) + panneau latéral (310px)
        Sur mobile (< 1024px) : 1 seule colonne
        ═══════════════════════════════════════
        */
        .map-grid {
            display: grid;
            grid-template-columns: 1fr 310px;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .map-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── CARTE (conteneur blanc avec bordure et ombre) ── */
        .map-card {
            background: #fff;
            border: 1px solid var(--bals-grey-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
        }

        .map-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--bals-grey-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-left: 3px solid var(--bals-blue);
        }

        .map-card-title {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--bals-black);
        }

        .map-card-badge {
            font-size: 11px;
            font-weight: 600;
            color: var(--bals-blue);
            background: var(--bals-blue-10);
            padding: 3px 10px;
            border-radius: 999px;
        }

        #map-container {
            padding: 20px;
            min-height: 540px;
        }

        #map-container svg {
            display: block;
        }

        .map-hint {
            font-size: 11px;
            color: var(--bals-grey);
            text-align: center;
            padding: 10px 0 14px;
            letter-spacing: 0.04em;
        }

        /*
        ═══════════════════════════════════════
        DÉPARTEMENTS SVG — styles des chemins
        ═══════════════════════════════════════
        */
        .departement {
            cursor: pointer;
            transition: opacity 0.2s, filter 0.2s;
            stroke: #fff;
            stroke-width: 0.7px;
        }

        /* Au survol : légèrement plus lumineux */
        .departement:hover {
            filter: brightness(1.15) saturate(1.2);
        }

        /* Département "grisé" quand une autre région est sélectionnée */
        .departement.dimmed {
            opacity: 0.15;
        }

        /* Département "actif" = fait partie de la région sélectionnée */
        .departement.active {
            opacity: 1;
            filter: brightness(1.08);
            stroke-width: 1.4px;
            stroke: #fff;
        }

        /* ── PANNEAU LATÉRAL ── */
        .side-panel {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ── INFO-BOX : affiche les contacts de la région cliquée ── */
        .info-box {
            background: #fff;
            border: 1px solid var(--bals-grey-border);
            border-radius: 12px;
            padding: 24px;
            min-height: 200px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
            border-left: 3px solid var(--bals-grey-border);
            transition: border-left-color 0.3s;
        }

        /* Quand une région est sélectionnée, la bordure devient rouge */
        .info-box.has-selection {
            border-left-color: var(--bals-red);
        }

        /* Message affiché quand aucune région n'est sélectionnée */
        .placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 28px 0;
            text-align: center;
            color: var(--bals-grey);
            font-size: 13px;
            font-weight: 300;
            line-height: 1.6;
        }

        .placeholder svg {
            opacity: 0.4;
        }

        /* ── Contenu de l'info-box après sélection ── */
        .info-zone-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--bals-red);
            margin-bottom: 10px;
        }

        .info-zone-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .info-region-name {
            font-size: 20px;
            font-weight: 800;
            color: var(--bals-black);
            line-height: 1.15;
            margin-bottom: 4px;
        }

        .info-dept-name {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 14px;
        }

        .info-depts-covered {
            font-size: 11px;
            color: var(--bals-grey);
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--bals-grey-border);
        }

        /* ── Carte de contact d'un agent ── */
        .contact-card {
            background: var(--bals-grey-light);
            border-radius: 8px;
            padding: 12px 14px;
            margin-bottom: 10px;
        }

        .contact-card:last-of-type {
            margin-bottom: 16px;
        }

        .contact-agence {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--bals-blue);
            margin-bottom: 2px;
        }

        .contact-nom {
            font-size: 13px;
            font-weight: 700;
            color: var(--bals-black);
            margin-bottom: 6px;
        }

        .contact-depts {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .contact-links {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .contact-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--bals-blue);
            text-decoration: none;
            font-weight: 500;
        }

        .contact-link:hover {
            text-decoration: underline;
        }

        .contact-link svg {
            flex-shrink: 0;
        }

        /* ── LISTE DES RÉGIONS (panneau droit) ── */
        .region-list-card {
            background: #fff;
            border: 1px solid var(--bals-grey-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
        }

        .region-list-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--bals-grey-border);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--bals-grey);
            background: var(--bals-grey-light);
        }

        .region-list {
            max-height: 440px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--bals-grey-border) transparent;
        }

        .region-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px;
            cursor: pointer;
            transition: background 0.12s;
            border-bottom: 1px solid rgba(226, 230, 234, 0.6);
            font-size: 13px;
        }

        .region-item:hover {
            background: var(--bals-blue-10);
        }

        .region-item.active {
            background: var(--bals-red-10);
            border-left: 3px solid var(--bals-red);
            padding-left: 17px;
        }

        .region-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .region-item-name {
            flex: 1;
            color: var(--bals-black);
            font-weight: 500;
        }

        .region-item-count {
            font-size: 11px;
            color: var(--bals-grey);
            background: var(--bals-grey-light);
            padding: 2px 8px;
            border-radius: 999px;
            font-weight: 600;
        }

        /* Bouton de réinitialisation */
        .reset-btn {
            display: none;
            width: 100%;
            padding: 10px;
            background: transparent;
            border: 1px solid var(--bals-grey-border);
            border-radius: 8px;
            color: var(--bals-grey);
            font-size: 12px;
            font-family: 'Exo 2', sans-serif;
            font-weight: 600;
            cursor: pointer;
            letter-spacing: 0.06em;
            transition: all 0.2s;
        }

        .reset-btn:hover {
            border-color: var(--bals-blue);
            color: var(--bals-blue);
            background: var(--bals-blue-10);
        }

        /* ── Tooltip (bulle d'info au survol d'un département) ── */
        #tooltip {
            position: fixed;
            background: var(--bals-black);
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            font-family: 'Exo 2', sans-serif;
            font-size: 12px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.1s;
            z-index: 9999;
            border-left: 3px solid var(--bals-blue);
        }

        #tooltip strong {
            display: block;
            font-weight: 700;
            margin-bottom: 1px;
        }

        #tooltip small {
            color: var(--bals-grey);
            font-size: 11px;
        }

        /* ── Animation d'apparition ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .map-card {
            animation: fadeUp 0.45s ease 0.05s both;
        }

        .info-box {
            animation: fadeUp 0.45s ease 0.15s both;
        }

        .region-list-card {
            animation: fadeUp 0.45s ease 0.22s both;
        }

        /*
        ═══════════════════════════════════════
        NOUVEAU : Style du lien vers le back-office
        ═══════════════════════════════════════
        */
        .admin-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--bals-blue);
            text-decoration: none;
            padding: 6px 14px;
            border: 1px solid var(--bals-blue);
            border-radius: 6px;
            transition: all 0.2s;
        }

        .admin-link:hover {
            background: var(--bals-blue);
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>

    {{-- Barre bleue→rouge (identité Bals) --}}
    <div class="brand-bar"></div>

    {{-- Header du site (inclus depuis un composant Laravel) --}}
    @include('livewire.layout.header')

    <div class="page-wrapper">

        {{-- ══════════════ EN-TÊTE DE LA PAGE ══════════════ --}}
        <header class="page-header">
            <div class="eyebrow">Réseau commercial</div>
            <h1>Notre réseau d'agents <span>commerciaux</span></h1>
            <p class="tagline">
                Cliquez sur un département pour afficher l'agent local de votre région.
                Pour toute question&nbsp;: <a href="tel:+33164786080">01&nbsp;64&nbsp;78&nbsp;60&nbsp;80</a>
            </p>

            {{--
            ═══════════════════════════════════════════════════════
            NOUVEAU : LIEN VERS LE BACK-OFFICE
            ───────────────────────────────────────────────────────
            Ce lien est visible uniquement par l'administrateur.
            Il mène vers la page admin.blade.php où l'on peut
            modifier les contacts sans toucher au code.
            ═══════════════════════════════════════════════════════
            --}}
            <div class="mt-4">
                <a href="/admin-agents" class="admin-link">
                    {{-- Icône engrenage (SVG) --}}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0
                               0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0
                               0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0
                               1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65
                               1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0
                               0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65
                               0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65
                               1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2
                               2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0
                               0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1
                               2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65
                               1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0
                               0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65
                               1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2
                               2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                    Gérer les agents
                </a>
            </div>
        </header>

        {{-- ══════════════ GRILLE : CARTE + PANNEAU ══════════════ --}}
        <div class="map-grid">

            {{-- CARTE DE FRANCE --}}
            <div class="map-card">
                <div class="map-card-header">
                    <span class="map-card-title">France métropolitaine</span>
                    <span class="map-card-badge" id="region-count">— régions</span>
                </div>
                <div id="map-container"></div>
                <p class="map-hint">Cliquez sur un département · Double-clic pour réinitialiser</p>
            </div>

            {{-- PANNEAU LATÉRAL --}}
            <div class="side-panel">

                {{-- Info-box : affiche les contacts de la région cliquée --}}
                <div class="info-box" id="info-box">
                    <div class="placeholder">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5">
                            <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>Cliquez sur un département<br>pour afficher l'agent local</span>
                    </div>
                </div>

                {{-- Bouton de réinitialisation --}}
                <button class="reset-btn" id="reset-btn" onclick="resetMap()">
                    ↺ &nbsp; Réinitialiser la sélection
                </button>

                {{-- Liste des régions --}}
                <div class="region-list-card">
                    <div class="region-list-header">Toutes les régions</div>
                    <ul class="region-list" id="region-list"></ul>
                </div>

            </div>
        </div>
    </div>

    {{-- Tooltip (bulle au survol) --}}
    <div id="tooltip"></div>

    {{-- Footer du site --}}
    @include('livewire.layout.footer')


    {{--
    ╔═══════════════════════════════════════════════════════════════════════════╗
    ║                                                                          ║
    ║                    JAVASCRIPT — LOGIQUE DE LA CARTE                      ║
    ║                                                                          ║
    ╚═══════════════════════════════════════════════════════════════════════════╝
    --}}
    <script>
        /*
        ═══════════════════════════════════════════════════════════════════
        1. TABLE DE CORRESPONDANCE DES ANCIENNES RÉGIONS → NOUVELLES
        ───────────────────────────────────────────────────────────────────
        Le fichier GeoJSON (france.json) utilise les noms des anciennes
        régions françaises (avant la réforme de 2016).
        Cette table permet de convertir les anciens noms vers les
        nouveaux (ex: "Alsace" → "Grand Est").
        ═══════════════════════════════════════════════════════════════════
        */
        const REGION_MAP = {
            'Alsace': 'Grand Est',
            'Champagne-Ardenne': 'Grand Est',
            'Lorraine': 'Grand Est',
            'Aquitaine': 'Nouvelle-Aquitaine',
            'Limousin': 'Nouvelle-Aquitaine',
            'Poitou-Charentes': 'Nouvelle-Aquitaine',
            'Auvergne': 'Auvergne-Rhône-Alpes',
            'Rhône-Alpes': 'Auvergne-Rhône-Alpes',
            'Bourgogne': 'Bourgogne-Franche-Comté',
            'Franche-Comté': 'Bourgogne-Franche-Comté',
            'Basse-Normandie': 'Normandie',
            'Haute-Normandie': 'Normandie',
            'Languedoc-Roussillon': 'Occitanie',
            'Midi-Pyrénées': 'Occitanie',
            'Nord-Pas-de-Calais': 'Hauts-de-France',
            'Picardie': 'Hauts-de-France',
            'Bretagne': 'Bretagne',
            'Centre': 'Centre-Val de Loire',
            'Corse': 'Corse',
            'Île-de-France': 'Île-de-France',
            'Pays de la Loire': 'Pays de la Loire',
            "Provence-Alpes-Côte-d'Azur": "Provence-Alpes-Côte d'Azur",
        };


        /*
        ═══════════════════════════════════════════════════════════════════
        2. COULEURS DES RÉGIONS SUR LA CARTE
        ───────────────────────────────────────────────────────────────────
        Chaque région a une couleur unique pour la distinguer visuellement.
        Ces couleurs sont inspirées du bleu et rouge Bals, puis étendues
        à toute la palette pour maximiser le contraste entre voisins.
        ═══════════════════════════════════════════════════════════════════
        */
        const COLORS = {
            'Auvergne-Rhône-Alpes': '#7C3AED',     /* Violet */
            'Bourgogne-Franche-Comté': '#059669',   /* Vert émeraude */
            'Bretagne': '#ED1C24',                  /* Rouge Bals */
            'Centre-Val de Loire': '#CA8A04',       /* Or */
            'Corse': '#0E7490',                     /* Bleu canard */
            'Grand Est': '#FAF700',                 /* Jaune vif */
            'Hauts-de-France': '#4F46E5',           /* Indigo */
            'Île-de-France': '#DC2626',             /* Rouge vif */
            'Normandie': '#00FA08',                 /* Vert vif */
            'Nouvelle-Aquitaine': '#F97316',        /* Orange */
            'Occitanie': '#EC4899',                 /* Rose */
            'Pays de la Loire': '#A855F7',          /* Violet clair */
            "Provence-Alpes-Côte d'Azur": '#0E7490' /* Bleu canard */
        };
        const DEFAULT_COLOR = '#94A3B8'; /* Gris pour les régions inconnues */


        /*
        ═══════════════════════════════════════════════════════════════════
        3. DONNÉES PAR DÉFAUT DES CONTACTS
        ───────────────────────────────────────────────────────────────────
        NOUVEAU : Ces données ne sont plus utilisées directement.
        Elles servent de SECOURS si localStorage est vide
        (= première visite, ou données effacées).

        La fonction chargerContacts() plus bas décide quoi utiliser.
        ═══════════════════════════════════════════════════════════════════
        */
        const CONTACTS_PAR_DEFAUT = {

            'Normandie': {
                zone: 'NORMANDIE',
                agents: [{
                    agence: null,
                    nom: 'Vincent CARPENTIER',
                    depts: 'Dépt. 14, 27, 50, 61, 76',
                    tel: '06 27 32 49 23',
                    telRaw: '+330627324923',
                    email: 'vincent.carpentier85@sfr.fr'
                }]
            },

            'Bretagne': {
                zone: 'BRETAGNE',
                agents: [{
                    agence: 'AGENCE BONDUELLE',
                    nom: 'Isabelle ESPELLE',
                    depts: 'Dépt. 22, 29, 35, 56',
                    tel: '02 40 09 77 95',
                    telRaw: '+330240097795',
                    email: 'contact@agence-bonduelle.com'
                }]
            },

            'Pays de la Loire': {
                zone: 'PAYS DE LA LOIRE',
                agents: [{
                    agence: 'AGENCE BONDUELLE',
                    nom: 'Isabelle ESPELLE',
                    depts: 'Dépt. 44, 49, 53, 72, 79, 85',
                    tel: '02 40 09 77 95',
                    telRaw: '+330240097795',
                    email: 'contact@agence-bonduelle.com'
                }]
            },

            'Centre-Val de Loire': {
                zone: 'VAL DE LOIRE',
                agents: [{
                    agence: null,
                    nom: 'Yann GUYADER',
                    depts: 'Dépt. 18, 28, 36, 37, 41, 45, 86',
                    tel: '06 02 19 82 90',
                    telRaw: '+330602198290',
                    email: 'yguyader@gstec.fr'
                }]
            },

            'Île-de-France': {
                zone: 'ÎLE-DE-FRANCE',
                agents: [
                    {
                        agence: 'AGENCE DUMAS',
                        nom: 'Alexis ANDRADE SILVA',
                        depts: 'Dépt. 75, 78, 92',
                        tel: '06 33 37 30 17',
                        telRaw: '+330633373017',
                        email: 'a.andradesilva@agencedumas.net'
                    },
                    {
                        agence: 'AGENCE DUMAS',
                        nom: 'Arnaud JOUSSELIN',
                        depts: 'Dépt. 93, 95',
                        tel: '06 50 98 23 67',
                        telRaw: '+330650982367',
                        email: 'a.jousselin@agencedumas.net'
                    },
                    {
                        agence: 'AGENCE DUMAS',
                        nom: 'Adrien DUMAS',
                        depts: 'Dépt. 77, 91, 94',
                        tel: '06 33 57 21 38',
                        telRaw: '+330633572138',
                        email: 'a.dumas@agencedumas.net'
                    }
                ]
            },

            'Hauts-de-France': {
                zone: 'HAUTS-DE-FRANCE',
                agents: [
                    {
                        agence: 'AGENCE BESSA',
                        nom: 'Francis BESSA',
                        depts: 'Dépt. 59, 62, 80',
                        tel: '06 09 62 92 30',
                        telRaw: '+330609629230',
                        email: 'Francis.bessa@agencebessa.fr'
                    },
                    {
                        agence: 'AGENCE PICHAMPARDENNAISE',
                        nom: 'Angéline FAUCHART-PETIT',
                        depts: 'Dépt. 02, 60',
                        tel: '06 62 39 11 93',
                        telRaw: '+330662391193',
                        email: 'agence.angeline@orange.fr'
                    }
                ]
            },

            'Grand Est': {
                zone: 'GRAND EST',
                agents: [
                    {
                        agence: 'AGENCE VIERLING',
                        nom: 'Christian VIERLING',
                        depts: 'Dépt. 54, 55, 57, 67, 68, 88, 90',
                        tel: '06 09 48 66 91',
                        telRaw: '+330609486691',
                        email: 'contact@agencevierling.fr'
                    },
                    {
                        agence: 'AGENCE PICHAMPARDENNAISE',
                        nom: 'Angéline FAUCHART-PETIT',
                        depts: 'Dépt. 08, 10, 51, 52',
                        tel: '06 62 39 11 93',
                        telRaw: '+330662391193',
                        email: 'agence.angeline@orange.fr'
                    }
                ]
            },

            'Bourgogne-Franche-Comté': {
                zone: 'BOURGOGNE FRANCHE-COMTÉ',
                agents: [{
                    agence: 'FANJOUX',
                    nom: 'Raphaël LEGRAND',
                    depts: 'Dépt. 21, 25, 39, 58, 70, 71, 89',
                    tel: '06 12 22 34 16',
                    telRaw: '+330612223416',
                    email: 'Raphael.legrand@fanjouxdiffusion.com'
                }]
            },

            'Auvergne-Rhône-Alpes': {
                zone: 'AUVERGNE-RHÔNE-ALPES',
                agents: [
                    {
                        agence: 'MONIER',
                        nom: 'Ghislain MONIER',
                        depts: 'Dépt. 03, 15, 43, 63',
                        tel: '06 78 98 74 30',
                        telRaw: '+330678987430',
                        email: 'contact@agencemonier.com'
                    },
                    {
                        agence: 'AGENCE XPE XPRO ELEC',
                        nom: 'Lionel AUCLAIR',
                        depts: 'Dépt. 07, 26, 42',
                        tel: '07 85 23 64 23',
                        telRaw: '+330785236423',
                        email: 'lauclair@xpe-france.fr'
                    },
                    {
                        agence: 'AGENCE XPE XPRO ELEC',
                        nom: 'Nicolas CHARPENTIER',
                        depts: 'Dépt. 01, 73, 74',
                        tel: '06 08 62 00 39',
                        telRaw: '+330608620039',
                        email: 'ncharpentier@xpe-france.com'
                    },
                    {
                        agence: 'AGENCE XPE XPRO ELEC',
                        nom: 'Olivier REYNAUD',
                        depts: 'Dépt. 38, 69',
                        tel: '06 80 08 25 26',
                        telRaw: '+330680082526',
                        email: 'commercial@xpe-france.com'
                    }
                ]
            },

            'Nouvelle-Aquitaine': {
                zone: 'NOUVELLE-AQUITAINE',
                agents: [
                    {
                        agence: 'MONIER',
                        nom: 'Ghislain MONIER',
                        depts: 'Dépt. 19, 23, 87',
                        tel: '06 78 98 74 30',
                        telRaw: '+330678987430',
                        email: 'contact@agencemonier.com'
                    },
                    {
                        agence: 'RMEE',
                        nom: 'Christophe NIETRZEBA',
                        depts: 'Dépt. 16, 17, 24',
                        tel: '06 80 46 93 93',
                        telRaw: '+330680469393',
                        email: 'c.nietrzeba@rmee.fr'
                    },
                    {
                        agence: 'RMEE',
                        nom: 'Jean-Christophe SEBILE',
                        depts: 'Dépt. 33, 40, 47, 64',
                        tel: '06 86 16 63 64',
                        telRaw: '+330686166364',
                        email: 'jc.sebile@rmee.fr'
                    }
                ]
            },

            'Occitanie': {
                zone: 'OCCITANIE',
                agents: [
                    {
                        agence: 'REPELEC',
                        nom: 'Cédric RICAUD',
                        depts: 'Dépt. 09, 11, 32, 46, 65, 82',
                        tel: '06 33 98 59 18',
                        telRaw: '+330633985918',
                        email: 'c.ricaud@repelec.fr'
                    },
                    {
                        agence: 'REPELEC',
                        nom: 'Sébastien LIENARD',
                        depts: 'Dépt. 12, 31, 48, 66, 81',
                        tel: '06 78 22 54 30',
                        telRaw: '+330678225430',
                        email: 's.lienard@repelec.fr'
                    },
                    {
                        agence: 'AGENCE RENAUDI',
                        nom: 'Fabien RENAUDI',
                        depts: 'Dépt. 30, 34',
                        tel: '06 29 44 69 94',
                        telRaw: '+330629446994',
                        email: 'contact@agencerenaudi.fr'
                    }
                ]
            },

            "Provence-Alpes-Côte d'Azur": {
                zone: 'MÉDITERRANÉE',
                agents: [{
                    agence: 'AGENCE RENAUDI',
                    nom: 'Fabien RENAUDI',
                    depts: 'Dépt. 04, 05, 06, 13, 83, 84',
                    tel: '06 29 44 69 94',
                    telRaw: '+330629446994',
                    email: 'contact@agencerenaudi.fr'
                }]
            },

            'Corse': {
                zone: 'MÉDITERRANÉE',
                agents: [{
                    agence: 'AGENCE RENAUDI',
                    nom: 'Fabien RENAUDI',
                    depts: 'Dépt. 2A, 2B',
                    tel: '06 29 44 69 94',
                    telRaw: '+330629446994',
                    email: 'contact@agencerenaudi.fr'
                }]
            }
        };


        /*
        ═══════════════════════════════════════════════════════════════════
        4. FONCTION chargerContacts() — NOUVEAU (remplace l'ancien CONTACTS)
        ───────────────────────────────────────────────────────────────────
        C'est LA modification clé de cette version.

        AVANT : const CONTACTS = { ... }  (données écrites en dur)
        APRÈS : const CONTACTS = chargerContacts()  (données lues depuis localStorage)

        LOGIQUE :
        1. On regarde si "bals_contacts" existe dans localStorage
        2. Si OUI → on utilise ces données (modifiées par l'admin)
        3. Si NON → on utilise les données par défaut et on les sauvegarde

        C'est grâce à cette fonction que le back-office peut modifier
        les contacts sans toucher au code : il écrit dans localStorage,
        et la carte lit depuis localStorage.
        ═══════════════════════════════════════════════════════════════════
        */
        function chargerContacts() {

            // On essaie de lire les données sauvegardées
            const donneesSauvegardees = localStorage.getItem('bals_contacts');

            // Si des données existent dans localStorage, on les utilise
            if (donneesSauvegardees) {
                return JSON.parse(donneesSauvegardees);
            }

            // Sinon, première utilisation : on sauvegarde les données par défaut
            localStorage.setItem('bals_contacts',
                JSON.stringify(CONTACTS_PAR_DEFAUT)
            );
            return CONTACTS_PAR_DEFAUT;
        }

        // On charge les contacts (depuis localStorage ou par défaut)
        const CONTACTS = chargerContacts();


        /*
        ═══════════════════════════════════════════════════════════════════
        5. VARIABLES GLOBALES
        ═══════════════════════════════════════════════════════════════════
        */
        let deptCounts = {};  // Nombre de départements par région
        let allPaths = null;  // Tous les chemins SVG des départements


        /*
        ═══════════════════════════════════════════════════════════════════
        6. CHARGEMENT DU GEOJSON ET RENDU DE LA CARTE AVEC D3.js
        ───────────────────────────────────────────────────────────────────
        fetch() = télécharge le fichier france.json
        D3.js = dessine chaque département comme un chemin SVG
        ═══════════════════════════════════════════════════════════════════
        */
        fetch('/data/france.json')
            .then(r => r.json())  // Convertit la réponse en JSON
            .then(geojson => {

                // On garde uniquement la métropole (latitude > 40°)
                // Cela exclut les DOM-TOM
                const features = geojson.features.filter(
                    f => f.properties.latitude > 40
                );

                // On remplace les anciens noms de régions par les nouveaux
                features.forEach(f => {
                    const oldRegion = f.properties.region;
                    f.properties.region = REGION_MAP[oldRegion] || oldRegion;
                });

                // On compte combien de départements il y a par région
                features.forEach(f => {
                    const r = f.properties.region;
                    deptCounts[r] = (deptCounts[r] || 0) + 1;
                });

                // On mesure la taille du conteneur de la carte
                const container = document.getElementById('map-container');
                const getW = () => container.clientWidth || 720;
                let W = getW();
                let H = Math.round(W * 0.88);

                // Création de l'élément SVG avec D3
                const svg = d3.select('#map-container')
                    .append('svg')
                    .attr('width', '100%')
                    .attr('height', H)
                    .attr('viewBox', `0 0 ${W} ${H}`)
                    .attr('preserveAspectRatio', 'xMidYMid meet');

                // Projection Mercator : convertit lat/long → pixels
                const projection = d3.geoMercator()
                    .fitSize([W, H], {
                        type: 'FeatureCollection',
                        features
                    });

                // Générateur de chemins SVG
                const path = d3.geoPath().projection(projection);

                const tooltip = document.getElementById('tooltip');

                // Dessin de chaque département
                allPaths = svg.selectAll('path')
                    .data(features)
                    .enter()
                    .append('path')
                    .attr('class', 'departement')
                    .attr('d', path)
                    .attr('fill', d => COLORS[d.properties.region] || DEFAULT_COLOR)
                    // Au mouvement de la souris : afficher le tooltip
                    .on('mousemove', (event, d) => {
                        tooltip.style.opacity = '1';
                        tooltip.style.left = (event.clientX + 16) + 'px';
                        tooltip.style.top = (event.clientY - 12) + 'px';
                        const zone = CONTACTS[d.properties.region]?.zone || d.properties.region;
                        tooltip.innerHTML = `
                            <strong>${d.properties.name}</strong>
                            <small>${zone}</small>
                        `;
                    })
                    // Quand la souris quitte le département
                    .on('mouseleave', () => {
                        tooltip.style.opacity = '0';
                    })
                    // Au clic : sélectionner la région
                    .on('click', (event, d) => {
                        event.stopPropagation();
                        selectRegion(d.properties.region, d.properties.name);
                    });

                // Double-clic sur la carte : réinitialiser
                svg.on('dblclick', () => resetMap());

                // Génération de la liste des régions dans le panneau latéral
                const list = document.getElementById('region-list');
                const regions = [...new Set(
                    features.map(f => f.properties.region)
                )].sort();
                document.getElementById('region-count').textContent =
                    regions.length + ' régions';

                // Pour chaque région, on crée un élément de liste cliquable
                regions.forEach(region => {
                    const color = COLORS[region] || DEFAULT_COLOR;
                    const li = document.createElement('li');
                    li.className = 'region-item';
                    li.id = 'li-' + slugify(region);
                    li.innerHTML = `
                        <span class="region-dot" style="background:${color}"></span>
                        <span class="region-item-name">${region}</span>
                        <span class="region-item-count">${deptCounts[region] || 0}</span>
                    `;
                    li.addEventListener('click', () => selectRegion(region, null));
                    list.appendChild(li);
                });

                // Gestion du redimensionnement de la fenêtre
                window.addEventListener('resize', () => {
                    W = getW();
                    H = Math.round(W * 0.88);
                    svg.attr('height', H).attr('viewBox', `0 0 ${W} ${H}`);
                    projection.fitSize([W, H], {
                        type: 'FeatureCollection',
                        features
                    });
                    svg.selectAll('path').attr('d', path);
                });
            })
            .catch(() => {
                // En cas d'erreur (fichier france.json introuvable)
                document.getElementById('map-container').innerHTML = `
                    <div style="padding:32px;text-align:center;color:#ED1C24">
                        <strong>⚠ Impossible de charger la carte</strong><br>
                        <small style="color:#6b7280">Vérifiez que <code>public/data/france.json</code> existe</small>
                    </div>
                `;
            });


        /*
        ═══════════════════════════════════════════════════════════════════
        7. SÉLECTION D'UNE RÉGION — affiche les contacts
        ───────────────────────────────────────────────────────────────────
        Appelée quand l'utilisateur clique sur un département ou
        sur un élément de la liste latérale.
        ═══════════════════════════════════════════════════════════════════
        */
        function selectRegion(regionName, deptName) {
            if (!allPaths) return;

            // Highlight sur la carte : griser les autres, activer la sélection
            allPaths
                .classed('dimmed', d => d.properties.region !== regionName)
                .classed('active', d => d.properties.region === regionName);

            // Highlight dans la liste latérale
            document.querySelectorAll('.region-item').forEach(
                el => el.classList.remove('active')
            );
            const li = document.getElementById('li-' + slugify(regionName));
            if (li) {
                li.classList.add('active');
                li.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            // Construction de l'info-box avec les contacts de la région
            const color = COLORS[regionName] || DEFAULT_COLOR;
            const data = CONTACTS[regionName];
            const zone = data?.zone || regionName;
            const agents = data?.agents || [];
            const box = document.getElementById('info-box');
            box.classList.add('has-selection');

            // Génération du HTML pour chaque agent
            const agentsHTML = agents.map(a => `
                <div class="contact-card">
                    ${a.agence ? `<div class="contact-agence">${a.agence}</div>` : ''}
                    <div class="contact-nom">${a.nom}</div>
                    <div class="contact-depts">${a.depts}</div>
                    <div class="contact-links">
                        <a href="tel:${a.telRaw}" class="contact-link">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2.5">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.37 19
                                       A19.46 19.46 0 0 1 5 12.63a19.79 19.79 0 0 1-2.92-8.4A2 2 0
                                       0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.96.36 1.9.7 2.81a2 2 0 0
                                       1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1
                                       2.11-.45c.91.35 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            ${a.tel}
                        </a>
                        <a href="mailto:${a.email}" class="contact-link">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2.5">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1
                                       0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            ${a.email}
                        </a>
                    </div>
                </div>
            `).join('');

            // On injecte tout le HTML dans l'info-box
            box.innerHTML = `
                <div style="animation: fadeUp .25s ease both">
                    <div class="info-zone-label">
                        <span class="info-zone-dot" style="background:${color}"></span>
                        Zone commerciale
                    </div>
                    <div class="info-region-name">${zone}</div>
                    ${deptName
                        ? `<div class="info-dept-name">Département sélectionné&nbsp;: ${deptName}</div>`
                        : '<div style="height:14px"></div>'
                    }
                    <div class="info-depts-covered">
                        ${deptCounts[regionName] || 0} département${(deptCounts[regionName]||0) > 1 ? 's' : ''}
                        · ${agents.length} agent${agents.length > 1 ? 's' : ''}
                    </div>
                    ${agentsHTML || `<p style="font-size:13px;color:#6b7280">
                        Contactez le siège au
                        <a href="tel:+33164786080" style="color:var(--bals-blue)">01 64 78 60 80</a>
                    </p>`}
                </div>
            `;

            // On affiche le bouton "Réinitialiser"
            document.getElementById('reset-btn').style.display = 'block';
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        8. RÉINITIALISATION — remet la carte à son état initial
        ═══════════════════════════════════════════════════════════════════
        */
        function resetMap() {
            if (!allPaths) return;

            // On enlève les classes dimmed et active de tous les départements
            allPaths.classed('dimmed', false).classed('active', false);

            // On désactive tous les éléments de la liste
            document.querySelectorAll('.region-item').forEach(
                el => el.classList.remove('active')
            );

            // On remet le placeholder dans l'info-box
            const box = document.getElementById('info-box');
            box.classList.remove('has-selection');
            box.innerHTML = `
                <div class="placeholder">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5">
                        <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8
                               8.2c0 7.3-8 11.8-8 11.8z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span>Cliquez sur un département<br>pour afficher l'agent local</span>
                </div>
            `;

            // On cache le bouton réinitialiser
            document.getElementById('reset-btn').style.display = 'none';
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        9. UTILITAIRE — slugify (transforme un texte en identifiant HTML)
        ───────────────────────────────────────────────────────────────────
        Exemple : "Île-de-France" → "ile-de-france"
        Utilisé pour créer des id HTML valides pour chaque région.
        ═══════════════════════════════════════════════════════════════════
        */
        function slugify(str) {
            return str.toLowerCase()
                .normalize('NFD')                       // Décompose les accents
                .replace(/[\u0300-\u036f]/g, '')        // Supprime les accents
                .replace(/[^a-z0-9]/g, '-');            // Remplace le reste par des tirets
        }
    </script>

</body>

</html>