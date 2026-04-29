// ═══════════════════════════════════════════════════════════════════════
// configurateur.js — JavaScript unique pour tous les configurateurs BALS
// ═══════════════════════════════════════════════════════════════════════
//
// UTILISATION : chaque page blade définit window.COFFRET avant ce script.
//
//   <script>
//     window.COFFRET = {
//       nom:  'Coffret Industrie',   // titre affiché dans le résumé
//       type: 'coffret'              // 'coffret' ou 'prise'
//     };
//   </script>
//   <script src="{{ asset('configurateur/js/configurateur.js') }}"></script>
//
// ═══════════════════════════════════════════════════════════════════════


// ────────────────────────────────────────────────────────────────────────
// 1. ACCORDÉON — ouvrir / fermer une section en cliquant sur son en-tête
// ────────────────────────────────────────────────────────────────────────
function toggleSection(id) {
    var section = document.getElementById('section-' + id);
    var fleche = document.getElementById('arrow-' + id);
    if (!section) return;

    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden');
        if (fleche) fleche.textContent = '▲';
    } else {
        section.classList.add('hidden');
        if (fleche) fleche.textContent = '▼';
    }
}


// ────────────────────────────────────────────────────────────────────────
// 2. QUANTITÉ — boutons + / −
//
//    Coffrets     : onclick="changerQte(this, +1)"  → modifie un <span>
//    Prise indus. : onclick="changerQte(+1)"        → modifie l'<input id="quantite">
// ────────────────────────────────────────────────────────────────────────
function changerQte(btnOuDelta, direction) {
    if (typeof btnOuDelta === 'number') {
        // Mode prise-industrielle : l'argument est directement le delta (+1 ou -1)
        var champ = document.getElementById('quantite');
        if (!champ) return;
        champ.value = Math.max(1, (parseInt(champ.value) || 1) + btnOuDelta);
    } else {
        // Mode coffret : l'argument est le bouton cliqué (this)
        var span = btnOuDelta.parentElement.querySelector('span[data-type]');
        if (!span) return;
        span.textContent = Math.max(0, (parseInt(span.textContent) || 0) + direction);
    }
    gererInteractiviteTension();
    mettreAJour();
}


// ────────────────────────────────────────────────────────────────────────
// 2b. INTERACTIVITÉ TENSION — quand une prise 2P+T est sélectionnée,
//     les prises 3P+T et 3P+N+T passent automatiquement en 400V
// ────────────────────────────────────────────────────────────────────────
function gererInteractiviteTension() {
    // Vérifier si au moins un span 2P+T (prises OU alimentation) a une quantité > 0
    var has2PT = false;
    document.querySelectorAll('span[data-brochage="2P+T"]').forEach(function (span) {
        if (parseInt(span.textContent) > 0) has2PT = true;
    });

    if (has2PT) {
        // Auto-sélectionner 400V sur tous les <select> 3P+T et 3P+N+T vides
        // — couvre data-field="tension" (prises) ET data-field="tension-alim" (alimentation)
        document.querySelectorAll(
            'select[data-brochage="3P+T"],' +
            'select[data-brochage="3P+N+T"]'
        ).forEach(function (select) {
            if (select.value === '') select.value = '400V';
        });
    }
}


// ────────────────────────────────────────────────────────────────────────
// 2c. QUANTITÉ ALIMENTATION — boutons + / − pour la section Alimentation
// ────────────────────────────────────────────────────────────────────────
function changerQteAlim(btn, delta) {
    var span = btn.parentElement.querySelector('span[data-alim]');
    if (!span) return;
    span.textContent = Math.max(0, (parseInt(span.textContent) || 0) + delta);
    mettreAJour();
}


// ────────────────────────────────────────────────────────────────────────
// 3b. LIRE LES ALIMENTATIONS — section Alimentation & Éléments
//
//    Retourne un tableau d'objets : { type, brochage, quantite, tension }
// ────────────────────────────────────────────────────────────────────────
function lireAlimentations() {
    var alimentations = [];
    var section = document.getElementById('section-s-alim');
    if (!section) return alimentations;

    section.querySelectorAll('span[data-alim]').forEach(function (span) {
        var qte = parseInt(span.textContent) || 0;
        if (qte === 0) return;

        var alim = span.dataset.alim;
        var brochage = span.dataset.brochage || '';

        var filtre = '[data-alim="' + alim + '"]'
            + (brochage ? '[data-brochage="' + brochage + '"]' : '')
            + '[data-field="tension-alim"]';
        var tensionEl = document.querySelector(filtre);

        alimentations.push({
            type: alim,
            brochage: brochage,
            quantite: qte,
            tension: tensionEl ? tensionEl.value : ''
        });
    });

    return alimentations;
}


// ────────────────────────────────────────────────────────────────────────
// 3. LIRE LES PRISES — section 03 des coffrets
//
//    Retourne un tableau d'objets : { type, brochage, quantite, tension }
//
//    CORRECTION : utilise [data-field="tension"] sans préfixe "select",
//    ce qui fonctionne aussi bien avec <select> qu'avec <input type="hidden">.
// ────────────────────────────────────────────────────────────────────────
function lirePrises() {
    var prises = [];

    document.querySelectorAll('#section-s3 span[data-type]').forEach(function (span) {
        var qte = parseInt(span.textContent) || 0;
        if (qte === 0) return;

        var type = span.dataset.type;
        var brochage = span.dataset.brochage || '';

        // Ce sélecteur trouve à la fois <select> et <input type="hidden">
        var filtre = '[data-type="' + type + '"]'
            + (brochage ? '[data-brochage="' + brochage + '"]' : '')
            + '[data-field="tension"]';
        var tensionEl = document.querySelector(filtre);

        prises.push({
            type: type,
            brochage: brochage,
            quantite: qte,
            tension: tensionEl ? tensionEl.value : ''
        });
    });

    return prises;
}


// ────────────────────────────────────────────────────────────────────────
// 3c. POLARITÉ → TENSION (prise-industrielle uniquement)
//     2P+T (monophasé) → auto-sélectionne 230V
//     3P / 3P+N+T (triphasé) → auto-sélectionne 400V
// ────────────────────────────────────────────────────────────────────────
function gererPolaritePI() {
    var pol = _selectionne('pol');
    var cible = null;

    if (pol === '2P+T') {
        cible = '230V (50-60Hz)';
    } else if (pol === '3P' || pol === '3P+N+T') {
        cible = '400V (50-60Hz)';
    }

    if (cible) {
        var radio = document.querySelector('input[name="tension"][value="' + cible + '"]');
        if (radio && !radio.checked) radio.checked = true;
    }

    mettreAJour();
}


// ────────────────────────────────────────────────────────────────────────
// 4. TYPE DE PRODUIT — afficher / masquer le type de montage
//    (prise-industrielle uniquement)
// ────────────────────────────────────────────────────────────────────────
function gererTypeProduit() {
    var produitEl = document.querySelector('input[name="produit"]:checked');
    var produit = produitEl ? produitEl.value : '';
    var zoneMontage = document.getElementById('zone-montage');
    if (!zoneMontage) return;

    var avecMontage = ['Socle de prise', 'Socle connecteur'];
    if (avecMontage.indexOf(produit) !== -1) {
        zoneMontage.classList.remove('hidden');
    } else {
        zoneMontage.classList.add('hidden');
        document.querySelectorAll('input[name="montage_type"]').forEach(function (r) {
            r.checked = false;
        });
    }
    mettreAJour();
}


// ────────────────────────────────────────────────────────────────────────
// 5. MISE À JOUR — résumé + barre de progression
//    Appelée à chaque interaction dans le formulaire.
// ────────────────────────────────────────────────────────────────────────
function mettreAJour() {
    var config = window.COFFRET || { nom: 'BALS', type: 'coffret' };

    // Compteur de caractères pour le champ Observations
    var observations = _valeur('observations');
    var nbCar = document.getElementById('nb-caracteres');
    // Après — on n'affiche le chiffre que s'il y a vraiment du texte
    if (nbCar) nbCar.textContent = observations.length > 0 ? observations.length : '';

    // Déléguer à la fonction correspondant au type de page
    if (config.type === 'prise') {
        _mettreAJourPrise(config);
    } else {
        _mettreAJourCoffret(config);
    }
}

// ── Résumé pour les coffrets (industrie / chantier / étage / événementiel) ──
function _mettreAJourCoffret(config) {

    // Champs de contact — les noms varient selon le coffret :
    //   industrie/chantier  → societe, contact
    //   étage/événementiel  → distributeur, contact_distributeur
    var identite = _valeur('societe') || _valeur('distributeur');
    var contact = _valeur('contact') || _valeur('contact_distributeur');
    var installateur = _valeur('installateur');
    var contactInst = _valeur('contact_installateur');
    var affaire = _valeur('affaire');
    var telephone = _valeur('telephone');
    var email = _valeur('email');

    // Caractéristiques techniques
    var montage = _selectionne('montage');
    var materiau = _selectionne('materiau');
    var ip = _selectionne('ip');

    // Protections, prises et alimentations
    var protTete = _multiselectionne('prot_tete[]');
    var protPrises = _multiselectionne('prot_prises[]');
    var prises = lirePrises();
    var alimentations = lireAlimentations();

    // Progression : 5 champs principaux
    var remplis = _compterRemplis([identite, email, montage, materiau, ip]);
    _mettreAJourBarre(remplis, 5);

    var zone = document.getElementById('resume-zone');
    if (!zone) return;

  if (remplis === 0 && prises.length === 0 && alimentations.length === 0 && protTete.length === 0) {
    // On conserve le nom du coffret en bandeau, même quand tout est vide
    zone.innerHTML = '<div class="w-full text-left space-y-3">'
                   + '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">'
                   + config.nom
                   + '</div>'
                   + '<p class="text-gray-400 text-xs mt-2 text-center">Les informations apparaîtront ici</p>'
                   + '</div>';
    _afficherBoutons(false);
    return;
}

    var html = '<div class="w-full text-left space-y-3">';
    html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">'
        + config.nom + '</div>';

    // Labels adaptés selon les champs présents dans la page
    var labelIdentite = document.getElementById('societe') ? 'Société' : 'Distributeur';
    var labelContact = document.getElementById('contact') ? 'Contact' : 'Contact distrib.';

    if (identite) html += _ligne(labelIdentite, identite);
    if (contact) html += _ligne(labelContact, contact);
    if (installateur) html += _ligne('Installateur', installateur);
    if (contactInst) html += _ligne('Contact install.', contactInst);
    if (affaire) html += _ligne('Affaire', affaire);
    if (telephone) html += _ligne('Tél.', telephone);
    if (email) html += _ligne('Email', email);

    if (montage || materiau || ip) {
        html += '<div class="border-t border-gray-100 pt-2 space-y-1">';
        if (montage) html += _ligne('Montage', montage);
        if (materiau) html += _ligne('Matériau', materiau);
        if (ip) html += _ligneIP(ip);
        html += '</div>';
    }

    if (prises.length > 0) {
        var listePrises = prises.map(function (p) {
            return p.quantite + 'x ' + p.type
                + (p.brochage && p.brochage !== '—' ? ' ' + p.brochage : '')
                + (p.tension ? ' ' + p.tension : '');
        }).join('<br>');
        html += '<div class="border-t border-gray-100 pt-2">'
            + '<p class="text-xs text-gray-400 font-bold mb-1">Prises :</p>'
            + '<p class="text-xs font-bold text-gray-700">' + listePrises + '</p></div>';
    }

    if (alimentations.length > 0) {
        var listeAlim = alimentations.map(function (a) {
            return a.quantite + 'x ' + a.type + ' ' + a.brochage
                + (a.tension ? ' ' + a.tension : '');
        }).join('<br>');
        html += '<div class="border-t border-gray-100 pt-2">'
            + '<p class="text-xs text-gray-400 font-bold mb-1">Alimentation :</p>'
            + '<p class="text-xs font-bold text-gray-700">' + listeAlim + '</p></div>';
    }

    if (protTete.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">'
            + '<p class="text-xs text-gray-400 font-bold mb-1">Prot. de tête :</p>'
            + '<p class="text-xs font-bold text-gray-700">' + protTete.join(', ') + '</p></div>';
    }

    if (protPrises.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">'
            + '<p class="text-xs text-gray-400 font-bold mb-1">Prot. des prises :</p>'
            + '<p class="text-xs font-bold text-gray-700">' + protPrises.join(', ') + '</p></div>';
    }

    html += '</div>';
    zone.innerHTML = html;
    _afficherBoutons(true);
}

// ── Résumé pour la prise industrielle ───────────────────────────────────
function _mettreAJourPrise(config) {
    var societe = _valeur('societe');
    var contact = _valeur('contact');
    var installateur = _valeur('installateur');
    var affaire = _valeur('affaire');
    var email = _valeur('email');
    var quantite = _valeur('quantite') || '1';

    var produit = _selectionne('produit');
    var montage = _selectionne('montage_type');
    var tension = _selectionne('tension');
    var amp = _selectionne('amp');
    var pol = _selectionne('pol');
    var ip = _selectionne('ip');

    // Progression : 7 champs principaux
    var remplis = _compterRemplis([societe, email, produit, tension, amp, pol, ip]);
    _mettreAJourBarre(remplis, 7);

    var zone = document.getElementById('resume-zone');
    if (!zone) return;

    if (remplis === 0) {
        zone.innerHTML = '<p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre prise</p>'
            + '<p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>';
        _afficherBoutons(false);
        return;
    }

    var html = '<div class="w-full text-left space-y-3">';
    html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">'
        + config.nom + '</div>';

    if (societe) html += _ligne('Société', societe);
    if (contact) html += _ligne('Contact', contact);
    if (installateur) html += _ligne('Installateur', installateur);
    if (affaire) html += _ligne('Affaire', affaire);
    if (email) html += _ligne('Email', email);

    if (produit || montage) {
        html += '<div class="border-t border-gray-100 pt-2 space-y-1">';
        if (produit) html += _ligne('Produit', produit);
        if (montage) html += _ligne('Montage', montage);
        html += '</div>';
    }

    if (tension || amp || pol || ip) {
        html += '<div class="border-t border-gray-100 pt-2 space-y-1">';
        if (tension) html += _ligne('Tension', tension);
        if (amp) html += _ligne('Intensité', amp);
        if (pol) html += _ligne('Polarité', pol);
        if (ip) html += _ligneIP(ip);
        html += '</div>';
    }

    html += '<div class="border-t border-gray-100 pt-2">'
        + '<p class="text-xs"><span class="text-gray-400">Quantité :</span> '
        + '<span class="font-black text-bals-blue">' + quantite + '</span></p></div>';

    html += '</div>';
    zone.innerHTML = html;
    _afficherBoutons(true);
}


// ────────────────────────────────────────────────────────────────────────
// 6. COPIER LE RÉSUMÉ dans le presse-papiers
// ────────────────────────────────────────────────────────────────────────
function copierResume() {
    var config = window.COFFRET || { nom: 'BALS' };
    var societe = _valeur('societe') || _valeur('distributeur') || 'N/A';
    var email = _valeur('email') || 'N/A';
    var texte = 'DEVIS BALS — ' + config.nom.toUpperCase()
        + '\nSociété : ' + societe
        + '\nEmail : ' + email;
    navigator.clipboard.writeText(texte).then(function () {
        alert('Résumé copié dans le presse-papiers !');
    });
}


// ────────────────────────────────────────────────────────────────────────
// 7. RÉINITIALISER tous les champs du formulaire
// ────────────────────────────────────────────────────────────────────────
function reinitialiser() {
    // Vider les champs texte, email et téléphone
    document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], textarea').forEach(function (el) {
        el.value = '';
    });

    // Remettre la quantité à 1 (prise-industrielle)
    var quantite = document.getElementById('quantite');
    if (quantite) quantite.value = '1';

    // Décocher tous les radios et checkboxes
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function (r) {
        r.checked = false;
    });

    // Remettre les compteurs de prises à 0 (coffrets)
    document.querySelectorAll('span[data-type]').forEach(function (span) {
        span.textContent = '0';
    });

    // Remettre les compteurs d'alimentation à 0
    document.querySelectorAll('span[data-alim]').forEach(function (span) {
        span.textContent = '0';
    });

    // Réinitialiser les selects de tension (coffrets)
    document.querySelectorAll('select[data-field="tension"]').forEach(function (sel) {
        sel.value = '';
    });

    // Réinitialiser les selects de tension-alim
    document.querySelectorAll('select[data-field="tension-alim"]').forEach(function (sel) {
        sel.value = '';
    });

    // Masquer la zone de montage (prise-industrielle)
    var zoneMontage = document.getElementById('zone-montage');
    if (zoneMontage) zoneMontage.classList.add('hidden');

    // Remettre le compteur de caractères à 0
    var nbCar = document.getElementById('nb-caracteres');
    if (nbCar) nbCar.textContent = '';

    mettreAJour();
}


// ────────────────────────────────────────────────────────────────────────
// 8. ENVOYER LE DEVIS — POST vers /api/devis + ouverture du client mail
// ────────────────────────────────────────────────────────────────────────
function envoyerDevis() {
    var config = window.COFFRET || { nom: 'BALS', type: 'coffret' };
    var societe = _valeur('societe') || _valeur('distributeur');
    var contact = _valeur('contact') || _valeur('contact_distributeur');
    var installateur = _valeur('installateur');
    var contactInst = _valeur('contact_installateur');
    var affaire = _valeur('affaire');
    var telephone = _valeur('telephone');
    var email = _valeur('email');
    var observations = _valeur('observations');

    var payload;

    if (config.type === 'prise') {
        payload = {
            type_coffret: config.nom,
            societe: societe,
            contact: contact,
            installateur: installateur,
            affaire: affaire,
            email: email,
            observations: observations,
            donnees: {
                produit: _selectionne('produit'),
                montage: _selectionne('montage_type'),
                tension: _selectionne('tension'),
                amp: _selectionne('amp'),
                pol: _selectionne('pol'),
                ip: _selectionne('ip'),
                quantite: _valeur('quantite') || '1'
            }
        };
    } else {
        payload = {
            type_coffret: config.nom,
            societe: societe,
            contact: contact,
            installateur: installateur,
            contact_installateur: contactInst,
            affaire: affaire,
            telephone: telephone,
            email: email,
            observations: observations,
            donnees: {
                montage: _selectionne('montage'),
                materiau: _selectionne('materiau'),
                ip: _selectionne('ip'),
                prises: lirePrises(),
                alimentations: lireAlimentations(),
                protections_tete: _multiselectionne('prot_tete[]'),
                protections_prises: _multiselectionne('prot_prises[]')
            }
        };
    }

    var sujet = encodeURIComponent('Demande de devis ' + config.nom + (societe ? ' — ' + societe : ''));
    var corps = encodeURIComponent('Bonjour,\n\nVeuillez trouver ci-joint ma demande de devis.\n\nSociété : ' + societe);
    var lienMail = 'mailto:info@bals-france.fr?subject=' + sujet + '&body=' + corps;
    var token = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

    fetch('/api/devis', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body: JSON.stringify(payload)
    })
        .then(function () { window.location.href = lienMail; })
        .catch(function () { window.location.href = lienMail; });
}


// ────────────────────────────────────────────────────────────────────────
// 9. SOUMETTRE + TÉLÉCHARGER LE PDF — POST vers /configurateur/soumettre
//    Réutilise la même collecte de données que envoyerDevis().
//    Appelé par le bouton "Générer mon devis PDF" dans le panneau résumé.
// ────────────────────────────────────────────────────────────────────────
async function soumettrePDF() {
    var config = window.COFFRET || { nom: 'BALS', type: 'coffret' };
    var bouton = document.getElementById('btn-soumettre-pdf');
    var texteOriginal = bouton ? bouton.innerHTML : '';

    if (bouton) {
        bouton.disabled = true;
        bouton.innerHTML = '⏳ Génération en cours…';
    }

    try {
        // Réutilise la même structure de payload que envoyerDevis()
        var societe = _valeur('societe') || _valeur('distributeur');
        var payload;

        if (config.type === 'prise') {
            payload = {
                type_coffret: config.nom,
                distributeur: societe,
                contact:      _valeur('contact') || _valeur('contact_distributeur'),
                installateur: _valeur('installateur'),
                affaire:      _valeur('affaire'),
                email:        _valeur('email'),
                observations: _valeur('observations'),
                donnees: {
                    produit:  _selectionne('produit'),
                    montage:  _selectionne('montage_type'),
                    tension:  _selectionne('tension'),
                    amp:      _selectionne('amp'),
                    pol:      _selectionne('pol'),
                    ip:       _selectionne('ip'),
                    quantite: _valeur('quantite') || '1'
                }
            };
        } else {
            payload = {
                type_coffret:          config.nom,
                distributeur:          societe,
                contact:               _valeur('contact') || _valeur('contact_distributeur'),
                installateur:          _valeur('installateur'),
                contact_installateur:  _valeur('contact_installateur'),
                affaire:               _valeur('affaire'),
                telephone:             _valeur('telephone'),
                email:                 _valeur('email'),
                observations:          _valeur('observations'),
                donnees: {
                    montage:            _selectionne('montage'),
                    materiau:           _selectionne('materiau'),
                    ip:                 _selectionne('ip'),
                    prises:             lirePrises(),
                    alimentations:      lireAlimentations(),
                    protections_tete:   _multiselectionne('prot_tete[]'),
                    protections_prises: _multiselectionne('prot_prises[]')
                }
            };
        }

        var token = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

        var response = await fetch('/configurateur/soumettre', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/pdf',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(payload)
        });

        if (!response.ok) {
            throw new Error('Erreur serveur : ' + response.status);
        }

        // Déclenche le téléchargement du PDF reçu en réponse
        var blob    = await response.blob();
        var url     = URL.createObjectURL(blob);
        var lien    = document.createElement('a');
        lien.href   = url;
        lien.download = 'Devis-BALS-' + config.nom.replace(/\s+/g, '-') + '.pdf';
        document.body.appendChild(lien);
        lien.click();
        document.body.removeChild(lien);
        URL.revokeObjectURL(url);

        if (bouton) {
            bouton.innerHTML = '✅ Devis généré !';
            setTimeout(function () {
                bouton.innerHTML = texteOriginal;
                bouton.disabled = false;
            }, 3000);
        }

    } catch (err) {
        console.error('Erreur soumettrePDF :', err);
        alert('Une erreur est survenue lors de la génération du PDF. Réessayez.');
        if (bouton) {
            bouton.innerHTML = texteOriginal;
            bouton.disabled = false;
        }
    }
}


// ────────────────────────────────────────────────────────────────────────
// FONCTIONS UTILITAIRES (usage interne, préfixées _ par convention)
// ────────────────────────────────────────────────────────────────────────

// Lire la valeur d'un champ par son id
function _valeur(id) {
    return (document.getElementById(id) || {}).value || '';
}

// Lire la valeur d'un radio sélectionné
function _selectionne(name) {
    var el = document.querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : '';
}

// Lire les valeurs de toutes les checkboxes cochées
function _multiselectionne(name) {
    return Array.from(
        document.querySelectorAll('input[name="' + name + '"]:checked')
    ).map(function (el) { return el.value; });
}

// Compter le nombre de valeurs non-vides dans un tableau
function _compterRemplis(tableau) {
    return tableau.reduce(function (total, valeur) {
        return total + (valeur ? 1 : 0);
    }, 0);
}

// Mettre à jour la barre de progression
function _mettreAJourBarre(remplis, total) {
    var pct = Math.round(remplis / total * 100);
    var barre = document.getElementById('progression-barre');
    var texte = document.getElementById('progression-texte');
    if (barre) barre.style.width = pct + '%';
    if (texte) texte.textContent = '(' + pct + '%)';
}

// Afficher ou masquer les boutons d'action
function _afficherBoutons(visible) {
    var btns = document.getElementById('boutons-action');
    if (!btns) return;
    if (visible) {
        btns.classList.remove('hidden');
    } else {
        btns.classList.add('hidden');
    }
}

// Générer une ligne label : valeur dans le résumé
function _ligne(label, valeur) {
    return '<p class="text-xs">'
        + '<span class="text-gray-400">' + label + ' :</span> '
        + '<span class="font-bold text-gray-700">' + valeur + '</span>'
        + '</p>';
}

// Générer la ligne IP avec la couleur bleue BALS
function _ligneIP(valeur) {
    return '<p class="text-xs">'
        + '<span class="text-gray-400">IP :</span> '
        + '<span class="font-black text-bals-blue">' + valeur + '</span>'
        + '</p>';
}

// Tableau qui garde en mémoire les fichiers sélectionnés
// (un input file seul ne permet pas d'ajouter de façon cumulative)
let fichiersSelectionnes = new DataTransfer();

/**
 * Appelé quand l'utilisateur sélectionne des fichiers via le bouton
 */
function ajouterFichiers(nouveauxFichiers) {
    Array.from(nouveauxFichiers).forEach(fichier => {
        // Évite les doublons par nom
        const dejaPresent = Array.from(fichiersSelectionnes.files)
            .some(f => f.name === fichier.name);
        if (!dejaPresent) {
            fichiersSelectionnes.items.add(fichier);
        }
    });

    // Synchronise l'input réel avec notre DataTransfer
    document.getElementById('fichiers-input').files = fichiersSelectionnes.files;
    afficherListeFichiers();
    mettreAJour(); // met à jour le panneau résumé
}

/**
 * Gère le glisser-déposer
 */
function gererDrop(event) {
    event.preventDefault();
    const zone = document.getElementById('drop-zone');
    zone.classList.remove('border-bals-blue', 'bg-blue-50');
    ajouterFichiers(event.dataTransfer.files);
}

/**
 * Supprime un fichier de la liste
 */
function supprimerFichier(nomFichier) {
    const dt = new DataTransfer();
    Array.from(fichiersSelectionnes.files)
        .filter(f => f.name !== nomFichier)
        .forEach(f => dt.items.add(f));

    fichiersSelectionnes = dt;
    document.getElementById('fichiers-input').files = fichiersSelectionnes.files;
    afficherListeFichiers();
    mettreAJour();
}

/**
 * Affiche la liste des fichiers sous la zone de drop
 */
function afficherListeFichiers() {
    const liste = document.getElementById('liste-fichiers');
    liste.innerHTML = '';

    Array.from(fichiersSelectionnes.files).forEach(fichier => {
        const taille = (fichier.size / 1024 / 1024).toFixed(2); // en Mo
        const li = document.createElement('li');
        li.className = 'flex items-center justify-between bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm';
        li.innerHTML = `
            <div class="flex items-center gap-3">
                <span class="text-bals-blue font-bold">${iconeType(fichier.type)}</span>
                <span class="font-medium text-gray-700 truncate max-w-xs">${fichier.name}</span>
                <span class="text-gray-400 text-xs">${taille} Mo</span>
            </div>
            <button type="button" onclick="supprimerFichier('${fichier.name}')"
                class="text-red-400 hover:text-red-600 font-bold text-lg leading-none">×</button>
        `;
        liste.appendChild(li);
    });
}

/** Retourne une icône selon le type MIME */
function iconeType(mime) {
    if (mime === 'application/pdf') return '📄';
    if (mime.startsWith('image/')) return '🖼️';
    return '📎';
}


// ────────────────────────────────────────────────────────────────────────
// INITIALISATION — exécuté une fois que la page est complètement chargée
// ────────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    mettreAJour();
});
