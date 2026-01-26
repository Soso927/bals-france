// =====================================================
// GESTION DES PROTECTIONS AVEC GRISAGE VISUEL
// Version corrigée et simplifiée pour le jury
// =====================================================

/**
 * FONCTION : Griser ou dégriser une option
 * Cette fonction rend une option non-cliquable et grisée visuellement
 * @param {string} nomGroupe - Le nom du groupe (protTete ou protPrises)
 * @param {string} valeur - La valeur exacte de l'option à griser
 * @param {boolean} griser - true pour griser, false pour dégriser
 */
function griserOption(nomGroupe, valeur, griser) {
    // On cherche toutes les cases à cocher du groupe
    const toutesLesCases = document.querySelectorAll('input[name="' + nomGroupe + '"]');
    
    // Pour chaque case à cocher
    for (let i = 0; i < toutesLesCases.length; i++) {
        const caseActuelle = toutesLesCases[i];
        
        // Si c'est la case qu'on cherche (valeur exacte)
        if (caseActuelle.value === valeur) {
            // On trouve le label parent (la carte checkbox-card)
            const carteParent = caseActuelle.closest('.checkbox-card');
            
            if (griser) {
                // === GRISER L'OPTION ===
                // 1. Désactiver la case (non cliquable)
                caseActuelle.disabled = true;
                // 2. Décocher si elle était cochée
                caseActuelle.checked = false;
                
                // 3. Modifier l'apparence visuelle de la carte
                if (carteParent) {
                    carteParent.style.opacity = '0.4';              // Rendre transparent
                    carteParent.style.cursor = 'not-allowed';        // Curseur interdit
                    carteParent.style.backgroundColor = '#f0f0f0';   // Fond gris clair
                    carteParent.classList.remove('checked');         // Retirer le style coché
                    carteParent.style.pointerEvents = 'none';        // Bloquer tous les clics
                }
            } else {
                // === DÉGRISER L'OPTION ===
                // 1. Réactiver la case (cliquable à nouveau)
                caseActuelle.disabled = false;
                
                // 2. Restaurer l'apparence normale de la carte
                if (carteParent) {
                    carteParent.style.opacity = '1';                 // Opacité normale
                    carteParent.style.cursor = 'pointer';            // Curseur main
                    carteParent.style.backgroundColor = '';          // Couleur par défaut
                    carteParent.style.pointerEvents = '';            // Autoriser les clics
                }
            }
            
            // On a trouvé et traité l'option, on peut sortir de la boucle
            break;
        }
    }
}

/**
 * FONCTION : Gérer Protection de Tête
 * Applique les règles d'exclusivité pour la protection de tête
 * @param {HTMLElement} caseCliquee - La case checkbox qui a été cliquée
 */
function gererProtectionTete(caseCliquee) {
    // Récupérer la valeur exacte et l'état de la case
    const valeur = caseCliquee.value;
    const estCochee = caseCliquee.checked;
    
    console.log('Protection Tête changée:', valeur, 'Cochée:', estCochee);
    
    // === RÈGLE 1 : Interrupteur ⇔ Inter différentiel ===
    if (valeur === "Interrupteur") {
        if (estCochee) {
            // Interrupteur coché → griser Inter différentiel
            griserOption('protTete', 'Inter différentiel', true);
            console.log('→ Inter différentiel grisé');
        } else {
            // Interrupteur décoché → dégriser Inter différentiel
            griserOption('protTete', 'Inter différentiel', false);
            console.log('→ Inter différentiel dégrisé');
        }
    }
    
    if (valeur === "Inter différentiel") {
        if (estCochee) {
            // Inter différentiel coché → griser Interrupteur
            griserOption('protTete', 'Interrupteur', true);
            console.log('→ Interrupteur grisé');
        } else {
            // Inter différentiel décoché → dégriser Interrupteur
            griserOption('protTete', 'Interrupteur', false);
            console.log('→ Interrupteur dégrisé');
        }
    }
    
    // === RÈGLE 2 : Disjoncteur ⇔ Disjoncteur Diff. ===
    if (valeur === "Disjoncteur") {
        if (estCochee) {
            griserOption('protTete', 'Disjoncteur Diff.', true);
            console.log('→ Disjoncteur Diff. grisé');
        } else {
            griserOption('protTete', 'Disjoncteur Diff.', false);
            console.log('→ Disjoncteur Diff. dégrisé');
        }
    }
    
    if (valeur === "Disjoncteur Diff.") {
        if (estCochee) {
            griserOption('protTete', 'Disjoncteur', true);
            console.log('→ Disjoncteur grisé');
        } else {
            griserOption('protTete', 'Disjoncteur', false);
            console.log('→ Disjoncteur dégrisé');
        }
    }
    
    // Mettre à jour le résumé (si la fonction existe)
    if (typeof updateSummary === 'function') {
        updateSummary();
    }
}

/**
 * FONCTION : Gérer Protection des Prises
 * Applique les règles d'exclusivité pour la protection des prises
 * @param {HTMLElement} caseCliquee - La case checkbox qui a été cliquée
 */
function gererProtectionPrises(caseCliquee) {
    // Récupérer la valeur exacte et l'état de la case
    const valeur = caseCliquee.value;
    const estCochee = caseCliquee.checked;
    
    console.log('Protection Prises changée:', valeur, 'Cochée:', estCochee);
    
    // === RÈGLE 1 : Par prise ⇔ Par groupe ===
    if (valeur === "Par prise") {
        if (estCochee) {
            griserOption('protPrises', 'Par groupe', true);
            console.log('→ Par groupe grisé');
        } else {
            griserOption('protPrises', 'Par groupe', false);
            console.log('→ Par groupe dégrisé');
        }
    }
    
    if (valeur === "Par groupe") {
        if (estCochee) {
            griserOption('protPrises', 'Par prise', true);
            console.log('→ Par prise grisé');
        } else {
            griserOption('protPrises', 'Par prise', false);
            console.log('→ Par prise dégrisé');
        }
    }
    
    // === RÈGLE 2 : Disjoncteur ⇔ Disjoncteur Diff. ===
    if (valeur === "Disjoncteur") {
        if (estCochee) {
            griserOption('protPrises', 'Disjoncteur Diff.', true);
            console.log('→ Disjoncteur Diff. grisé');
        } else {
            griserOption('protPrises', 'Disjoncteur Diff.', false);
            console.log('→ Disjoncteur Diff. dégrisé');
        }
    }
    
    if (valeur === "Disjoncteur Diff.") {
        if (estCochee) {
            griserOption('protPrises', 'Disjoncteur', true);
            console.log('→ Disjoncteur grisé');
        } else {
            griserOption('protPrises', 'Disjoncteur', false);
            console.log('→ Disjoncteur dégrisé');
        }
    }
    
    // Mettre à jour le résumé (si la fonction existe)
    if (typeof updateSummary === 'function') {
        updateSummary();
    }
}

/**
 * FONCTION PRINCIPALE : Initialiser le système
 * Cette fonction s'exécute au chargement de la page
 */
function initialiserGestionProtections() {
    console.log('=== Initialisation du système de protection ===');
    
    // === 1. PROTECTION DE TÊTE ===
    const casesProtectionTete = document.querySelectorAll('input[name="protTete"]');
    console.log('Nombre de cases Protection Tête trouvées:', casesProtectionTete.length);
    
    // Pour chaque case Protection de Tête
    for (let i = 0; i < casesProtectionTete.length; i++) {
        const caseActuelle = casesProtectionTete[i];
        console.log('  - Protection Tête:', caseActuelle.value);
        
        // Ajouter un écouteur d'événement sur le changement
        caseActuelle.addEventListener('change', function() {
            gererProtectionTete(this);
        });
    }
    
    // === 2. PROTECTION DES PRISES ===
    const casesProtectionPrises = document.querySelectorAll('input[name="protPrises"]');
    console.log('Nombre de cases Protection Prises trouvées:', casesProtectionPrises.length);
    
    // Pour chaque case Protection des Prises
    for (let i = 0; i < casesProtectionPrises.length; i++) {
        const caseActuelle = casesProtectionPrises[i];
        console.log('  - Protection Prises:', caseActuelle.value);
        
        // Ajouter un écouteur d'événement sur le changement
        caseActuelle.addEventListener('change', function() {
            gererProtectionPrises(this);
        });
    }
    
    console.log('=== Système initialisé avec succès ! ===');
}

// =====================================================
// DÉMARRAGE AUTOMATIQUE
// Attend que la page soit complètement chargée
// =====================================================
if (document.readyState === 'loading') {
    // La page est encore en train de charger
    document.addEventListener('DOMContentLoaded', initialiserGestionProtections);
} else {
    // La page est déjà chargée
    initialiserGestionProtections();
}

// =====================================================
// RÉSUMÉ DES RÈGLES D'EXCLUSIVITÉ :
//
// PROTECTION DE TÊTE :
// • Interrupteur ⇔ Inter différentiel (mutuellement exclusifs)
// • Disjoncteur ⇔ Disjoncteur Diff. (mutuellement exclusifs)
//
// PROTECTION DES PRISES :
// • Par prise ⇔ Par groupe (mutuellement exclusifs)
// • Disjoncteur ⇔ Disjoncteur Diff. (mutuellement exclusifs)
//
// FONCTIONNEMENT :
// 1. Quand vous cochez une option → l'option incompatible est grisée
// 2. Quand vous décochez une option → l'option incompatible redevient disponible
// 3. Les options grisées ne peuvent pas être cliquées
// 4. L'apparence visuelle montre clairement ce qui est disponible
// =====================================================