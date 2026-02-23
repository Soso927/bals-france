<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte interactive — Bals France</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3@7"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /*
        ═══════════════════════════════════════════════════════
        VARIABLES — CHARTE GRAPHIQUE BALS (Style Guide V2016)
        Source : page 08 "Colours"
        ═══════════════════════════════════════════════════════
        */
        :root {
            --bals-blue:        #0095DA; /* R0 G149 B218  — Bals Blue officiel  */
            --bals-red:         #ED1C24; /* R237 G28 B36  — Bals Red officiel   */
            --bals-black:       #1A1A1A;
            --bals-grey:        #B3B3B3; /* R179 G179 B179 — Light Grey officiel */
            --bals-grey-light:  #F4F6F8;
            --bals-grey-border: #E2E6EA;
            --bals-blue-10:     rgba(0,149,218,0.10);
            --bals-blue-20:     rgba(0,149,218,0.20);
            --bals-red-10:      rgba(237,28,36,0.10);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bals-grey-light);
            color: var(--bals-black);
            font-family: 'Exo 2', sans-serif;
            font-weight: 400;
            min-height: 100vh;
        }

        /* Filet Bals bleu → rouge en haut de page */
        .brand-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--bals-blue) 70%, var(--bals-red) 100%);
        }

        .page-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 48px 32px 64px;
        }

        /* ── EN-TÊTE ── */
        .page-header { margin-bottom: 48px; }
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
        .eyebrow::before {
            content: '';
            width: 28px;
            height: 2px;
            background: var(--bals-blue);
        }
        .page-header h1 {
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.02em;
            color: var(--bals-black);
            margin-bottom: 6px;
        }
        .page-header h1 span { color: var(--bals-red); }
        .page-header .tagline {
            font-size: 15px;
            font-weight: 300;
            color: #6b7280;
            line-height: 1.7;
            margin-top: 12px;
            max-width: 580px;
        }
        .page-header a { color: var(--bals-blue); text-decoration: none; font-weight: 500; }
        .page-header a:hover { text-decoration: underline; }

        /* ── GRILLE PRINCIPALE ── */
        .map-grid {
            display: grid;
            grid-template-columns: 1fr 310px;
            gap: 24px;
            align-items: start;
        }
        @media (max-width: 1024px) { .map-grid { grid-template-columns: 1fr; } }

        /* ── CARTE ── */
        .map-card {
            background: #fff;
            border: 1px solid var(--bals-grey-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
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
        #map-container { padding: 20px; min-height: 540px; }
        #map-container svg { display: block; }
        .map-hint {
            font-size: 11px;
            color: var(--bals-grey);
            text-align: center;
            padding: 10px 0 14px;
            letter-spacing: 0.04em;
        }

        /* ── PATHS SVG ── */
        .departement {
            cursor: pointer;
            transition: opacity 0.2s, filter 0.2s;
            stroke: #fff;
            stroke-width: 0.7px;
        }
        .departement:hover  { filter: brightness(1.15) saturate(1.2); }
        .departement.dimmed { opacity: 0.15; }
        .departement.active { opacity: 1; filter: brightness(1.08); stroke-width: 1.4px; stroke: #fff; }

        /* ── PANNEAU LATÉRAL ── */
        .side-panel { display: flex; flex-direction: column; gap: 16px; }

        /* Info-box */
        .info-box {
            background: #fff;
            border: 1px solid var(--bals-grey-border);
            border-radius: 12px;
            padding: 24px;
            min-height: 200px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            border-left: 3px solid var(--bals-grey-border);
            transition: border-left-color 0.3s;
        }
        .info-box.has-selection { border-left-color: var(--bals-red); }

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
        .placeholder svg { opacity: 0.4; }

        /* Contenu info-box après sélection */
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
            width: 8px; height: 8px;
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

        /* Carte de contact d'un agent */
        .contact-card {
            background: var(--bals-grey-light);
            border-radius: 8px;
            padding: 12px 14px;
            margin-bottom: 10px;
        }
        .contact-card:last-of-type { margin-bottom: 16px; }
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
        .contact-links { display: flex; flex-direction: column; gap: 4px; }
        .contact-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--bals-blue);
            text-decoration: none;
            font-weight: 500;
        }
        .contact-link:hover { text-decoration: underline; }
        .contact-link svg { flex-shrink: 0; }

        /* ── LISTE RÉGIONS ── */
        .region-list-card {
            background: #fff;
            border: 1px solid var(--bals-grey-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
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
            border-bottom: 1px solid rgba(226,230,234,0.6);
            font-size: 13px;
        }
        .region-item:hover  { background: var(--bals-blue-10); }
        .region-item.active {
            background: var(--bals-red-10);
            border-left: 3px solid var(--bals-red);
            padding-left: 17px;
        }
        .region-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
        .region-item-name { flex: 1; color: var(--bals-black); font-weight: 500; }
        .region-item-count {
            font-size: 11px;
            color: var(--bals-grey);
            background: var(--bals-grey-light);
            padding: 2px 8px;
            border-radius: 999px;
            font-weight: 600;
        }

        /* Bouton reset */
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
        .reset-btn:hover { border-color: var(--bals-blue); color: var(--bals-blue); background: var(--bals-blue-10); }

        /* Tooltip */
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
        #tooltip strong { display: block; font-weight: 700; margin-bottom: 1px; }
        #tooltip small  { color: var(--bals-grey); font-size: 11px; }

        /* Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .map-card          { animation: fadeUp 0.45s ease 0.05s both; }
        .info-box          { animation: fadeUp 0.45s ease 0.15s both; }
        .region-list-card  { animation: fadeUp 0.45s ease 0.22s both; }
    </style>
</head>
<body>

    <div class="brand-bar"></div>

    @include('livewire.layout.header')

    <div class="page-wrapper">

        <header class="page-header">
            <div class="eyebrow">Réseau commercial</div>
            <h1>Carte des régions de <span>France</span></h1>
            <p class="tagline">
                Cliquez sur un département pour afficher l'agent local de votre région.
                Pour toute question&nbsp;: <a href="tel:+33164786080">01&nbsp;64&nbsp;78&nbsp;60&nbsp;80</a>
            </p>
        </header>

        <div class="map-grid">

            {{-- CARTE --}}
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

                <div class="info-box" id="info-box">
                    <div class="placeholder">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>Cliquez sur un département<br>pour afficher l'agent local</span>
                    </div>
                </div>

                <button class="reset-btn" id="reset-btn" onclick="resetMap()">
                    ↺ &nbsp; Réinitialiser la sélection
                </button>

                <div class="region-list-card">
                    <div class="region-list-header">Toutes les régions</div>
                    <ul class="region-list" id="region-list"></ul>
                </div>

            </div>
        </div>
    </div>

    <div id="tooltip"></div>

    @include('livewire.layout.footer')

    <script>
    /*
    ═══════════════════════════════════════════════════════════════════
    1. COULEURS — 22 couleurs distinctes, une par région GeoJSON
       Basées sur les couleurs Bals (bleu #0095DA et rouge #ED1C24)
       étendues à toute la roue chromatique pour maximiser le contraste
    ═══════════════════════════════════════════════════════════════════
    */
    const COLORS = {
        'Alsace':                           '#06B6D4', // Cyan
        'Aquitaine':                        '#F97316', // Orange
        'Auvergne':                         '#1E3A8A', // Bleu marine
        'Basse-Normandie':                  '#0095DA', // Bals Blue officiel
        'Bourgogne':                        '#059669', // Vert émeraude
        'Bretagne':                         '#ED1C24', // Bals Red officiel
        'Centre':                           '#CA8A04', // Ambre doré
        'Champagne-Ardenne':                '#FACC15', // Jaune
        'Corse':                            '#D97706', // Orange ambré
        'Franche-Comté':                    '#10B981', // Vert menthe
        'Haute-Normandie':                  '#2563EB', // Bleu roi
        'Languedoc-Roussillon':             '#65A30D', // Vert lime
        'Limousin':                         '#3B82F6', // Bleu ciel
        'Lorraine':                         '#0891B2', // Bleu canard
        'Midi-Pyrénées':                    '#EC4899', // Rose
        'Nord-Pas-de-Calais':               '#4F46E5', // Indigo
        'Pays de la Loire':                 '#A855F7', // Violet
        'Picardie':                         '#22D3EE', // Cyan clair
        'Poitou-Charentes':                 '#FB923C', // Orange clair
        "Provence-Alpes-Côte-d'Azur":      '#0E7490', // Bleu pétrole
        'Rhône-Alpes':                      '#7C3AED', // Violet foncé
        'Île-de-France':                    '#DC2626', // Rouge vif
    };
    const DEFAULT_COLOR = '#94A3B8';

    /*
    ═══════════════════════════════════════════════════════════════════
    2. DONNÉES DE CONTACT — Source : bals-france.fr/reseau
       Structure : clé = nom de région GeoJSON
       Chaque région pointe vers une zone commerciale Bals
       contenant un ou plusieurs agents avec leurs coordonnées
    ═══════════════════════════════════════════════════════════════════
    */
    const CONTACTS = {
        'Basse-Normandie': {
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
        'Haute-Normandie': {
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
        'Centre': {
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
        'Poitou-Charentes': {
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
        'Auvergne': {
            zone: 'AUVERGNE-LIMOUSIN',
            agents: [{
                agence: 'MONIER',
                nom: 'Ghislain MONIER',
                depts: 'Dépt. 03, 15, 19, 23, 43, 63, 87',
                tel: '06 78 98 74 30',
                telRaw: '+330678987430',
                email: 'contact@agencemonier.com'
            }]
        },
        'Limousin': {
            zone: 'AUVERGNE-LIMOUSIN',
            agents: [{
                agence: 'MONIER',
                nom: 'Ghislain MONIER',
                depts: 'Dépt. 03, 15, 19, 23, 43, 63, 87',
                tel: '06 78 98 74 30',
                telRaw: '+330678987430',
                email: 'contact@agencemonier.com'
            }]
        },
        'Aquitaine': {
            zone: 'AQUITAINE',
            agents: [
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
        'Midi-Pyrénées': {
            zone: 'MIDI-PYRÉNÉES',
            agents: [
                {
                    agence: 'REPELEC',
                    nom: 'Cédric RICAUD',
                    depts: 'Dépt. 09, 11, 32, 65, 46, 82',
                    tel: '06 33 98 59 18',
                    telRaw: '+330633985918',
                    email: 'c.ricaud@repelec.fr'
                },
                {
                    agence: 'REPELEC',
                    nom: 'Sébastien LIENARD',
                    depts: 'Dépt. 31, 66, 81, 48, 12',
                    tel: '06 78 22 54 30',
                    telRaw: '+330678225430',
                    email: 's.lienard@repelec.fr'
                }
            ]
        },
        'Languedoc-Roussillon': {
            zone: 'MÉDITERRANÉE',
            agents: [{
                agence: 'AGENCE RENAUDI',
                nom: 'Fabien RENAUDI',
                depts: 'Dépt. 04, 05, 06, 13, 2A, 2B, 30, 34, 83, 84',
                tel: '06 29 44 69 94',
                telRaw: '+330629446994',
                email: 'contact@agencerenaudi.fr'
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
        'Nord-Pas-de-Calais': {
            zone: 'NORD',
            agents: [{
                agence: 'AGENCE BESSA',
                nom: 'Francis BESSA',
                depts: 'Dépt. 59, 62, 80',
                tel: '06 09 62 92 30',
                telRaw: '+330609629230',
                email: 'Francis.bessa@agencebessa.fr'
            }]
        },
        'Picardie': {
            zone: 'NORD / CHAMPAGNE',
            agents: [
                {
                    agence: 'AGENCE BESSA',
                    nom: 'Francis BESSA',
                    depts: 'Dépt. 80 (Somme)',
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
        'Champagne-Ardenne': {
            zone: 'CHAMPAGNE-ARDENNES',
            agents: [{
                agence: 'AGENCE PICHAMPARDENNAISE',
                nom: 'Angéline FAUCHART-PETIT',
                depts: 'Dépt. 02, 08, 10, 51, 52, 60',
                tel: '06 62 39 11 93',
                telRaw: '+330662391193',
                email: 'agence.angeline@orange.fr'
            }]
        },
        'Alsace': {
            zone: 'ALSACE LORRAINE',
            agents: [{
                agence: 'AGENCE VIERLING',
                nom: 'Christian VIERLING',
                depts: 'Dépt. 54, 55, 57, 67, 68, 88, 90',
                tel: '06 09 48 66 91',
                telRaw: '+330609486691',
                email: 'contact@agencevierling.fr'
            }]
        },
        'Lorraine': {
            zone: 'ALSACE LORRAINE',
            agents: [{
                agence: 'AGENCE VIERLING',
                nom: 'Christian VIERLING',
                depts: 'Dépt. 54, 55, 57, 67, 68, 88, 90',
                tel: '06 09 48 66 91',
                telRaw: '+330609486691',
                email: 'contact@agencevierling.fr'
            }]
        },
        'Bourgogne': {
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
        'Franche-Comté': {
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
        'Rhône-Alpes': {
            zone: 'RHÔNE-ALPES',
            agents: [
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
        "Provence-Alpes-Côte-d'Azur": {
            zone: 'MÉDITERRANÉE',
            agents: [{
                agence: 'AGENCE RENAUDI',
                nom: 'Fabien RENAUDI',
                depts: 'Dépt. 04, 05, 06, 13, 2A, 2B, 30, 34, 83, 84',
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
        },
    };

    /*
    ═══════════════════════════════════════════════════════════════════
    3. VARIABLES GLOBALES
    ═══════════════════════════════════════════════════════════════════
    */
    let deptCounts = {};
    let allPaths   = null;

    /*
    ═══════════════════════════════════════════════════════════════════
    4. CHARGEMENT GEOJSON ET RENDU D3
    ═══════════════════════════════════════════════════════════════════
    */
    fetch('/data/france.json')
        .then(r => r.json())
        .then(geojson => {

            /* Filtre : latitude > 40° → uniquement la métropole */
            const features = geojson.features.filter(f => f.properties.latitude > 40);

            /* Comptage des départements par région */
            features.forEach(f => {
                const r = f.properties.region;
                deptCounts[r] = (deptCounts[r] || 0) + 1;
            });

            /* Dimensions */
            const container = document.getElementById('map-container');
            const getW = () => container.clientWidth || 720;
            let W = getW();
            let H = Math.round(W * 0.88);

            /* Création du SVG */
            const svg = d3.select('#map-container')
                .append('svg')
                .attr('width', '100%')
                .attr('height', H)
                .attr('viewBox', `0 0 ${W} ${H}`)
                .attr('preserveAspectRatio', 'xMidYMid meet');

            /* Projection Mercator auto-ajustée */
            const projection = d3.geoMercator()
                .fitSize([W, H], { type: 'FeatureCollection', features });

            /* Générateur de chemins SVG */
            const path = d3.geoPath().projection(projection);

            const tooltip = document.getElementById('tooltip');

            /* Dessin des départements */
            allPaths = svg.selectAll('path')
                .data(features)
                .enter()
                .append('path')
                .attr('class', 'departement')
                .attr('d', path)
                .attr('fill', d => COLORS[d.properties.region] || DEFAULT_COLOR)
                .on('mousemove', (event, d) => {
                    tooltip.style.opacity = '1';
                    tooltip.style.left    = (event.clientX + 16) + 'px';
                    tooltip.style.top     = (event.clientY - 12) + 'px';
                    const zone = CONTACTS[d.properties.region]?.zone || d.properties.region;
                    tooltip.innerHTML = `
                        <strong>${d.properties.name}</strong>
                        <small>${zone}</small>
                    `;
                })
                .on('mouseleave', () => { tooltip.style.opacity = '0'; })
                .on('click', (event, d) => {
                    event.stopPropagation();
                    selectRegion(d.properties.region, d.properties.name);
                });

            svg.on('dblclick', () => resetMap());

            /* Génération de la liste latérale */
            const list    = document.getElementById('region-list');
            const regions = [...new Set(features.map(f => f.properties.region))].sort();
            document.getElementById('region-count').textContent = regions.length + ' régions';

            regions.forEach(region => {
                const color = COLORS[region] || DEFAULT_COLOR;
                const li    = document.createElement('li');
                li.className = 'region-item';
                li.id        = 'li-' + slugify(region);
                li.innerHTML = `
                    <span class="region-dot" style="background:${color}"></span>
                    <span class="region-item-name">${region}</span>
                    <span class="region-item-count">${deptCounts[region] || 0}</span>
                `;
                li.addEventListener('click', () => selectRegion(region, null));
                list.appendChild(li);
            });

            /* Responsive */
            window.addEventListener('resize', () => {
                W = getW(); H = Math.round(W * 0.88);
                svg.attr('height', H).attr('viewBox', `0 0 ${W} ${H}`);
                projection.fitSize([W, H], { type: 'FeatureCollection', features });
                svg.selectAll('path').attr('d', path);
            });
        })
        .catch(() => {
            document.getElementById('map-container').innerHTML = `
                <div style="padding:32px;text-align:center;color:#ED1C24">
                    <strong>⚠ Impossible de charger la carte</strong><br>
                    <small style="color:#6b7280">Vérifiez que <code>public/data/france.json</code> existe</small>
                </div>
            `;
        });

    /*
    ═══════════════════════════════════════════════════════════════════
    5. SÉLECTION D'UNE RÉGION — affiche les contacts réels
    ═══════════════════════════════════════════════════════════════════
    */
    function selectRegion(regionName, deptName) {
        if (!allPaths) return;

        /* Highlight carte */
        allPaths
            .classed('dimmed', d => d.properties.region !== regionName)
            .classed('active', d => d.properties.region === regionName);

        /* Highlight liste */
        document.querySelectorAll('.region-item').forEach(el => el.classList.remove('active'));
        const li = document.getElementById('li-' + slugify(regionName));
        if (li) { li.classList.add('active'); li.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); }

        /* Construction de l'info-box avec les contacts */
        const color   = COLORS[regionName] || DEFAULT_COLOR;
        const data    = CONTACTS[regionName];
        const zone    = data?.zone || regionName;
        const agents  = data?.agents || [];
        const box     = document.getElementById('info-box');
        box.classList.add('has-selection');

        /* Génération du HTML des cartes agents */
        const agentsHTML = agents.map(a => `
            <div class="contact-card">
                ${a.agence ? `<div class="contact-agence">${a.agence}</div>` : ''}
                <div class="contact-nom">${a.nom}</div>
                <div class="contact-depts">${a.depts}</div>
                <div class="contact-links">
                    <a href="tel:${a.telRaw}" class="contact-link">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.37 19 19.46 19.46 0 0 1 5 12.63a19.79 19.79 0 0 1-2.92-8.4A2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        ${a.tel}
                    </a>
                    <a href="mailto:${a.email}" class="contact-link">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        ${a.email}
                    </a>
                </div>
            </div>
        `).join('');

        box.innerHTML = `
            <div style="animation: fadeUp .25s ease both">
                <div class="info-zone-label">
                    <span class="info-zone-dot" style="background:${color}"></span>
                    Zone commerciale
                </div>
                <div class="info-region-name">${zone}</div>
                ${deptName ? `<div class="info-dept-name">Département sélectionné&nbsp;: ${deptName}</div>` : '<div style="height:14px"></div>'}
                <div class="info-depts-covered">
                    ${deptCounts[regionName] || 0} département${(deptCounts[regionName]||0) > 1 ? 's' : ''} · ${agents.length} agent${agents.length > 1 ? 's' : ''}
                </div>
                ${agentsHTML || `<p style="font-size:13px;color:#6b7280">Contactez le siège au <a href="tel:+33164786080" style="color:var(--bals-blue)">01 64 78 60 80</a></p>`}
            </div>
        `;

        document.getElementById('reset-btn').style.display = 'block';
    }

    /*
    ═══════════════════════════════════════════════════════════════════
    6. RÉINITIALISATION
    ═══════════════════════════════════════════════════════════════════
    */
    function resetMap() {
        if (!allPaths) return;
        allPaths.classed('dimmed', false).classed('active', false);
        document.querySelectorAll('.region-item').forEach(el => el.classList.remove('active'));
        const box = document.getElementById('info-box');
        box.classList.remove('has-selection');
        box.innerHTML = `
            <div class="placeholder">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                <span>Cliquez sur un département<br>pour afficher l'agent local</span>
            </div>
        `;
        document.getElementById('reset-btn').style.display = 'none';
    }

    /*
    ═══════════════════════════════════════════════════════════════════
    7. UTILITAIRE — slugify pour les id HTML
    ═══════════════════════════════════════════════════════════════════
    */
    function slugify(str) {
        return str.toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]/g, '-');
    }
    </script>

</body>
</html>