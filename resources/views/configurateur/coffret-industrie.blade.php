{{-- 
=============================================================================
VUE BLADE : COFFRET INDUSTRIE
=============================================================================

Ce fichier est la version Laravel de votre fichier coffret-industrie.html

FICHIER À PLACER DANS : resources/views/configurateur/coffret-industrie.blade.php

Code simple et bien commenté pour présentation au jury
============================================================================= 
--}}

@extends('configurateur.layout')

{{-- Titre de la page (affiché dans l'onglet du navigateur) --}}
@section('titre', $titre ?? 'Coffret Industrie')

{{-- Contenu principal de la page --}}
@section('contenu')

<!-- Conteneur principal : 2 colonnes (formulaire + résumé) -->
<div class="app-container">
    
    {{-- =========================================================================
         COLONNE GAUCHE : FORMULAIRE
         Contient toutes les sections du formulaire de devis
    ========================================================================= --}}
    <div class="form-column">
        <div class="form-wrapper">
            
            {{-- =================================================================
                 EN-TÊTE : Logo et titre
            ================================================================= --}}
            <div class="header-section">
                <!-- Logo BALS en SVG -->
                <div class="logo-container">
                    <svg width="120" height="40" viewBox="0 0 300 100" xmlns="http://www.w3.org/2000/svg">
                        <!-- Icône de prise (rectangles bleus et rouges) -->
                        <rect x="20" y="20" width="50" height="15" fill="#0095DA" />
                        <rect x="35" y="37" width="50" height="15" fill="#ED1C24" />
                        <rect x="20" y="54" width="50" height="15" fill="#0095DA" />
                        <rect x="35" y="71" width="50" height="15" fill="#ED1C24" />
                        <rect x="20" y="88" width="50" height="15" fill="#0095DA" />
                        <!-- Texte "Bals" -->
                        <text x="100" y="75" font-family="Arial, sans-serif" font-size="60" font-weight="bold" fill="#0095DA">Bals</text>
                    </svg>
                </div>
                <h1>Configurateur de Devis</h1>
                
                {{-- Sous-titre dynamique depuis le contrôleur --}}
                <p class="subtitle">{{ $titre ?? 'Coffret Industrie BALS' }}</p>
                
                {{-- Référence du produit depuis le contrôleur --}}
                @if(isset($reference))
                    <p class="subtitle">Référence : {{ $reference }}</p>
                @endif
                
                <div class="header-divider"></div>
            </div>

            {{-- =================================================================
                 MENU DE NAVIGATION
                 Utilise les routes Laravel pour générer les liens
            ================================================================= --}}
            <div class="nav-menu">
                <p class="nav-title">Type de coffret</p>
                <div class="nav-links">
                    
                    {{-- Lien vers coffret de chantier  --}}
                    <a href="{{ route('configurateur.chantier') }}" 
                       class="nav-link {{ request()->routeIs('configurateur.chantier') ? 'active' : '' }}">
                        Coffret Chantier
                    </a>
                    
                    {{-- Lien vers coffret d'étage (page actuelle) --}}
                    <a href="{{ route('configurateur.etage') }}" 
                       class="nav-link {{ request()->routeIs('configurateur.etage') ? 'active' : '' }}">
                        Coffret d'Étage
                    </a>
                    
                    {{-- Lien vers coffret industrie --}}
                    <a href="{{ route('configurateur.industrie') }}" 
                       class="nav-link {{ request()->routeIs('configurateur.industrie') ? 'active' : '' }}">
                        Coffret Industrie
                    </a>
                    
                    {{-- Lien vers coffret événementiel --}}
                    <a href="{{ route('configurateur.evenementiel') }}" 
                       class="nav-link {{ request()->routeIs('configurateur.evenementiel') ? 'active' : '' }}">
                        Coffret Événementiel
                    </a>
                    
                    {{-- Lien vers prise industrielle --}}
                    <a href="{{ route('configurateur.prise') }}" 
                       class="nav-link {{ request()->routeIs('configurateur.prise') ? 'active' : '' }}">
                        Prise industrielle
                    </a>
                </div>
            </div>

            {{-- =================================================================
                 EXPLICATION POUR LE JURY :
                 
                 request()->routeIs('configurateur.industrie')
                 → Vérifie si on est sur la route "configurateur.industrie"
                 → Si oui, ajoute la classe "active" pour styliser le lien
                 
                 {{ route('configurateur.macon') }}
                 → Génère automatiquement l'URL : /configurateur/coffret-macon
                 → Si l'URL change dans routes/web.php, elle se met à jour ici
            ================================================================= --}}

            {{-- =================================================================
                 BARRE DE PROGRESSION
                 Mise à jour par JavaScript
            ================================================================= --}}
            <div class="progress-container">
                <div class="progress-label">Progression du devis (0%)</div>
                <div class="progress-bar-wrapper">
                    <div class="progress-bar" id="progressBar"></div>
                </div>
            </div>

            {{-- =================================================================
                 SECTION 1 : INFORMATIONS DE CONTACT
            ================================================================= --}}
            <div class="section-card">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-title">
                        <span class="section-number">01</span>
                        <h2>Informations de Contact</h2>
                    </div>
                    <span class="section-toggle">▼</span>
                </div>
                <div class="section-content">
                    <!-- Société -->
                    <div class="form-group">
                        <label>Société</label>
                        <input type="text" id="distributeur" class="input-field" placeholder="Nom de la société">
                    </div>
                    <!-- Contact -->
                    <div class="form-group">
                        <label>Contact de la Société</label>
                        <input type="text" id="contactDist" class="input-field" placeholder="Nom du contact">
                    </div>
                    <!-- Installateur -->
                    <div class="form-group">
                        <label>Installateur</label>
                        <input type="text" id="installateur" class="input-field" placeholder="Nom de l'installateur">
                    </div>
                    <!-- Référence affaire -->
                    <div class="form-group">
                        <label>Référence Affaire</label>
                        <input type="text" id="affaire" class="input-field" placeholder="Référence du projet">
                    </div>
                    <!-- Téléphone -->
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="tel" id="telephone" class="input-field" placeholder="06 12 34 56 78">
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="email" class="input-field" placeholder="contact@exemple.fr">
                    </div>
                </div>
            </div>

            {{-- =================================================================
                 SECTION 2 : TYPE ET CARACTÉRISTIQUES
            ================================================================= --}}
            <div class="section-card">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-title">
                        <span class="section-number">02</span>
                        <h2>Type et Caractéristiques</h2>
                    </div>
                    <span class="section-toggle">▼</span>
                </div>
                <div class="section-content">
                    
                    <!-- TYPE DE COFFRET -->
                    <div class="form-group">
                        <label>Type de coffret *</label>
                        <p class="field-description">Choisissez le mode de fixation</p>
                        <div class="checkbox-grid">
                            <label class="checkbox-card">
                                <input type="checkbox" name="type" value="Fixe" checked>
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☑</span>
                                    <span class="checkbox-label">Fixe</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="type" value="Mobile sur pied">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Mobile sur pied</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="type" value="Mobile">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Mobile</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- MATÉRIAU -->
                    <div class="form-group">
                        <label>Matériau *</label>
                        <p class="field-description">Sélectionnez le matériau du boîtier</p>
                        <div class="checkbox-grid">
                            <label class="checkbox-card">
                                <input type="checkbox" name="materiau" value="Caoutchouc">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Caoutchouc</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="materiau" value="Métallique" checked>
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☑</span>
                                    <span class="checkbox-label">Métallique</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="materiau" value="Plastique">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Plastique</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- INDICE DE PROTECTION -->
                    <div class="form-group">
                        <label>Indice de protection *</label>
                        <p class="field-description">Niveau de protection contre l'eau et la poussière</p>
                        <div class="checkbox-grid">
                            <label class="checkbox-card">
                                <input type="checkbox" name="ip" value="IP44">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">IP44</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="ip" value="IP54">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">IP54</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="ip" value="IP67" checked>
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☑</span>
                                    <span class="checkbox-label">IP67</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                </div>
            </div>

            {{-- =================================================================
                 SECTION 3 : CONFIGURATION DES PRISES
            ================================================================= --}}
            <div class="section-card">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-title">
                        <span class="section-number">03</span>
                        <h2>Configuration des Prises</h2>
                    </div>
                    <span class="section-toggle">▼</span>
                </div>
                <div class="section-content">
                    <p class="field-description">Configurez le nombre et le type de prises</p>
                    
                    <!-- PRISES 10/16A -->
                    <div class="form-group">
                        <label>Prises NF 10/16A - 230V</label>
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn" onclick="decrementValue('qte_10_16A')">−</button>
                            <input type="number" id="qte_10_16A" value="2" min="0" max="20" class="qty-input" readonly>
                            <button type="button" class="qty-btn" onclick="incrementValue('qte_10_16A')">+</button>
                            <span class="qty-label">Brochage : 2P+T</span>
                        </div>
                    </div>

                    <!-- PRISES 16A -->
                    <div class="form-group">
                        <label>Prises NF 16A - 400V</label>
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn" onclick="decrementValue('qte_16A')">−</button>
                            <input type="number" id="qte_16A" value="3" min="0" max="20" class="qty-input" readonly>
                            <button type="button" class="qty-btn" onclick="incrementValue('qte_16A')">+</button>
                            <span class="qty-label">Brochage : 3P+N+T</span>
                        </div>
                    </div>

                    <!-- PRISES 32A -->
                    <div class="form-group">
                        <label>Prises NF 32A - 400V</label>
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn" onclick="decrementValue('qte_32A')">−</button>
                            <input type="number" id="qte_32A" value="2" min="0" max="20" class="qty-input" readonly>
                            <button type="button" class="qty-btn" onclick="incrementValue('qte_32A')">+</button>
                            <span class="qty-label">Brochage : 3P+N+T</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- =================================================================
                 SECTION 4 : PROTECTIONS
                 
                 IMPORTANT : Cette section utilise le système d'exclusivité
                 géré par protection-exclusivite.js
            ================================================================= --}}
            <div class="section-card">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-title">
                        <span class="section-number">04</span>
                        <h2>Protections</h2>
                    </div>
                    <span class="section-toggle">▼</span>
                </div>
                <div class="section-content">
                    
                    <!-- PROTECTION DE TÊTE -->
                    <div class="form-group">
                        <label>Protection de tête *</label>
                        <p class="field-description">Sélectionnez un ou plusieurs types de protection de tête</p>
                        <div class="checkbox-grid">
                            <label class="checkbox-card">
                                <input type="checkbox" name="protTete" value="Sans">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Sans</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="protTete" value="Interrupteur">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Interrupteur</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="protTete" value="Inter différentiel">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Inter différentiel</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="protTete" value="Disjoncteur" checked>
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☑</span>
                                    <span class="checkbox-label">Disjoncteur</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="protTete" value="Disjoncteur Diff." checked>
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☑</span>
                                    <span class="checkbox-label">Disjoncteur Diff.</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="protTete" value="Arrêt d'urgence">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Arrêt d'urgence</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- PROTECTION DES PRISES -->
                    <div class="form-group">
                        <label>Protection des prises *</label>
                        <p class="field-description">Sélectionnez un ou plusieurs types de protection des prises</p>
                        <div class="checkbox-grid">
                            <label class="checkbox-card">
                                <input type="checkbox" name="protPrises" value="Sans">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Sans</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="protPrises" value="Par prise">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Par prise</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="protPrises" value="Par groupe">
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☐</span>
                                    <span class="checkbox-label">Par groupe</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="protPrises" value="Disjoncteur" checked>
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☑</span>
                                    <span class="checkbox-label">Disjoncteur</span>
                                </div>
                            </label>
                            <label class="checkbox-card">
                                <input type="checkbox" name="protPrises" value="Disjoncteur Diff." checked>
                                <div class="checkbox-content">
                                    <span class="checkbox-icon">☑</span>
                                    <span class="checkbox-label">Disjoncteur Diff.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                </div>
            </div>

            {{-- =================================================================
                 SECTION 5 : OBSERVATIONS
            ================================================================= --}}
            <div class="section-card">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-title">
                        <span class="section-number">05</span>
                        <h2>Observations</h2>
                    </div>
                    <span class="section-toggle">▼</span>
                </div>
                <div class="section-content">
                    <div class="form-group">
                        <label>Remarques et besoins spécifiques</label>
                        <textarea id="observations" class="input-field" rows="6" 
                                  placeholder="Ajoutez vos remarques, besoins particuliers, contraintes techniques, délais..."></textarea>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    {{-- =========================================================================
         COLONNE DROITE : RÉSUMÉ EN TEMPS RÉEL
    ========================================================================= --}}
    <div class="summary-column">
        <div class="summary-sticky">
            <!-- Titre du résumé -->
            <div class="summary-header">
                <h3>Résumé de Configuration</h3>
                <p class="summary-subtitle">Devis en temps réel</p>
            </div>
            
            <!-- Contenu mis à jour par JavaScript -->
            <div class="summary-content" id="summaryList">
                <div class="empty-state">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15M9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.10457 15 5M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5M12 12H15M12 16H15M9 12H9.01M9 16H9.01"
                            stroke="rgba(255,255,255,0.3)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p>Configurez votre coffret</p>
                    <small>Les informations apparaîtront ici</small>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="summary-footer">
                <div class="summary-actions">
                    <!-- Bouton reset -->
                    <button type="button" class="btn btn-icon" onclick="resetForm()" title="Réinitialiser">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 7L5 21M5 7L19 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <!-- Bouton copier -->
                    <button type="button" class="btn btn-secondary" onclick="copierTexte()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 16H6C4.89543 16 4 15.1046 4 14V6C4 4.89543 4.89543 4 6 4H14C15.1046 4 16 4.89543 16 6V8M10 20H18C19.1046 20 20 19.1046 20 18V10C20 8.89543 19.1046 8 18 8H10C8.89543 8 8 8.89543 8 10V18C8 19.1046 8.89543 20 10 20Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Copier
                    </button>
                    <!-- Bouton envoyer -->
                    <button type="button" class="btn btn-primary" onclick="generateMailto()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 8L10.89 13.26C11.2187 13.4793 11.6049 13.5963 12 13.5963C12.3951 13.5963 12.7813 13.4793 13.11 13.26L21 8M5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Envoyer
                    </button>
                </div>
                <p class="summary-help">
                    Destination : <strong>info@bals-france.fr</strong>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- =============================================================================
     SCRIPTS JAVASCRIPT
     
     On charge les scripts nécessaires pour cette page :
     1. protection-exclusivite.js (commun à toutes les pages)
     2. script-industrie.js (spécifique à cette page)
============================================================================= --}}
@section('scripts')
    {{-- Script du système d'exclusivité des protections --}}
    <script src="{{ asset('configurateur/js/protection-exclusivite.js') }}"></script>
    
    {{-- Script spécifique au coffret industrie --}}
    <script src="{{ asset('configurateur/js/' . ($typeScript ?? 'script-industrie.js')) }}"></script>
@endsection

{{-- =============================================================================
     NOTES POUR LE JURY :
     
     STRUCTURE BLADE :
     
     @extends('configurateur.layout')
     → Cette vue hérite du template de base (layout.blade.php)
     
     @section('contenu')
     → On remplit la section "contenu" du layout
     
     {{ $titre }}
     → Affiche la variable $titre passée par le contrôleur
     
     {{ route('configurateur.macon') }}
     → Génère l'URL vers la route nommée "configurateur.macon"
     
     {{ asset('configurateur/js/script.js') }}
     → Génère le chemin vers le fichier : /configurateur/js/script.js
     
     AVANTAGES PAR RAPPORT AU HTML SIMPLE :
     
     ✓ Réutilisation du layout (pas de duplication)
     ✓ Variables dynamiques (titre, référence)
     ✓ Routes automatiques (changent avec routes/web.php)
     ✓ Sécurité Laravel (protection XSS, CSRF)
     ✓ Maintenance facilitée
============================================================================= --}}
