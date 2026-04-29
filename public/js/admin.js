/**
 * admin.js
 *
 * Logique JavaScript du back-office de gestion des agents commerciaux BALS.
 * Ce fichier est chargé uniquement sur la page /admin.
 *
 * Fonctionnement :
 *   Les données des agents sont stockées dans localStorage du navigateur
 *   sous la clé "bals_contacts". Cette clé est la MÊME que celle lue par
 *   la carte interactive (france-map.js) — c'est ainsi que les deux pages
 *   restent synchronisées sans base de données.
 *
 * Organisation :
 *   1. DONNÉES PAR DÉFAUT (secours si localStorage est vide)
 *   2. chargerContacts()       — lecture depuis localStorage
 *   3. sauvegarderContacts()   — écriture dans localStorage
 *   4. afficherTout()          — rendu de toutes les régions et agents
 *   5. remplirMenuRegions()    — menu déroulant du formulaire d'ajout
 *   6. activerModification()   — afficher le formulaire d'édition
 *   7. annulerModification()   — annuler et revenir à l'affichage
 *   8. sauvegarderModification()— valider les changements
 *   9. supprimerAgent()        — supprimer un agent
 *  10. afficherFormulaireAjout() / cacherFormulaireAjout()
 *  11. ajouterAgent()          — ajouter un nouvel agent
 *  12. afficherToast()         — message de confirmation visuel
 *  13. Initialisation          — lancement au chargement de la page
 */


/* ════════════════════════════════════════════════════════════════
   1. DONNÉES PAR DÉFAUT
   ────────────────────────────────────────────────────────────────
   Utilisées UNIQUEMENT si localStorage est vide (première visite).
   Ce sont les mêmes données que dans france-map.js — elles servent
   de point de départ commun aux deux pages.
   ════════════════════════════════════════════════════════════════ */
const DONNEES_PAR_DEFAUT = {

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
   2. chargerContacts() — LECTURE DEPUIS localStorage
   ────────────────────────────────────────────────────────────────
   localStorage.getItem('bals_contacts') retourne :
     - une chaîne JSON si des données ont déjà été sauvegardées
     - null si c'est la première utilisation

   JSON.parse() convertit cette chaîne en objet JavaScript.
   ════════════════════════════════════════════════════════════════ */
function chargerContacts() {
    const donneesSauvegardees = localStorage.getItem('bals_contacts');

    if (donneesSauvegardees) {
        return JSON.parse(donneesSauvegardees);
    }

    /* Première utilisation : initialiser avec les données par défaut */
    localStorage.setItem('bals_contacts', JSON.stringify(DONNEES_PAR_DEFAUT));
    return DONNEES_PAR_DEFAUT;
}


/* ════════════════════════════════════════════════════════════════
   3. sauvegarderContacts() — ÉCRITURE DANS localStorage
   ────────────────────────────────────────────────────────────────
   JSON.stringify() convertit l'objet JavaScript en chaîne de texte
   car localStorage ne peut stocker que du texte.
   ════════════════════════════════════════════════════════════════ */
function sauvegarderContacts(contacts) {
    localStorage.setItem('bals_contacts', JSON.stringify(contacts));
}


/* ════════════════════════════════════════════════════════════════
   4. afficherTout() — RENDU COMPLET DE LA PAGE
   ────────────────────────────────────────────────────────────────
   Génère le HTML de toute la liste des régions et agents, puis
   l'injecte dans #liste-regions.

   Appelée au chargement et après chaque modification/ajout/suppression
   pour que l'affichage soit toujours à jour.
   ════════════════════════════════════════════════════════════════ */
function afficherTout() {
    const contacts  = chargerContacts();
    const conteneur = document.getElementById('liste-regions');
    conteneur.innerHTML = '';

    let totalAgents = 0;

    /* Tri alphabétique des régions pour un affichage cohérent */
    const regionsTriees = Object.keys(contacts).sort();

    regionsTriees.forEach(function (nomRegion) {
        const region = contacts[nomRegion];
        totalAgents += region.agents.length;

        /* Construction du bloc HTML pour cette région */
        let htmlRegion = `
            <div class="mb-8">
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

        /* Une carte par agent dans cette région */
        region.agents.forEach(function (agent, index) {

            htmlRegion += `
                <div class="agent-card" id="agent-${nomRegion}-${index}">

                    <!-- MODE LECTURE (affiché par défaut) -->
                    <div id="affichage-${nomRegion}-${index}">

                        ${agent.agence
                            ? `<div class="text-xs font-bold uppercase tracking-wider mb-1"
                                    style="color: var(--bals-blue);">${agent.agence}</div>`
                            : ''
                        }

                        <div class="text-sm font-bold" style="color: var(--bals-black);">
                            ${agent.nom}
                        </div>

                        <div class="text-xs mt-1" style="color: #6b7280;">
                            ${agent.depts}
                        </div>

                        <div class="text-xs mt-1" style="color: var(--bals-blue);">
                            ${agent.tel} · ${agent.email}
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex gap-2 mt-3">
                            <button onclick="activerModification('${nomRegion}', ${index})"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-md transition-all"
                                    style="background: rgba(0,149,218,0.1); color: var(--bals-blue);">
                                Modifier
                            </button>
                            <button onclick="supprimerAgent('${nomRegion}', ${index})"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-md transition-all"
                                    style="background: rgba(237,28,36,0.1); color: var(--bals-red);">
                                Supprimer
                            </button>
                        </div>
                    </div>

                    <!-- MODE ÉDITION (masqué par défaut, affiché par activerModification()) -->
                    <div id="edition-${nomRegion}-${index}" class="edit-form hidden">

                        <input type="text"  id="edit-agence-${nomRegion}-${index}"
                               value="${agent.agence || ''}" placeholder="Agence (optionnel)">
                        <input type="text"  id="edit-nom-${nomRegion}-${index}"
                               value="${agent.nom}"          placeholder="Nom complet">
                        <input type="text"  id="edit-depts-${nomRegion}-${index}"
                               value="${agent.depts}"        placeholder="Départements">
                        <input type="text"  id="edit-tel-${nomRegion}-${index}"
                               value="${agent.tel}"          placeholder="Téléphone">
                        <input type="text"  id="edit-telRaw-${nomRegion}-${index}"
                               value="${agent.telRaw}"       placeholder="Tél. brut (+33...)">
                        <input type="email" id="edit-email-${nomRegion}-${index}"
                               value="${agent.email}"        placeholder="Email">

                        <div class="flex gap-2 mt-2">
                            <button onclick="sauvegarderModification('${nomRegion}', ${index})"
                                    class="text-white text-xs font-semibold px-4 py-2 rounded-md"
                                    style="background: #059669;">
                                Sauvegarder
                            </button>
                            <button onclick="annulerModification('${nomRegion}', ${index})"
                                    class="text-xs font-semibold px-4 py-2 rounded-md border"
                                    style="color: var(--bals-grey); border-color: #E2E6EA;">
                                Annuler
                            </button>
                        </div>
                    </div>

                </div>
            `;
        });

        htmlRegion += `</div>`;
        conteneur.innerHTML += htmlRegion;
    });

    /* Mise à jour du compteur total en haut de page */
    document.getElementById('total-agents').textContent = totalAgents + ' agents au total';

    /* Mise à jour du menu déroulant des régions (formulaire d'ajout) */
    remplirMenuRegions(regionsTriees);
}


/* ════════════════════════════════════════════════════════════════
   5. remplirMenuRegions() — MENU DÉROULANT DU FORMULAIRE D'AJOUT
   ────────────────────────────────────────────────────────────────
   Crée une balise <option> par région dans le <select> du formulaire.
   ════════════════════════════════════════════════════════════════ */
function remplirMenuRegions(regions) {
    const select = document.getElementById('new-region');
    select.innerHTML = '';

    regions.forEach(function (region) {
        const option     = document.createElement('option');
        option.value     = region;
        option.textContent = region;
        select.appendChild(option);
    });
}


/* ════════════════════════════════════════════════════════════════
   6. activerModification() — PASSER EN MODE ÉDITION
   ────────────────────────────────────────────────────────────────
   Cache le mode lecture et affiche le formulaire d'édition
   pour l'agent identifié par (region, index).
   ════════════════════════════════════════════════════════════════ */
function activerModification(region, index) {
    document.getElementById('affichage-' + region + '-' + index).classList.add('hidden');
    document.getElementById('edition-'   + region + '-' + index).classList.remove('hidden');
}


/* ════════════════════════════════════════════════════════════════
   7. annulerModification() — REVENIR EN MODE LECTURE
   ════════════════════════════════════════════════════════════════ */
function annulerModification(region, index) {
    document.getElementById('edition-'   + region + '-' + index).classList.add('hidden');
    document.getElementById('affichage-' + region + '-' + index).classList.remove('hidden');
}


/* ════════════════════════════════════════════════════════════════
   8. sauvegarderModification() — VALIDER LES CHANGEMENTS
   ────────────────────────────────────────────────────────────────
   Lit les nouvelles valeurs depuis les champs du formulaire,
   met à jour l'objet contacts, sauvegarde dans localStorage
   et rafraîchit l'affichage.
   ════════════════════════════════════════════════════════════════ */
function sauvegarderModification(region, index) {
    const contacts = chargerContacts();

    /* Lecture des champs (.trim() retire les espaces parasites) */
    const nouvelleAgence = document.getElementById('edit-agence-' + region + '-' + index).value.trim();
    const nouveauNom     = document.getElementById('edit-nom-'    + region + '-' + index).value.trim();
    const nouveauxDepts  = document.getElementById('edit-depts-'  + region + '-' + index).value.trim();
    const nouveauTel     = document.getElementById('edit-tel-'    + region + '-' + index).value.trim();
    const nouveauTelRaw  = document.getElementById('edit-telRaw-' + region + '-' + index).value.trim();
    const nouveauEmail   = document.getElementById('edit-email-'  + region + '-' + index).value.trim();

    /* Validation des champs obligatoires */
    if (!nouveauNom || !nouveauEmail) {
        alert('Le nom et l\'email sont obligatoires.');
        return;
    }

    /* Mise à jour de l'agent dans l'objet */
    contacts[region].agents[index] = {
        agence: nouvelleAgence || null,  /* null si le champ est laissé vide */
        nom:    nouveauNom,
        depts:  nouveauxDepts,
        tel:    nouveauTel,
        telRaw: nouveauTelRaw,
        email:  nouveauEmail
    };

    sauvegarderContacts(contacts);
    afficherTout();
    afficherToast('Modifications enregistrées !');
}


/* ════════════════════════════════════════════════════════════════
   9. supprimerAgent() — SUPPRIMER UN AGENT
   ────────────────────────────────────────────────────────────────
   Demande confirmation, retire l'agent du tableau via splice(),
   sauvegarde et rafraîchit.
   ════════════════════════════════════════════════════════════════ */
function supprimerAgent(region, index) {
    if (!confirm('Voulez-vous vraiment supprimer cet agent ?')) return;

    const contacts = chargerContacts();
    contacts[region].agents.splice(index, 1);  /* retire 1 élément à la position index */

    sauvegarderContacts(contacts);
    afficherTout();
    afficherToast('Agent supprimé.');
}


/* ════════════════════════════════════════════════════════════════
   10. Affichage / masquage du formulaire d'ajout
   ════════════════════════════════════════════════════════════════ */
function afficherFormulaireAjout() {
    document.getElementById('formulaire-ajout').classList.remove('hidden');
}

function cacherFormulaireAjout() {
    document.getElementById('formulaire-ajout').classList.add('hidden');

    /* Vider tous les champs du formulaire */
    ['new-agence', 'new-nom', 'new-depts', 'new-tel', 'new-telRaw', 'new-email']
        .forEach(id => { document.getElementById(id).value = ''; });
}


/* ════════════════════════════════════════════════════════════════
   11. ajouterAgent() — AJOUTER UN NOUVEL AGENT
   ────────────────────────────────────────────────────────────────
   Lit le formulaire, valide les champs obligatoires, ajoute l'agent
   au tableau de la région choisie via push(), sauvegarde et rafraîchit.
   ════════════════════════════════════════════════════════════════ */
function ajouterAgent() {
    const region = document.getElementById('new-region').value;
    const agence = document.getElementById('new-agence').value.trim();
    const nom    = document.getElementById('new-nom').value.trim();
    const depts  = document.getElementById('new-depts').value.trim();
    const tel    = document.getElementById('new-tel').value.trim();
    const telRaw = document.getElementById('new-telRaw').value.trim();
    const email  = document.getElementById('new-email').value.trim();

    if (!nom || !email) {
        alert('Le nom et l\'email sont obligatoires.');
        return;
    }

    const contacts = chargerContacts();

    contacts[region].agents.push({
        agence: agence || null,
        nom, depts, tel, telRaw, email
    });

    sauvegarderContacts(contacts);
    cacherFormulaireAjout();
    afficherTout();
    afficherToast('Nouvel agent ajouté !');
}


/* ════════════════════════════════════════════════════════════════
   12. afficherToast() — MESSAGE DE CONFIRMATION
   ────────────────────────────────────────────────────────────────
   Affiche le bandeau vert en bas à droite pendant 2 secondes.
   La classe .visible est définie dans admin.css.
   ════════════════════════════════════════════════════════════════ */
function afficherToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('visible');

    setTimeout(function () {
        toast.classList.remove('visible');
    }, 2000);
}


/* ════════════════════════════════════════════════════════════════
   13. INITIALISATION
   ────────────────────────────────────────────────────────────────
   On lance afficherTout() dès que la page est prête.
   ════════════════════════════════════════════════════════════════ */
afficherTout();
