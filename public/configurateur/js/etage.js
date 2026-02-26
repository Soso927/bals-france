// ================================================================
// JAVASCRIPT DU CONFIGURATEUR COFFRET D'ÉTAGE BALS
// Gestion de l'interactivité, mise à jour du résumé, actions
// ================================================================

// ================================================================
// 1️⃣ GESTION DES ACCORDÉONS (sections repliables)
// ================================================================
/**
 * Fonction : toggleSection
 * Rôle : Ouvre ou ferme une section accordéon
 * 
 * @param {string} id - Identifiant de la section (ex: 's1', 's2'...)
 * 
 * Fonctionnement :
 * - Si la section est cachée → on l'ouvre
 * - Si la section est visible → on la cache
 * - La flèche change de direction (▲ ou ▼)
 */
function toggleSection(id) {
    // Récupération des éléments DOM
    const section = document.getElementById('section-' + id);
    const arrow   = document.getElementById('arrow-' + id);

    // Vérification de l'état actuel
    if (section.classList.contains('hidden')) {
        // Section fermée → on l'ouvre
        section.classList.remove('hidden');
        arrow.textContent = '▲';  // Flèche vers le haut
    } else {
        // Section ouverte → on la ferme
        section.classList.add('hidden');
        arrow.textContent = '▼';  // Flèche vers le bas
    }
}

// ================================================================
// 2️⃣ SÉLECTION DU TYPE DE COFFRET
// ================================================================
/**
 * Gestion des boutons de type de coffret
 * Ajoute un écouteur d'événement sur chaque bouton
 * Pour mettre en évidence le bouton actif
 */
document.querySelectorAll('.btn-type').forEach(function(btn) {
    btn.addEventListener('click', function() {
        // Réinitialiser tous les boutons (style inactif)
        document.querySelectorAll('.btn-type').forEach(function(b) {
            b.classList.remove('border-bals-blue', 'bg-bals-blue', 'text-white');
            b.classList.add('border-gray-200', 'text-gray-600');
        });

        // Activer le bouton cliqué (style actif)
        this.classList.remove('border-gray-200', 'text-gray-600');
        this.classList.add('border-bals-blue', 'bg-bals-blue', 'text-white');

        // Mettre à jour le résumé
        mettreAJour();
    });
});

// ================================================================
// 3️⃣ CONTRÔLE DES QUANTITÉS (boutons +/-)
// ================================================================
/**
 * Fonction : changerQte
 * Rôle : Augmente ou diminue la quantité d'une prise
 * 
 * @param {HTMLElement} btn - Le bouton cliqué (+ ou -)
 * @param {number} direction - +1 pour augmenter, -1 pour diminuer
 * 
 * Fonctionnement :
 * 1. Trouve le <span> qui contient la quantité actuelle
 * 2. Récupère la valeur numérique
 * 3. Ajoute la direction (+1 ou -1)
 * 4. Empêche les valeurs négatives (minimum = 0)
 * 5. Met à jour l'affichage
 * 6. Déclenche la mise à jour du résumé
 */
function changerQte(btn, direction) {
    // Trouver le span contenant la quantité
    const span  = btn.parentElement.querySelector('span');
    
    // Récupérer et convertir la valeur actuelle
    let valeur  = parseInt(span.textContent);

    // Modifier la valeur
    valeur += direction;

    // Empêcher les valeurs négatives
    if (valeur < 0) valeur = 0;

    // Mettre à jour l'affichage
    span.textContent = valeur;
    
    // Mettre à jour le résumé
    mettreAJour();
}

// ================================================================
// 4️⃣ MISE À JOUR DU RÉSUMÉ EN TEMPS RÉEL
// ================================================================
/**
 * Fonction : mettreAJour
 * Rôle : Met à jour le résumé et la barre de progression
 * 
 * Appelée à chaque modification du formulaire :
 * - Changement de champ texte (oninput)
 * - Sélection radio/checkbox (onchange)
 * - Modification de quantité (changerQte)
 * 
 * Étapes :
 * 1. Récupérer toutes les valeurs du formulaire
 * 2. Calculer le pourcentage de complétion
 * 3. Construire le HTML du résumé
 * 4. Afficher ou masquer les boutons d'action
 */
function mettreAJour() {
    
    // ============================================================
    // ÉTAPE 1 : Récupération des valeurs du formulaire
    // ============================================================
    
    // Champs de contact
    const distributeur       = document.getElementById('distributeur').value;
    const contactDist        = document.getElementById('contact_distributeur').value;
    const installateur       = document.getElementById('installateur').value;
    const contactInst        = document.getElementById('contact_installateur').value;
    const affaire            = document.getElementById('affaire').value;
    const telephone          = document.getElementById('telephone').value;
    const email              = document.getElementById('email').value;

    // Type de coffret sélectionné (bouton actif)
    const typeBoutonActif = document.querySelector('.btn-type.bg-bals-blue');
    const typeCoffret = typeBoutonActif ? typeBoutonActif.dataset.type : '';

    // Caractéristiques techniques
    const montageEl  = document.querySelector('input[name="montage"]:checked');
    const materiauEl = document.querySelector('input[name="materiau"]:checked');
    const ipEl       = document.querySelector('input[name="ip"]:checked');

    const montage  = montageEl  ? montageEl.value  : '';
    const materiau = materiauEl ? materiauEl.value : '';
    const ip       = ipEl       ? ipEl.value       : '';

    // Protections cochées (tableaux)
    const protTeteCoches = Array.from(
        document.querySelectorAll('input[name="prot_tete[]"]:checked')
    ).map(function(el) { return el.value; });

    const protPrisesCoches = Array.from(
        document.querySelectorAll('input[name="prot_prises[]"]:checked')
    ).map(function(el) { return el.value; });

    // Observations
    const observations = document.getElementById('observations').value;
    
    // Mise à jour du compteur de caractères
    document.getElementById('nb-caracteres').textContent = observations.length;

    // ============================================================
    // ÉTAPE 2 : Calcul de la progression (0-100%)
    // ============================================================
    
    // Liste des champs à vérifier (1 = rempli, 0 = vide)
    const champs = [
        distributeur     ? 1 : 0,  // Champ 1
        contactDist      ? 1 : 0,  // Champ 2
        installateur     ? 1 : 0,  // Champ 3
        email            ? 1 : 0,  // Champ 4
        typeCoffret      ? 1 : 0,  // Champ 5
        montage          ? 1 : 0,  // Champ 6
        materiau         ? 1 : 0,  // Champ 7
        ip               ? 1 : 0,  // Champ 8
        protTeteCoches.length   > 0 ? 1 : 0,  // Champ 9
        protPrisesCoches.length > 0 ? 1 : 0,  // Champ 10
    ];

    // Calcul du pourcentage
    const totalChamps   = champs.length;  // 10 champs au total
    const champsRemplis = champs.reduce(function(a, b) { return a + b; }, 0);  // Somme
    const pourcentage   = Math.round(champsRemplis / totalChamps * 100);

    // Mise à jour visuelle de la barre de progression
    document.getElementById('progression-barre').style.width = pourcentage + '%';
    document.getElementById('progression-texte').textContent = '(' + pourcentage + '%)';

    // ============================================================
    // ÉTAPE 3 : Construction du HTML du résumé
    // ============================================================
    
    const zoneResume = document.getElementById('resume-zone');

    // Si aucun champ n'est rempli → afficher le message par défaut
    if (champsRemplis === 0) {
        zoneResume.innerHTML = '<p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>'
                             + '<p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>';
        document.getElementById('boutons-action').classList.add('hidden');
        return;  // Sortir de la fonction
    }

    // Construction du HTML du résumé (concaténation de chaînes)
    let html = '<div class="w-full text-left space-y-3">';

    // Badge du type de coffret (bleu)
    if (typeCoffret) {
        html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">'
              + typeCoffret + '</div>';
    }

    // Section Contact
    if (distributeur || contactDist || installateur || email || telephone || affaire) {
        html += '<div class="space-y-1">';
        if (distributeur) html += '<p class="text-xs"><span class="text-gray-400">Distributeur :</span> <span class="font-bold text-gray-700">' + distributeur + '</span></p>';
        if (contactDist)  html += '<p class="text-xs"><span class="text-gray-400">Contact :</span> <span class="font-bold text-gray-700">' + contactDist + '</span></p>';
        if (installateur) html += '<p class="text-xs"><span class="text-gray-400">Installateur :</span> <span class="font-bold text-gray-700">' + installateur + '</span></p>';
        if (affaire)      html += '<p class="text-xs"><span class="text-gray-400">Affaire :</span> <span class="font-bold text-gray-700">' + affaire + '</span></p>';
        if (telephone)    html += '<p class="text-xs"><span class="text-gray-400">Tél :</span> <span class="font-bold text-gray-700">' + telephone + '</span></p>';
        if (email)        html += '<p class="text-xs"><span class="text-gray-400">Email :</span> <span class="font-bold text-gray-700">' + email + '</span></p>';
        html += '</div>';
    }

    // Section Caractéristiques techniques
    if (montage || materiau || ip) {
        html += '<div class="border-t border-gray-100 pt-2 space-y-1">';
        if (montage)  html += '<p class="text-xs"><span class="text-gray-400">Montage :</span> <span class="font-bold text-gray-700">' + montage + '</span></p>';
        if (materiau) html += '<p class="text-xs"><span class="text-gray-400">Matériau :</span> <span class="font-bold text-gray-700">' + materiau + '</span></p>';
        if (ip)       html += '<p class="text-xs"><span class="text-gray-400">Protection :</span> <span class="font-black text-bals-blue">' + ip + '</span></p>';
        html += '</div>';
    }

    // Section Protection de tête
    if (protTeteCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection de tête :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protTeteCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // Section Protection des prises
    if (protPrisesCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection des prises :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protPrisesCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // Section Observations (tronquée à 80 caractères)
    if (observations) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Observations :</p>';
        html += '<p class="text-xs text-gray-600 italic">' + observations.substring(0, 80);
        if (observations.length > 80) html += '...';
        html += '</p>';
        html += '</div>';
    }

    html += '</div>';

    // Injection du HTML dans la zone de résumé
    zoneResume.innerHTML = html;
    
    // Affichage des boutons d'action
    document.getElementById('boutons-action').classList.remove('hidden');
}

// ================================================================
// 5️⃣ BOUTONS D'ACTION
// ================================================================

/**
 * Fonction : copierResume
 * Rôle : Copie le résumé dans le presse-papiers
 * 
 * Utilise l'API Clipboard moderne du navigateur
 */
function copierResume() {
    // Récupération des données principales
    const distributeur = document.getElementById('distributeur').value;
    const email        = document.getElementById('email').value;
    const montageEl    = document.querySelector('input[name="montage"]:checked');
    const ipEl         = document.querySelector('input[name="ip"]:checked');

    // Construction du texte à copier
    const texte = 'DEVIS BALS - COFFRET D\'ÉTAGE\n'
                + 'Distributeur : ' + (distributeur || 'N/A') + '\n'
                + 'Email : '        + (email        || 'N/A') + '\n'
                + 'Montage : '      + (montageEl ? montageEl.value : 'N/A') + '\n'
                + 'IP : '           + (ipEl ? ipEl.value : 'N/A');

    // Copie dans le presse-papiers
    navigator.clipboard.writeText(texte).then(function() {
        alert('Résumé copié dans le presse-papiers !');
    });
}

/**
 * Fonction : envoyerDevis
 * Rôle : Ouvre le client email avec un sujet et corps pré-remplis
 * 
 * Utilise mailto: pour générer un lien email
 */
function envoyerDevis() {
    const distributeur = document.getElementById('distributeur').value;
    
    // Encodage URL pour éviter les problèmes de caractères spéciaux
    const sujet = encodeURIComponent('Demande de devis - Coffret d\'Étage - ' + distributeur);
    const corps = encodeURIComponent('Bonjour,\n\nVeuillez trouver ci-joint ma demande de devis pour un coffret d\'étage.\n\nDistributeur : ' + distributeur);

    // Ouverture du client email
    window.location.href = 'mailto:info@bals-france.fr?subject=' + sujet + '&body=' + corps;
}

/**
 * Fonction : reinitialiser
 * Rôle : Remet le formulaire aux valeurs PAR DÉFAUT du coffret d'étage
 * 
 * ⚠️ IMPORTANT : Ne vide PAS tous les champs, mais remet la configuration
 * recommandée selon le PDF du coffret d'étage :
 * - 6x NF 10/16A
 * - 1x CEI 16A
 * - 1x CEI 32A
 * - Mobile + Plastique + IP44
 * - Inter différentiel + Disjoncteur (tête)
 * - Disjoncteur (prises)
 */
function reinitialiser() {
    // ============================================================
    // ÉTAPE 1 : Vider tous les champs texte
    // ============================================================
    ['distributeur','contact_distributeur','installateur','contact_installateur','affaire','telephone','email','observations'].forEach(function(id) {
        document.getElementById(id).value = '';
    });

    // ============================================================
    // ÉTAPE 2 : Décocher TOUS les radios et checkboxes
    // ============================================================
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function(r) {
        r.checked = false;
    });

    // ============================================================
    // ÉTAPE 3 : Recocher les valeurs PAR DÉFAUT du coffret d'étage
    // ============================================================
    
    // Montage : Mobile (recommandé pour étage)
    document.querySelector('input[name="montage"][value="Mobile"]').checked = true;
    
    // Matériau : Plastique (seule option pour étage)
    document.querySelector('input[name="materiau"][value="Plastique"]').checked = true;
    
    // Protection : IP44 (recommandé)
    document.querySelector('input[name="ip"][value="IP44"]').checked = true;
    
    // Protection de tête : Inter différentiel + Disjoncteur (selon PDF)
    document.querySelector('input[name="prot_tete[]"][value="Inter différentiel"]').checked = true;
    document.querySelector('input[name="prot_tete[]"][value="Disjoncteur"]').checked = true;
    
    // Protection des prises : Disjoncteur (selon PDF)
    document.querySelector('input[name="prot_prises[]"][value="Disjoncteur"]').checked = true;

    // ============================================================
    // ÉTAPE 4 : Remettre les QUANTITÉS par défaut (selon PDF 510_802)
    // ============================================================
    const spans = document.querySelectorAll('#section-s3 tbody tr td:nth-child(2) span');
    if (spans.length >= 3) {
        spans[0].textContent = '6';  // NF 10/16A = 6 prises
        spans[1].textContent = '1';  // CEI 16A = 1 prise
        spans[2].textContent = '1';  // CEI 32A = 1 prise
        if (spans[3]) spans[3].textContent = '0';  // CEI 63A = 0 (option)
    }

    // Réinitialiser le compteur de caractères
    document.getElementById('nb-caracteres').textContent = '0';
    
    // Mettre à jour l'affichage du résumé
    mettreAJour();
}

// ================================================================
// 6️⃣ INITIALISATION AU CHARGEMENT DE LA PAGE
// ================================================================
/**
 * Exécuté quand le DOM est complètement chargé
 * Lance une première mise à jour pour calculer la progression initiale
 */
document.addEventListener('DOMContentLoaded', function() {
    mettreAJour();
});
