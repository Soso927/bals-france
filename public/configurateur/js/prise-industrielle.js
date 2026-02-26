/**
 * ============================================================
 * FICHIER : public/configurateur/js/prise-industrielle.js
 * RÔLE    : Toute la logique JavaScript de la page Prise Industrielle
 * AUTEUR  : Projet BALS configurateur
 * ============================================================
 */


// ============================================================
// 1. ACCORDÉON — Ouvrir / Fermer les sections du formulaire
// ============================================================
// Cette fonction est appelée quand on clique sur un en-tête de section
// Elle affiche ou cache le contenu et retourne la flèche

function toggleSection(id) {

    // On récupère la boîte de contenu et la flèche grâce à leur id
    const section = document.getElementById('section-' + id);
    const arrow   = document.getElementById('arrow-' + id);

    // Si la section est cachée → on l'affiche
    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden');
        arrow.textContent = '▲'; // flèche vers le haut = ouvert

    // Sinon → on la cache
    } else {
        section.classList.add('hidden');
        arrow.textContent = '▼'; // flèche vers le bas = fermé
    }
}


// ============================================================
// 2. LOGIQUE MÉTIER — Afficher le choix de montage
// ============================================================
// Certains produits (Socle) ont un type de montage à choisir.
// Les autres (Fiche, Prolongateur) n'en ont pas besoin.

function gererTypeProduit() {

    // On récupère le produit coché par l'utilisateur
    const produitEl  = document.querySelector('input[name="produit"]:checked');
    const zoneMontage = document.getElementById('zone-montage');

    if (produitEl) {
        const val = produitEl.value;

        // Si le produit contient "Socle" → on affiche le choix de montage
        if (val.includes('Socle')) {
            zoneMontage.classList.remove('hidden');

        // Sinon → on cache et on décoche les boutons de montage
        } else {
            zoneMontage.classList.add('hidden');
            document.querySelectorAll('input[name="montage_type"]').forEach(r => r.checked = false);
        }
    }
}


// ============================================================
// 3. QUANTITÉ — Boutons + et - pour changer la quantité
// ============================================================
// delta = +1 quand on clique sur "+", et -1 quand on clique sur "-"

function changerQteGlobale(delta) {

    const input = document.getElementById('quantite');
    let val = parseInt(input.value) || 0; // on lit la valeur actuelle

    val += delta; // on ajoute ou enlève 1

    if (val < 1) val = 1; // on ne descend jamais en dessous de 1

    input.value = val;
    mettreAJour(); // on rafraîchit le résumé
}


// ============================================================
// 4. MOTEUR PRINCIPAL — Met à jour la progression et le résumé
// ============================================================
// Cette fonction est appelée à chaque fois que l'utilisateur
// modifie quelque chose dans le formulaire (oninput / onchange)

function mettreAJour() {

    // --- Lecture de tous les champs du formulaire ---

    // Infos de contact (texte libre)
    const contact = {
        societe: document.getElementById('societe').value,
        nom:     document.getElementById('contact').value,
        email:   document.getElementById('email').value,
    };

    // Boutons radio : on cherche celui qui est coché (ou null si aucun)
    const produitEl  = document.querySelector('input[name="produit"]:checked');
    const produit    = produitEl ? produitEl.value : null;

    const montageEl  = document.querySelector('input[name="montage_type"]:checked');
    const montage    = montageEl ? montageEl.value : null;

    const tensionEl  = document.querySelector('input[name="tension"]:checked');
    const tension    = tensionEl ? tensionEl.value : null;

    const ampEl      = document.querySelector('input[name="amp"]:checked');
    const amp        = ampEl ? ampEl.value : null;

    const polEl      = document.querySelector('input[name="pol"]:checked');
    const pol        = polEl ? polEl.value : null;

    const ipEl       = document.querySelector('input[name="ip"]:checked');
    const ip         = ipEl ? ipEl.value : null;

    // Quantité et observations
    const qte = document.getElementById('quantite').value;
    const obs = document.getElementById('observations').value;


    // --- Calcul de la barre de progression ---
    // Chaque step vaut 1 si rempli, 0 si vide.
    // Pour le montage : obligatoire seulement si c'est un Socle.

    const steps = [
        contact.societe ? 1 : 0,
        contact.email   ? 1 : 0,
        produit         ? 1 : 0,
        (produit && produit.includes('Socle')) ? (montage ? 1 : 0) : 1,
        tension         ? 1 : 0,
        amp             ? 1 : 0,
        pol             ? 1 : 0,
        ip              ? 1 : 0,
    ];

    const total  = steps.length;
    const filled = steps.reduce((a, b) => a + b, 0); // somme des 1
    const percent = Math.round((filled / total) * 100);

    // On met à jour la barre visuelle et le texte du pourcentage
    document.getElementById('progression-barre').style.width = percent + '%';
    document.getElementById('progression-texte').textContent = '(' + percent + '%)';


    // --- Génération du résumé dans la colonne de droite ---

    const zone   = document.getElementById('resume-zone');
    const btnBox = document.getElementById('boutons-action');

    // Si rien n'est encore rempli → message d'attente
    if (filled === 0 && !obs) {
        zone.innerHTML = '<p class="text-bals-blue font-bold text-sm opacity-40">En attente de saisie...</p>';
        btnBox.classList.add('hidden');
        return; // on s'arrête là
    }

    // Sinon on construit le HTML du résumé ligne par ligne
    let html = '<div class="w-full text-left space-y-3 text-sm">';

    // Bloc produit (en bleu si rempli)
    if (produit) {
        html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 font-bold text-center">' + produit;
        if (montage) html += ' <span class="block text-xs font-normal text-blue-100">' + montage + '</span>';
        html += '</div>';
    }

    // Bloc caractéristiques techniques
    if (tension || amp || pol || ip) {
        html += '<div class="bg-gray-50 rounded-lg p-3 border border-gray-100 space-y-1">';
        if (tension) html += '<div class="flex justify-between"><span>Tension:</span> <span class="font-bold text-gray-800">' + tension + '</span></div>';
        if (amp)     html += '<div class="flex justify-between"><span>Intensité:</span> <span class="font-bold text-gray-800">' + amp + '</span></div>';
        if (pol)     html += '<div class="flex justify-between"><span>Polarité:</span> <span class="font-bold text-gray-800">' + pol + '</span></div>';
        if (ip)      html += '<div class="flex justify-between"><span>Protection:</span> <span class="font-black text-bals-blue">' + ip + '</span></div>';
        html += '</div>';
    }

    // Quantité
    html += '<div class="text-center font-bold text-gray-700 py-2 border-t border-b border-gray-100">Quantité : ' + qte + '</div>';

    // Contact
    if (contact.societe || contact.email) {
        html += '<div class="text-xs text-gray-500 italic text-center">';
        if (contact.societe) html += contact.societe + '<br>';
        if (contact.email)   html += contact.email;
        html += '</div>';
    }

    html += '</div>';

    // On injecte le HTML dans la zone résumé et on affiche les boutons
    zone.innerHTML = html;
    btnBox.classList.remove('hidden');
}


// ============================================================
// 5. ACTIONS DES BOUTONS (Copier, Envoyer, Réinitialiser)
// ============================================================

// Copie le résumé dans le presse-papier
function copierResume() {
    const resumeText = document.getElementById('resume-zone').innerText;
    navigator.clipboard.writeText("DEMANDE DE PRIX BALS :\n\n" + resumeText)
        .then(() => alert('Résumé copié !'));
}

// Ouvre le client mail avec les infos pré-remplies
function envoyerDevis() {
    const soc        = document.getElementById('societe').value;
    const resumeText = document.getElementById('resume-zone').innerText;
    const body       = encodeURIComponent("Bonjour,\n\nVoici ma configuration :\n\n" + resumeText);
    window.location.href = `mailto:info@bals-france.fr?subject=Devis Prise - ${soc}&body=${body}`;
}

// Recharge la page pour tout remettre à zéro
function reinitialiser() {
    location.reload();
}


// ============================================================
// 6. INITIALISATION — S'exécute une fois la page chargée
// ============================================================
// On attend que tout le HTML soit prêt avant de lancer mettreAJour()

document.addEventListener('DOMContentLoaded', () => mettreAJour());