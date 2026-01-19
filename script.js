// =====================================================
//    GESTION D'ÉTAT CENTRALISÉE
// =====================================================
const state = {
    distributeur: '',
    contactDist: '',
    installateur: '',
    affaire: '',
    email: '',
    type: '',
    materiau: '',
    ip: '',
    protections: {
        tete: '',
        departs: ''
    },
    sockets: [],
    observations: ''
};

// =====================================================
//    LOGIQUE D'INTERFACE (UI)
// =====================================================

function toggleSection(header) {
    const content = header.nextElementSibling;
    const icon = header.querySelector('.section-toggle');
    
    if (content.classList.contains('collapsed')) {
        // Ouvrir la section
        content.classList.remove('collapsed');
        icon.style.transform = 'rotate(180deg)';
    } else {
        // Fermer la section
        content.classList.add('collapsed');
        icon.style.transform = 'rotate(0deg)';
    }
}

function selectCard(label, category) {
    // Retirer la classe active des autres cartes
    const container = label.closest('.selection-grid');
    container.querySelectorAll('.selectable-card').forEach(c => c.classList.remove('active'));
    
    // Ajouter la classe active à la carte sélectionnée
    label.classList.add('active');
    
    // Mettre à jour le state
    const input = label.querySelector('input');
    input.checked = true;
    
    if(category === 'type') state.type = input.value;
    if(category === 'mat') state.materiau = input.value;
    if(category === 'prot_departs') state.protections.departs = input.value;

    updateSummary();
    updateProgress();
}

function selectToggle(label, category) {
    const container = label.closest('.toggle-group');
    container.querySelectorAll('.toggle-label').forEach(l => l.classList.remove('active'));
    label.classList.add('active');
    
    const input = label.querySelector('input');
    input.checked = true;

    if(category === 'ip') state.ip = input.value;
    if(category === 'prot_tete') state.protections.tete = input.value;

    updateSummary();
    updateProgress();
}

function step(btn, val) {
    const input = btn.parentElement.querySelector('input');
    let current = parseInt(input.value) || 0;
    let newVal = current + val;
    if (newVal < 0) newVal = 0;
    input.value = newVal;
    
    collectSocketData();
    updateSummary();
    updateProgress();
}

// =====================================================
//    COLLECTE DE DONNÉES
// =====================================================

function collectFormData() {
    state.distributeur = document.getElementById('distributeur').value;
    state.contactDist = document.getElementById('contactDist').value;
    state.installateur = document.getElementById('installateur').value;
    state.affaire = document.getElementById('affaire').value;
    state.email = document.getElementById('email').value;
    state.observations = document.getElementById('observations').value;
}

function collectSocketData() {
    state.sockets = [];
    const rows = document.querySelectorAll('.styled-table tbody tr');
    
    rows.forEach(row => {
        const qtyInput = row.querySelector('.qty-input');
        const qty = parseInt(qtyInput.value);
        
        if (qty > 0) {
            const name = qtyInput.dataset.name;
            let detail = "";
            
            // Récupérer les selects (brochage et tension)
            const selects = row.querySelectorAll('select');
            if (selects.length > 0) {
                const brochage = selects[0].value || 'non spécifié';
                const tension = selects[1] ? (selects[1].value || 'non spécifié') : '';
                detail = `${brochage} - ${tension}`;
            } else {
                // Pour NF 10/16A (pas de select)
                const cells = row.querySelectorAll('td');
                const brochage = cells[2].innerText.trim();
                const tension = cells[3].innerText.trim();
                detail = `${brochage} - ${tension}`;
            }

            state.sockets.push({ qty, name, detail });
        }
    });
}

// =====================================================
//    BARRE DE PROGRESSION
// =====================================================

function updateProgress() {
    let score = 0;
    let totalPossible = 100;

    // Section 1: Infos Projet (40 points)
    if(state.distributeur.length > 0) score += 10;
    if(state.contactDist.length > 0) score += 5;
    if(state.installateur.length > 0) score += 5;
    if(state.affaire.length > 0) score += 10;
    if(state.email.length > 0) score += 10;

    // Section 2: Caractéristiques Techniques (30 points)
    if(state.type) score += 10;
    if(state.materiau) score += 10;
    if(state.ip) score += 10;

    // Section 3: Configuration Prises (20 points)
    if(state.sockets.length > 0) score += 20;

    // Section 4: Protections (10 points)
    if(state.protections.tete) score += 5;
    if(state.protections.departs) score += 5;

    const bar = document.getElementById('progressBar');
    const percentage = Math.min(Math.round((score / totalPossible) * 100), 100);
    bar.style.width = percentage + '%';

    if (percentage === 100) {
        bar.style.background = 'linear-gradient(90deg, #10B981, #059669)';
    } else {
        bar.style.background = 'linear-gradient(90deg, #0095DA, #ED1C24)';
    }

    const progressLabel = document.querySelector('.progress-label');
    progressLabel.textContent = `Progression du devis (${percentage}%)`;
}

// =====================================================
//    RÉSUMÉ DYNAMIQUE
// =====================================================

function updateSummary() {
    collectFormData();
    collectSocketData();

    const list = document.getElementById('summaryList');
    let html = '';

    // 1. Informations Projet
    if(state.distributeur || state.affaire || state.contactDist || state.installateur || state.email) {
        html += `<div class="summary-item"><strong>Projet</strong> <span>${state.distributeur || ''} ${state.affaire ? '/ ' + state.affaire : ''}</span></div>`;
        if(state.contactDist) html += `<div class="summary-item"><strong>Contact Dist.</strong> <span>${state.contactDist}</span></div>`;
        if(state.installateur) html += `<div class="summary-item"><strong>Installateur</strong> <span>${state.installateur}</span></div>`;
        if(state.email) html += `<div class="summary-item"><strong>Email</strong> <span>${state.email}</span></div>`;
    }

    // 2. Caractéristiques Coffret
    if (state.type || state.materiau) {
        if (html !== '') html += `<hr style="border:0; border-top:1px solid rgba(255,255,255,0.1); margin: 0.75rem 0;">`;
        html += `<div class="summary-item"><strong>Coffret</strong> <span>${state.type || ''} ${state.materiau ? '('+state.materiau+')' : ''}</span></div>`;
    }
    if (state.ip) {
        html += `<div class="summary-item"><strong>Indice</strong> <span>${state.ip}</span></div>`;
    }

    // 3. Prises
    if (state.sockets.length > 0) {
        if (html !== '') html += `<hr style="border:0; border-top:1px solid rgba(255,255,255,0.1); margin: 0.75rem 0;">`;
        html += `<div class="summary-item" style="font-weight:700; color:var(--white); margin-bottom:0.75rem; font-size:1rem;">🔌 Prises:</div>`;
        state.sockets.forEach(s => {
            html += `<div class="summary-item"><strong>${s.qty}x ${s.name}</strong> <span style="font-size:0.85rem; opacity:0.8">${s.detail}</span></div>`;
        });
    }

    // 4. Protections
    if (state.protections.tete || state.protections.departs) {
        if (html !== '') html += `<hr style="border:0; border-top:1px solid rgba(255,255,255,0.1); margin: 0.75rem 0;">`;
        html += `<div class="summary-item" style="font-weight:700; color:var(--white); margin-bottom:0.75rem; font-size:1rem;">⚡ Protections:</div>`;
        if(state.protections.tete) html += `<div class="summary-item"><strong>Tête</strong> <span>${state.protections.tete}</span></div>`;
        if(state.protections.departs) html += `<div class="summary-item"><strong>Départs</strong> <span>${state.protections.departs}</span></div>`;
    }

    // 5. Observations
    if (state.observations) {
        if (html !== '') html += `<hr style="border:0; border-top:1px solid rgba(255,255,255,0.1); margin: 0.75rem 0;">`;
        html += `<div class="summary-item" style="font-weight:700; color:var(--white); margin-bottom:0.75rem; font-size:1rem;">💬 Observations:</div>`;
        html += `<div class="summary-item" style="font-style:italic;"><span>${state.observations}</span></div>`;
    }

    if (html === '') {
        list.innerHTML = '<div class="empty-state">Configurez votre coffret pour voir apparaître le détail ici.</div>';
    } else {
        list.innerHTML = html;
    }
}

// =====================================================
//    GÉNÉRATION EMAIL
// =====================================================

function generateMailto() {
    collectFormData();

    let body = `DEMANDE DE DEVIS - COFFRET DE CHANTIER BALS\n`;
    body += `================================================\n\n`;
    
    body += `📋 INFORMATIONS DE CONTACT\n`;
    body += `------------------------------------------------\n`;
    body += `Distributeur       : ${state.distributeur || 'Non renseigné'}\n`;
    body += `Contact Dist.      : ${state.contactDist || 'Non renseigné'}\n`;
    body += `Installateur       : ${state.installateur || 'Non renseigné'}\n`;
    body += `Référence Affaire  : ${state.affaire || 'Non renseignée'}\n`;
    body += `Email de contact   : ${state.email || 'Non renseigné'}\n\n`;

    body += `🔧 CONFIGURATION TECHNIQUE\n`;
    body += `------------------------------------------------\n`;
    body += `Type de coffret   : ${state.type || 'Non défini'}\n`;
    body += `Matériau           : ${state.materiau || 'Non défini'}\n`;
    body += `Indice protection  : ${state.ip || 'Non défini'}\n\n`;

    if(state.sockets.length > 0) {
        body += `🔌 PRISES SÉLECTIONNÉES\n`;
        body += `------------------------------------------------\n`;
        state.sockets.forEach(s => {
            body += `  • ${s.qty}x ${s.name} [${s.detail}]\n`;
        });
        body += `\n`;
    } else {
        body += `🔌 PRISES SÉLECTIONNÉES : Aucune\n\n`;
    }

    body += `⚡ PROTECTIONS\n`;
    body += `------------------------------------------------\n`;
    body += `Protection de tête : ${state.protections.tete || 'Non définie'}\n`;
    body += `Protection départs : ${state.protections.departs || 'Non définie'}\n\n`;

    if(state.observations) {
        body += `💬 OBSERVATIONS TECHNIQUES\n`;
        body += `------------------------------------------------\n`;
        body += `${state.observations}\n\n`;
    }

    body += `================================================\n`;
    body += `       BALS France - Coffrets sur mesure\n`;
    body += `           info@bals-france.fr\n`;
    body += `================================================\n`;

    const subject = `Demande Devis BALS - Coffret ${state.affaire || 'Sans référence'}`;
    window.location.href = `mailto:info@bals-france.fr?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
}

// =====================================================
//    COPIER LE TEXTE
// =====================================================

function copierTexte() {
    collectFormData();
    
    let contenu = `DEMANDE DE DEVIS - COFFRET DE CHANTIER BALS\n`;
    contenu += `================================================\n\n`;
    
    contenu += `📋 INFORMATIONS DE CONTACT\n`;
    contenu += `------------------------------------------------\n`;
    contenu += `Distributeur       : ${state.distributeur || 'Non renseigné'}\n`;
    contenu += `Contact Dist.      : ${state.contactDist || 'Non renseigné'}\n`;
    contenu += `Installateur       : ${state.installateur || 'Non renseigné'}\n`;
    contenu += `Référence Affaire  : ${state.affaire || 'Non renseignée'}\n`;
    contenu += `Email de contact   : ${state.email || 'Non renseigné'}\n\n`;

    contenu += `🔧 CONFIGURATION TECHNIQUE\n`;
    contenu += `------------------------------------------------\n`;
    contenu += `Type de coffret   : ${state.type || 'Non défini'}\n`;
    contenu += `Matériau           : ${state.materiau || 'Non défini'}\n`;
    contenu += `Indice protection  : ${state.ip || 'Non défini'}\n\n`;

    if(state.sockets.length > 0) {
        contenu += `🔌 PRISES SÉLECTIONNÉES\n`;
        contenu += `------------------------------------------------\n`;
        state.sockets.forEach(s => {
            contenu += `  • ${s.qty}x ${s.name} [${s.detail}]\n`;
        });
        contenu += `\n`;
    } else {
        contenu += `🔌 PRISES SÉLECTIONNÉES : Aucune\n\n`;
    }

    contenu += `⚡ PROTECTIONS\n`;
    contenu += `------------------------------------------------\n`;
    contenu += `Protection de tête : ${state.protections.tete || 'Non définie'}\n`;
    contenu += `Protection départs : ${state.protections.departs || 'Non définie'}\n\n`;

    if(state.observations) {
        contenu += `💬 OBSERVATIONS TECHNIQUES\n`;
        contenu += `------------------------------------------------\n`;
        contenu += `${state.observations}\n\n`;
    }

    contenu += `================================================\n`;
    contenu += `       BALS France - Coffrets sur mesure\n`;
    contenu += `           info@bals-france.fr\n`;
    contenu += `================================================\n`;

    // Copier dans le presse-papiers
    navigator.clipboard.writeText(contenu).then(() => {
        // Animation de confirmation
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '✅ Copié !';
        btn.style.background = 'rgba(16, 185, 129, 0.2)';
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = '';
        }, 2000);
    }).catch(err => {
        alert('❌ Erreur lors de la copie. Veuillez réessayer.');
        console.error('Erreur de copie:', err);
    });
}

// =====================================================
//    INITIALISATION
// =====================================================

document.addEventListener('DOMContentLoaded', () => {
    // Fermer toutes les sections sauf la première
    document.querySelectorAll('.section-card .section-content').forEach((content, index) => {
        const icon = content.previousElementSibling.querySelector('.section-toggle');
        if (index > 0) {
            content.classList.add('collapsed');
            icon.style.transform = 'rotate(0deg)';
        } else {
            content.classList.remove('collapsed');
            icon.style.transform = 'rotate(180deg)';
        }
    });

    // Ajouter les listeners sur les champs texte
    document.querySelectorAll('.input-field').forEach(input => {
        input.addEventListener('input', () => {
            collectFormData();
            updateSummary();
            updateProgress();
        });
    });

    // Ajouter les listeners sur les inputs de quantité
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', () => {
            collectSocketData();
            updateSummary();
            updateProgress();
        });
    });
    
    // Ajouter les listeners sur les selects
    document.querySelectorAll('.detail-select').forEach(sel => {
        sel.addEventListener('change', () => {
            collectSocketData();
            updateSummary();
            updateProgress();
        });
    });

    // Mise à jour initiale
    collectFormData();
    collectSocketData();
    updateSummary();
    updateProgress();
});