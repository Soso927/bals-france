// ============================================================
// CONFIGURATEUR BALS - JAVASCRIPT CONSOLIDÉ
// Fichier unique pour gérer tous les types de coffrets
// Version Laravel + Tailwind
// ============================================================

/**
 * Classe principale du configurateur
 * Gère l'état et toutes les interactions du formulaire
 */
class ConfigurateurBALS {
    constructor(typeConfigurator = 'chantier') {
        // Type de configurateur (chantier, etage, industrie, evenementiel, prise-industrielle)
        this.type = typeConfigurator;
        
        // État de l'application
        this.state = {
            distributeur: '',
            contactDist: '',
            installateur: '',
            affaire: '',
            email: '',
            type: '',
            materiau: '',
            ip: '',
            protections: {
                tete: [],
                prises: []
            },
            sockets: [],
            observations: ''
        };
        
        // Initialisation
        this.init();
    }

    /**
     * Initialisation du configurateur
     */
    init() {
        this.bindEvents();
        this.initializeProtectionExclusivity();
        this.updateProgress();
    }

    /**
     * Liaison des événements
     */
    bindEvents() {
        // Événements de saisie
        this.bindInputEvents();
        
        // Événements de sélection de cartes
        this.bindCardSelectionEvents();
        
        // Événements des checkboxes
        this.bindCheckboxEvents();
        
        // Événements de génération de devis
        this.bindQuoteGenerationEvents();
    }

    /**
     * Liaison des événements de saisie de texte
     */
    bindInputEvents() {
        const inputs = ['distributeur', 'contactDist', 'installateur', 'affaire', 'email', 'observations'];
        
        inputs.forEach(inputId => {
            const element = document.getElementById(inputId);
            if (element) {
                element.addEventListener('input', (e) => {
                    this.state[inputId] = e.target.value;
                    this.updateProgress();
                });
            }
        });
    }

    /**
     * Liaison des événements de sélection de cartes
     */
    bindCardSelectionEvents() {
        // Cartes de type
        document.querySelectorAll('.selection-grid input[name="type"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                this.selectCard(e.target.closest('label'), 'type');
            });
        });

        // Cartes de matériau
        document.querySelectorAll('.selection-grid input[name="mat"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                this.selectCard(e.target.closest('label'), 'mat');
            });
        });

        // Cartes IP
        document.querySelectorAll('.ip-grid input[name="ip"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                this.selectIPCard(e.target.closest('label'));
            });
        });
    }

    /**
     * Liaison des événements des checkboxes
     */
    bindCheckboxEvents() {
        // Protections de tête
        document.querySelectorAll('input[name="protTete"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                this.toggleCheckbox(e.target.closest('.checkbox-card'));
                this.updateProtectionState('tete');
            });
        });

        // Protections de prises
        document.querySelectorAll('input[name="protPrises"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                this.toggleCheckbox(e.target.closest('.checkbox-card'));
                this.updateProtectionState('prises');
            });
        });
    }

    /**
     * Liaison des événements de génération de devis
     */
    bindQuoteGenerationEvents() {
        const pdfBtn = document.getElementById('genererPDF');
        const excelBtn = document.getElementById('genererExcel');

        if (pdfBtn) {
            pdfBtn.addEventListener('click', () => this.generatePDF());
        }

        if (excelBtn) {
            excelBtn.addEventListener('click', () => this.generateExcel());
        }
    }

    /**
     * Toggle des sections accordéon
     */
    toggleSection(header) {
        const content = header.nextElementSibling;
        const icon = header.querySelector('.section-toggle');
        
        if (content.classList.contains('collapsed')) {
            content.classList.remove('collapsed');
            if (icon) icon.style.transform = 'rotate(180deg)';
        } else {
            content.classList.add('collapsed');
            if (icon) icon.style.transform = 'rotate(0deg)';
        }
    }

    /**
     * Sélection d'une carte (type ou matériau)
     */
    selectCard(label, category) {
        const container = label.closest('.selection-grid');
        const allCards = container.querySelectorAll('label');
        
        allCards.forEach(card => card.classList.remove('active'));
        label.classList.add('active');
        
        const radio = label.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
            
            if (category === 'type') {
                this.state.type = radio.value;
            } else if (category === 'mat') {
                this.state.materiau = radio.value;
            }
            
            this.updateProgress();
        }
    }

    /**
     * Sélection d'une carte IP
     */
    selectIPCard(label) {
        const container = label.closest('.ip-grid');
        const allCards = container.querySelectorAll('label');
        
        allCards.forEach(card => card.classList.remove('active'));
        label.classList.add('active');
        
        const radio = label.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
            this.state.ip = radio.value;
            this.updateProgress();
        }
    }

    /**
     * Toggle d'une checkbox
     */
    toggleCheckbox(card) {
        const checkbox = card.querySelector('input[type="checkbox"]');
        const icon = card.querySelector('.checkbox-icon');
        
        if (checkbox.checked) {
            card.classList.add('active');
            if (icon) icon.textContent = '✓';
        } else {
            card.classList.remove('active');
            if (icon) icon.textContent = '☐';
        }
    }

    /**
     * Mise à jour de l'état des protections
     */
    updateProtectionState(type) {
        const name = type === 'tete' ? 'protTete' : 'protPrises';
        const checkboxes = document.querySelectorAll(`input[name="${name}"]:checked`);
        
        this.state.protections[type] = Array.from(checkboxes).map(cb => cb.value);
        this.updateProgress();
    }

    /**
     * Calcul de la progression
     */
    calculateProgress() {
        let completed = 0;
        let total = 0;
        
        // Informations de contact (5 champs)
        const contactFields = ['distributeur', 'contactDist', 'installateur', 'affaire', 'email'];
        contactFields.forEach(field => {
            total++;
            if (this.state[field] && this.state[field].trim()) completed++;
        });
        
        // Caractéristiques techniques (3 champs)
        total += 3;
        if (this.state.type) completed++;
        if (this.state.materiau) completed++;
        if (this.state.ip) completed++;
        
        // Protections (2 groupes)
        total += 2;
        if (this.state.protections.tete.length > 0) completed++;
        if (this.state.protections.prises.length > 0) completed++;
        
        // Prises (au moins une)
        total++;
        if (this.state.sockets.length > 0) completed++;
        
        return Math.round((completed / total) * 100);
    }

    /**
     * Mise à jour de la barre de progression
     */
    updateProgress() {
        const percentage = this.calculateProgress();
        const progressBar = document.getElementById('progressBar');
        const progressLabel = document.querySelector('.progress-label');
        
        if (progressBar) {
            progressBar.style.width = percentage + '%';
        }
        
        if (progressLabel) {
            progressLabel.textContent = `Progression du devis (${percentage}%)`;
        }
    }

    /**
     * Ajout d'une prise
     */
    addSocket(socketType, socketName, amperage, phases) {
        const quantity = parseInt(document.getElementById(`qty-${socketType}`)?.value || 1);
        
        if (quantity > 0) {
            const existingIndex = this.state.sockets.findIndex(s => s.type === socketType);
            
            if (existingIndex >= 0) {
                this.state.sockets[existingIndex].quantity = quantity;
            } else {
                this.state.sockets.push({
                    type: socketType,
                    name: socketName,
                    amperage: amperage,
                    phases: phases,
                    quantity: quantity
                });
            }
            
            this.updateSelectedSockets();
            this.updateProgress();
        }
    }

    /**
     * Suppression d'une prise
     */
    removeSocket(socketType) {
        this.state.sockets = this.state.sockets.filter(s => s.type !== socketType);
        
        const qtyInput = document.getElementById(`qty-${socketType}`);
        if (qtyInput) qtyInput.value = 0;
        
        this.updateSelectedSockets();
        this.updateProgress();
    }

    /**
     * Mise à jour de l'affichage des prises sélectionnées
     */
    updateSelectedSockets() {
        const container = document.getElementById('selectedSockets');
        if (!container) return;
        
        if (this.state.sockets.length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-500 italic">Aucune prise sélectionnée</p>';
            return;
        }
        
        container.innerHTML = this.state.sockets.map(socket => `
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex-1">
                    <p class="font-medium text-gray-900">${socket.name}</p>
                    <p class="text-sm text-gray-500">${socket.amperage} - ${socket.phases}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        Qté: ${socket.quantity}
                    </span>
                    <button onclick="configurateur.removeSocket('${socket.type}')" 
                            class="text-red-600 hover:text-red-800 font-medium">
                        ✕
                    </button>
                </div>
            </div>
        `).join('');
    }

    /**
     * Génération du PDF
     */
    async generatePDF() {
        try {
            const response = await fetch('/api/generate-quote/pdf', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    type: this.type,
                    data: this.state
                })
            });

            if (!response.ok) throw new Error('Erreur lors de la génération du PDF');

            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `devis-bals-${Date.now()}.pdf`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            this.showNotification('PDF généré avec succès !', 'success');
        } catch (error) {
            console.error('Erreur:', error);
            this.showNotification('Erreur lors de la génération du PDF', 'error');
        }
    }

    /**
     * Génération du fichier Excel
     */
    async generateExcel() {
        try {
            const response = await fetch('/api/generate-quote/excel', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    type: this.type,
                    data: this.state
                })
            });

            if (!response.ok) throw new Error('Erreur lors de la génération du fichier Excel');

            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `devis-bals-${Date.now()}.xlsx`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            this.showNotification('Fichier Excel généré avec succès !', 'success');
        } catch (error) {
            console.error('Erreur:', error);
            this.showNotification('Erreur lors de la génération du fichier Excel', 'error');
        }
    }

    /**
     * Affichage d'une notification
     */
    showNotification(message, type = 'info') {
        // Vous pouvez utiliser une bibliothèque comme Toastr ou créer votre propre système
        alert(message); // Temporaire - à remplacer par un vrai système de notification
    }

    // ============================================================
    // GESTION DE L'EXCLUSIVITÉ DES PROTECTIONS
    // ============================================================

    /**
     * Initialisation de l'exclusivité des protections
     */
    initializeProtectionExclusivity() {
        // Protection de Tête
        document.querySelectorAll('input[name="protTete"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                this.handleProtectionTete(e.target);
            });
        });

        // Protection des Prises
        document.querySelectorAll('input[name="protPrises"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                this.handleProtectionPrises(e.target);
            });
        });
    }

    /**
     * Gestion de l'exclusivité pour Protection de Tête
     */
    handleProtectionTete(checkbox) {
        const value = checkbox.value;
        const isChecked = checkbox.checked;

        // Règle 1: Interrupteur ↔ Inter différentiel
        if (value === 'Interrupteur') {
            this.greyOutOption('protTete', 'Inter différentiel', isChecked);
        }
        if (value === 'Inter différentiel') {
            this.greyOutOption('protTete', 'Interrupteur', isChecked);
        }

        // Règle 2: Disjoncteur ↔ Disjoncteur Diff.
        if (value === 'Disjoncteur') {
            this.greyOutOption('protTete', 'Disjoncteur Diff.', isChecked);
        }
        if (value === 'Disjoncteur Diff.') {
            this.greyOutOption('protTete', 'Disjoncteur', isChecked);
        }
    }

    /**
     * Gestion de l'exclusivité pour Protection des Prises
     */
    handleProtectionPrises(checkbox) {
        const value = checkbox.value;
        const isChecked = checkbox.checked;

        // Règle 1: Par prise ↔ Par groupe
        if (value === 'Par prise') {
            this.greyOutOption('protPrises', 'Par groupe', isChecked);
        }
        if (value === 'Par groupe') {
            this.greyOutOption('protPrises', 'Par prise', isChecked);
        }

        // Règle 2: Disjoncteur ↔ Disjoncteur Diff.
        if (value === 'Disjoncteur') {
            this.greyOutOption('protPrises', 'Disjoncteur Diff.', isChecked);
        }
        if (value === 'Disjoncteur Diff.') {
            this.greyOutOption('protPrises', 'Disjoncteur', isChecked);
        }
    }

    /**
     * Griser ou dégriser une option
     */
    greyOutOption(groupName, value, shouldGrey) {
        const checkboxes = document.querySelectorAll(`input[name="${groupName}"]`);
        
        checkboxes.forEach(checkbox => {
            if (checkbox.value === value) {
                const card = checkbox.closest('.checkbox-card');
                const icon = card?.querySelector('.checkbox-icon');
                
                if (shouldGrey) {
                    // Griser
                    checkbox.disabled = true;
                    checkbox.checked = false;
                    
                    if (card) {
                        card.style.opacity = '0.4';
                        card.style.cursor = 'not-allowed';
                        card.style.pointerEvents = 'none';
                        card.classList.remove('active');
                        
                        if (icon) icon.textContent = '☐';
                    }
                } else {
                    // Dégriser
                    checkbox.disabled = false;
                    
                    if (card) {
                        card.style.opacity = '1';
                        card.style.cursor = 'pointer';
                        card.style.pointerEvents = '';
                    }
                }
            }
        });
    }
}

// ============================================================
// INITIALISATION GLOBALE
// ============================================================

let configurateur;

document.addEventListener('DOMContentLoaded', function() {
    // Récupérer le type de configurateur depuis l'attribut data
    const appContainer = document.querySelector('[data-configurateur-type]');
    const type = appContainer?.dataset.configurateurType || 'chantier';
    
    // Initialiser le configurateur
    configurateur = new ConfigurateurBALS(type);
    
    // Exposer globalement pour les événements inline
    window.configurateur = configurateur;
    window.toggleSection = (header) => configurateur.toggleSection(header);
});

// Export pour utilisation en module (optionnel)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ConfigurateurBALS;
}