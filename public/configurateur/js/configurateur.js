// ============================================================
// CONFIGURATEUR BALS — JavaScript unique pour tous les coffrets
// Fonctions attendues par les templates Blade :
//   toggleSection(id), mettreAJour(), changerQte(btn, delta),
//   changerQteAlim(btn, delta), reinitialiser(), envoyerDevis(),
//   copierResume(), soumettrePDF(), ajouterFichiers(files),
//   gererDrop(event), gererTypeProduit(), gererPolaritePI()
// ============================================================

var fichiersPJ = [];

// ── Accordéon ────────────────────────────────────────────────
function toggleSection(id) {
    var section = document.getElementById('section-' + id);
    var arrow   = document.getElementById('arrow-' + id);
    if (!section) return;

    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden');
        if (arrow) arrow.textContent = '▲';
    } else {
        section.classList.add('hidden');
        if (arrow) arrow.textContent = '▼';
    }
}

// ── Quantités prises ─────────────────────────────────────────
function changerQte(btn, delta) {
    var span = btn.parentElement.querySelector('span[data-type]');
    if (!span) return;
    var val = Math.max(0, (parseInt(span.textContent) || 0) + delta);
    span.textContent = val;
    mettreAJour();
}

// ── Quantités alimentation ───────────────────────────────────
function changerQteAlim(btn, delta) {
    var span = btn.parentElement.querySelector('span[data-alim]');
    if (!span) return;
    var val = Math.max(0, (parseInt(span.textContent) || 0) + delta);
    span.textContent = val;
    mettreAJour();
}

// ── Mise à jour globale ───────────────────────────────────────
function mettreAJour() {
    // Compteur caractères observations
    var obs = document.getElementById('observations');
    var nb  = document.getElementById('nb-caracteres');
    if (obs && nb) nb.textContent = obs.value.length;

    var data = collecterDonnees();
    var pct  = calculerProgression(data);

    var barre = document.getElementById('progression-barre');
    var texte = document.getElementById('progression-texte');
    if (barre) barre.style.width = pct + '%';
    if (texte) texte.textContent = '(' + pct + '%)';

    afficherResume(data, pct);
}

// ── Collecte de toutes les valeurs du formulaire ─────────────
function collecterDonnees() {
    var d = {};

    // Champs texte
    ['societe','contact','distributeur','contact_distributeur',
     'installateur','contact_installateur','affaire','telephone',
     'email','observations','quantite'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) d[id] = el.value.trim();
    });

    // Radios
    ['montage','materiau','ip','produit','montage_type',
     'tension','amp','pol'].forEach(function(name) {
        var el = document.querySelector('input[name="' + name + '"]:checked');
        if (el) d[name] = el.value;
    });

    // Checkboxes protections
    d.prot_tete   = Array.from(document.querySelectorAll('input[name="prot_tete[]"]:checked')).map(function(el) { return el.value; });
    d.prot_prises = Array.from(document.querySelectorAll('input[name="prot_prises[]"]:checked')).map(function(el) { return el.value; });

    // Prises avec quantité > 0
    d.prises = [];
    document.querySelectorAll('span[data-type][data-brochage]').forEach(function(span) {
        var qte = parseInt(span.textContent) || 0;
        if (qte <= 0) return;
        var tension = '';
        var row = span.closest('tr');
        if (row) {
            var h = row.querySelector('input[data-field="tension"]');
            var s = row.querySelector('select[data-field="tension"]');
            if (h) tension = h.value;
            else if (s) tension = s.value;
        }
        d.prises.push({ type: span.dataset.type, brochage: span.dataset.brochage, qte: qte, tension: tension });
    });

    // Alimentation avec quantité > 0
    d.alim = [];
    document.querySelectorAll('span[data-alim][data-brochage]').forEach(function(span) {
        var qte = parseInt(span.textContent) || 0;
        if (qte <= 0) return;
        var tension = '';
        var row = span.closest('tr');
        if (row) {
            var h = row.querySelector('input[data-field="tension-alim"]');
            var s = row.querySelector('select[data-field="tension-alim"]');
            if (h) tension = h.value;
            else if (s) tension = s.value;
        }
        d.alim.push({ type: span.dataset.alim, brochage: span.dataset.brochage, qte: qte, tension: tension });
    });

    d.fichiers = fichiersPJ;
    return d;
}

// ── Calcul du pourcentage de complétion ──────────────────────
function calculerProgression(d) {
    var score = 0, total = 0;

    // Détecte les champs de contact présents dans le DOM
    var contactCandidats = ['societe','contact','distributeur','contact_distributeur',
                            'installateur','contact_installateur','affaire','email','telephone'];
    contactCandidats.forEach(function(f) {
        if (document.getElementById(f)) {
            total++;
            if (d[f]) score++;
        }
    });

    // Caractéristiques techniques
    ['montage','materiau','ip','tension','amp','pol'].forEach(function(name) {
        if (document.querySelector('input[name="' + name + '"]')) {
            total++;
            if (d[name]) score++;
        }
    });

    // Protections
    if (document.querySelector('input[name="prot_tete[]"]'))   { total++; if (d.prot_tete.length)   score++; }
    if (document.querySelector('input[name="prot_prises[]"]')) { total++; if (d.prot_prises.length) score++; }

    // Au moins une prise ou alimentation
    if (document.querySelector('span[data-type]') || document.querySelector('span[data-alim]')) {
        total++;
        if (d.prises.length > 0 || d.alim.length > 0) score++;
    }

    return total > 0 ? Math.round((score / total) * 100) : 0;
}

// ── Affichage du résumé ──────────────────────────────────────
function afficherResume(d, pct) {
    var zone    = document.getElementById('resume-zone');
    var boutons = document.getElementById('boutons-action');
    if (!zone) return;

    var nom = (window.COFFRET && window.COFFRET.nom) ? window.COFFRET.nom : 'Coffret';

    var lignes = [];
    if (d.produit)     lignes.push({ l: 'Produit',       v: d.produit });
    if (d.montage)     lignes.push({ l: 'Type',          v: d.montage });
    if (d.materiau)    lignes.push({ l: 'Matériau',      v: d.materiau });
    if (d.ip)          lignes.push({ l: 'IP',            v: d.ip });
    if (d.tension)     lignes.push({ l: 'Tension',       v: d.tension });
    if (d.amp)         lignes.push({ l: 'Intensité',     v: d.amp });
    if (d.pol)         lignes.push({ l: 'Polarité',      v: d.pol });
    if (d.prot_tete   && d.prot_tete.length)   lignes.push({ l: 'Prot. tête',   v: d.prot_tete.join(', ') });
    if (d.prot_prises && d.prot_prises.length) lignes.push({ l: 'Prot. prises', v: d.prot_prises.join(', ') });

    d.prises.forEach(function(p) {
        lignes.push({ l: p.type + ' ' + p.brochage, v: '×' + p.qte + (p.tension ? ' — ' + p.tension : '') });
    });
    d.alim.forEach(function(a) {
        lignes.push({ l: a.type + ' ' + a.brochage, v: '×' + a.qte + (a.tension ? ' — ' + a.tension : '') });
    });

    if (d.observations) {
        var obs = d.observations.length > 80 ? d.observations.substring(0, 80) + '…' : d.observations;
        lignes.push({ l: 'Notes', v: obs });
    }
    if (d.fichiers.length > 0) lignes.push({ l: 'Fichiers', v: d.fichiers.length + ' pièce(s)' });

    if (lignes.length === 0) {
        zone.innerHTML = '<p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre ' +
                         nom.toLowerCase() + '</p>' +
                         '<p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>';
        if (boutons) boutons.classList.add('hidden');
        return;
    }

    var html = '<div class="w-full text-left space-y-2">' +
               '<p class="font-black text-gray-800 text-sm mb-3">' + nom + '</p>';
    lignes.forEach(function(l) {
        html += '<div class="flex justify-between items-start gap-2 text-xs border-b border-gray-50 pb-1.5">' +
                '<span class="text-gray-400 shrink-0">' + l.l + '</span>' +
                '<span class="text-gray-700 font-semibold text-right">' + l.v + '</span>' +
                '</div>';
    });
    html += '</div>';
    zone.innerHTML = html;

    if (boutons) {
        if (pct >= 20) boutons.classList.remove('hidden');
        else            boutons.classList.add('hidden');
    }
}

// ── Réinitialisation ─────────────────────────────────────────
function reinitialiser() {
    document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], textarea').forEach(function(el) {
        el.value = '';
    });
    document.querySelectorAll('input[type="radio"]').forEach(function(el) { el.checked = false; });
    document.querySelectorAll('input[type="checkbox"]').forEach(function(el) { el.checked = false; });
    document.querySelectorAll('span[data-type], span[data-alim]').forEach(function(span) { span.textContent = '0'; });
    document.querySelectorAll('select[data-field]').forEach(function(el) { el.selectedIndex = 0; });

    fichiersPJ = [];
    var liste = document.getElementById('liste-fichiers');
    if (liste) liste.innerHTML = '';
    var input = document.getElementById('fichiers-input');
    if (input) input.value = '';

    mettreAJour();
}

// ── Actions panneau résumé ────────────────────────────────────
function envoyerDevis() {
    alert('Fonctionnalité d\'envoi en cours de développement.');
}

function copierResume() {
    var zone = document.getElementById('resume-zone');
    if (!zone) return;
    navigator.clipboard.writeText(zone.innerText).then(function() {
        var btn = document.querySelector('button[onclick="copierResume()"]');
        if (btn) {
            var orig = btn.textContent;
            btn.textContent = '✓ Copié !';
            setTimeout(function() { btn.textContent = orig; }, 1500);
        }
    }).catch(function() {
        alert(zone.innerText);
    });
}

function soumettrePDF() {
    alert('Génération PDF en cours de développement.');
}

// ── Fichiers joints ──────────────────────────────────────────
function ajouterFichiers(files) {
    var liste = document.getElementById('liste-fichiers');
    if (!liste) return;

    Array.from(files).forEach(function(file) {
        if (fichiersPJ.find(function(f) { return f.name === file.name; })) return;
        if (file.size > 10 * 1024 * 1024) {
            alert(file.name + ' dépasse 10 Mo.');
            return;
        }
        fichiersPJ.push(file);

        var li = document.createElement('li');
        li.className = 'flex items-center justify-between bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 text-sm';
        li.innerHTML = '<span class="text-gray-700 font-medium truncate max-w-50">' + file.name + '</span>' +
                       '<span class="text-gray-400 text-xs ml-2 shrink-0">' + (file.size / 1024).toFixed(0) + ' Ko</span>' +
                       '<button type="button" class="ml-3 text-red-400 hover:text-red-600 text-xs font-bold shrink-0">✕</button>';

        li.querySelector('button').addEventListener('click', function() {
            fichiersPJ = fichiersPJ.filter(function(f) { return f.name !== file.name; });
            li.remove();
            mettreAJour();
        });

        liste.appendChild(li);
    });

    var input = document.getElementById('fichiers-input');
    if (input) input.value = '';

    mettreAJour();
}

function gererDrop(event) {
    event.preventDefault();
    var dz = document.getElementById('drop-zone');
    if (dz) dz.classList.remove('border-bals-blue', 'bg-blue-50');
    if (event.dataTransfer && event.dataTransfer.files.length) {
        ajouterFichiers(event.dataTransfer.files);
    }
}

// ── Spécifique Prise Industrielle ────────────────────────────
function gererTypeProduit() {
    var sel = document.querySelector('input[name="produit"]:checked');
    var zm  = document.getElementById('zone-montage');
    if (zm) {
        if (sel && (sel.value === 'Socle de prise' || sel.value === 'Socle connecteur')) {
            zm.classList.remove('hidden');
        } else {
            zm.classList.add('hidden');
        }
    }
    mettreAJour();
}

function gererPolaritePI() {
    mettreAJour();
}

// ── Interactivité tension alimentation → prises CEI ─────────
// • 230V    : griser les lignes 3P+T et 3P+N+T (incompatibles)
// • 400V    : activer et forcer 400V sur 3P+T et 3P+N+T
// • Tri 230V: activer et forcer 230V sur 3P+T et 3P+N+T
function gererInteractiviteTension() {
    var selectAlim = document.getElementById('alim-tension');
    var tensionAlim = selectAlim ? selectAlim.value : '';

    ['3P+T', '3P+N+T'].forEach(function (brochage) {
        document.querySelectorAll(
            '[data-type^="Prises CEI"][data-brochage="' + brochage + '"][data-field="tension"]'
        ).forEach(function (input) {
            var tr = input.closest('tr');
            var spanDisplay = input.previousElementSibling;
            var spanQte = tr ? tr.querySelector('span[data-brochage]') : null;

            if (tensionAlim === '230V') {
                if (tr) tr.classList.add('opacity-50', 'pointer-events-none');
                if (spanQte) spanQte.textContent = '0';
            } else if (tensionAlim === '400V') {
                if (tr) tr.classList.remove('opacity-50', 'pointer-events-none');
                input.value = '400V';
                if (spanDisplay) spanDisplay.textContent = '400V';
            } else if (tensionAlim === 'Tri 230V') {
                if (tr) tr.classList.remove('opacity-50', 'pointer-events-none');
                input.value = '230V';
                if (spanDisplay) spanDisplay.textContent = '230V';
            } else {
                if (tr) tr.classList.remove('opacity-50', 'pointer-events-none');
                input.value = '400V';
                if (spanDisplay) spanDisplay.textContent = '400V';
            }
        });
    });

    mettreAJour();
}

// ── Init ──────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    gererInteractiviteTension();
    mettreAJour();
});
