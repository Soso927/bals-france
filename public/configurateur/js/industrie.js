/*
 * ================================================================
 * JAVASCRIPT DU CONFIGURATEUR BALS
 * ================================================================
 *
 * Ce fichier gère :
 * 1. Les accordéons (ouvrir/fermer les sections)
 * 2. La mise à jour du résumé en temps réel
 * 3. La barre de progression
 * 4. Les boutons d'action
 *
 * PRINCIPE GÉNÉRAL :
 * Chaque fois que l'utilisateur modifie un champ,
 * la fonction mettreAJour() est appelée.
 * Elle recalcule le résumé et la progression.
 */


// ================================================================
// 1. GESTION DES ACCORDÉONS
// ================================================================

/**
 * toggleSection(id) : ouvre ou ferme une section accordéon
 *
 * PARAMÈTRE : id = identifiant de la section (ex: 's1', 's2', 's3')
 *
 * FONCTIONNEMENT :
 * - On récupère l'élément HTML avec document.getElementById()
 * - On ajoute ou retire la classe CSS 'hidden' pour cacher/afficher
 * - On fait pivoter la flèche pour indiquer l'état
 */
function toggleSection(id) {
    // Récupère le contenu de la section
    const section = document.getElementById('section-' + id);
    // Récupère la flèche de la section
    const arrow   = document.getElementById('arrow-' + id);

    // Si la section est cachée : on l'affiche
    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden'); // Afficher
        arrow.textContent = '▲';            // Flèche vers le haut = ouvert
    } else {
        // Sinon : on la cache
        section.classList.add('hidden');    // Cacher
        arrow.textContent = '▼';            // Flèche vers le bas = fermé
    }
}


// ================================================================
// 2. SÉLECTION DU TYPE DE COFFRET (boutons du haut)
// ================================================================

/**
 * Gestion des boutons "Type de coffret" en haut de page
 * Au clic sur un bouton : on le met en bleu, les autres en blanc
 */
document.querySelectorAll('.btn-type').forEach(function(btn) {
    btn.addEventListener('click', function() {

        // Enlève le style "actif" de TOUS les boutons
        document.querySelectorAll('.btn-type').forEach(function(b) {
            b.classList.remove('border-bals-blue', 'bg-bals-blue', 'text-white');
            b.classList.add('border-gray-200', 'text-gray-600');
        });

        // Met le style "actif" sur le bouton cliqué
        this.classList.remove('border-gray-200', 'text-gray-600');
        this.classList.add('border-bals-blue', 'bg-bals-blue', 'text-white');

        // Met à jour le résumé
        mettreAJour();
    });
});


// ================================================================
// 3. CONTRÔLE DES QUANTITÉS (+/-)
// ================================================================

/**
 * changerQte(btn, direction) : augmente ou diminue une quantité
 *
 * PARAMÈTRES :
 * - btn       : le bouton cliqué (+ ou -)
 * - direction : +1 pour augmenter, -1 pour diminuer
 */
function changerQte(btn, direction) {
    // Trouve le span de la quantité (frère du bouton)
    const span  = btn.parentElement.querySelector('span');
    // Lit la valeur actuelle (parseInt = convertit le texte en nombre)
    let valeur  = parseInt(span.textContent);

    // Modifie la valeur
    valeur += direction;

    // Empêche les valeurs négatives (minimum = 0)
    if (valeur < 0) valeur = 0;

    // Affiche la nouvelle valeur
    span.textContent = valeur;

    // Met à jour le résumé
    mettreAJour();
}


// ================================================================
// 4. MISE À JOUR DU RÉSUMÉ EN TEMPS RÉEL
// ================================================================

/**
 * mettreAJour() : relit tous les champs et affiche le résumé
 *
 * Cette fonction est appelée chaque fois qu'un champ change.
 * Elle :
 * 1. Lit les valeurs de tous les champs
 * 2. Construit le texte du résumé
 * 3. Met à jour la barre de progression
 * 4. Affiche ou cache les boutons d'action
 */
function mettreAJour() {

    // ----------------------------------------------------------------
    // LECTURE DES CHAMPS DE CONTACT
    // ----------------------------------------------------------------
    const societe      = document.getElementById('societe').value;
    const contact      = document.getElementById('contact').value;
    const installateur = document.getElementById('installateur').value;
    const affaire      = document.getElementById('affaire').value;
    const email        = document.getElementById('email').value;

    // ----------------------------------------------------------------
    // LECTURE DU TYPE DE COFFRET (bouton actif en bleu)
    // ----------------------------------------------------------------
    const typeBoutonActif = document.querySelector('.btn-type.bg-bals-blue');
    const typeCoffret = typeBoutonActif ? typeBoutonActif.dataset.type : '';

    // ----------------------------------------------------------------
    // LECTURE DES BOUTONS RADIO (un seul choix possible)
    // querySelector cherche le premier radio coché dans la page
    // ----------------------------------------------------------------
    const montageEl  = document.querySelector('input[name="montage"]:checked');
    const materiauEl = document.querySelector('input[name="materiau"]:checked');
    const ipEl       = document.querySelector('input[name="ip"]:checked');

    const montage  = montageEl  ? montageEl.value  : '';
    const materiau = materiauEl ? materiauEl.value  : '';
    const ip       = ipEl       ? ipEl.value        : '';

    // ----------------------------------------------------------------
    // LECTURE DES CHECKBOXES PROTECTION DE TÊTE
    // querySelectorAll = récupère TOUS les checkboxes cochés
    // Array.from().map() = transforme la liste en tableau de textes
    // ----------------------------------------------------------------
    const protTeteCoches = Array.from(
        document.querySelectorAll('input[name="prot_tete[]"]:checked')
    ).map(function(el) { return el.value; });
    // Exemple de résultat : ['Disjoncteur', 'Arrêt d\'urgence']

    // ----------------------------------------------------------------
    // LECTURE DES CHECKBOXES PROTECTION DES PRISES
    // ----------------------------------------------------------------
    const protPrisesCoches = Array.from(
        document.querySelectorAll('input[name="prot_prises[]"]:checked')
    ).map(function(el) { return el.value; });

    // ----------------------------------------------------------------
    // LECTURE DE LA ZONE OBSERVATIONS
    // ----------------------------------------------------------------
    const observations = document.getElementById('observations').value;

    // Met à jour le compteur de caractères
    document.getElementById('nb-caracteres').textContent = observations.length;

    // ----------------------------------------------------------------
    // CALCUL DE LA PROGRESSION
    // Chaque champ vaut 1 point s'il est rempli, 0 sinon
    // ----------------------------------------------------------------
    const champs = [
        societe          ? 1 : 0,   // Société remplie ?
        contact          ? 1 : 0,   // Contact rempli ?
        installateur     ? 1 : 0,   // Installateur rempli ?
        email            ? 1 : 0,   // Email rempli ?
        typeCoffret      ? 1 : 0,   // Type coffret sélectionné ?
        montage          ? 1 : 0,   // Montage sélectionné ?
        materiau         ? 1 : 0,   // Matériau sélectionné ?
        ip               ? 1 : 0,   // IP sélectionné ?
        protTeteCoches.length   > 0 ? 1 : 0,  // Au moins une protection de tête ?
        protPrisesCoches.length > 0 ? 1 : 0,  // Au moins une protection des prises ?
    ];

    // Additionne les 1 pour obtenir le nombre de champs remplis
    // reduce(a, b) => a + b : parcourt le tableau et additionne tout
    const totalChamps   = champs.length;
    const champsRemplis = champs.reduce(function(a, b) { return a + b; }, 0);
    const pourcentage   = Math.round(champsRemplis / totalChamps * 100);

    // Met à jour la barre de progression dans le DOM
    document.getElementById('progression-barre').style.width = pourcentage + '%';
    document.getElementById('progression-texte').textContent = '(' + pourcentage + '%)';

    // ----------------------------------------------------------------
    // CONSTRUCTION DU RÉSUMÉ HTML
    // ----------------------------------------------------------------
    const zoneResume = document.getElementById('resume-zone');

    // Si aucun champ n'est rempli : message par défaut
    if (champsRemplis === 0) {
        zoneResume.innerHTML = '<p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>'
                             + '<p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>';
        document.getElementById('boutons-action').classList.add('hidden');
        return;
    }

    // Commence à construire le HTML du résumé
    let html = '<div class="w-full text-left space-y-3">';

    // Bloc 1 : Type de coffret (badge bleu)
    if (typeCoffret) {
        html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">'
              + typeCoffret + '</div>';
    }

    // Bloc 2 : Informations de contact
    if (societe || contact || email || installateur || affaire) {
        html += '<div class="space-y-1">';
        if (societe)      html += '<p class="text-xs"><span class="text-gray-400">Société :</span> <span class="font-bold text-gray-700">' + societe + '</span></p>';
        if (contact)      html += '<p class="text-xs"><span class="text-gray-400">Contact :</span> <span class="font-bold text-gray-700">' + contact + '</span></p>';
        if (installateur) html += '<p class="text-xs"><span class="text-gray-400">Installateur :</span> <span class="font-bold text-gray-700">' + installateur + '</span></p>';
        if (affaire)      html += '<p class="text-xs"><span class="text-gray-400">Affaire :</span> <span class="font-bold text-gray-700">' + affaire + '</span></p>';
        if (email)        html += '<p class="text-xs"><span class="text-gray-400">Email :</span> <span class="font-bold text-gray-700">' + email + '</span></p>';
        html += '</div>';
    }

    // Bloc 3 : Caractéristiques techniques
    if (montage || materiau || ip) {
        html += '<div class="border-t border-gray-100 pt-2 space-y-1">';
        if (montage)  html += '<p class="text-xs"><span class="text-gray-400">Montage :</span> <span class="font-bold text-gray-700">' + montage + '</span></p>';
        if (materiau) html += '<p class="text-xs"><span class="text-gray-400">Matériau :</span> <span class="font-bold text-gray-700">' + materiau + '</span></p>';
        if (ip)       html += '<p class="text-xs"><span class="text-gray-400">Protection :</span> <span class="font-black text-bals-blue">' + ip + '</span></p>';
        html += '</div>';
    }

    // Bloc 4 : Protection de tête (si au moins une option cochée)
    if (protTeteCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection de tête :</p>';
        // join(', ') = sépare les éléments du tableau par une virgule
        html += '<p class="text-xs font-bold text-gray-700">' + protTeteCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // Bloc 5 : Protection des prises (si au moins une option cochée)
    if (protPrisesCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection des prises :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protPrisesCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // Bloc 6 : Observations (si remplies)
    if (observations) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Observations :</p>';
        // substring(0, 80) = affiche max 80 caractères dans le résumé
        html += '<p class="text-xs text-gray-600 italic">' + observations.substring(0, 80);
        if (observations.length > 80) html += '...'; // Ajoute "..." si texte trop long
        html += '</p>';
        html += '</div>';
    }

    html += '</div>';

    // Injecte le HTML construit dans la zone résumé
    zoneResume.innerHTML = html;

    // Affiche les boutons d'action
    document.getElementById('boutons-action').classList.remove('hidden');
}


// ================================================================
// 5. BOUTONS D'ACTION
// ================================================================

/**
 * copierResume() : copie le résumé dans le presse-papiers
 */
function copierResume() {
    const societe  = document.getElementById('societe').value;
    const email    = document.getElementById('email').value;
    const montageEl= document.querySelector('input[name="montage"]:checked');
    const ipEl     = document.querySelector('input[name="ip"]:checked');

    const texte = 'DEVIS BALS\n'
                + 'Société : ' + (societe || 'N/A') + '\n'
                + 'Email : '   + (email   || 'N/A') + '\n'
                + 'Montage : ' + (montageEl ? montageEl.value : 'N/A') + '\n'
                + 'IP : '      + (ipEl     ? ipEl.value     : 'N/A');

    // Copie dans le presse-papiers
    navigator.clipboard.writeText(texte).then(function() {
        alert('Résumé copié !');
    });
}

/**
 * envoyerDevis() : ouvre le client mail avec le résumé pré-rempli
 */
function envoyerDevis() {
    const societe = document.getElementById('societe').value;
    const sujet   = encodeURIComponent('Demande de devis - ' + societe);
    const corps   = encodeURIComponent('Bonjour,\n\nVeuillez trouver ci-joint ma demande de devis.\n\nSociété : ' + societe);

    // Ouvre le client email
    window.location.href = 'mailto:info@bals-france.fr?subject=' + sujet + '&body=' + corps;
}

/**
 * reinitialiser() : remet tout le formulaire à zéro
 */
function reinitialiser() {
    // Vide tous les champs texte
    ['societe','contact','installateur','affaire','email','observations'].forEach(function(id) {
        document.getElementById(id).value = '';
    });

    // Décoche tous les radios ET checkboxes
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function(r) {
        r.checked = false;
    });

    // Remet le compteur de caractères à 0
    document.getElementById('nb-caracteres').textContent = '0';

    // Met à jour le résumé
    mettreAJour();
}


// ================================================================
// 6. INITIALISATION AU CHARGEMENT DE LA PAGE
// ================================================================

// Quand la page est chargée, met à jour une première fois
document.addEventListener('DOMContentLoaded', function() {
    mettreAJour();
});
