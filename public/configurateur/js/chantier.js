
// =====================================================
//    ÉTAT GLOBAL
// =====================================================
const state = {
    societe: '',
    contact: '',
    installateur: '',
    affaire: '',
    email: '',
    type: '',
    montage: '',
    materiau: '',
    ip: '',
    sockets: [],
    protections: {
        tete: [],
        prises: []
    },
    observations: ''
};


// ================================================================
// 1. GESTION DES ACCORDÉONS
// ================================================================

function toggleSection(id) {
    const section = document.getElementById('section-' + id);
    const arrow   = document.getElementById('arrow-' + id);

    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden');
        arrow.textContent = '▲';
    } else {
        section.classList.add('hidden');
        arrow.textContent = '▼';
    }
}


// ================================================================
// 2. SÉLECTION DU TYPE DE COFFRET
// ================================================================

document.querySelectorAll('.btn-type').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.btn-type').forEach(function(b) {
            b.classList.remove('border-bals-blue', 'bg-bals-blue', 'text-white');
            b.classList.add('border-gray-200', 'text-gray-600');
        });
        this.classList.remove('border-gray-200', 'text-gray-600');
        this.classList.add('border-bals-blue', 'bg-bals-blue', 'text-white');
        mettreAJour();
    });
});


// ================================================================
// 3. CONTRÔLE DES QUANTITÉS (+/-)
// ================================================================

function changerQte(btn, direction) {
    const span  = btn.parentElement.querySelector('span');
    let valeur  = parseInt(span.textContent);
    valeur += direction;
    if (valeur < 0) valeur = 0;
    span.textContent = valeur;
    mettreAJour();
}


// =====================================================
//    4. COLLECTE DES DONNÉES DU FORMULAIRE
// =====================================================

function collectFormData() {
    state.societe      = document.getElementById('societe').value;
    state.contact      = document.getElementById('contact').value;
    state.installateur = document.getElementById('installateur').value;
    state.affaire      = document.getElementById('affaire').value;
    state.email        = document.getElementById('email').value;

    const typeBoutonActif = document.querySelector('.btn-type.bg-bals-blue');
    state.type = typeBoutonActif ? typeBoutonActif.dataset.type : '';

    const montageEl  = document.querySelector('input[name="montage"]:checked');
    const materiauEl = document.querySelector('input[name="materiau"]:checked');
    const ipEl       = document.querySelector('input[name="ip"]:checked');

    state.montage  = montageEl  ? montageEl.value  : '';
    state.materiau = materiauEl ? materiauEl.value : '';
    state.ip       = ipEl       ? ipEl.value       : '';

    state.observations = document.getElementById('observations').value;
    document.getElementById('nb-caracteres').textContent = state.observations.length;
}

function collectSocketData() {
    state.sockets = [];

    document.querySelectorAll('span[data-type]').forEach(function(span) {
        const qty = parseInt(span.textContent);
        if (qty > 0) {
            const type     = span.dataset.type;
            const brochage = span.dataset.brochage;

            let tension = '';
            if (brochage) {
                const selectTension = document.querySelector(`select[data-type="${type}"][data-brochage="${brochage}"][data-field="tension"]`);
                tension = selectTension ? selectTension.value : '';
            } else {
                const selectTension = document.querySelector(`select[data-type="${type}"][data-field="tension"]`);
                tension = selectTension ? selectTension.value : '';
            }

            if (!brochage) {
                state.sockets.push({ name: type, detail: '', tension: tension, qty: qty });
            } else {
                state.sockets.push({ name: type, detail: brochage, tension: tension, qty: qty });
            }
        }
    });
}

function collectProtections() {
    state.protections.tete = Array.from(
        document.querySelectorAll('input[name="prot_tete[]"]:checked')
    ).map(el => el.value);

    state.protections.prises = Array.from(
        document.querySelectorAll('input[name="prot_prises[]"]:checked')
    ).map(el => el.value);
}


// =====================================================
//    5. RÉSUMÉ DYNAMIQUE
// =====================================================

function updateSummary() {
    collectFormData();
    collectSocketData();
    collectProtections();

    const champs = [
        state.societe      ? 1 : 0,
        state.contact      ? 1 : 0,
        state.installateur ? 1 : 0,
        state.email        ? 1 : 0,
        state.type         ? 1 : 0,
        state.montage      ? 1 : 0,
        state.materiau     ? 1 : 0,
        state.ip           ? 1 : 0,
        state.protections.tete.length  > 0 ? 1 : 0,
        state.protections.prises.length > 0 ? 1 : 0,
        state.sockets.length > 0 ? 1 : 0
    ];

    const totalChamps   = champs.length;
    const champsRemplis = champs.reduce((a, b) => a + b, 0);
    const pourcentage   = Math.round(champsRemplis / totalChamps * 100);

    document.getElementById('progression-barre').style.width = pourcentage + '%';
    document.getElementById('progression-texte').textContent = '(' + pourcentage + '%)';

    const zoneResume = document.getElementById('resume-zone');
    let html = '';

    if (state.type) {
        html += `<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">${state.type}</div>`;
    }

    if (state.societe || state.contact || state.installateur || state.affaire || state.email) {
        html += `<div class="space-y-1">`;
        if (state.societe)      html += `<p class="text-xs"><span class="text-gray-400">Société :</span> <span class="font-bold text-gray-700">${state.societe}</span></p>`;
        if (state.contact)      html += `<p class="text-xs"><span class="text-gray-400">Contact :</span> <span class="font-bold text-gray-700">${state.contact}</span></p>`;
        if (state.installateur) html += `<p class="text-xs"><span class="text-gray-400">Installateur :</span> <span class="font-bold text-gray-700">${state.installateur}</span></p>`;
        if (state.affaire)      html += `<p class="text-xs"><span class="text-gray-400">Affaire :</span> <span class="font-bold text-gray-700">${state.affaire}</span></p>`;
        if (state.email)        html += `<p class="text-xs"><span class="text-gray-400">Email :</span> <span class="font-bold text-gray-700">${state.email}</span></p>`;
        html += `</div>`;
    }

    if (state.montage || state.materiau || state.ip) {
        html += `<div class="border-t border-gray-100 pt-2 space-y-1">`;
        if (state.montage)  html += `<p class="text-xs"><span class="text-gray-400">Montage :</span> <span class="font-bold text-gray-700">${state.montage}</span></p>`;
        if (state.materiau) html += `<p class="text-xs"><span class="text-gray-400">Matériau :</span> <span class="font-bold text-gray-700">${state.materiau}</span></p>`;
        if (state.ip)       html += `<p class="text-xs"><span class="text-gray-400">Protection :</span> <span class="font-black text-bals-blue">${state.ip}</span></p>`;
        html += `</div>`;
    }

    if (state.sockets.length > 0) {
        html += `<div class="border-t border-gray-100 pt-2">`;
        html += `<p class="text-xs text-gray-400 font-bold mb-1">Prises</p>`;
        html += `<div class="space-y-1">`;
        state.sockets.forEach(s => {
            let description = s.name;
            if (s.detail)  description += ' [' + s.detail + ']';
            if (s.tension) description += ' - ' + s.tension;
            html += `<p class="text-xs font-bold text-gray-700">${s.qty}× ${description}</p>`;
        });
        html += `</div></div>`;
    }

    if (state.protections.tete.length > 0) {
        html += `<div class="border-t border-gray-100 pt-2">`;
        html += `<p class="text-xs text-gray-400 font-bold mb-1">Protection tête</p>`;
        html += `<p class="text-xs font-bold text-gray-700">${state.protections.tete.join(', ')}</p>`;
        html += `</div>`;
    }

    if (state.protections.prises.length > 0) {
        html += `<div class="border-t border-gray-100 pt-2">`;
        html += `<p class="text-xs text-gray-400 font-bold mb-1">Protection prises</p>`;
        html += `<p class="text-xs font-bold text-gray-700">${state.protections.prises.join(', ')}</p>`;
        html += `</div>`;
    }

    if (state.observations) {
        html += `<div class="border-t border-gray-100 pt-2">`;
        html += `<p class="text-xs text-gray-400 font-bold mb-1">Observations</p>`;
        const preview = state.observations.substring(0, 100);
        html += `<p class="text-xs text-gray-600 italic">${preview}${state.observations.length > 100 ? '...' : ''}</p>`;
        html += `</div>`;
    }

    if (html === '') {
        zoneResume.innerHTML = `<div class="text-center">
            <p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>
            <p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>
        </div>`;
        document.getElementById('boutons-action').classList.add('hidden');
    } else {
        zoneResume.innerHTML = '<div class="w-full text-left space-y-3">' + html + '</div>';
        document.getElementById('boutons-action').classList.remove('hidden');
    }
}

function mettreAJour() {
    updateSummary();
}


// ================================================================
// 6. BOUTONS D'ACTION
// ================================================================

function copierResume() {
    collectFormData();
    collectSocketData();
    collectProtections();

    let texte = '═══ DEVIS BALS - ' + (state.type || 'Configuration') + ' ═══\n\n';

    if (state.societe || state.contact) {
        texte += '▸ PROJET\n';
        if (state.societe)      texte += '  Société : '      + state.societe + '\n';
        if (state.contact)      texte += '  Contact : '      + state.contact + '\n';
        if (state.installateur) texte += '  Installateur : ' + state.installateur + '\n';
        if (state.affaire)      texte += '  Affaire : '      + state.affaire + '\n';
        if (state.email)        texte += '  Email : '        + state.email + '\n';
        texte += '\n';
    }

    if (state.montage || state.materiau || state.ip) {
        texte += '▸ CONFIGURATION\n';
        if (state.montage)  texte += '  Montage : '    + state.montage  + '\n';
        if (state.materiau) texte += '  Matériau : '   + state.materiau + '\n';
        if (state.ip)       texte += '  Protection : ' + state.ip       + '\n';
        texte += '\n';
    }

    if (state.sockets.length > 0) {
        texte += '▸ PRISES\n';
        state.sockets.forEach(s => {
            let description = s.name;
            if (s.detail)  description += ' [' + s.detail + ']';
            if (s.tension) description += ' - ' + s.tension;
            texte += '  ' + s.qty + '× ' + description + '\n';
        });
        texte += '\n';
    }

    if (state.protections.tete.length > 0)   texte += '▸ PROTECTION TÊTE : '   + state.protections.tete.join(', ')   + '\n';
    if (state.protections.prises.length > 0) texte += '▸ PROTECTION PRISES : ' + state.protections.prises.join(', ') + '\n';

    if (state.observations) {
        texte += '\n▸ OBSERVATIONS\n' + state.observations;
    }

    navigator.clipboard.writeText(texte).then(function() {
        alert('✓ Résumé copié dans le presse-papiers !');
    }).catch(function() {
        alert('Erreur lors de la copie');
    });
}

function envoyerDevis() {
    collectFormData();
    collectSocketData();
    collectProtections();

    const sujet = encodeURIComponent('Demande de devis - ' + (state.type || 'Configuration') + ' - ' + (state.societe || 'Client'));

    let corps = 'Bonjour,\n\nVeuillez trouver ci-dessous ma demande de devis :\n\n';

    if (state.societe) corps += 'Société : ' + state.societe + '\n';
    if (state.contact) corps += 'Contact : ' + state.contact + '\n';
    if (state.email)   corps += 'Email : '   + state.email   + '\n\n';

    if (state.type)     corps += 'Type : '       + state.type     + '\n';
    if (state.montage)  corps += 'Montage : '    + state.montage  + '\n';
    if (state.materiau) corps += 'Matériau : '   + state.materiau + '\n';
    if (state.ip)       corps += 'Protection : ' + state.ip       + '\n\n';

    if (state.sockets.length > 0) {
        corps += 'PRISES :\n';
        state.sockets.forEach(s => {
            let description = s.name;
            if (s.detail)  description += ' [' + s.detail + ']';
            if (s.tension) description += ' - ' + s.tension;
            corps += '- ' + s.qty + '× ' + description + '\n';
        });
        corps += '\n';
    }

    corps += 'Cordialement';

    window.location.href = 'mailto:info@bals-france.fr?subject=' + sujet + '&body=' + encodeURIComponent(corps);
}

function reinitialiser() {
    ['societe','contact','installateur','affaire','email','observations'].forEach(function(id) {
        document.getElementById(id).value = '';
    });

    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function(r) {
        r.checked = false;
    });

    document.querySelectorAll('span[data-type]').forEach(function(span) {
        span.textContent = '0';
    });

    document.querySelectorAll('select[data-field="tension"]').forEach(function(select) {
        select.value = '';
    });

    document.getElementById('nb-caracteres').textContent = '0';

    mettreAJour();
}


// ================================================================
// 7. INITIALISATION AU CHARGEMENT DE LA PAGE
// ================================================================

document.addEventListener('DOMContentLoaded', function() {
    updateSummary();
});
