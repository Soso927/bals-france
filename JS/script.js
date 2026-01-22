// =====================================================
//    FICHIER JAVASCRIPT - CONFIGURATEUR BALS
//    Ce fichier contient toute la logique du formulaire
// =====================================================

// =====================================================
//    1. ÉTAT DE L'APPLICATION (STATE)
//    C'est un objet qui stocke toutes les données du formulaire
//    Comme une "mémoire" de ce que l'utilisateur a choisi
// =====================================================

const state = {
    // Informations de contact
    distributeur: '',      // Nom de la société
    contactDist: '',       // Nom du contact
    installateur: '',      // Nom de l'installateur
    affaire: '',           // Référence de l'affaire
    email: '',             // Email de contact
    
    // Caractéristiques techniques
    type: '',              // Fixe, Mobile ou Mobile sur pied
    materiau: '',          // Caoutchouc, Métallique ou Plastique
    ip: '',                // Indice de protection (IP44, IP54, IP67)
    
    // Protections électriques
    protections: {
        tete: [],          // Tableau des protections de tête choisies
        prises: []         // Tableau des protections de prises choisies
    },
    
    // Prises sélectionnées
    sockets: [],           // Tableau des prises avec quantité et détails
    
    // Observations
    observations: ''       // Texte libre de remarques
};


// =====================================================
//    2. FONCTIONS D'INTERFACE (UI)
//    Ces fonctions gèrent l'affichage et les interactions
// =====================================================

/**
 * FONCTION : toggleSection
 * Ouvre ou ferme une section accordéon quand on clique dessus
 * 
 * @param header - L'élément HTML de l'en-tête cliqué
 */
function toggleSection(header) {
    // Récupère le contenu de la section (l'élément juste après l'en-tête)
    const content = header.nextElementSibling;
    // Récupère l'icône de flèche
    const icon = header.querySelector('.section-toggle');
    
    // Vérifie si la section est fermée (a la classe 'collapsed')
    if (content.classList.contains('collapsed')) {
        // OUVRIR la section
        content.classList.remove('collapsed');  // Retire la classe pour afficher
        icon.style.transform = 'rotate(180deg)'; // Tourne la flèche vers le haut
    } else {
        // FERMER la section
        content.classList.add('collapsed');     // Ajoute la classe pour cacher
        icon.style.transform = 'rotate(0deg)';  // Remet la flèche vers le bas
    }
}

/**
 * FONCTION : selectCard
 * Sélectionne une carte (pour type de coffret ou matériau)
 * Une seule carte peut être sélectionnée à la fois
 * 
 * @param label - La carte cliquée
 * @param category - 'type' ou 'mat' selon le groupe
 */
function selectCard(label, category) {
    // 1. Trouve le conteneur parent de toutes les cartes
    const container = label.closest('.selection-grid');
    
    // 2. Retire la classe 'active' de TOUTES les cartes du groupe
    container.querySelectorAll('.selectable-card').forEach(card => {
        card.classList.remove('active');
    });
    
    // 3. Ajoute la classe 'active' uniquement à la carte cliquée
    label.classList.add('active');
    
    // 4. Coche le bouton radio caché dans la carte
    const input = label.querySelector('input');
    input.checked = true;
    
    // 5. Met à jour le state selon la catégorie
    if (category === 'type') {
        state.type = input.value;  // Stocke le type choisi
    }
    if (category === 'mat') {
        state.materiau = input.value;  // Stocke le matériau choisi
    }
    
    // 6. Rafraîchit l'affichage
    updateSummary();
    updateProgress();
}

/**
 * FONCTION : selectToggle
 * Sélectionne un bouton toggle (pour l'indice IP)
 * 
 * @param label - Le toggle cliqué
 * @param category - Catégorie (ici 'ip')
 */
function selectToggle(label, category) {
    // 1. Trouve le groupe de toggles
    const container = label.closest('.toggle-group');
    
    // 2. Désactive tous les toggles
    container.querySelectorAll('.toggle-label').forEach(l => {
        l.classList.remove('active');
    });
    
    // 3. Active le toggle cliqué
    label.classList.add('active');
    
    // 4. Coche le radio button
    const input = label.querySelector('input');
    input.checked = true;
    
    // 5. Met à jour le state
    if (category === 'ip') {
        state.ip = input.value;
    }
    
    // 6. Rafraîchit l'affichage
    updateSummary();
    updateProgress();
}

/**
 * FONCTION : step
 * Augmente ou diminue la quantité d'une prise
 * 
 * @param btn - Le bouton + ou - cliqué
 * @param val - La valeur à ajouter (+1 ou -1)
 */
function step(btn, val) {
    // 1. Trouve le champ input de quantité (dans le même parent que le bouton)
    const input = btn.parentElement.querySelector('input');
    
    // 2. Récupère la valeur actuelle (ou 0 si vide)
    let current = parseInt(input.value) || 0;
    
    // 3. Calcule la nouvelle valeur
    let newVal = current + val;
    
    // 4. Empêche les valeurs négatives
    if (newVal < 0) {
        newVal = 0;
    }
    
    // 5. Met à jour l'affichage
    input.value = newVal;
    
    // 6. Collecte les données et rafraîchit
    collectSocketData();
    updateSummary();
    updateProgress();
}


// =====================================================
//    3. FONCTIONS DE COLLECTE DE DONNÉES
//    Ces fonctions récupèrent les valeurs du formulaire
// =====================================================

/**
 * FONCTION : collectFormData
 * Récupère toutes les données texte du formulaire
 */
function collectFormData() {
    // Récupère la valeur de chaque champ par son ID
    state.distributeur = document.getElementById('distributeur').value;
    state.contactDist = document.getElementById('contactDist').value;
    state.installateur = document.getElementById('installateur').value;
    state.affaire = document.getElementById('affaire').value;
    state.email = document.getElementById('email').value;
    state.observations = document.getElementById('observations').value;
}

/**
 * FONCTION : collectProtections
 * Récupère les protections cochées (tête et prises)
 */
function collectProtections() {
    // 1. Vide les tableaux actuels
    state.protections.tete = [];
    state.protections.prises = [];
    
    // 2. Parcourt toutes les checkboxes "protTete" cochées
    document.querySelectorAll('input[name="protTete"]:checked').forEach(input => {
        // Ajoute la valeur au tableau
        state.protections.tete.push(input.value);
    });
    
    // 3. Parcourt toutes les checkboxes "protPrises" cochées
    document.querySelectorAll('input[name="protPrises"]:checked').forEach(input => {
        state.protections.prises.push(input.value);
    });
}

/**
 * FONCTION : collectSocketData
 * Récupère les prises sélectionnées avec leurs détails
 */
function collectSocketData() {
    // 1. Vide le tableau des prises
    state.sockets = [];
    
    // 2. Parcourt chaque ligne du tableau de prises
    const rows = document.querySelectorAll('.styled-table tbody tr');
    
    rows.forEach(row => {
        // Récupère le champ quantité
        const qtyInput = row.querySelector('.qty-input');
        const qty = parseInt(qtyInput.value);
        
        // Si la quantité est supérieure à 0
        if (qty > 0) {
            // Récupère le nom de la prise (stocké dans data-name)
            const name = qtyInput.dataset.name;
            let detail = "";
            
            // Récupère les selects (brochage et tension)
            const selects = row.querySelectorAll('select');
            if (selects.length > 0) {
                // Pour les prises industrielles avec selects
                const brochage = selects[0].value || 'non spécifié';
                const tension = selects[1] ? (selects[1].value || 'non spécifié') : '';
                detail = `${brochage} - ${tension}`;
            } else {
                // Pour la prise NF domestique (valeurs fixes dans le tableau)
                const cells = row.querySelectorAll('td');
                const brochage = cells[2].innerText.trim();
                const tension = cells[3].innerText.trim();
                detail = `${brochage} - ${tension}`;
            }
            
            // Ajoute la prise au tableau state.sockets
            state.sockets.push({ qty, name, detail });
        }
    });
}


// =====================================================
//    4. BARRE DE PROGRESSION
//    Calcule et affiche le pourcentage de complétion
// =====================================================

/**
 * FONCTION : updateProgress
 * Met à jour la barre de progression selon les champs remplis
 */
function updateProgress() {
    let score = 0;           // Points accumulés
    let totalPossible = 100; // Total maximum
    
    // Section 1 : Infos Contact (40 points)
    if (state.distributeur.length > 0) score += 10;
    if (state.contactDist.length > 0) score += 5;
    if (state.installateur.length > 0) score += 5;
    if (state.affaire.length > 0) score += 10;
    if (state.email.length > 0) score += 10;
    
    // Section 2 : Caractéristiques Techniques (30 points)
    if (state.type) score += 10;
    if (state.materiau) score += 10;
    if (state.ip) score += 10;
    
    // Section 3 : Prises (20 points)
    if (state.sockets.length > 0) score += 20;
    
    // Section 4 : Protections (10 points)
    if (state.protections.tete.length > 0) score += 5;
    if (state.protections.prises.length > 0) score += 5;
    
    // Calcule le pourcentage
    const percentage = Math.min(Math.round((score / totalPossible) * 100), 100);
    
    // Met à jour la barre visuelle
    const bar = document.getElementById('progressBar');
    bar.style.width = percentage + '%';
    
    // Change la couleur si complet (vert)
    if (percentage === 100) {
        bar.style.background = 'linear-gradient(90deg, #10B981, #059669)';
    } else {
        bar.style.background = 'linear-gradient(90deg, #0095DA, #ED1C24)';
    }
    
    // Met à jour le texte
    const progressLabel = document.querySelector('.progress-label');
    progressLabel.textContent = `Progression du devis (${percentage}%)`;
}


// =====================================================
//    5. RÉSUMÉ DYNAMIQUE
//    Génère le récapitulatif en temps réel
// =====================================================

/**
 * FONCTION : updateSummary
 * Met à jour le panneau de résumé à droite
 */
function updateSummary() {
    // 1. Collecte toutes les données
    collectFormData();
    collectSocketData();
    collectProtections();
    
    // 2. Récupère l'élément HTML où afficher le résumé
    const list = document.getElementById('summaryList');
    let html = '';
    
    // 3. Génère le HTML pour chaque section remplie
    
    // Informations Projet
    if (state.distributeur || state.affaire) {
        html += `<div class="summary-item">
            <strong>Projet</strong>
            <span>${state.distributeur} ${state.affaire ? '/ ' + state.affaire : ''}</span>
        </div>`;
    }
    
    // Caractéristiques Techniques
    if (state.type || state.materiau || state.ip) {
        html += `<div class="summary-item">
            <strong>Configuration</strong>
            <span>${[state.type, state.materiau, state.ip].filter(Boolean).join(' • ')}</span>
        </div>`;
    }
    
    // Prises sélectionnées
    if (state.sockets.length > 0) {
        html += `<div class="summary-item"><strong>Prises</strong><span>`;
        state.sockets.forEach(s => {
            html += `${s.qty}x ${s.name} [${s.detail}]<br>`;
        });
        html += `</span></div>`;
    }
    
    // Protections de tête
    if (state.protections.tete.length > 0) {
        html += `<div class="summary-item">
            <strong>Protection tête</strong>
            <span>${state.protections.tete.join(', ')}</span>
        </div>`;
    }
    
    // Protections des prises
    if (state.protections.prises.length > 0) {
        html += `<div class="summary-item">
            <strong>Protection prises</strong>
            <span>${state.protections.prises.join(', ')}</span>
        </div>`;
    }
    
    // Observations
    if (state.observations) {
        html += `<div class="summary-item">
            <strong>Observations</strong>
            <span>${state.observations.substring(0, 100)}${state.observations.length > 100 ? '...' : ''}</span>
        </div>`;
    }
    
    // 4. Affiche le HTML ou l'état vide
    if (html === '') {
        list.innerHTML = `<div class="empty-state">
            <p>Configurez votre coffret</p>
            <small>Les informations apparaîtront ici</small>
        </div>`;
    } else {
        list.innerHTML = html;
    }
}


// =====================================================
//    6. ACTIONS (BOUTONS)
//    Copier, envoyer par mail, réinitialiser
// =====================================================

/**
 * FONCTION : generateMailto
 * Crée un email avec toutes les informations du devis
 */
function generateMailto() {
    // Construit le contenu de l'email
    let body = "=== DEMANDE DE DEVIS - COFFRET DE CHANTIER BALS ===\n\n";
    
    body += "📋 INFORMATIONS PROJET\n";
    body += "Société : " + (state.distributeur || 'Non renseigné') + "\n";
    body += "Contact : " + (state.contactDist || 'Non renseigné') + "\n";
    body += "Installateur : " + (state.installateur || 'Non renseigné') + "\n";
    body += "Affaire : " + (state.affaire || 'Non renseigné') + "\n";
    body += "Email : " + (state.email || 'Non renseigné') + "\n\n";
    
    body += "🔧 CONFIGURATION TECHNIQUE\n";
    body += "Type : " + (state.type || 'Non défini') + "\n";
    body += "Matériau : " + (state.materiau || 'Non défini') + "\n";
    body += "Indice IP : " + (state.ip || 'Non défini') + "\n\n";
    
    if (state.sockets.length > 0) {
        body += "🔌 PRISES\n";
        state.sockets.forEach(s => {
            body += "• " + s.qty + "x " + s.name + " [" + s.detail + "]\n";
        });
        body += "\n";
    }
    
    body += "⚡ PROTECTIONS\n";
    body += "Tête : " + (state.protections.tete.length > 0 ? state.protections.tete.join(', ') : 'Non définie') + "\n";
    body += "Prises : " + (state.protections.prises.length > 0 ? state.protections.prises.join(', ') : 'Non définie') + "\n\n";
    
    if (state.observations) {
        body += "💬 OBSERVATIONS\n";
        body += state.observations + "\n";
    }
    
    // Encode le contenu pour l'URL
    const subject = encodeURIComponent("Demande de devis - Coffret de chantier");
    const bodyEncoded = encodeURIComponent(body);
    
    // Ouvre le client mail avec le lien mailto
    window.location.href = `mailto:info@bals-france.fr?subject=${subject}&body=${bodyEncoded}`;
}

/**
 * FONCTION : copierTexte
 * Copie le récapitulatif dans le presse-papiers
 */
function copierTexte() {
    // Construit le texte à copier (même format que l'email)
    let contenu = "=== DEMANDE DE DEVIS - COFFRET DE CHANTIER BALS ===\n\n";
    
    contenu += "Société : " + (state.distributeur || 'Non renseigné') + "\n";
    contenu += "Affaire : " + (state.affaire || 'Non renseigné') + "\n";
    contenu += "Type : " + (state.type || 'Non défini') + "\n";
    contenu += "Matériau : " + (state.materiau || 'Non défini') + "\n";
    contenu += "IP : " + (state.ip || 'Non défini') + "\n";
    
    if (state.sockets.length > 0) {
        contenu += "\nPrises :\n";
        state.sockets.forEach(s => {
            contenu += "  • " + s.qty + "x " + s.name + " [" + s.detail + "]\n";
        });
    }
    
    contenu += "\nProtection tête : " + (state.protections.tete.join(', ') || 'Non définie') + "\n";
    contenu += "Protection prises : " + (state.protections.prises.join(', ') || 'Non définie') + "\n";
    
    // Copie dans le presse-papiers
    navigator.clipboard.writeText(contenu).then(() => {
        alert('✅ Copié dans le presse-papiers !');
    }).catch(err => {
        alert('❌ Erreur lors de la copie');
        console.error(err);
    });
}

/**
 * FONCTION : resetForm
 * Réinitialise tout le formulaire
 */
function resetForm() {
    // Demande confirmation
    if (!confirm('⚠️ Réinitialiser le formulaire ?\n\nToutes les données seront perdues.')) {
        return;
    }
    
    // Remet le state à zéro
    state.distributeur = '';
    state.contactDist = '';
    state.installateur = '';
    state.affaire = '';
    state.email = '';
    state.type = '';
    state.materiau = '';
    state.ip = '';
    state.protections.tete = [];
    state.protections.prises = [];
    state.sockets = [];
    state.observations = '';
    
    // Vide tous les champs texte
    document.getElementById('distributeur').value = '';
    document.getElementById('contactDist').value = '';
    document.getElementById('installateur').value = '';
    document.getElementById('affaire').value = '';
    document.getElementById('email').value = '';
    document.getElementById('observations').value = '';
    
    // Désélectionne les cartes
    document.querySelectorAll('.selectable-card').forEach(card => {
        card.classList.remove('active');
    });
    document.querySelectorAll('.selectable-card input').forEach(radio => {
        radio.checked = false;
    });
    
    // Désélectionne les toggles
    document.querySelectorAll('.toggle-label').forEach(label => {
        label.classList.remove('active');
    });
    document.querySelectorAll('.toggle-label input').forEach(radio => {
        radio.checked = false;
    });
    
    // Désélectionne les checkboxes
    document.querySelectorAll('.checkbox-card').forEach(card => {
        card.classList.remove('active');
        const icon = card.querySelector('.checkbox-icon');
        if (icon) icon.textContent = '☐';
    });
    document.querySelectorAll('.checkbox-card input').forEach(cb => {
        cb.checked = false;
    });
    
    // Remet les quantités à zéro
    document.querySelectorAll('.qty-input').forEach(input => {
        input.value = 0;
    });
    
    // Remet les selects à vide
    document.querySelectorAll('.detail-select').forEach(select => {
        select.value = '';
    });
    
    // Met à jour l'affichage
    updateSummary();
    updateProgress();
}


// =====================================================
//    7. INITIALISATION
//    Ce code s'exécute quand la page est chargée
// =====================================================

document.addEventListener('DOMContentLoaded', () => {
    // --- Ferme toutes les sections sauf la première ---
    document.querySelectorAll('.section-card .section-content').forEach((content, index) => {
        const icon = content.previousElementSibling.querySelector('.section-toggle');
        if (index > 0) {
            // Ferme les sections 2, 3, 4, 5
            content.classList.add('collapsed');
            icon.style.transform = 'rotate(0deg)';
        } else {
            // Garde la première section ouverte
            content.classList.remove('collapsed');
            icon.style.transform = 'rotate(180deg)';
        }
    });
    
    // --- Ajoute les écouteurs sur les champs texte ---
    // À chaque frappe, on met à jour le résumé
    document.querySelectorAll('.input-field').forEach(input => {
        input.addEventListener('input', () => {
            collectFormData();
            updateSummary();
            updateProgress();
        });
    });
    
    // --- Ajoute les écouteurs sur les quantités ---
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', () => {
            collectSocketData();
            updateSummary();
            updateProgress();
        });
    });
    
    // --- Ajoute les écouteurs sur les selects ---
    document.querySelectorAll('.detail-select').forEach(sel => {
        sel.addEventListener('change', () => {
            collectSocketData();
            updateSummary();
            updateProgress();
        });
    });
    
    // --- Ajoute les écouteurs sur les checkboxes ---
    // C'est ICI que se gère le clic sur les protections
    document.querySelectorAll('.checkbox-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Empêche le comportement par défaut
            e.preventDefault();
            
            // Récupère la checkbox et l'icône
            const input = this.querySelector('input[type="checkbox"]');
            const icon = this.querySelector('.checkbox-icon');
            
            // Inverse l'état (coché/décoché)
            input.checked = !input.checked;
            
            // Met à jour l'apparence
            if (input.checked) {
                this.classList.add('active');
                icon.textContent = '☑';  // Icône cochée
            } else {
                this.classList.remove('active');
                icon.textContent = '☐';  // Icône décochée
            }
            
            // Collecte les protections et met à jour
            collectProtections();
            updateSummary();
            updateProgress();
        });
    });
    
    // --- Première mise à jour ---
    collectFormData();
    collectSocketData();
    collectProtections();
    updateSummary();
    updateProgress();
});
