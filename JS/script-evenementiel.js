/* =====================================================
   SCRIPT JAVASCRIPT - COFFRET ÉVÉNEMENTIEL
   
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
    // closest() cherche l'ancêtre le plus proche avec la classe donnée
    const section = header.closest('.section-card');
    
    // Trouve le contenu de cette section
    // querySelector() cherche un élément à l'intérieur
    const content = section.querySelector('.section-content');
    
    // Trouve la flèche (▼ ou ▶)
    const toggle = section.querySelector('.section-toggle');
    
    // Toggle = inverser l'état actuel
    // Si la classe 'collapsed' existe → on l'enlève
    // Si elle n'existe pas → on l'ajoute
    section.classList.toggle('collapsed');
    
    // Change la flèche selon l'état
    // textContent = le texte à l'intérieur de l'élément
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
   Gère la sélection des cartes cliquables (montage, matériaux).
   Quand on clique sur une carte, elle devient "active"
   et les autres sont désélectionnées.
   
   Paramètres :
   - card = la carte sur laquelle on a cliqué
===================================================== */
function selectCard(card) {
    // Trouve le radio button à l'intérieur de la carte
    const radio = card.querySelector('input[type="radio"]');
    
    // Coche ce radio button
    radio.checked = true;
    
    // Trouve TOUTES les cartes du même groupe
    // On cherche les cartes dont le radio a le même "name"
    const allCards = document.querySelectorAll(
        `.selectable-card input[name="${radio.name}"]`
    );
    
    // Parcourt toutes les cartes du groupe
    // forEach = "pour chaque élément, faire..."
    allCards.forEach(function(input) {
        // Trouve la carte parent de ce radio
        const parentCard = input.closest('.selectable-card');
        
        // Enlève la classe 'selected' de toutes les cartes
        parentCard.classList.remove('selected');
    });
    
    // Ajoute la classe 'selected' UNIQUEMENT à la carte cliquée
    card.classList.add('selected');
    
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
    
    // Enlève 'selected' de tous les toggles
    allToggles.forEach(function(input) {
        input.closest('.toggle-label').classList.remove('selected');
    });
    
    // Ajoute 'selected' au toggle cliqué
    label.classList.add('selected');
    
    // Met à jour le résumé
    updateSummary();
}


/* =====================================================
   FONCTION : step
   
   À quoi ça sert ?
   ----------------
   Augmente ou diminue la quantité d'une prise quand on 
   clique sur les boutons + ou -.
   
   Paramètres :
   - btn = le bouton cliqué (+ ou -)
   - delta = la valeur à ajouter (+1 ou -1)
===================================================== */
function step(btn, delta) {
    // Trouve le champ de quantité à côté du bouton
    // parentElement = l'élément parent (le conteneur qty-control)
    const input = btn.parentElement.querySelector('.qty-input');
    
    // Récupère la valeur actuelle
    // parseInt() convertit le texte en nombre
    let currentValue = parseInt(input.value) || 0;
    
    // Calcule la nouvelle valeur
    let newValue = currentValue + delta;
    
    // Empêche les valeurs négatives
    // Math.max() retourne le plus grand des deux nombres
    newValue = Math.max(0, newValue);
    
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
    
    // Récupère la valeur du champ "distributeur"
    // || '' signifie : si vide, utiliser une chaîne vide
    const distributeur = document.getElementById('distributeur').value || '';
    const contactDist = document.getElementById('contactDist').value || '';
    const installateur = document.getElementById('installateur').value || '';
    const affaire = document.getElementById('affaire').value || '';
    const email = document.getElementById('email').value || '';
    
    // Si au moins un champ de contact est rempli...
    if (distributeur || contactDist || installateur || affaire || email) {
        // Crée une section "Contact" dans le résumé
        let contactContent = '';
        
        // Ajoute chaque champ rempli à la section
        if (distributeur) contactContent += `<p>Société: ${distributeur}</p>`;
        if (contactDist) contactContent += `<p>Contact: ${contactDist}</p>`;
        if (installateur) contactContent += `<p>Installateur: ${installateur}</p>`;
        if (affaire) contactContent += `<p>Réf. Affaire: ${affaire}</p>`;
        if (email) contactContent += `<p>Email: ${email}</p>`;
        
        // Ajoute cette section au tableau items
        items.push(`
            <div class="summary-section">
                <h4>Contact</h4>
                ${contactContent}
            </div>
        `);
        
        // Augmente le compteur de progression
        filledFields++;
    }
    
    // ===== SECTION 2 : CARACTÉRISTIQUES =====
    
    // Récupère le type de montage sélectionné
    // querySelector() trouve le premier élément qui correspond
    // :checked = qui est coché
    const montage = document.querySelector('input[name="montage"]:checked');
    const materiau = document.querySelector('input[name="materiau"]:checked');
    const ip = document.querySelector('input[name="ip"]:checked');
    
    // Si au moins une caractéristique est sélectionnée...
    if (montage || materiau || ip) {
        let caractContent = '';
        
        // Ajoute chaque option sélectionnée
        // ? = opérateur ternaire (si ... alors ... sinon)
        if (montage) caractContent += `<p>Montage: ${montage.value}</p>`;
        if (materiau) caractContent += `<p>Matériau: ${materiau.value}</p>`;
        if (ip) caractContent += `<p>Protection: ${ip.value}</p>`;
        
        items.push(`
            <div class="summary-section">
                <h4>Caractéristiques</h4>
                ${caractContent}
            </div>
        `);
        
        filledFields++;
    }
    
    // ===== SECTION 3 : PRISES =====
    
    // Récupère tous les champs de quantité
    const qtyInputs = document.querySelectorAll('.qty-input');
    let prisesContent = '';
    let hasPrises = false;
    
    // Parcourt tous les champs de quantité
    qtyInputs.forEach(function(input) {
        // Récupère la quantité (convertie en nombre)
        const qty = parseInt(input.value) || 0;
        
        // Si la quantité est supérieure à 0...
        if (qty > 0) {
            hasPrises = true;
            
            // Récupère le nom de la prise depuis l'attribut data-name
            const name = input.getAttribute('data-name');
            
            // Trouve la ligne du tableau qui contient ce champ
            const row = input.closest('tr');
            
            // Récupère les listes déroulantes (brochage et tension)
            const selects = row.querySelectorAll('.detail-select');
            
            let brochage = '';
            let tension = '';
            
            // Si on a trouvé au moins 2 listes déroulantes...
            if (selects.length >= 2) {
                brochage = selects[0].value || 'Non spécifié';
                tension = selects[1].value || 'Non spécifié';
            }
            
            // Ajoute cette prise au résumé
            prisesContent += `
                <div class="prise-item">
                    <strong>${qty}x ${name}</strong><br>
                    <small>Brochage: ${brochage} | Tension: ${tension}</small>
                </div>
            `;
        }
    });
    
    // Si au moins une prise a été configurée...
    if (hasPrises) {
        items.push(`
            <div class="summary-section">
                <h4>Prises</h4>
                ${prisesContent}
            </div>
        `);
        
        filledFields++;
    }
    
    // ===== SECTION 4 : PROTECTIONS =====
    
    // Récupère toutes les checkboxes cochées pour protection de tête
    const protTete = document.querySelectorAll('input[name="protTete"]:checked');
    
    // Récupère toutes les checkboxes cochées pour protection des prises
    const protPrises = document.querySelectorAll('input[name="protPrises"]:checked');
    
    // Si au moins une protection est sélectionnée...
    if (protTete.length > 0 || protPrises.length > 0) {
        let protContent = '';
        
        // Protection de tête
        if (protTete.length > 0) {
            // Convertit NodeList en Array, puis récupère toutes les valeurs
            // join(', ') = les joint avec des virgules
            const values = Array.from(protTete).map(function(cb) {
                return cb.value;
            }).join(', ');
            
            protContent += `<p><strong>Protection de tête:</strong><br>${values}</p>`;
        }
        
        // Protection des prises
        if (protPrises.length > 0) {
            const values = Array.from(protPrises).map(function(cb) {
                return cb.value;
            }).join(', ');
            
            protContent += `<p><strong>Protection des prises:</strong><br>${values}</p>`;
        }
        
        items.push(`
            <div class="summary-section">
                <h4>Protections</h4>
                ${protContent}
            </div>
        `);
        
        filledFields++;
    }
    
    // ===== SECTION 5 : OBSERVATIONS =====
    
    const observations = document.getElementById('observations').value || '';
    
    if (observations) {
        items.push(`
            <div class="summary-section">
                <h4>Observations</h4>
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
                <p>Configurez votre coffret</p>
                <small>Les informations apparaîtront ici</small>
            </div>
        `;
    } else {
        // Affiche le résumé
        // join('') = combine tous les éléments du tableau en une seule chaîne
        summaryList.innerHTML = items.join('');
    }
    
    // ===== MISE À JOUR DE LA BARRE DE PROGRESSION =====
    
    // Calcule le pourcentage de complétion
    // Math.round() arrondit à l'entier le plus proche
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
    // confirm() affiche une boîte de dialogue avec OK/Annuler
    if (confirm('Voulez-vous vraiment réinitialiser le formulaire ?')) {
        // Efface tous les champs texte
        document.querySelectorAll('input[type="text"], input[type="email"], textarea').forEach(function(input) {
            input.value = '';
        });
        
        // Remet toutes les quantités à 0
        document.querySelectorAll('.qty-input').forEach(function(input) {
            input.value = '0';
        });
        
        // Décoche tous les radio buttons
        document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
            radio.checked = false;
        });
        
        // Décoche toutes les checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(function(cb) {
            cb.checked = false;
        });
        
        // Enlève la classe 'selected' de tous les éléments
        document.querySelectorAll('.selected').forEach(function(el) {
            el.classList.remove('selected');
        });
        
        // Remet toutes les listes déroulantes à leur valeur par défaut
        document.querySelectorAll('.detail-select').forEach(function(select) {
            select.selectedIndex = 0;
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
    let text = '=== DEMANDE DE DEVIS - COFFRET ÉVÉNEMENTIEL ===\n\n';
    
    // ===== CONTACT =====
    const distributeur = document.getElementById('distributeur').value || '';
    const contactDist = document.getElementById('contactDist').value || '';
    const installateur = document.getElementById('installateur').value || '';
    const affaire = document.getElementById('affaire').value || '';
    const email = document.getElementById('email').value || '';
    
    text += '--- INFORMATIONS DE CONTACT ---\n';
    text += `Société: ${distributeur}\n`;
    text += `Contact: ${contactDist}\n`;
    text += `Installateur: ${installateur}\n`;
    text += `Référence Affaire: ${affaire}\n`;
    text += `Email: ${email}\n\n`;
    
    // ===== CARACTÉRISTIQUES =====
    const montage = document.querySelector('input[name="montage"]:checked');
    const materiau = document.querySelector('input[name="materiau"]:checked');
    const ip = document.querySelector('input[name="ip"]:checked');
    
    text += '--- CARACTÉRISTIQUES TECHNIQUES ---\n';
    text += `Type de montage: ${montage ? montage.value : 'Non spécifié'}\n`;
    text += `Matériau: ${materiau ? materiau.value : 'Non spécifié'}\n`;
    text += `Indice IP: ${ip ? ip.value : 'Non spécifié'}\n\n`;
    
    // ===== PRISES =====
    text += '--- PRISES ---\n';
    const qtyInputs = document.querySelectorAll('.qty-input');
    
    qtyInputs.forEach(function(input) {
        const qty = parseInt(input.value) || 0;
        if (qty > 0) {
            const name = input.getAttribute('data-name');
            const row = input.closest('tr');
            const selects = row.querySelectorAll('.detail-select');
            
            let brochage = '';
            let tension = '';
            if (selects.length >= 2) {
                brochage = selects[0].value || 'Non spécifié';
                tension = selects[1].value || 'Non spécifié';
            }
            
            text += `${qty}x ${name} - Brochage: ${brochage} - Tension: ${tension}\n`;
        }
    });
    text += '\n';
    
    // ===== PROTECTIONS =====
    const protTete = document.querySelectorAll('input[name="protTete"]:checked');
    const protPrises = document.querySelectorAll('input[name="protPrises"]:checked');
    
    text += '--- PROTECTIONS ---\n';
    
    if (protTete.length > 0) {
        const values = Array.from(protTete).map(function(cb) {
            return cb.value;
        }).join(', ');
        text += `Protection de tête: ${values}\n`;
    } else {
        text += 'Protection de tête: Non spécifié\n';
    }
    
    if (protPrises.length > 0) {
        const values = Array.from(protPrises).map(function(cb) {
            return cb.value;
        }).join(', ');
        text += `Protection des prises: ${values}\n`;
    } else {
        text += 'Protection des prises: Non spécifié\n';
    }
    text += '\n';
    
    // ===== OBSERVATIONS =====
    const observations = document.getElementById('observations').value || '';
    text += '--- OBSERVATIONS ---\n';
    text += observations || 'Aucune observation';
    
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
    // navigator.clipboard.writeText() est une "Promise" (opération asynchrone)
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
    const sujet = `Demande de devis Coffret Événementiel - ${affaire}`;
    
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
document.querySelectorAll('input[type="text"], input[type="email"], textarea').forEach(function(input) {
    // 'input' = événement déclenché à chaque frappe de touche
    input.addEventListener('input', updateSummary);
});

// Écoute les changements sur les quantités
document.querySelectorAll('.qty-input').forEach(function(input) {
    input.addEventListener('change', updateSummary);
});

// Écoute les changements sur les checkboxes
document.querySelectorAll('input[type="checkbox"]').forEach(function(cb) {
    cb.addEventListener('change', updateSummary);
});

// Écoute les changements sur les listes déroulantes
document.querySelectorAll('.detail-select').forEach(function(select) {
    select.addEventListener('change', updateSummary);
});


/* =====================================================
   FIN DU FICHIER
   
   Résumé des fonctions principales :
   
   1. toggleSection() - Ouvre/ferme les sections
   2. selectCard() - Sélectionne une carte (montage/matériaux)
   3. selectToggle() - Sélectionne un toggle (IP)
   4. step() - Modifie les quantités (+/-)
   5. updateSummary() - Met à jour le résumé
   6. resetForm() - Efface le formulaire
   7. generateText() - Génère le texte du devis
   8. copierTexte() - Copie dans le presse-papier
   9. generateMailto() - Envoie par email
===================================================== */