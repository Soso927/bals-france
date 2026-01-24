/* =====================================================
   SCRIPT JAVASCRIPT - PRISE INDUSTRIELLE
   
   Ce fichier contient toute la logique du formulaire :
   - Les fonctions qui réagissent aux clics
   - La mise à jour automatique du résumé
   - L'envoi par email
   
   VOCABULAIRE JAVASCRIPT :
   - fonction = bloc de code réutilisable
   - variable = boîte qui stocke une valeur
   - const = variable qui ne change pas
   - let = variable qui peut changer
   - document = la page web actuelle
===================================================== */


/* =====================================================
   FONCTION : toggleSection
   
   À quoi ça sert ?
   ----------------
   Ouvre ou ferme une section du formulaire quand on 
   clique sur son en-tête.
   
   Comment ça marche ?
   -------------------
   1. On récupère le contenu de la section
   2. Si le contenu est visible → on le cache
   3. Si le contenu est caché → on le montre
   
   Paramètre :
   - header = l'élément HTML sur lequel on a cliqué
===================================================== */
function toggleSection(header) {
    // Trouve le parent (la section complète)
    const section = header.closest('.section-card');
    
    // Trouve le contenu de cette section
    const content = section.querySelector('.section-content');
    
    // Trouve la flèche (▼ ou ▶)
    const toggle = section.querySelector('.section-toggle');
    
    // Toggle = inverser l'état actuel
    section.classList.toggle('collapsed');
    
    // Change la flèche selon l'état
    if (section.classList.contains('collapsed')) {
        toggle.textContent = '▶';  // Section fermée
    } else {
        toggle.textContent = '▼';  // Section ouverte
    }
}


/* =====================================================
   FONCTION : selectCard
   
   À quoi ça sert ?
   ----------------
   Gère la sélection des cartes cliquables.
   Quand on clique sur une carte, elle devient "active"
   et les autres du même groupe sont désélectionnées.
   
   Paramètres :
   - card = la carte sur laquelle on a cliqué
===================================================== */
function selectCard(card) {
    // Trouve le radio button à l'intérieur de la carte
    const radio = card.querySelector('input[type="radio"]');
    
    // Coche ce radio button
    radio.checked = true;
    
    // Trouve TOUTES les cartes du même groupe
    const allCards = document.querySelectorAll(
        `.selectable-card input[name="${radio.name}"]`
    );
    
    // Parcourt toutes les cartes du groupe
    allCards.forEach(function(input) {
        // Trouve la carte parent de ce radio
        const parentCard = input.closest('.selectable-card');
        
        // Enlève la classe 'active' de toutes les cartes
        parentCard.classList.remove('active');
    });
    
    // Ajoute la classe 'active' UNIQUEMENT à la carte cliquée
    card.classList.add('active');
    
    // Met à jour le résumé à droite
    updateSummary();
}


/* =====================================================
   FONCTION : selectToggle
   
   À quoi ça sert ?
   ----------------
   Gère la sélection des boutons toggle (IP44, IP54, IP67).
   Similaire à selectCard mais pour un style différent.
   
   Paramètres :
   - label = le label sur lequel on a cliqué
===================================================== */
function selectToggle(label) {
    // Trouve le radio button à l'intérieur
    const radio = label.querySelector('input[type="radio"]');
    
    // Coche ce radio button
    radio.checked = true;
    
    // Trouve tous les toggles du même groupe
    const allToggles = document.querySelectorAll(
        `.toggle-label input[name="${radio.name}"]`
    );
    
    // Enlève 'active' de tous les toggles
    allToggles.forEach(function(input) {
        input.closest('.toggle-label').classList.remove('active');
    });
    
    // Ajoute 'active' au toggle cliqué
    label.classList.add('active');
    
    // Met à jour le résumé
    updateSummary();
}


/* =====================================================
   FONCTION : stepQty
   
   À quoi ça sert ?
   ----------------
   Augmente ou diminue la quantité quand on clique 
   sur les boutons + ou -.
   
   Paramètres :
   - btn = le bouton cliqué (+ ou -)
   - delta = la valeur à ajouter (+1 ou -1)
===================================================== */
function stepQty(btn, delta) {
    // Trouve le champ de quantité à côté du bouton
    const input = btn.parentElement.querySelector('.qty-input');
    
    // Récupère la valeur actuelle
    // parseInt() convertit le texte en nombre
    let currentValue = parseInt(input.value) || 1;
    
    // Calcule la nouvelle valeur
    let newValue = currentValue + delta;
    
    // Empêche les valeurs inférieures à 1
    // Math.max() retourne le plus grand des deux nombres
    newValue = Math.max(1, newValue);
    
    // Met à jour le champ avec la nouvelle valeur
    input.value = newValue;
    
    // Met à jour le résumé
    updateSummary();
}


/* =====================================================
   FONCTION : updateSummary
   
   À quoi ça sert ?
   ----------------
   Met à jour le panneau de résumé à droite de la page.
   Cette fonction est appelée à chaque modification.
   
   C'est la fonction la plus importante du fichier !
===================================================== */
function updateSummary() {
    // Récupère l'élément qui va contenir le résumé
    const summaryList = document.getElementById('summaryList');
    
    // Tableau pour stocker les lignes du résumé
    let items = [];
    
    // Variable pour compter les champs remplis (pour la progression)
    let filledFields = 0;
    
    // Nombre total de champs à remplir pour avoir 100%
    const totalFields = 6;
    
    // ===== SECTION 1 : CONTACT =====
    
    const distributeur = document.getElementById('distributeur').value || '';
    const contactDist = document.getElementById('contactDist').value || '';
    const installateur = document.getElementById('installateur').value || '';
    const contactInst = document.getElementById('contactInst').value || '';
    const affaire = document.getElementById('affaire').value || '';
    const contactAffaire = document.getElementById('contactAffaire').value || '';
    const telephone = document.getElementById('telephone').value || '';
    const fax = document.getElementById('fax').value || '';
    const email = document.getElementById('email').value || '';
    
    // Si au moins un champ de contact est rempli...
    if (distributeur || contactDist || installateur || contactInst || affaire || contactAffaire || telephone || fax || email) {
        let contactContent = '';
        
        if (distributeur) contactContent += `<p>Distributeur: ${distributeur}</p>`;
        if (contactDist) contactContent += `<p>Contact Dist.: ${contactDist}</p>`;
        if (installateur) contactContent += `<p>Installateur: ${installateur}</p>`;
        if (contactInst) contactContent += `<p>Contact Inst.: ${contactInst}</p>`;
        if (affaire) contactContent += `<p>Affaire: ${affaire}</p>`;
        if (contactAffaire) contactContent += `<p>Contact Affaire: ${contactAffaire}</p>`;
        if (telephone) contactContent += `<p>Tél.: ${telephone}</p>`;
        if (fax) contactContent += `<p>Fax: ${fax}</p>`;
        if (email) contactContent += `<p>Email: ${email}</p>`;
        
        items.push(`
            <div class="summary-section">
                <h4>Contact</h4>
                ${contactContent}
            </div>
        `);
        
        filledFields++;
    }
    
    // ===== SECTION 2 : QUANTITÉ =====
    
    const quantite = document.getElementById('quantite').value || '1';
    
    if (parseInt(quantite) > 0) {
        items.push(`
            <div class="summary-section">
                <h4>Quantité</h4>
                <p><strong>${quantite}</strong> prise(s)</p>
            </div>
        `);
        
        filledFields++;
    }
    
    // ===== SECTION 3 : PRODUIT =====
    
    const produit = document.querySelector('input[name="produit"]:checked');
    
    if (produit) {
        items.push(`
            <div class="summary-section">
                <h4>Type de produit</h4>
                <p>${produit.value}</p>
            </div>
        `);
        
        filledFields++;
    }
    
    // ===== SECTION 4 : CARACTÉRISTIQUES ÉLECTRIQUES =====
    
    const tension = document.querySelector('input[name="tension"]:checked');
    const intensite = document.querySelector('input[name="intensite"]:checked');
    const polarite = document.querySelector('input[name="polarite"]:checked');
    const ip = document.querySelector('input[name="ip"]:checked');
    
    if (tension || intensite || polarite || ip) {
        let caractContent = '';
        
        if (tension) caractContent += `<p>Tension: ${tension.value}</p>`;
        if (intensite) caractContent += `<p>Intensité: ${intensite.value}</p>`;
        if (polarite) caractContent += `<p>Polarité: ${polarite.value}</p>`;
        if (ip) caractContent += `<p>Protection: ${ip.value}</p>`;
        
        items.push(`
            <div class="summary-section">
                <h4>Caractéristiques</h4>
                ${caractContent}
            </div>
        `);
        
        filledFields++;
    }
    
    // ===== SECTION 5 : REMARQUES =====
    
    const observations = document.getElementById('observations').value || '';
    
    if (observations) {
        items.push(`
            <div class="summary-section">
                <h4>Remarques</h4>
                <p>${observations}</p>
            </div>
        `);
        
        filledFields++;
    }
    
    // ===== MISE À JOUR DE L'AFFICHAGE =====
    
    // Si aucune donnée n'a été saisie...
    if (items.length === 0) {
        // Affiche l'état vide
        summaryList.innerHTML = `
            <div class="empty-state">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15M9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.10457 15 5M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5M12 12H15M12 16H15M9 12H9.01M9 16H9.01" 
                          stroke="rgba(255,255,255,0.3)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <p>Configurez votre prise</p>
                <small>Les informations apparaîtront ici</small>
            </div>
        `;
    } else {
        // Affiche le résumé
        summaryList.innerHTML = items.join('');
    }
    
    // ===== MISE À JOUR DE LA BARRE DE PROGRESSION =====
    
    // Calcule le pourcentage de complétion
    const percentage = Math.round((filledFields / totalFields) * 100);
    
    // Récupère la barre de progression
    const progressBar = document.getElementById('progressBar');
    
    // Met à jour la largeur de la barre (en CSS)
    progressBar.style.width = percentage + '%';
    
    // Met à jour le texte du pourcentage
    const progressLabel = document.querySelector('.progress-label');
    progressLabel.textContent = `Progression du devis (${percentage}%)`;
}


/* =====================================================
   FONCTION : resetForm
   
   À quoi ça sert ?
   ----------------
   Réinitialise complètement le formulaire.
   Efface tous les champs et déselectionne tout.
===================================================== */
function resetForm() {
    // Demande confirmation avant d'effacer
    if (confirm('Voulez-vous vraiment réinitialiser le formulaire ?')) {
        // Efface tous les champs texte
        document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], textarea').forEach(function(input) {
            input.value = '';
        });
        
        // Remet la quantité à 1
        document.getElementById('quantite').value = '1';
        
        // Décoche tous les radio buttons
        document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
            radio.checked = false;
        });
        
        // Enlève la classe 'selected' de tous les éléments
        document.querySelectorAll('.selected').forEach(function(el) {
            el.classList.remove('selected');
        });
        
        // Met à jour le résumé (qui sera vide)
        updateSummary();
    }
}


/* =====================================================
   FONCTION : generateText
   
   À quoi ça sert ?
   ----------------
   Génère le texte du devis pour l'email ou la copie.
   Retourne une chaîne de caractères formatée.
===================================================== */
function generateText() {
    // Commence par le titre
    let text = '=== DEMANDE DE DEVIS - PRISE INDUSTRIELLE ===\n\n';
    text += 'Conformes aux normes : NF EN 60 309-1/2 (NF C 63-300 et NF C 63-310), CEI 309-1/2, CEE 17\n\n';
    
    // ===== CONTACT =====
    const distributeur = document.getElementById('distributeur').value || '';
    const contactDist = document.getElementById('contactDist').value || '';
    const installateur = document.getElementById('installateur').value || '';
    const contactInst = document.getElementById('contactInst').value || '';
    const affaire = document.getElementById('affaire').value || '';
    const contactAffaire = document.getElementById('contactAffaire').value || '';
    const telephone = document.getElementById('telephone').value || '';
    const fax = document.getElementById('fax').value || '';
    const email = document.getElementById('email').value || '';
    
    text += '--- INFORMATIONS DE CONTACT ---\n';
    text += `Distributeur: ${distributeur}\n`;
    text += `Contact Distributeur: ${contactDist}\n`;
    text += `Installateur: ${installateur}\n`;
    text += `Contact Installateur: ${contactInst}\n`;
    text += `Affaire: ${affaire}\n`;
    text += `Contact Affaire: ${contactAffaire}\n`;
    text += `Téléphone: ${telephone}\n`;
    text += `Fax: ${fax}\n`;
    text += `Email: ${email}\n\n`;
    
    // ===== QUANTITÉ =====
    const quantite = document.getElementById('quantite').value || '1';
    text += '--- QUANTITÉ ---\n';
    text += `Nombre de prises: ${quantite}\n\n`;
    
    // ===== PRODUIT =====
    const produit = document.querySelector('input[name="produit"]:checked');
    text += '--- TYPE DE PRODUIT ---\n';
    text += `Produit: ${produit ? produit.value : 'Non spécifié'}\n\n`;
    
    // ===== CARACTÉRISTIQUES ÉLECTRIQUES =====
    const tension = document.querySelector('input[name="tension"]:checked');
    const intensite = document.querySelector('input[name="intensite"]:checked');
    const polarite = document.querySelector('input[name="polarite"]:checked');
    const ip = document.querySelector('input[name="ip"]:checked');
    
    text += '--- CARACTÉRISTIQUES ÉLECTRIQUES ---\n';
    text += `Tension: ${tension ? tension.value : 'Non spécifié'}\n`;
    text += `Intensité: ${intensite ? intensite.value : 'Non spécifié'}\n`;
    text += `Polarité: ${polarite ? polarite.value : 'Non spécifié'}\n`;
    text += `Indice IP: ${ip ? ip.value : 'Non spécifié'}\n\n`;
    
    // ===== REMARQUES =====
    const observations = document.getElementById('observations').value || '';
    text += '--- REMARQUES ---\n';
    text += observations || 'Aucune remarque';
    
    return text;
}


/* =====================================================
   FONCTION : copierTexte
   
   À quoi ça sert ?
   ----------------
   Copie le texte du devis dans le presse-papier.
   L'utilisateur peut ensuite le coller où il veut.
===================================================== */
function copierTexte() {
    // Génère le texte du devis
    const text = generateText();
    
    // Utilise l'API moderne du presse-papier
    navigator.clipboard.writeText(text).then(function() {
        // Succès : affiche un message
        alert('Le devis a été copié dans le presse-papier !');
    }).catch(function(err) {
        // Erreur : affiche un message d'erreur
        console.error('Erreur lors de la copie:', err);
        alert('Impossible de copier. Erreur: ' + err);
    });
}


/* =====================================================
   FONCTION : generateMailto
   
   À quoi ça sert ?
   ----------------
   Ouvre le client email de l'utilisateur avec un email
   pré-rempli contenant le devis.
   
   Comment ça marche ?
   -------------------
   On utilise un lien "mailto:" qui est un protocole spécial
   reconnu par les navigateurs pour ouvrir le client email.
===================================================== */
function generateMailto() {
    // Génère le texte du devis
    const text = generateText();
    
    // Récupère la référence affaire pour le sujet
    const affaire = document.getElementById('affaire').value || 'Sans référence';
    
    // Adresse email de destination
    const destinataire = 'info@bals-france.fr';
    
    // Sujet de l'email
    const sujet = `Demande de devis Prise Industrielle - ${affaire}`;
    
    // Construit le lien mailto
    // encodeURIComponent() encode les caractères spéciaux pour l'URL
    const mailtoLink = `mailto:${destinataire}?subject=${encodeURIComponent(sujet)}&body=${encodeURIComponent(text)}`;
    
    // Ouvre le lien (ouvre le client email)
    window.location.href = mailtoLink;
}


/* =====================================================
   ÉCOUTEURS D'ÉVÉNEMENTS
   
   Ces lignes s'exécutent quand la page est chargée.
   Elles "écoutent" les changements sur les éléments
   et appellent updateSummary() automatiquement.
===================================================== */

// Écoute les changements sur tous les champs texte
document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], textarea').forEach(function(input) {
    // 'input' = événement déclenché à chaque frappe de touche
    input.addEventListener('input', updateSummary);
});

// Écoute les changements sur la quantité
document.getElementById('quantite').addEventListener('change', updateSummary);


/* =====================================================
   FIN DU FICHIER
   
   Résumé des fonctions principales :
   
   1. toggleSection() - Ouvre/ferme les sections
   2. selectCard() - Sélectionne une carte
   3. selectToggle() - Sélectionne un toggle (IP)
   4. stepQty() - Modifie la quantité (+/-)
   5. updateSummary() - Met à jour le résumé
   6. resetForm() - Efface le formulaire
   7. generateText() - Génère le texte du devis
   8. copierTexte() - Copie dans le presse-papier
   9. generateMailto() - Envoie par email
===================================================== */