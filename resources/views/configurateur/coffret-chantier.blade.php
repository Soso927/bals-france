{{-- 
=============================================================================
VUE BLADE : COFFRET DE CHANTIER
=============================================================================

EXPLICATION SIMPLE :
Ce fichier affiche le formulaire pour configurer un coffret de chantier.
Il hérite du layout.blade.php qui contient déjà :
- Le lien CSS (pas besoin de le répéter ici)
- La colonne résumé
- Les boutons d'action

FICHIER À PLACER DANS : resources/views/configurateur/coffret-chantier.blade.php
============================================================================= 
--}}

{{-- 
    @extends = On hérite du fichier layout.blade.php
    Notre contenu sera injecté dans le @yield('contenu') du layout
--}}
@extends('configurateur.layout')

{{-- 
    TITRE DE LA PAGE
    Affiché dans l'onglet du navigateur
    $titre vient du contrôleur, sinon on utilise la valeur par défaut
--}}
@section('titre', $titre ?? 'Coffret de Chantier')

{{-- =========================================================================
     CONTENU PRINCIPAL DE LA PAGE
     Cette section sera injectée dans @yield('contenu') du layout
========================================================================= --}}
@section('contenu')

    {{-- =====================================================================
         CONTENEUR PRINCIPAL : 2 COLONNES
         Colonne gauche = Formulaire
         Colonne droite = Résumé (déjà dans le layout)
    ===================================================================== --}}
    <div class="app-container">

        {{-- =================================================================
             COLONNE GAUCHE : FORMULAIRE
             Contient toutes les sections du formulaire de devis
        ================================================================= --}}
        <div class="form-column">
            <div class="form-wrapper">

                {{-- =========================================================
                     EN-TÊTE : Logo et titre
                ========================================================= --}}
                <div class="header-section">
                    
                    {{-- Logo BALS en SVG (image vectorielle) --}}
                    <div class="logo-container">
                        <svg width="120" height="40" viewBox="0 0 300 100" xmlns="http://www.w3.org/2000/svg">
                            {{-- Icône de prise : 3 rectangles bleus + 2 rectangles rouges --}}
                            <rect x="20" y="20" width="50" height="15" fill="#0095DA" />
                            <rect x="35" y="37" width="50" height="15" fill="#ED1C24" />
                            <rect x="20" y="54" width="50" height="15" fill="#0095DA" />
                            <rect x="35" y="71" width="50" height="15" fill="#ED1C24" />
                            <rect x="20" y="88" width="50" height="15" fill="#0095DA" />
                            {{-- Texte "Bals" --}}
                            <text x="100" y="75" font-family="Arial, sans-serif" font-size="60" font-weight="bold" fill="#0095DA">Bals</text>
                        </svg>
                    </div>
                    
                    <h1>Configurateur de Devis</h1>

                    {{-- 
                        Titre dynamique : $titre vient du contrôleur
                        ?? = opérateur "null coalescing" (si null, utilise la valeur après)
                    --}}
                    <p class="subtitle">{{ $titre ?? 'Coffret de Chantier BALS' }}</p>

                    {{-- 
                        Affiche la référence SI elle existe
                        @if vérifie la condition, @endif ferme le bloc
                    --}}
                    @if (isset($reference))
                        <p class="subtitle">Référence : {{ $reference }}</p>
                    @endif

                    <div class="header-divider"></div>
                </div>

                {{-- =========================================================
                     MENU DE NAVIGATION
                     Liens vers les autres types de coffrets
                ========================================================= --}}
                <div class="nav-menu">
                    <p class="nav-title">Type de coffret</p>
                    <div class="nav-links">

                        {{-- 
                            EXPLICATION IMPORTANTE :
                            
                            route('configurateur.chantier') 
                            → Génère l'URL : /configurateur/coffret-chantier
                            
                            request()->routeIs('configurateur.chantier')
                            → Vérifie si on est sur cette route
                            → Si oui, ajoute la classe 'active' pour styliser le lien
                        --}}
                        
                        {{-- Lien Coffret Chantier (page actuelle) --}}
                        <a href="{{ route('configurateur.chantier') }}"
                            class="nav-link {{ request()->routeIs('configurateur.chantier') ? 'active' : '' }}">
                            Coffret Chantier
                        </a>

                        {{-- Lien Coffret d'Étage --}}
                        <a href="{{ route('configurateur.etage') }}"
                            class="nav-link {{ request()->routeIs('configurateur.etage') ? 'active' : '' }}">
                            Coffret d'Étage
                        </a>

                        {{-- Lien Coffret Industrie --}}
                        <a href="{{ route('configurateur.industrie') }}"
                            class="nav-link {{ request()->routeIs('configurateur.industrie') ? 'active' : '' }}">
                            Coffret Industrie
                        </a>

                        {{-- Lien Coffret Événementiel --}}
                        <a href="{{ route('configurateur.evenementiel') }}"
                            class="nav-link {{ request()->routeIs('configurateur.evenementiel') ? 'active' : '' }}">
                            Coffret Événementiel
                        </a>

                        {{-- Lien Prise Industrielle --}}
                        <a href="{{ route('configurateur.prise') }}"
                            class="nav-link {{ request()->routeIs('configurateur.prise') ? 'active' : '' }}">
                            Prise industrielle
                        </a>
                    </div>
                </div>

                {{-- =========================================================
                     BARRE DE PROGRESSION
                     Mise à jour automatiquement par JavaScript
                ========================================================= --}}
                <div class="progress-container">
                    <div class="progress-label">Progression du devis (0%)</div>
                    <div class="progress-bar-wrapper">
                        <div class="progress-bar" id="progressBar"></div>
                    </div>
                </div>

                {{-- =========================================================
                     SECTION 1 : INFORMATIONS DE CONTACT
                     Données du distributeur et installateur
                ========================================================= --}}
                <div class="section-card">
                    {{-- En-tête de section (cliquable pour plier/déplier) --}}
                    <div class="section-header" onclick="toggleSection(this)">
                        <div class="section-title">
                            <span class="section-number">01</span>
                            <h2>Informations de Contact</h2>
                        </div>
                        <span class="section-toggle">▼</span>
                    </div>
                    
                    {{-- Contenu de la section --}}
                    <div class="section-content">
                        {{-- Champ : Société --}}
                        <div class="form-group">
                            <label>Société</label>
                            <input type="text" id="distributeur" class="input-field" placeholder="Nom de la société">
                        </div>
                        
                        {{-- Champ : Contact --}}
                        <div class="form-group">
                            <label>Contact de la Société</label>
                            <input type="text" id="contactDist" class="input-field" placeholder="Nom du contact">
                        </div>
                        
                        {{-- Champ : Installateur --}}
                        <div class="form-group">
                            <label>Installateur</label>
                            <input type="text" id="installateur" class="input-field" placeholder="Nom de l'installateur">
                        </div>
                        
                        {{-- Champ : Référence affaire --}}
                        <div class="form-group">
                            <label>Référence Affaire</label>
                            <input type="text" id="affaire" class="input-field" placeholder="Numéro ou nom du projet">
                        </div>
                        
                        {{-- Champ : Téléphone --}}
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="tel" id="telephone" class="input-field" placeholder="01 23 45 67 89">
                        </div>
                        
                        {{-- Champ : Email --}}
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="email" class="input-field" placeholder="exemple@email.com">
                        </div>
                    </div>
                </div>

                {{-- =========================================================
                     SECTION 2 : TYPE DE COFFRET
                     Mobilité, Matériau, Indice de protection
                ========================================================= --}}
                <div class="section-card">
                    <div class="section-header" onclick="toggleSection(this)">
                        <div class="section-title">
                            <span class="section-number">02</span>
                            <h2>Type de Coffret</h2>
                        </div>
                        <span class="section-toggle">▼</span>
                    </div>
                    <div class="section-content">
                        
                        {{-- Sous-section : Mobilité --}}
                        <div class="sub-section">
                            <h3 class="sub-title">Mobilité</h3>
                            <div class="checkbox-group">
                                {{-- 
                                    EXPLICATION DES CHECKBOX :
                                    - name="mobilite" = groupe de checkboxes
                                    - value="Fixe" = valeur envoyée si cochée
                                    - checked = cochée par défaut
                                --}}
                                <label class="checkbox-card">
                                    <input type="checkbox" name="mobilite" value="Fixe">
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☐</span>
                                        <span class="checkbox-label">Fixe</span>
                                    </div>
                                </label>
                                <label class="checkbox-card">
                                    <input type="checkbox" name="mobilite" value="Mobile" checked>
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☑</span>
                                        <span class="checkbox-label">Mobile</span>
                                    </div>
                                </label>
                                <label class="checkbox-card">
                                    <input type="checkbox" name="mobilite" value="Mobile sur pied">
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☐</span>
                                        <span class="checkbox-label">Mobile sur pied</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Sous-section : Matériau --}}
                        <div class="sub-section">
                            <h3 class="sub-title">Matériau</h3>
                            <div class="checkbox-group">
                                <label class="checkbox-card">
                                    <input type="checkbox" name="materiau" value="Caoutchouc">
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☐</span>
                                        <span class="checkbox-label">Caoutchouc</span>
                                    </div>
                                </label>
                                <label class="checkbox-card">
                                    <input type="checkbox" name="materiau" value="Métallique">
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☐</span>
                                        <span class="checkbox-label">Métallique</span>
                                    </div>
                                </label>
                                <label class="checkbox-card">
                                    <input type="checkbox" name="materiau" value="Plastique" checked>
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☑</span>
                                        <span class="checkbox-label">Plastique</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Sous-section : Indice de Protection (IP) --}}
                        <div class="sub-section">
                            <h3 class="sub-title">Indice de Protection</h3>
                            <div class="checkbox-group">
                                <label class="checkbox-card">
                                    <input type="checkbox" name="indiceIP" value="IP44" checked>
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☑</span>
                                        <span class="checkbox-label">IP44</span>
                                    </div>
                                </label>
                                <label class="checkbox-card">
                                    <input type="checkbox" name="indiceIP" value="IP54">
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☐</span>
                                        <span class="checkbox-label">IP54</span>
                                    </div>
                                </label>
                                <label class="checkbox-card">
                                    <input type="checkbox" name="indiceIP" value="IP67">
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☐</span>
                                        <span class="checkbox-label">IP67</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- =========================================================
                     SECTION 3 : CONFIGURATION DES PRISES
                     Tableau avec les types de prises et quantités
                ========================================================= --}}
                <div class="section-card">
                    <div class="section-header" onclick="toggleSection(this)">
                        <div class="section-title">
                            <span class="section-number">03</span>
                            <h2>Configuration des Prises</h2>
                        </div>
                        <span class="section-toggle">▼</span>
                    </div>
                    <div class="section-content">
                        
                        {{-- Tableau des prises --}}
                        <div class="prises-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>NF 10/16A</th>
                                        <th>CEI 16A</th>
                                        <th>CEI 32A</th>
                                        <th>CEI 63A</th>
                                        <th>CEI 125A</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Ligne : Quantité --}}
                                    <tr>
                                        <td>Quantité</td>
                                        <td><input type="number" id="qteNF" min="0" value="2" class="table-input"></td>
                                        <td><input type="number" id="qte16A" min="0" value="0" class="table-input"></td>
                                        <td><input type="number" id="qte32A" min="0" value="4" class="table-input"></td>
                                        <td><input type="number" id="qte63A" min="0" value="0" class="table-input"></td>
                                        <td><input type="number" id="qte125A" min="0" value="0" class="table-input"></td>
                                    </tr>
                                    {{-- Ligne : Brochage --}}
                                    <tr>
                                        <td>Brochage</td>
                                        <td>
                                            <select id="brochageNF" class="table-select">
                                                <option value="">-</option>
                                                <option value="2P">2P</option>
                                                <option value="2P+T" selected>2P+T</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="brochage16A" class="table-select">
                                                <option value="">-</option>
                                                <option value="3P+T">3P+T</option>
                                                <option value="3P+N+T">3P+N+T</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="brochage32A" class="table-select">
                                                <option value="">-</option>
                                                <option value="3P+T">3P+T</option>
                                                <option value="3P+N+T" selected>3P+N+T</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="brochage63A" class="table-select">
                                                <option value="">-</option>
                                                <option value="3P+T">3P+T</option>
                                                <option value="3P+N+T">3P+N+T</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="brochage125A" class="table-select">
                                                <option value="">-</option>
                                                <option value="3P+T">3P+T</option>
                                                <option value="3P+N+T">3P+N+T</option>
                                            </select>
                                        </td>
                                    </tr>
                                    {{-- Ligne : Tension --}}
                                    <tr>
                                        <td>Tension</td>
                                        <td>230V</td>
                                        <td>400V</td>
                                        <td>400V</td>
                                        <td>400V</td>
                                        <td>400V</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Zone pour autres départs personnalisés --}}
                        <div class="form-group">
                            <label>Autres départs (optionnel)</label>
                            <textarea id="autresDeparts" class="input-field" rows="2" 
                                placeholder="Ex: 1x prise USB, 1x interrupteur..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- =========================================================
                     SECTION 4 : PROTECTIONS ÉLECTRIQUES
                     Protection de tête et protection des prises
                ========================================================= --}}
                <div class="section-card">
                    <div class="section-header" onclick="toggleSection(this)">
                        <div class="section-title">
                            <span class="section-number">04</span>
                            <h2>Protections</h2>
                        </div>
                        <span class="section-toggle">▼</span>
                    </div>
                    <div class="section-content">
                        
                        {{-- Sous-section : Protection de tête --}}
                        <div class="sub-section">
                            <h3 class="sub-title">Protection de tête</h3>
                            <div class="checkbox-group">
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
                                    <input type="checkbox" name="protTete" value="Inter différentiel" checked>
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☑</span>
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
                                    <input type="checkbox" name="protTete" value="Disjoncteur Diff.">
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☐</span>
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

                        {{-- Sous-section : Protection des prises --}}
                        <div class="sub-section">
                            <h3 class="sub-title">Protection des prises</h3>
                            <div class="checkbox-group">
                                <label class="checkbox-card">
                                    <input type="checkbox" name="protPrises" value="Sans">
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☐</span>
                                        <span class="checkbox-label">Sans</span>
                                    </div>
                                </label>
                                <label class="checkbox-card">
                                    <input type="checkbox" name="protPrises" value="Par prise" checked>
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☑</span>
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
                                    <input type="checkbox" name="protPrises" value="Disjoncteur Diff.">
                                    <div class="checkbox-content">
                                        <span class="checkbox-icon">☐</span>
                                        <span class="checkbox-label">Disjoncteur Diff.</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- =========================================================
                     SECTION 5 : OBSERVATIONS
                     Zone de texte libre pour remarques
                ========================================================= --}}
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

        {{-- =================================================================
             COLONNE DROITE : RÉSUMÉ
             Cette partie est gérée par le layout.blade.php
             Elle est automatiquement incluse grâce à @extends
        ================================================================= --}}

    </div>

@endsection

{{-- =========================================================================
     SCRIPTS JAVASCRIPT
     On charge les scripts nécessaires pour cette page
========================================================================= --}}
@section('scripts')
    {{-- 
        Script pour gérer l'exclusivité des protections
        (si on coche "Sans", les autres se décochent)
    --}}
    <script src="{{ asset('configurateur/js/protection-exclusivite.js') }}"></script>

    {{-- 
        Script spécifique au coffret de chantier
        Gère : mise à jour du résumé, progression, envoi email
    --}}
    <script src="{{ asset('configurateur/js/script-chantier.js') }}"></script>
@endsection

{{-- 
=============================================================================
NOTES POUR LE JURY
=============================================================================

STRUCTURE DU FICHIER :
----------------------
1. @extends → Hérite du layout (contient déjà le CSS)
2. @section('titre') → Définit le titre de la page
3. @section('contenu') → Contenu du formulaire
4. @section('scripts') → Scripts JavaScript

POURQUOI LE CSS N'EST PAS ICI :
-------------------------------
Le CSS est dans layout.blade.php (ligne 12)
Toutes les pages qui @extends le layout ont automatiquement le CSS
= Pas de duplication = Code plus propre

AVANTAGES DE BLADE :
--------------------
✓ {{ $variable }} = Affichage sécurisé (protection XSS)
✓ @if/@endif = Conditions simples
✓ @extends/@section = Héritage de templates
✓ route() = URLs automatiques
✓ asset() = Chemins vers fichiers publics
============================================================================= 
--}}