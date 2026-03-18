{{--
╔═══════════════════════════════════════════════════════════════════════════════╗
║  BACK-OFFICE — GESTION DES AGENTS COMMERCIAUX BALS FRANCE                  ║
║                                                                              ║
║  Ce fichier est la page d'administration (back-office).                      ║
║  Elle permet à l'administrateur de :                                         ║
║    1. Voir tous les agents classés par région                                ║
║    2. Modifier les infos d'un agent (nom, téléphone, email, etc.)            ║
║    3. Ajouter un nouvel agent à une région                                   ║
║    4. Supprimer un agent                                                     ║
║                                                                              ║
║  Les données sont stockées dans le localStorage du navigateur.               ║
║  localStorage = un petit espace de stockage dans le navigateur               ║
║  qui conserve les données même après fermeture de la page.                   ║
║                                                                              ║
║  FONCTIONNEMENT :                                                            ║
║    - Au chargement, on lit les données depuis localStorage                   ║
║    - Si aucune donnée n'existe, on utilise les données par défaut            ║
║    - À chaque modification, on sauvegarde dans localStorage                  ║
║    - La carte interactive lit ces mêmes données depuis localStorage          ║
╚═══════════════════════════════════════════════════════════════════════════════╝
--}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-office — Gestion des agents | Bals France</title>

    {{-- Tailwind CSS pour le style rapide --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Police Exo 2 — même police que la carte interactive --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /*
        ═══════════════════════════════════════════════════════════
        VARIABLES CSS — COULEURS BALS (Style Guide V2016 page 08)
        On réutilise les mêmes couleurs que la carte interactive
        pour garder une cohérence visuelle sur tout le site.
        ═══════════════════════════════════════════════════════════
        */
        :root {
            --bals-blue: #0095DA;     /* Bleu Bals officiel */
            --bals-red: #ED1C24;      /* Rouge Bals officiel */
            --bals-black: #1A1A1A;    /* Noir pour le texte */
            --bals-grey: #B3B3B3;     /* Gris clair officiel */
            --bals-grey-light: #F4F6F8; /* Fond de page */
        }

        /* On applique la police Exo 2 à toute la page */
        * {
            font-family: 'Exo 2', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: var(--bals-grey-light);
            color: var(--bals-black);
        }

        /*
        ═══════════════════════════════════════
        Barre bleue→rouge en haut de la page
        (même design que la carte interactive)
        ═══════════════════════════════════════
        */
        .brand-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--bals-blue) 70%, var(--bals-red) 100%);
        }

        /*
        ═══════════════════════════════════════
        STYLES DES CARTES D'AGENTS
        Chaque agent est affiché dans une "carte"
        avec ses informations et des boutons d'action
        ═══════════════════════════════════════
        */
        .agent-card {
            background: white;
            border: 1px solid #E2E6EA;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 12px;
            /* Transition douce quand on survole la carte */
            transition: box-shadow 0.2s, border-color 0.2s;
        }

        /* Au survol, la carte se met légèrement en avant */
        .agent-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border-color: var(--bals-blue);
        }

        /*
        ═══════════════════════════════════════
        FORMULAIRE DE MODIFICATION
        Quand on clique sur "Modifier", un formulaire
        apparaît à la place des infos de l'agent
        ═══════════════════════════════════════
        */
        .edit-form input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #E2E6EA;
            border-radius: 6px;
            font-size: 13px;
            font-family: 'Exo 2', sans-serif;
            margin-bottom: 8px;
            /* Transition pour le focus */
            transition: border-color 0.2s;
        }

        /* Quand on clique dans un champ, la bordure devient bleue */
        .edit-form input:focus {
            outline: none;
            border-color: var(--bals-blue);
        }

        /*
        ═══════════════════════════════════════
        MESSAGE DE CONFIRMATION
        Affiché après une sauvegarde réussie
        ═══════════════════════════════════════
        */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #059669;  /* Vert = succès */
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            /* Caché par défaut */
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s;
            z-index: 9999;
        }

        /* Classe ajoutée quand on veut montrer le message */
        .toast.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>

    {{-- ══════════════ BARRE BLEUE/ROUGE EN HAUT ══════════════ --}}
    <div class="brand-bar"></div>

    {{--
    ═══════════════════════════════════════════════════════════════
    CONTENU PRINCIPAL DE LA PAGE
    Structure : en-tête + liste des régions avec leurs agents
    ═══════════════════════════════════════════════════════════════
    --}}
    <div class="max-w-4xl mx-auto px-6 py-10">

        {{-- ══════════════ EN-TÊTE DE LA PAGE ══════════════ --}}
        <div class="mb-8">

            {{-- Lien pour retourner à la carte interactive --}}
            <a href="/france-map"
               class="inline-flex items-center gap-2 text-sm font-medium mb-4"
               style="color: var(--bals-blue);">
                {{-- Icône flèche gauche (SVG) --}}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Retour à la carte
            </a>

            {{-- Titre principal --}}
            <h1 class="text-3xl font-extrabold" style="color: var(--bals-black);">
                Gestion des agents
                <span style="color: var(--bals-red);">commerciaux</span>
            </h1>

            {{-- Sous-titre explicatif --}}
            <p class="text-sm mt-2" style="color: #6b7280;">
                Modifiez les informations des agents directement ici.
                Les changements seront visibles immédiatement sur la carte interactive.
            </p>
        </div>

        {{--
        ═══════════════════════════════════════════════════════════
        BARRE D'ACTIONS : Bouton pour ajouter un agent
        ═══════════════════════════════════════════════════════════
        --}}
        <div class="flex items-center justify-between mb-6">
            <span class="text-sm font-bold uppercase tracking-wider"
                  style="color: var(--bals-grey);"
                  id="total-agents">
                — agents au total
            </span>

            {{-- Bouton "Ajouter un agent" --}}
            <button onclick="afficherFormulaireAjout()"
                    class="text-white text-sm font-semibold px-5 py-2.5 rounded-lg
                           transition-all hover:brightness-110"
                    style="background: var(--bals-blue);">
                + Ajouter un agent
            </button>
        </div>

        {{--
        ═══════════════════════════════════════════════════════════
        FORMULAIRE D'AJOUT D'UN NOUVEL AGENT
        Caché par défaut, affiché quand on clique sur "Ajouter"
        ═══════════════════════════════════════════════════════════
        --}}
        <div id="formulaire-ajout" class="hidden mb-8 bg-white border border-dashed
             rounded-xl p-6" style="border-color: var(--bals-blue);">

            <h3 class="text-base font-bold mb-4" style="color: var(--bals-blue);">
                Nouvel agent
            </h3>

            {{-- Formulaire avec tous les champs nécessaires --}}
            <div class="edit-form">

                {{-- Menu déroulant pour choisir la région --}}
                <label class="block text-xs font-semibold uppercase tracking-wider mb-1"
                       style="color: var(--bals-grey);">
                    Région
                </label>
                <select id="new-region"
                        class="w-full p-2 border rounded-md text-sm mb-3"
                        style="border-color: #E2E6EA; font-family: 'Exo 2', sans-serif;">
                    {{-- Les options sont remplies dynamiquement par JavaScript --}}
                </select>

                {{-- Champ : Nom de l'agence (optionnel) --}}
                <input type="text" id="new-agence" placeholder="Agence (optionnel)">

                {{-- Champ : Nom complet de l'agent --}}
                <input type="text" id="new-nom" placeholder="Nom complet *" required>

                {{-- Champ : Départements couverts --}}
                <input type="text" id="new-depts" placeholder="Départements (ex: Dépt. 75, 92)">

                {{-- Champ : Numéro de téléphone affiché --}}
                <input type="text" id="new-tel" placeholder="Téléphone (ex: 06 12 34 56 78)">

                {{-- Champ : Numéro brut pour le lien tel: --}}
                <input type="text" id="new-telRaw" placeholder="Tél. brut (ex: +33612345678)">

                {{-- Champ : Adresse email --}}
                <input type="email" id="new-email" placeholder="Email *" required>

                {{-- Boutons Valider / Annuler --}}
                <div class="flex gap-3 mt-3">
                    <button onclick="ajouterAgent()"
                            class="text-white text-sm font-semibold px-4 py-2 rounded-lg"
                            style="background: #059669;">
                        Valider
                    </button>
                    <button onclick="cacherFormulaireAjout()"
                            class="text-sm font-semibold px-4 py-2 rounded-lg border"
                            style="color: var(--bals-grey); border-color: #E2E6EA;">
                        Annuler
                    </button>
                </div>
            </div>
        </div>

        {{--
        ═══════════════════════════════════════════════════════════
        ZONE D'AFFICHAGE — ici seront injectées toutes les régions
        et leurs agents par JavaScript
        ═══════════════════════════════════════════════════════════
        --}}
        <div id="liste-regions"></div>

    </div>

    {{-- ══════════════ MESSAGE DE CONFIRMATION ══════════════ --}}
    <div class="toast" id="toast">Modifications enregistrées !</div>

    {{--
    ╔═══════════════════════════════════════════════════════════════════════════╗
    ║                                                                          ║
    ║                         JAVASCRIPT — LOGIQUE                             ║
    ║                                                                          ║
    ║  Ce script gère toute la logique du back-office :                        ║
    ║    1. Chargement des données depuis localStorage                         ║
    ║    2. Affichage des régions et agents                                    ║
    ║    3. Modification d'un agent                                            ║
    ║    4. Ajout d'un nouvel agent                                            ║
    ║    5. Suppression d'un agent                                             ║
    ║    6. Sauvegarde dans localStorage                                       ║
    ╚═══════════════════════════════════════════════════════════════════════════╝
    --}}
    <script>
        /*
        ═══════════════════════════════════════════════════════════════════
        1. DONNÉES PAR DÉFAUT
        ───────────────────────────────────────────────────────────────────
        Ces données sont utilisées UNIQUEMENT si localStorage est vide
        (= première utilisation de l'application).
        C'est une copie exacte des contacts de la carte interactive.
        ═══════════════════════════════════════════════════════════════════
        */
        const DONNEES_PAR_DEFAUT = {

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
        2. CHARGER LES DONNÉES
        ───────────────────────────────────────────────────────────────────
        Cette fonction essaie de lire les données depuis localStorage.
        Si rien n'est trouvé, elle utilise les données par défaut.

        localStorage.getItem('clé') → retourne la valeur stockée ou null
        JSON.parse() → transforme du texte en objet JavaScript
        ═══════════════════════════════════════════════════════════════════
        */
        function chargerContacts() {

            // On essaie de lire "bals_contacts" dans localStorage
            const donneesSauvegardees = localStorage.getItem('bals_contacts');

            // Si des données existent, on les utilise
            if (donneesSauvegardees) {
                return JSON.parse(donneesSauvegardees);
            }

            // Sinon, on utilise les données par défaut
            // et on les sauvegarde pour la prochaine fois
            localStorage.setItem('bals_contacts', JSON.stringify(DONNEES_PAR_DEFAUT));
            return DONNEES_PAR_DEFAUT;
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        3. SAUVEGARDER LES DONNÉES
        ───────────────────────────────────────────────────────────────────
        Cette fonction écrit les données dans localStorage.
        JSON.stringify() → transforme un objet JavaScript en texte
        (localStorage ne peut stocker que du texte)
        ═══════════════════════════════════════════════════════════════════
        */
        function sauvegarderContacts(contacts) {
            localStorage.setItem('bals_contacts', JSON.stringify(contacts));
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        4. AFFICHER TOUTES LES RÉGIONS ET LEURS AGENTS
        ───────────────────────────────────────────────────────────────────
        Cette fonction génère le HTML de toute la page :
        - Pour chaque région, une section avec un titre
        - Pour chaque agent dans la région, une "carte" avec ses infos
        ═══════════════════════════════════════════════════════════════════
        */
        function afficherTout() {

            // On charge les données actuelles
            const contacts = chargerContacts();

            // On récupère la zone d'affichage dans le HTML
            const conteneur = document.getElementById('liste-regions');

            // On vide le contenu actuel (pour le rafraîchir)
            conteneur.innerHTML = '';

            // Compteur total d'agents
            let totalAgents = 0;

            // On trie les régions par ordre alphabétique
            const regionsTriees = Object.keys(contacts).sort();

            /*
            ─── BOUCLE : pour chaque région ───
            Object.keys(contacts) retourne la liste des noms de régions
            Ex: ['Normandie', 'Bretagne', 'Île-de-France', ...]
            */
            regionsTriees.forEach(function(nomRegion) {

                // On récupère les données de cette région
                const region = contacts[nomRegion];

                // On compte les agents de cette région
                totalAgents += region.agents.length;

                /*
                ─── Construction du HTML pour cette région ───
                On crée une section avec :
                - Le nom de la zone commerciale
                - Le nombre d'agents
                - Puis chaque carte d'agent
                */
                let htmlRegion = `
                    <div class="mb-8">
                        <!-- Titre de la région -->
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-lg font-bold" style="color: var(--bals-black);">
                                ${nomRegion}
                                <span class="text-xs font-semibold uppercase tracking-wider ml-2"
                                      style="color: var(--bals-blue);">
                                    ${region.zone}
                                </span>
                            </h2>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full"
                                  style="background: rgba(0,149,218,0.1); color: var(--bals-blue);">
                                ${region.agents.length} agent${region.agents.length > 1 ? 's' : ''}
                            </span>
                        </div>
                `;

                /*
                ─── BOUCLE : pour chaque agent de cette région ───
                index = position de l'agent dans le tableau (0, 1, 2...)
                On a besoin de l'index pour identifier l'agent lors de
                la modification ou la suppression.
                */
                region.agents.forEach(function(agent, index) {

                    htmlRegion += `
                        <div class="agent-card" id="agent-${nomRegion}-${index}">

                            <!-- ═══ MODE AFFICHAGE (lecture seule) ═══ -->
                            <div id="affichage-${nomRegion}-${index}">

                                <!-- Nom de l'agence (si renseigné) -->
                                ${agent.agence
                                    ? `<div class="text-xs font-bold uppercase tracking-wider mb-1"
                                            style="color: var(--bals-blue);">
                                            ${agent.agence}
                                       </div>`
                                    : ''
                                }

                                <!-- Nom de l'agent -->
                                <div class="text-sm font-bold"
                                     style="color: var(--bals-black);">
                                    ${agent.nom}
                                </div>

                                <!-- Départements couverts -->
                                <div class="text-xs mt-1" style="color: #6b7280;">
                                    ${agent.depts}
                                </div>

                                <!-- Téléphone et email -->
                                <div class="text-xs mt-1" style="color: var(--bals-blue);">
                                    ${agent.tel} · ${agent.email}
                                </div>

                                <!-- Boutons d'action : Modifier / Supprimer -->
                                <div class="flex gap-2 mt-3">
                                    <button onclick="activerModification('${nomRegion}', ${index})"
                                            class="text-xs font-semibold px-3 py-1.5 rounded-md
                                                   transition-all"
                                            style="background: rgba(0,149,218,0.1);
                                                   color: var(--bals-blue);">
                                        Modifier
                                    </button>
                                    <button onclick="supprimerAgent('${nomRegion}', ${index})"
                                            class="text-xs font-semibold px-3 py-1.5 rounded-md
                                                   transition-all"
                                            style="background: rgba(237,28,36,0.1);
                                                   color: var(--bals-red);">
                                        Supprimer
                                    </button>
                                </div>
                            </div>

                            <!-- ═══ MODE MODIFICATION (formulaire caché par défaut) ═══ -->
                            <div id="edition-${nomRegion}-${index}"
                                 class="edit-form hidden">

                                <input type="text"
                                       id="edit-agence-${nomRegion}-${index}"
                                       value="${agent.agence || ''}"
                                       placeholder="Agence (optionnel)">

                                <input type="text"
                                       id="edit-nom-${nomRegion}-${index}"
                                       value="${agent.nom}"
                                       placeholder="Nom complet">

                                <input type="text"
                                       id="edit-depts-${nomRegion}-${index}"
                                       value="${agent.depts}"
                                       placeholder="Départements">

                                <input type="text"
                                       id="edit-tel-${nomRegion}-${index}"
                                       value="${agent.tel}"
                                       placeholder="Téléphone">

                                <input type="text"
                                       id="edit-telRaw-${nomRegion}-${index}"
                                       value="${agent.telRaw}"
                                       placeholder="Tél. brut (+33...)">

                                <input type="email"
                                       id="edit-email-${nomRegion}-${index}"
                                       value="${agent.email}"
                                       placeholder="Email">

                                <!-- Boutons Sauvegarder / Annuler -->
                                <div class="flex gap-2 mt-2">
                                    <button onclick="sauvegarderModification('${nomRegion}', ${index})"
                                            class="text-white text-xs font-semibold
                                                   px-4 py-2 rounded-md"
                                            style="background: #059669;">
                                        Sauvegarder
                                    </button>
                                    <button onclick="annulerModification('${nomRegion}', ${index})"
                                            class="text-xs font-semibold px-4 py-2
                                                   rounded-md border"
                                            style="color: var(--bals-grey);
                                                   border-color: #E2E6EA;">
                                        Annuler
                                    </button>
                                </div>
                            </div>

                        </div>
                    `;
                });

                // On ferme la div de la région
                htmlRegion += `</div>`;

                // On ajoute le HTML de cette région au conteneur
                conteneur.innerHTML += htmlRegion;
            });

            // On met à jour le compteur total
            document.getElementById('total-agents').textContent =
                totalAgents + ' agents au total';

            // On remplit le menu déroulant des régions (pour l'ajout)
            remplirMenuRegions(regionsTriees);
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        5. REMPLIR LE MENU DÉROULANT DES RÉGIONS
        ───────────────────────────────────────────────────────────────────
        Utilisé dans le formulaire d'ajout pour que l'admin
        puisse choisir dans quelle région ajouter l'agent.
        ═══════════════════════════════════════════════════════════════════
        */
        function remplirMenuRegions(regions) {
            const select = document.getElementById('new-region');
            select.innerHTML = ''; // On vide d'abord

            regions.forEach(function(region) {
                // On crée une balise <option> pour chaque région
                const option = document.createElement('option');
                option.value = region;    // Valeur envoyée
                option.textContent = region; // Texte affiché
                select.appendChild(option);
            });
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        6. ACTIVER LE MODE MODIFICATION
        ───────────────────────────────────────────────────────────────────
        Quand l'admin clique sur "Modifier" :
        - On cache l'affichage normal de l'agent
        - On montre le formulaire de modification à la place
        ═══════════════════════════════════════════════════════════════════
        */
        function activerModification(region, index) {

            // On cache la vue "lecture seule"
            document.getElementById('affichage-' + region + '-' + index)
                .classList.add('hidden');

            // On montre le formulaire d'édition
            document.getElementById('edition-' + region + '-' + index)
                .classList.remove('hidden');
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        7. ANNULER LA MODIFICATION
        ───────────────────────────────────────────────────────────────────
        L'admin a cliqué sur "Annuler" → on revient à l'affichage normal
        ═══════════════════════════════════════════════════════════════════
        */
        function annulerModification(region, index) {

            // On cache le formulaire d'édition
            document.getElementById('edition-' + region + '-' + index)
                .classList.add('hidden');

            // On réaffiche la vue "lecture seule"
            document.getElementById('affichage-' + region + '-' + index)
                .classList.remove('hidden');
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        8. SAUVEGARDER UNE MODIFICATION
        ───────────────────────────────────────────────────────────────────
        L'admin a rempli le formulaire et cliqué sur "Sauvegarder" :
        - On lit les nouvelles valeurs des champs du formulaire
        - On met à jour l'objet contacts
        - On sauvegarde dans localStorage
        - On rafraîchit l'affichage
        ═══════════════════════════════════════════════════════════════════
        */
        function sauvegarderModification(region, index) {

            // On charge les données actuelles
            const contacts = chargerContacts();

            // On lit les nouvelles valeurs depuis les champs du formulaire
            // .value = le texte tapé par l'admin dans le champ
            // .trim() = enlève les espaces au début et à la fin
            const nouvelleAgence = document.getElementById('edit-agence-' + region + '-' + index).value.trim();
            const nouveauNom     = document.getElementById('edit-nom-' + region + '-' + index).value.trim();
            const nouveauxDepts  = document.getElementById('edit-depts-' + region + '-' + index).value.trim();
            const nouveauTel     = document.getElementById('edit-tel-' + region + '-' + index).value.trim();
            const nouveauTelRaw  = document.getElementById('edit-telRaw-' + region + '-' + index).value.trim();
            const nouveauEmail   = document.getElementById('edit-email-' + region + '-' + index).value.trim();

            // Vérification : le nom et l'email sont obligatoires
            if (!nouveauNom || !nouveauEmail) {
                alert('Le nom et l\'email sont obligatoires.');
                return; // On arrête la fonction ici
            }

            // On met à jour l'agent dans l'objet contacts
            // contacts[region].agents[index] = l'agent qu'on modifie
            contacts[region].agents[index] = {
                agence: nouvelleAgence || null,  // null si le champ est vide
                nom: nouveauNom,
                depts: nouveauxDepts,
                tel: nouveauTel,
                telRaw: nouveauTelRaw,
                email: nouveauEmail
            };

            // On sauvegarde dans localStorage
            sauvegarderContacts(contacts);

            // On rafraîchit tout l'affichage
            afficherTout();

            // On affiche le message de confirmation
            afficherToast('Modifications enregistrées !');
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        9. SUPPRIMER UN AGENT
        ───────────────────────────────────────────────────────────────────
        L'admin a cliqué sur "Supprimer" :
        - On demande une confirmation (pour éviter les erreurs)
        - On retire l'agent du tableau
        - On sauvegarde et on rafraîchit
        ═══════════════════════════════════════════════════════════════════
        */
        function supprimerAgent(region, index) {

            // Demande de confirmation avant suppression
            const confirmation = confirm(
                'Voulez-vous vraiment supprimer cet agent ?'
            );

            // Si l'admin a cliqué "Annuler", on ne fait rien
            if (!confirmation) return;

            // On charge les données
            const contacts = chargerContacts();

            // splice(index, 1) = retire 1 élément à la position "index"
            contacts[region].agents.splice(index, 1);

            // On sauvegarde
            sauvegarderContacts(contacts);

            // On rafraîchit l'affichage
            afficherTout();

            // Message de confirmation
            afficherToast('Agent supprimé.');
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        10. AFFICHER LE FORMULAIRE D'AJOUT
        ═══════════════════════════════════════════════════════════════════
        */
        function afficherFormulaireAjout() {
            // On retire la classe "hidden" pour montrer le formulaire
            document.getElementById('formulaire-ajout').classList.remove('hidden');
        }

        function cacherFormulaireAjout() {
            // On ajoute la classe "hidden" pour cacher le formulaire
            document.getElementById('formulaire-ajout').classList.add('hidden');

            // On vide tous les champs du formulaire
            document.getElementById('new-agence').value = '';
            document.getElementById('new-nom').value = '';
            document.getElementById('new-depts').value = '';
            document.getElementById('new-tel').value = '';
            document.getElementById('new-telRaw').value = '';
            document.getElementById('new-email').value = '';
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        11. AJOUTER UN NOUVEL AGENT
        ───────────────────────────────────────────────────────────────────
        L'admin a rempli le formulaire d'ajout et cliqué sur "Valider" :
        - On lit les valeurs du formulaire
        - On ajoute l'agent au tableau de la région choisie
        - On sauvegarde et on rafraîchit
        ═══════════════════════════════════════════════════════════════════
        */
        function ajouterAgent() {

            // On lit la région choisie dans le menu déroulant
            const region = document.getElementById('new-region').value;

            // On lit les valeurs des champs
            const agence = document.getElementById('new-agence').value.trim();
            const nom    = document.getElementById('new-nom').value.trim();
            const depts  = document.getElementById('new-depts').value.trim();
            const tel    = document.getElementById('new-tel').value.trim();
            const telRaw = document.getElementById('new-telRaw').value.trim();
            const email  = document.getElementById('new-email').value.trim();

            // Vérification des champs obligatoires
            if (!nom || !email) {
                alert('Le nom et l\'email sont obligatoires.');
                return;
            }

            // On charge les données actuelles
            const contacts = chargerContacts();

            // On crée le nouvel objet agent
            const nouvelAgent = {
                agence: agence || null,
                nom: nom,
                depts: depts,
                tel: tel,
                telRaw: telRaw,
                email: email
            };

            // push() = ajoute un élément à la fin du tableau
            contacts[region].agents.push(nouvelAgent);

            // On sauvegarde
            sauvegarderContacts(contacts);

            // On cache le formulaire et on rafraîchit
            cacherFormulaireAjout();
            afficherTout();

            // Message de confirmation
            afficherToast('Nouvel agent ajouté !');
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        12. MESSAGE DE CONFIRMATION (TOAST)
        ───────────────────────────────────────────────────────────────────
        Affiche un petit message vert en bas à droite pendant 2 secondes.
        ═══════════════════════════════════════════════════════════════════
        */
        function afficherToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;

            // On ajoute la classe "visible" pour l'afficher
            toast.classList.add('visible');

            // Après 2 secondes, on le cache à nouveau
            setTimeout(function() {
                toast.classList.remove('visible');
            }, 2000);
        }


        /*
        ═══════════════════════════════════════════════════════════════════
        13. LANCEMENT — On affiche tout au chargement de la page
        ═══════════════════════════════════════════════════════════════════
        */
        afficherTout();
    </script>

</body>

</html>