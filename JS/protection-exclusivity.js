// =====================================================
// GESTION DES PROTECTIONS AVEC GRISAGE VISUEL
// Version simple et efficace pour le jury
// =====================================================

/**
 * FONCTION : Griser ou dégriser une option
 * Cette fonction rend une option non-cliquable et grisée visuellement
 * @param {string} nomGroupe - Le nom du groupe (protTete ou protPrises)
 * @param {string} valeur - La valeur de l'option à griser
 * @param {boolean} griser - true pour griser, false pour dégriser
 */
function griserOption(nomGroupe, valeur, griser) {
    // On cherche toutes les cases du groupe
    const cases = document.querySelectorAll('input[name="' + nomGroupe + '"]');
    
    // Pour chaque case
    for (let i = 0; i < cases.length; i++) {
        const caseActuelle = cases[i];
        
        // Si c'est la case qu'on cherche
        if (caseActuelle.value === valeur) {
            // On trouve le label parent (la carte visuelle)
            const carte = caseActuelle.closest('.checkbox-card');
            
            if (griser) {
                // GRISER : On désactive la case et on ajoute un style grisé
                caseActuelle.disabled = true;
                caseActuelle.checked = false;
                
                if (carte) {
                    carte.style.opacity = '0.4';
                    carte.style.cursor = 'not-allowed';
                    carte.style.backgroundColor = '#f5f5f5';
                    carte.classList.remove('checked');
                }
            } else {
                // DÉGRISER : On réactive la case et on retire le style grisé
                caseActuelle.disabled = false;
                
                if (carte) {
                    carte.style.opacity = '1';
                    carte.style.cursor = 'pointer';
                    carte.style.backgroundColor = '';
                }
            }
        }
    }
}

/**
 * FONCTION : Gérer Protection de Tête
 * Quand une option est cochée, elle grise les options incompatibles
 * @param {HTMLElement} caseCliquee - La case qui a été cliquée
 */
function gererProtectionTete(caseCliquee) {
    const valeur = caseCliquee.value;
    const estCochee = caseCliquee.checked;
    
    // RÈGLE 1 : Interrupteur ⇔ Inter différentiel
    if (valeur === "Interrupteur") {
        if (estCochee) {
            // Si Interrupteur est coché → griser Inter différentiel
            griserOption('protTete', 'Inter différentiel', true);
        } else {
            // Si Interrupteur est décoché → dégriser Inter différentiel
            griserOption('protTete', 'Inter différentiel', false);
        }
    }
    
    if (valeur === "Inter différentiel") {
        if (estCochee) {
            // Si Inter différentiel est coché → griser Interrupteur
            griserOption('protTete', 'Interrupteur', true);
        } else {
            // Si Inter différentiel est décoché → dégriser Interrupteur
            griserOption('protTete', 'Interrupteur', false);
        }
    }
    
    // RÈGLE 2 : Disjoncteur ⇔ Disjoncteur Diff.
    if (valeur === "Disjoncteur") {
        if (estCochee) {
            griserOption('protTete', 'Disjoncteur Diff.', true);
        } else {
            griserOption('protTete', 'Disjoncteur Diff.', false);
        }
    }
    
    if (valeur === "Disjoncteur Diff.") {
        if (estCochee) {
            griserOption('protTete', 'Disjoncteur', true);
        } else {
            griserOption('protTete', 'Disjoncteur', false);
        }
    }
    
    // Mettre à jour le résumé
    mettreAJourResume();
}

/**
 * FONCTION : Gérer Protection des Prises
 * Même logique que pour Protection de Tête
 * @param {HTMLElement} caseCliquee - La case qui a été cliquée
 */
function gererProtectionPrises(caseCliquee) {
    const valeur = caseCliquee.value;
    const estCochee = caseCliquee.checked;
    
    // RÈGLE 1 : Par prise ⇔ Par groupe de prises
    if (valeur === "Par prise") {
        if (estCochee) {
            griserOption('protPrises', 'Par groupe de prises', true);
        } else {
            griserOption('protPrises', 'Par groupe de prises', false);
        }
    }
    
    if (valeur === "Par groupe de prises") {
        if (estCochee) {
            griserOption('protPrises', 'Par prise', true);
        } else {
            griserOption('protPrises', 'Par prise', false);
        }
    }
    
    // RÈGLE 2 : Disjoncteur ⇔ Disjoncteur Diff.
    if (valeur === "Disjoncteur") {
        if (estCochee) {
            griserOption('protPrises', 'Disjoncteur Diff.', true);
        } else {
            griserOption('protPrises', 'Disjoncteur Diff.', false);
        }
    }
    
    if (valeur === "Disjoncteur Diff.") {
        if (estCochee) {
            griserOption('protPrises', 'Disjoncteur', true);
        } else {
            griserOption('protPrises', 'Disjoncteur', false);
        }
    }
    
    // Mettre à jour le résumé
    mettreAJourResume();
}

/**
 * FONCTION : Mettre à jour le résumé
 * Affiche les options sélectionnées dans le résumé
 */
function mettreAJourResume() {
    // Protection de Tête
    const protTeteCochees = [];
    const casesProtTete = document.querySelectorAll('input[name="protTete"]:checked');
    for (let i = 0; i < casesProtTete.length; i++) {
        protTeteCochees.push(casesProtTete[i].value);
    }
    
    const resumeProtTete = document.getElementById('resume-protTete');
    if (resumeProtTete) {
        resumeProtTete.textContent = protTeteCochees.length > 0 ? protTeteCochees.join(', ') : 'Aucune';
    }
    
    // Protection des Prises
    const protPrisesCochees = [];
    const casesProtPrises = document.querySelectorAll('input[name="protPrises"]:checked');
    for (let i = 0; i < casesProtPrises.length; i++) {
        protPrisesCochees.push(casesProtPrises[i].value);
    }
    
    const resumeProtPrises = document.getElementById('resume-protPrises');
    if (resumeProtPrises) {
        resumeProtPrises.textContent = protPrisesCochees.length > 0 ? protPrisesCochees.join(', ') : 'Aucune';
    }
}

/**
 * FONCTION : Initialiser
 * Lance le système au chargement de la page
 */
function initialiser() {
    // Protection de Tête
    const casesProtTete = document.querySelectorAll('input[name="protTete"]');
    for (let i = 0; i < casesProtTete.length; i++) {
        casesProtTete[i].addEventListener('change', function() {
            gererProtectionTete(this);
        });
    }
    
    // Protection des Prises
    const casesProtPrises = document.querySelectorAll('input[name="protPrises"]');
    for (let i = 0; i < casesProtPrises.length; i++) {
        casesProtPrises[i].addEventListener('change', function() {
            gererProtectionPrises(this);
        });
    }
    
    // Première mise à jour du résumé
    mettreAJourResume();
}

// Démarrage automatique
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initialiser);
} else {
    initialiser();
}

// =====================================================
// COMMENT ÇA MARCHE :
// 
// 1. Quand vous cochez "Interrupteur"
//    → "Inter différentiel" devient grisé et non-cliquable
// 
// 2. Quand vous décochez "Interrupteur"  
//    → "Inter différentiel" redevient normal et cliquable
//
// 3. Même logique pour tous les couples incompatibles
//
// AVANTAGES :
// ✓ Visuel clair (grisé = pas disponible)
// ✓ Impossible de cliquer sur une option grisée
// ✓ Code simple et facile à expliquer au jury
// =====================================================