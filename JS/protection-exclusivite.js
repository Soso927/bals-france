// ============================================================
// GESTION DE L'EXCLUSIVITÉ DES PROTECTIONS
// Code simple et commenté pour présentation au jury
// ============================================================

// ============================================================
// PARTIE 1 : FONCTION POUR GRISER UNE OPTION
// ============================================================

/**
 * Cette fonction grise ou dégrise une case à cocher
 * 
 * Paramètres :
 * - nomGroupe : le nom du groupe de cases (ex: "protTete" ou "protPrises")
 * - valeur : la valeur de l'option à griser (ex: "Interrupteur")
 * - doitGriser : true = griser, false = dégriser
 */
function griserOption(nomGroupe, valeur, doitGriser) {
    
    // Étape 1 : On cherche toutes les cases du groupe
    var toutesLesCases = document.querySelectorAll('input[name="' + nomGroupe + '"]');
    
    // Étape 2 : On parcourt chaque case pour trouver celle qu'on cherche
    for (var i = 0; i < toutesLesCases.length; i++) {
        
        var caseActuelle = toutesLesCases[i];
        
        // Étape 3 : On vérifie si c'est la bonne case
        if (caseActuelle.value === valeur) {
            
            // Étape 4 : On trouve la carte visuelle (le conteneur parent)
            var carte = caseActuelle.closest('.checkbox-card');
            
            // Étape 5 : On grise OU on dégrise selon le paramètre
            if (doitGriser === true) {
                // === GRISER ===
                caseActuelle.disabled = true;       // Désactiver le clic
                caseActuelle.checked = false;       // Décocher si cochée
                
                if (carte) {
                    carte.style.opacity = '0.4';           // Rendre transparent
                    carte.style.cursor = 'not-allowed';    // Curseur interdit
                    carte.style.pointerEvents = 'none';    // Bloquer les clics
                    carte.classList.remove('active');      // Retirer le style actif
                    
                    // Remettre l'icône décochée
                    var icone = carte.querySelector('.checkbox-icon');
                    if (icone) {
                        icone.textContent = '☐';
                    }
                }
            } else {
                // === DÉGRISER ===
                caseActuelle.disabled = false;      // Réactiver le clic
                
                if (carte) {
                    carte.style.opacity = '1';             // Opacité normale
                    carte.style.cursor = 'pointer';        // Curseur normal
                    carte.style.pointerEvents = '';        // Autoriser les clics
                }
            }
            
            // On a trouvé la case, on arrête la boucle
            break;
        }
    }
}


// ============================================================
// PARTIE 2 : GESTION DE LA PROTECTION DE TÊTE
// ============================================================

/**
 * Cette fonction est appelée quand on clique sur une option de Protection de Tête
 * Elle applique les règles d'exclusivité
 */
function gererProtectionTete(caseCliquee) {
    
    // On récupère quelle option a été cliquée et si elle est cochée
    var optionChoisie = caseCliquee.value;
    var estCochee = caseCliquee.checked;
    
    // --------------------------------------------------------
    // RÈGLE 1 : Interrupteur ↔ Inter différentiel
    // Si on coche l'un, l'autre devient grisé
    // --------------------------------------------------------
    
    if (optionChoisie === "Interrupteur") {
        if (estCochee) {
            // Interrupteur coché → griser Inter différentiel
            griserOption('protTete', 'Inter différentiel', true);
        } else {
            // Interrupteur décoché → dégriser Inter différentiel
            griserOption('protTete', 'Inter différentiel', false);
        }
    }
    
    if (optionChoisie === "Inter différentiel") {
        if (estCochee) {
            // Inter différentiel coché → griser Interrupteur
            griserOption('protTete', 'Interrupteur', true);
        } else {
            // Inter différentiel décoché → dégriser Interrupteur
            griserOption('protTete', 'Interrupteur', false);
        }
    }
    
    // --------------------------------------------------------
    // RÈGLE 2 : Disjoncteur ↔ Disjoncteur Diff.
    // Si on coche l'un, l'autre devient grisé
    // --------------------------------------------------------
    
    if (optionChoisie === "Disjoncteur") {
        if (estCochee) {
            griserOption('protTete', 'Disjoncteur Diff.', true);
        } else {
            griserOption('protTete', 'Disjoncteur Diff.', false);
        }
    }
    
    if (optionChoisie === "Disjoncteur Diff.") {
        if (estCochee) {
            griserOption('protTete', 'Disjoncteur', true);
        } else {
            griserOption('protTete', 'Disjoncteur', false);
        }
    }
}


// ============================================================
// PARTIE 3 : GESTION DE LA PROTECTION DES PRISES
// ============================================================

/**
 * Cette fonction est appelée quand on clique sur une option de Protection des Prises
 * Elle applique les règles d'exclusivité
 */
function gererProtectionPrises(caseCliquee) {
    
    // On récupère quelle option a été cliquée et si elle est cochée
    var optionChoisie = caseCliquee.value;
    var estCochee = caseCliquee.checked;
    
    // --------------------------------------------------------
    // RÈGLE 1 : Par prise ↔ Par groupe
    // Si on coche l'un, l'autre devient grisé
    // --------------------------------------------------------
    
    if (optionChoisie === "Par prise") {
        if (estCochee) {
            griserOption('protPrises', 'Par groupe', true);
        } else {
            griserOption('protPrises', 'Par groupe', false);
        }
    }
    
    if (optionChoisie === "Par groupe") {
        if (estCochee) {
            griserOption('protPrises', 'Par prise', true);
        } else {
            griserOption('protPrises', 'Par prise', false);
        }
    }
    
    // --------------------------------------------------------
    // RÈGLE 2 : Disjoncteur ↔ Disjoncteur Diff.
    // Si on coche l'un, l'autre devient grisé
    // --------------------------------------------------------
    
    if (optionChoisie === "Disjoncteur") {
        if (estCochee) {
            griserOption('protPrises', 'Disjoncteur Diff.', true);
        } else {
            griserOption('protPrises', 'Disjoncteur Diff.', false);
        }
    }

    if (optionChoisie === "Disjoncteur Diff.") {
        if (estCochee) {
            griserOption('protPrises', 'Disjoncteur', true);
        } else {
            griserOption('protPrises', 'Disjoncteur', false);
        }
    }
}


// ============================================================
// PARTIE 4 : INITIALISATION AU CHARGEMENT DE LA PAGE
// ============================================================

/**
 * Cette fonction connecte les cases à cocher aux fonctions de gestion
 * Elle s'exécute quand la page est chargée
 */
function initialiserExclusivite() {
    
    // --- Protection de Tête ---
    var casesProtTete = document.querySelectorAll('input[name="protTete"]');
    
    for (var i = 0; i < casesProtTete.length; i++) {
        casesProtTete[i].addEventListener('change', function() {
            gererProtectionTete(this);
        });
    }
    
    // --- Protection des Prises ---
    var casesProtPrises = document.querySelectorAll('input[name="protPrises"]');
    
    for (var i = 0; i < casesProtPrises.length; i++) {
        casesProtPrises[i].addEventListener('change', function() {
            gererProtectionPrises(this);
        });
    }
}

// Lancer l'initialisation quand la page est prête
document.addEventListener('DOMContentLoaded', initialiserExclusivite);


// ============================================================
// RÉSUMÉ POUR LE JURY :
// 
// CE QUE FAIT LE CODE :
// 1. Quand l'utilisateur coche "Interrupteur" 
//    → "Inter différentiel" devient grisé et non cliquable
// 
// 2. Quand l'utilisateur décoche "Interrupteur"
//    → "Inter différentiel" redevient normal et cliquable
// 
// 3. Même logique pour les autres paires incompatibles
// 
// RÈGLES D'EXCLUSIVITÉ :
// 
// Protection de Tête :
//    - Interrupteur ↔ Inter différentiel (mutuellement exclusifs)
//    - Disjoncteur ↔ Disjoncteur Diff. (mutuellement exclusifs)
// 
// Protection des Prises :
//    - Par prise ↔ Par groupe (mutuellement exclusifs)
//    - Disjoncteur ↔ Disjoncteur Diff. (mutuellement exclusifs)
// ============================================================