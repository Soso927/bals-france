/**
 * france-map.js
 *
 * Logique JavaScript de la carte interactive du réseau commercial BALS France.
 * Ce fichier est chargé uniquement sur la page /france-map.
 *
 * Dépendances :
 *   - D3.js v7 (chargé avant ce script via CDN)
 *   - Le fichier GeoJSON /data/france.json (départements français)
 *   - localStorage (pour lire les contacts gérés depuis le back-office)
 *
 * Organisation :
 *   1. TABLE DE CORRESPONDANCE des régions (ancien nom → nouveau nom)
 *   2. COULEURS des régions
 *   3. DONNÉES PAR DÉFAUT des contacts (secours si localStorage vide)
 *   4. chargerContacts() — lecture depuis localStorage
 *   5. Chargement du GeoJSON et rendu de la carte avec D3.js
 *   6. selectRegion() — sélection et affichage des contacts
 *   7. resetMap() — réinitialisation de la carte
 *   8. slugify() — utilitaire de conversion de texte
 */


/* ════════════════════════════════════════════════════════════════
   1. TABLE DE CORRESPONDANCE ANCIENS → NOUVEAUX NOMS DE RÉGIONS
   ────────────────────────────────────────────────────────────────
   Le fichier GeoJSON (france.json) utilise les anciens noms de régions
   (avant la réforme territoriale de 2016).
   Cette table convertit les anciens noms vers les nouveaux.
   Ex: "Alsace" + "Lorraine" + "Champagne-Ardenne" → "Grand Est"
   ════════════════════════════════════════════════════════════════ */
const REGION_MAP = {
    'Alsace':               'Grand Est',
    'Champagne-Ardenne':    'Grand Est',
    'Lorraine':             'Grand Est',
    'Aquitaine':            'Nouvelle-Aquitaine',
    'Limousin':             'Nouvelle-Aquitaine',
    'Poitou-Charentes':     'Nouvelle-Aquitaine',
    'Auvergne':             'Auvergne-Rhône-Alpes',
    'Rhône-Alpes':          'Auvergne-Rhône-Alpes',
    'Bourgogne':            'Bourgogne-Franche-Comté',
    'Franche-Comté':        'Bourgogne-Franche-Comté',
    'Basse-Normandie':      'Normandie',
    'Haute-Normandie':      'Normandie',
    'Languedoc-Roussillon': 'Occitanie',
    'Midi-Pyrénées':        'Occitanie',
    'Nord-Pas-de-Calais':   'Hauts-de-France',
    'Picardie':             'Hauts-de-France',
    'Bretagne':             'Bretagne',
    'Centre':               'Centre-Val de Loire',
    'Corse':                'Corse',
    'Île-de-France':        'Île-de-France',
    'Pays de la Loire':     'Pays de la Loire',
    "Provence-Alpes-Côte-d'Azur": "Provence-Alpes-Côte d'Azur",
};


/* ════════════════════════════════════════════════════════════════
   2. COULEURS DES RÉGIONS SUR LA CARTE
   ────────────────────────────────────────────────────────────────
   Chaque région a une couleur distinctive pour faciliter la lecture.
   Les couleurs maximisent le contraste entre régions voisines.
   ════════════════════════════════════════════════════════════════ */
const COLORS = {
    'Auvergne-Rhône-Alpes':        '#7C3AED',  /* Violet         */
    'Bourgogne-Franche-Comté':     '#059669',  /* Vert émeraude  */
    'Bretagne':                    '#ED1C24',  /* Rouge Bals     */
    'Centre-Val de Loire':         '#CA8A04',  /* Or             */
    'Corse':                       '#0E7490',  /* Bleu canard    */
    'Grand Est':                   '#FAF700',  /* Jaune vif      */
    'Hauts-de-France':             '#4F46E5',  /* Indigo         */
    'Île-de-France':               '#DC2626',  /* Rouge vif      */
    'Normandie':                   '#00FA08',  /* Vert vif       */
    'Nouvelle-Aquitaine':          '#F97316',  /* Orange         */
    'Occitanie':                   '#EC4899',  /* Rose           */
    'Pays de la Loire':            '#A855F7',  /* Violet clair   */
    "Provence-Alpes-Côte d'Azur": '#0E7490',  /* Bleu canard    */
};

/* Gris de secours pour une région non répertoriée */
const DEFAULT_COLOR = '#94A3B8';


/* ════════════════════════════════════════════════════════════════
   3. DONNÉES PAR DÉFAUT DES CONTACTS
   ────────────────────────────────────────────────────────────────
   Ces données servent de SECOURS si localStorage est vide
   (première visite ou données effacées par l'utilisateur).
   Elles correspondent aux agents commerciaux réels de BALS France.

   Structure d'une région :
   {
     zone:   'NOM AFFICHÉ' (peut différer du nom de la région),
     agents: [ { agence, nom, depts, tel, telRaw, email }, ... ]
   }
   ════════════════════════════════════════════════════════════════ */
const CONTACTS_PAR_DEFAUT = {

    'Normandie': {
        zone: 'NORMANDIE',
        agents: [{
            agence: null,
            nom:    'Vincent CARPENTIER',
            depts:  'Dépt. 14, 27, 50, 61, 76',
            tel:    '06 27 32 49 23',
            telRaw: '+330627324923',
            email:  'vincent.carpentier85@sfr.fr'
        }]
    },

    'Bretagne': {
        zone: 'BRETAGNE',
        agents: [{
            agence: 'AGENCE BONDUELLE',
            nom:    'Isabelle ESPELLE',
            depts:  'Dépt. 22, 29, 35, 56',
            tel:    '02 40 09 77 95',
            telRaw: '+330240097795',
            email:  'contact@agence-bonduelle.com'
        }]
    },

    'Pays de la Loire': {
        zone: 'PAYS DE LA LOIRE',
        agents: [{
            agence: 'AGENCE BONDUELLE',
            nom:    'Isabelle ESPELLE',
            depts:  'Dépt. 44, 49, 53, 72, 79, 85',
            tel:    '02 40 09 77 95',
            telRaw: '+330240097795',
            email:  'contact@agence-bonduelle.com'
        }]
    },

    'Centre-Val de Loire': {
        zone: 'VAL DE LOIRE',
        agents: [{
            agence: null,
            nom:    'Yann GUYADER',
            depts:  'Dépt. 18, 28, 36, 37, 41, 45, 86',
            tel:    '06 02 19 82 90',
            telRaw: '+330602198290',
            email:  'yguyader@gstec.fr'
        }]
    },

    'Île-de-France': {
        zone: 'ÎLE-DE-FRANCE',
        agents: [
            {
                agence: 'AGENCE DUMAS',
                nom:    'Alexis ANDRADE SILVA',
                depts:  'Dépt. 75, 78, 92',
                tel:    '06 33 37 30 17',
                telRaw: '+330633373017',
                email:  'a.andradesilva@agencedumas.net'
            },
            {
                agence: 'AGENCE DUMAS',
                nom:    'Arnaud JOUSSELIN',
                depts:  'Dépt. 93, 95',
                tel:    '06 50 98 23 67',
                telRaw: '+330650982367',
                email:  'a.jousselin@agencedumas.net'
            },
            {
                agence: 'AGENCE DUMAS',
                nom:    'Adrien DUMAS',
                depts:  'Dépt. 77, 91, 94',
                tel:    '06 33 57 21 38',
                telRaw: '+330633572138',
                email:  'a.dumas@agencedumas.net'
            }
        ]
    },

    'Hauts-de-France': {
        zone: 'HAUTS-DE-FRANCE',
        agents: [
            {
                agence: 'AGENCE BESSA',
                nom:    'Francis BESSA',
                depts:  'Dépt. 59, 62, 80',
                tel:    '06 09 62 92 30',
                telRaw: '+330609629230',
                email:  'Francis.bessa@agencebessa.fr'
            },
            {
                agence: 'AGENCE PICHAMPARDENNAISE',
                nom:    'Angéline FAUCHART-PETIT',
                depts:  'Dépt. 02, 60',
                tel:    '06 62 39 11 93',
                telRaw: '+330662391193',
                email:  'agence.angeline@orange.fr'
            }
        ]
    },

    'Grand Est': {
        zone: 'GRAND EST',
        agents: [
            {
                agence: 'AGENCE VIERLING',
                nom:    'Christian VIERLING',
                depts:  'Dépt. 54, 55, 57, 67, 68, 88, 90',
                tel:    '06 09 48 66 91',
                telRaw: '+330609486691',
                email:  'contact@agencevierling.fr'
            },
            {
                agence: 'AGENCE PICHAMPARDENNAISE',
                nom:    'Angéline FAUCHART-PETIT',
                depts:  'Dépt. 08, 10, 51, 52',
                tel:    '06 62 39 11 93',
                telRaw: '+330662391193',
                email:  'agence.angeline@orange.fr'
            }
        ]
    },

    'Bourgogne-Franche-Comté': {
        zone: 'BOURGOGNE FRANCHE-COMTÉ',
        agents: [{
            agence: 'FANJOUX',
            nom:    'Raphaël LEGRAND',
            depts:  'Dépt. 21, 25, 39, 58, 70, 71, 89',
            tel:    '06 12 22 34 16',
            telRaw: '+330612223416',
            email:  'Raphael.legrand@fanjouxdiffusion.com'
        }]
    },

    'Auvergne-Rhône-Alpes': {
        zone: 'AUVERGNE-RHÔNE-ALPES',
        agents: [
            {
                agence: 'MONIER',
                nom:    'Ghislain MONIER',
                depts:  'Dépt. 03, 15, 43, 63',
                tel:    '06 78 98 74 30',
                telRaw: '+330678987430',
                email:  'contact@agencemonier.com'
            },
            {
                agence: 'AGENCE XPE XPRO ELEC',
                nom:    'Lionel AUCLAIR',
                depts:  'Dépt. 07, 26, 42',
                tel:    '07 85 23 64 23',
                telRaw: '+330785236423',
                email:  'lauclair@xpe-france.fr'
            },
            {
                agence: 'AGENCE XPE XPRO ELEC',
                nom:    'Nicolas CHARPENTIER',
                depts:  'Dépt. 01, 73, 74',
                tel:    '06 08 62 00 39',
                telRaw: '+330608620039',
                email:  'ncharpentier@xpe-france.com'
            },
            {
                agence: 'AGENCE XPE XPRO ELEC',
                nom:    'Olivier REYNAUD',
                depts:  'Dépt. 38, 69',
                tel:    '06 80 08 25 26',
                telRaw: '+330680082526',
                email:  'commercial@xpe-france.com'
            }
        ]
    },

    'Nouvelle-Aquitaine': {
        zone: 'NOUVELLE-AQUITAINE',
        agents: [
            {
                agence: 'MONIER',
                nom:    'Ghislain MONIER',
                depts:  'Dépt. 19, 23, 87',
                tel:    '06 78 98 74 30',
                telRaw: '+330678987430',
                email:  'contact@agencemonier.com'
            },
            {
                agence: 'RMEE',
                nom:    'Christophe NIETRZEBA',
                depts:  'Dépt. 16, 17, 24',
                tel:    '06 80 46 93 93',
                telRaw: '+330680469393',
                email:  'c.nietrzeba@rmee.fr'
            },
            {
                agence: 'RMEE',
                nom:    'Jean-Christophe SEBILE',
                depts:  'Dépt. 33, 40, 47, 64',
                tel:    '06 86 16 63 64',
                telRaw: '+330686166364',
                email:  'jc.sebile@rmee.fr'
            }
        ]
    },

    'Occitanie': {
        zone: 'OCCITANIE',
        agents: [
            {
                agence: 'REPELEC',
                nom:    'Cédric RICAUD',
                depts:  'Dépt. 09, 11, 32, 46, 65, 82',
                tel:    '06 33 98 59 18',
                telRaw: '+330633985918',
                email:  'c.ricaud@repelec.fr'
            },
            {
                agence: 'REPELEC',
                nom:    'Sébastien LIENARD',
                depts:  'Dépt. 12, 31, 48, 66, 81',
                tel:    '06 78 22 54 30',
                telRaw: '+330678225430',
                email:  's.lienard@repelec.fr'
            },
            {
                agence: 'AGENCE RENAUDI',
                nom:    'Fabien RENAUDI',
                depts:  'Dépt. 30, 34',
                tel:    '06 29 44 69 94',
                telRaw: '+330629446994',
                email:  'contact@agencerenaudi.fr'
            }
        ]
    },

    "Provence-Alpes-Côte d'Azur": {
        zone: 'MÉDITERRANÉE',
        agents: [{
            agence: 'AGENCE RENAUDI',
            nom:    'Fabien RENAUDI',
            depts:  'Dépt. 04, 05, 06, 13, 83, 84',
            tel:    '06 29 44 69 94',
            telRaw: '+330629446994',
            email:  'contact@agencerenaudi.fr'
        }]
    },

    'Corse': {
        zone: 'MÉDITERRANÉE',
        agents: [{
            agence: 'AGENCE RENAUDI',
            nom:    'Fabien RENAUDI',
            depts:  'Dépt. 2A, 2B',
            tel:    '06 29 44 69 94',
            telRaw: '+330629446994',
            email:  'contact@agencerenaudi.fr'
        }]
    }
};


/* ════════════════════════════════════════════════════════════════
   4. chargerContacts() — LECTURE DEPUIS localStorage
   ────────────────────────────────────────────────────────────────
   Le back-office (admin.blade.php) sauvegarde les contacts dans
   localStorage sous la clé "bals_contacts".

   Cette fonction :
     1. Lit "bals_contacts" dans localStorage
     2. Si des données existent → les retourne (données de l'admin)
     3. Sinon → sauvegarde et retourne les données par défaut

   C'est ce mécanisme qui synchronise le back-office et la carte
   sans nécessiter de base de données.
   ════════════════════════════════════════════════════════════════ */
function chargerContacts() {
    const donneesSauvegardees = localStorage.getItem('bals_contacts');

    if (donneesSauvegardees) {
        return JSON.parse(donneesSauvegardees);
    }

    /* Première visite : initialiser localStorage avec les données par défaut */
    localStorage.setItem('bals_contacts', JSON.stringify(CONTACTS_PAR_DEFAUT));
    return CONTACTS_PAR_DEFAUT;
}

/* Chargement des contacts (localStorage ou données par défaut) */
const CONTACTS = chargerContacts();


/* ════════════════════════════════════════════════════════════════
   5. VARIABLES GLOBALES
   ════════════════════════════════════════════════════════════════ */
let deptCounts = {};  /* Nombre de départements par région (calculé lors du rendu) */
let allPaths   = null; /* Sélection D3 de tous les <path> SVG des départements   */


/* ════════════════════════════════════════════════════════════════
   6. CHARGEMENT DU GEOJSON ET RENDU DE LA CARTE AVEC D3.js
   ────────────────────────────────────────────────────────────────
   fetch()  → télécharge le fichier france.json
   D3.js    → dessine chaque département comme un chemin SVG coloré
   ════════════════════════════════════════════════════════════════ */
fetch('/data/france.json')
    .then(r => r.json())
    .then(geojson => {

        /* On garde uniquement la France métropolitaine (latitude > 40°)
           Cela exclut automatiquement les DOM-TOM */
        const features = geojson.features.filter(f => f.properties.latitude > 40);

        /* Conversion anciens → nouveaux noms de régions */
        features.forEach(f => {
            const oldRegion = f.properties.region;
            f.properties.region = REGION_MAP[oldRegion] || oldRegion;
        });

        /* Comptage du nombre de départements par région */
        features.forEach(f => {
            const r = f.properties.region;
            deptCounts[r] = (deptCounts[r] || 0) + 1;
        });

        /* Mesure du conteneur pour dimensionner le SVG */
        const container = document.getElementById('map-container');
        const getW = () => container.clientWidth || 720;
        let W = getW();
        let H = Math.round(W * 0.88);  /* ratio hauteur/largeur de la carte */

        /* Création de l'élément SVG avec D3 */
        const svg = d3.select('#map-container')
            .append('svg')
            .attr('width', '100%')
            .attr('height', H)
            .attr('viewBox', `0 0 ${W} ${H}`)
            .attr('preserveAspectRatio', 'xMidYMid meet');

        /* Projection Mercator : convertit lat/long en coordonnées pixels */
        const projection = d3.geoMercator()
            .fitSize([W, H], { type: 'FeatureCollection', features });

        /* Générateur de chemins SVG à partir de la projection */
        const path    = d3.geoPath().projection(projection);
        const tooltip = document.getElementById('tooltip');

        /* Dessin de chaque département */
        allPaths = svg.selectAll('path')
            .data(features)
            .enter()
            .append('path')
            .attr('class', 'departement')
            .attr('d', path)
            .attr('fill', d => COLORS[d.properties.region] || DEFAULT_COLOR)
            /* Tooltip au mouvement de la souris */
            .on('mousemove', (event, d) => {
                const zone = CONTACTS[d.properties.region]?.zone || d.properties.region;
                tooltip.style.opacity = '1';
                tooltip.style.left   = (event.clientX + 16) + 'px';
                tooltip.style.top    = (event.clientY - 12) + 'px';
                tooltip.innerHTML    = `<strong>${d.properties.name}</strong><small>${zone}</small>`;
            })
            .on('mouseleave', () => { tooltip.style.opacity = '0'; })
            /* Clic → sélectionner la région */
            .on('click', (event, d) => {
                event.stopPropagation();
                selectRegion(d.properties.region, d.properties.name);
            });

        /* Double-clic sur le fond SVG → réinitialiser */
        svg.on('dblclick', () => resetMap());

        /* ── Génération de la liste des régions (panneau latéral) ── */
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

        /* Recalcul du SVG lors du redimensionnement de la fenêtre */
        window.addEventListener('resize', () => {
            W = getW();
            H = Math.round(W * 0.88);
            svg.attr('height', H).attr('viewBox', `0 0 ${W} ${H}`);
            projection.fitSize([W, H], { type: 'FeatureCollection', features });
            svg.selectAll('path').attr('d', path);
        });
    })
    .catch(() => {
        /* Message d'erreur si france.json est introuvable */
        document.getElementById('map-container').innerHTML = `
            <div style="padding:32px;text-align:center;color:#ED1C24">
                <strong>⚠ Impossible de charger la carte</strong><br>
                <small style="color:#6b7280">Vérifiez que <code>public/data/france.json</code> existe</small>
            </div>
        `;
    });


/* ════════════════════════════════════════════════════════════════
   7. selectRegion() — SÉLECTION ET AFFICHAGE DES CONTACTS
   ────────────────────────────────────────────────────────────────
   Appelée quand l'utilisateur clique sur un département (SVG)
   ou sur un élément de la liste latérale.

   @param {string} regionName  Nom de la région sélectionnée
   @param {string|null} deptName  Nom du département cliqué (null si sélection par liste)
   ════════════════════════════════════════════════════════════════ */
function selectRegion(regionName, deptName) {
    if (!allPaths) return;

    /* Mettre en avant la région sur la carte */
    allPaths
        .classed('dimmed', d => d.properties.region !== regionName)
        .classed('active', d => d.properties.region === regionName);

    /* Mettre en avant la région dans la liste latérale */
    document.querySelectorAll('.region-item').forEach(el => el.classList.remove('active'));
    const li = document.getElementById('li-' + slugify(regionName));
    if (li) {
        li.classList.add('active');
        li.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /* Récupération des données de la région */
    const color  = COLORS[regionName] || DEFAULT_COLOR;
    const data   = CONTACTS[regionName];
    const zone   = data?.zone || regionName;
    const agents = data?.agents || [];
    const box    = document.getElementById('info-box');
    box.classList.add('has-selection');

    /* Génération du HTML pour chaque agent */
    const agentsHTML = agents.map(a => `
        <div class="contact-card">
            ${a.agence ? `<div class="contact-agence">${a.agence}</div>` : ''}
            <div class="contact-nom">${a.nom}</div>
            <div class="contact-depts">${a.depts}</div>
            <div class="contact-links">
                <a href="tel:${a.telRaw}" class="contact-link">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.37 19
                               A19.46 19.46 0 0 1 5 12.63a19.79 19.79 0 0 1-2.92-8.4A2 2 0
                               0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.96.36 1.9.7 2.81a2 2 0 0
                               1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1
                               2.11-.45c.91.35 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>
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

    /* Injection du HTML dans l'info-box */
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
                ${deptCounts[regionName] || 0} département${(deptCounts[regionName] || 0) > 1 ? 's' : ''}
                · ${agents.length} agent${agents.length > 1 ? 's' : ''}
            </div>
            ${agentsHTML || `<p style="font-size:13px;color:#6b7280">
                Contactez le siège au
                <a href="tel:+33164786080" style="color:var(--bals-blue)">01 64 78 60 80</a>
            </p>`}
        </div>
    `;

    /* Afficher le bouton de réinitialisation */
    document.getElementById('reset-btn').style.display = 'block';
}


/* ════════════════════════════════════════════════════════════════
   8. resetMap() — RÉINITIALISATION DE LA CARTE
   ────────────────────────────────────────────────────────────────
   Remet la carte dans son état initial :
   - Tous les départements reprennent leur couleur normale
   - L'info-box affiche le message d'invitation
   - Le bouton "Réinitialiser" disparaît
   ════════════════════════════════════════════════════════════════ */
function resetMap() {
    if (!allPaths) return;

    /* Supprimer les classes de sélection sur tous les départements */
    allPaths.classed('dimmed', false).classed('active', false);

    /* Supprimer la classe active dans la liste */
    document.querySelectorAll('.region-item').forEach(el => el.classList.remove('active'));

    /* Remettre le placeholder dans l'info-box */
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

    /* Cacher le bouton réinitialiser */
    document.getElementById('reset-btn').style.display = 'none';
}


/* ════════════════════════════════════════════════════════════════
   9. slugify() — UTILITAIRE DE CONVERSION DE TEXTE
   ────────────────────────────────────────────────────────────────
   Transforme un nom de région en identifiant HTML valide.
   Ex: "Île-de-France" → "ile-de-france"

   Utilisé pour créer des id HTML uniques pour chaque région
   dans la liste latérale (id="li-ile-de-france").
   ════════════════════════════════════════════════════════════════ */
function slugify(str) {
    return str.toLowerCase()
        .normalize('NFD')              /* décompose les caractères accentués */
        .replace(/[̀-ͯ]/g, '') /* supprime les accents */
        .replace(/[^a-z0-9]/g, '-');    /* remplace tout le reste par un tiret */
}
