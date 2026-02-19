{{-- ============================================================ --}}
{{-- FICHIER : resources/views/configurateur/etage.blade.php      --}}
{{-- PRODUIT : COFFRET D'ÉTAGE BALS                                --}}
{{-- RÉFÉRENCE : 510_802 (configuration par défaut)                --}}
{{-- ============================================================ --}}
{{-- 
    ✅ SPÉCIFICITÉS COFFRET D'ÉTAGE (selon PDF) :
    
    📦 TYPE DE MONTAGE :
       - Mobile (par défaut) ⭐
       - Mobile sur pied
    
    🏗️ MATÉRIAUX :
       - Plastique uniquement (léger et adapté aux étages)
    
    🔌 CONFIGURATION DES PRISES PAR DÉFAUT :
       - 6x NF 10/16A (230V, 2P+T) - prises domestiques
       - 1x CEI 16A (400V, 3P+N+T) - prise industrielle
       - 1x CEI 32A (400V, 3P+N+T) - prise industrielle
    
    🛡️ PROTECTION DE TÊTE (par défaut) :
       - Inter différentiel ✓
       - Disjoncteur ✓
    
    🔒 PROTECTION DES PRISES (par défaut) :
       - Disjoncteur ✓
    
    📋 CHAMPS DE CONTACT :
       - Distributeur
       - Contact Distributeur
       - Installateur
       - Contact Installateur
       - Référence Affaire
       - Téléphone
       - Email
--}}

@extends('layouts.app')

{{-- Titre de l'onglet du navigateur --}}
@section('title', 'Configurateur - Coffret d\'Étage BALS')

{{-- ============================================================ --}}
{{-- SECTION CONTENT : contenu principal de la page              --}}
{{-- ============================================================ --}}
@section('content')

{{-- ============================================================ --}}
{{-- STRUCTURE : Layout en 2 colonnes                            --}}
{{--   ├── Colonne GAUCHE (flex-1) : Formulaire de configuration --}}
{{--   └── Colonne DROITE (w-80)   : Résumé sticky + Actions     --}}
{{-- ============================================================ --}}
<div class="relative flex min-h-screen gap-6 p-6 max-w-7xl mx-auto">

    <!-- Bouton Accueil en haut à gauche -->
    <a href="/" class="absolute left-6 top-6 z-50" title="Accueil">
        <i class="fa-solid fa-house" style="color: rgb(116, 192, 252); font-size: 2rem;"></i>
    </a>

    {{-- ========================================================== --}}
    {{-- 📝 COLONNE GAUCHE : Formulaire principal                   --}}
    {{-- ========================================================== --}}
    <div class="flex-1 flex flex-col gap-5">

        {{-- ====================================================== --}}
        {{-- 🎨 EN-TÊTE : Logo + Titre                              --}}
        {{-- ====================================================== --}}
        <div class="text-center py-4">

            {{-- Logo BALS (image depuis /public/images/) --}}
            <div class="flex justify-center mb-3">
                <img src="{{ asset('images/logo-bals.png') }}"
                     alt="Logo BALS"
                     class="h-10"
                     onerror="this.style.display='none'; document.getElementById('logo-fallback').style.display='flex'">

                {{-- ⚠️ Fallback : logo SVG si l'image n'existe pas --}}
                <div id="logo-fallback" class="items-center gap-2" style="display:none">
                    {{-- Icône SVG représentant les prises BALS --}}
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                        <rect x="0" y="2"  width="22" height="7" fill="#009EE3"/>
                        <rect x="12" y="11" width="24" height="7" fill="#DA291C"/>
                        <rect x="0" y="20" width="22" height="7" fill="#009EE3"/>
                        <rect x="12" y="29" width="24" height="7" fill="#DA291C"/>
                    </svg>
                    <span class="text-3xl font-black text-bals-blue ml-1">Bals</span>
                </div>
            </div>

            {{-- Titre principal --}}
            <h1 class="text-3xl font-black text-gray-800">Configurateur de Devis</h1>

            {{-- Sous-titre : type de produit --}}
            <p class="text-gray-400 font-medium mt-1">Coffret d'Étage BALS</p>

            {{-- Ligne décorative bleue --}}
            <div class="h-1 bg-bals-blue rounded-full mt-4 max-w-lg mx-auto"></div>
        </div>

        {{-- ====================================================== --}}
        {{-- 🎯 CARTE 1 : Sélection du TYPE DE COFFRET              --}}
        {{-- Navigation entre les différents configurateurs         --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

            {{-- Label de la section --}}
            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">
                Type de Coffret
            </p>

            {{-- Boutons de navigation --}}
            <div class="flex flex-wrap gap-3" id="type-coffret-buttons">
                {{-- Boutons de navigation par type de coffret --}}
                <a href="{{ route('configurateur.chantier') }}" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret Chantier">
                    Coffret Chantier
                </a>

                {{-- Bouton actif (page courante) --}}
                <a href="#" class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all cursor-default"
                   data-type="Coffret d'Étage">
                    Coffret d'Étage
                </a>

                
                <a href="{{ route('configurateur.industrie') }}" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret Industrie">
                    Coffret Industrie
                </a>

                
                <a href="{{ route('configurateur.evenementiel') }}" class="btn-type  px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white transition-all "
                   data-type="Coffret Événementiel">
                    Coffret Événementiel
                </a>

                <a href="{{ route('configurateur.prise-industrielle') }}" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Prise industrielle">
                    Prise industrielle
                </a>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- 📊 BARRE DE PROGRESSION DU DEVIS                       --}}
        {{-- Affiche visuellement le taux de complétion (0-100%)    --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl px-6 py-4 shadow-sm border border-gray-100">

            {{-- Texte avec pourcentage (mis à jour via JavaScript) --}}
            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2">
                Progression du Devis
                <span id="progression-texte" class="text-bals-blue">(0%)</span>
            </p>

            {{-- Barre de progression : fond gris + remplissage bleu --}}
            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                <div id="progression-barre"
                     class="h-full bg-bals-blue rounded-full transition-all duration-500"
                     style="width: 0%">
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- 📋 SECTION 01 : INFORMATIONS DE CONTACT                --}}
        {{-- Format accordéon : cliquable pour ouvrir/fermer        --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête de section (cliquable) --}}
            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s1')">
                <div class="flex items-center gap-3">
                    {{-- Numéro de section --}}
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                        01
                    </span>
                    <span class="font-bold text-lg">Informations de Contact</span>
                </div>
                {{-- Flèche d'accordéon --}}
                <span id="arrow-s1" class="text-white text-lg transition-transform duration-300">▲</span>
            </div>

            {{-- Contenu de la section (ouvert par défaut) --}}
            <div id="section-s1" class="p-6 flex flex-col gap-5">

                {{-- 
                    🔹 CHAMP : Distributeur
                    Nom de la société distributrice
                --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Distributeur</label>
                    <input type="text"
                           id="distributeur"
                           placeholder="Nom du distributeur"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- 
                    🔹 CHAMP : Contact Distributeur
                    Nom de la personne de contact chez le distributeur
                --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact Distributeur</label>
                    <input type="text"
                           id="contact_distributeur"
                           placeholder="Nom du contact"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- 
                    🔹 CHAMP : Installateur
                    Nom de la société qui va installer le coffret
                --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Installateur</label>
                    <input type="text"
                           id="installateur"
                           placeholder="Nom de l'installateur"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- 
                    🔹 CHAMP : Contact Installateur
                    Nom de la personne de contact chez l'installateur
                --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact Installateur</label>
                    <input type="text"
                           id="contact_installateur"
                           placeholder="Nom du contact"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- 
                    🔹 CHAMP : Référence Affaire
                    Numéro de dossier ou de projet
                --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Référence Affaire</label>
                    <input type="text"
                           id="affaire"
                           placeholder="Référence de l'affaire"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- 
                    🔹 CHAMP : Téléphone
                    Numéro de téléphone de contact
                --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Téléphone</label>
                    <input type="tel"
                           id="telephone"
                           placeholder="+33 1 23 45 67 89"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- 
                    🔹 CHAMP : Email
                    Adresse email de contact
                --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email"
                           id="email"
                           placeholder="contact@exemple.fr"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- ⚙️ SECTION 02 : CARACTÉRISTIQUES TECHNIQUES GÉNÉRALES --}}
        {{-- SPÉCIFICITÉ ÉTAGE : Mobile + Plastique uniquement     --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s2')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                        02
                    </span>
                    <span class="font-bold text-lg">Caractéristiques Techniques générales</span>
                </div>
                <span id="arrow-s2" class="text-white text-lg transition-transform duration-300">▲</span>
            </div>

            <div id="section-s2" class="p-6 flex flex-col gap-7">

                {{-- 
                    🔧 TYPE DE COFFRET D'ÉTAGE
                    Selon PDF : Mobile (par défaut) ou Mobile sur pied
                --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Type de coffret <span class="text-red-500">*</span>
                    </label>

                    {{-- Badge informatif sur la configuration d'étage --}}
                    <div class="bg-blue-50 border-l-4 border-bals-blue p-3 mb-3 rounded">
                        <p class="text-xs text-blue-800">
                            <strong>💡 Configuration Coffret d'Étage :</strong>
                            Mobile avec boîtier Plastique - Conçu pour une installation facile et rapide dans les étages.
                        </p>
                    </div>

                    {{-- 
                        Sélection du type de montage : 2 options radio
                        - Mobile (par défaut) ⭐
                        - Mobile sur pied
                    --}}
                    <div class="grid grid-cols-2 gap-3" id="type-montage">

                        {{-- Option 1 : Mobile (PAR DÉFAUT selon PDF) --}}
                        <label class="cursor-pointer">
                            <input type="radio" 
                                   name="montage" 
                                   value="Mobile" 
                                   class="sr-only peer" 
                                   onchange="mettreAJour()" 
                                   checked>
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                {{-- Icône Mobile --}}
                                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <rect x="2" y="4" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <circle cx="7" cy="20" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="17" cy="20" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                                    <line x1="4" y1="11" x2="20" y2="11" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                <span class="font-bold text-sm text-gray-700">Mobile</span>
                                <span class="block text-xs text-bals-blue mt-1">Recommandé</span>
                            </div>
                        </label>

                        {{-- Option 2 : Mobile sur pied --}}
                        <label class="cursor-pointer">
                            <input type="radio" 
                                   name="montage" 
                                   value="Mobile sur pied" 
                                   class="sr-only peer" 
                                   onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                {{-- Icône Mobile sur pied --}}
                                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <rect x="4" y="2" width="16" height="12" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <line x1="12" y1="14" x2="12" y2="20" stroke="currentColor" stroke-width="1.5"/>
                                    <line x1="8" y1="20" x2="16" y2="20" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                <span class="font-bold text-sm text-gray-700">Mobile sur pied</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- 
                    🏗️ MATÉRIAUX
                    SPÉCIFICITÉ COFFRET D'ÉTAGE : Plastique UNIQUEMENT (selon PDF)
                    Plus léger que le métal, adapté aux étages
                --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Matériaux <span class="text-red-500">*</span>
                    </label>

                    {{-- 
                        Une seule option : Plastique
                        C'est le matériau standard pour coffrets d'étage
                    --}}
                    <div class="grid grid-cols-1 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" 
                                   name="materiau" 
                                   value="Plastique" 
                                   class="sr-only peer" 
                                   onchange="mettreAJour()" 
                                   checked>
                            <div class="border-2 border-bals-blue bg-blue-50 rounded-xl p-4 text-center transition-all cursor-pointer">
                                <span class="font-bold text-gray-700">Plastique</span>
                                <span class="block text-xs text-bals-blue mt-1">
                                    Matériau standard pour coffrets d'étage - Léger et résistant
                                </span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- 
                    🛡️ INDICE DE PROTECTION (IP)
                    3 niveaux disponibles : IP44, IP54, IP67
                    IP44 par défaut (protection projections d'eau)
                --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Indice de Protection (IP) <span class="text-red-500">*</span>
                    </label>

                    {{-- 3 cartes de sélection radio --}}
                    <div class="grid grid-cols-3 gap-3">

                        {{-- IP44 : Protection de base (PAR DÉFAUT) --}}
                        <label class="cursor-pointer">
                            <input type="radio" 
                                   name="ip" 
                                   value="IP44" 
                                   class="sr-only peer" 
                                   onchange="mettreAJour()" 
                                   checked>
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-black text-bals-blue">IP44</span>
                                <span class="text-gray-400 text-xs ml-1 block mt-1">Projections d'eau</span>
                                <span class="text-xs text-bals-blue block mt-1">Recommandé</span>
                            </div>
                        </label>

                        {{-- IP54 : Protection poussière + projections --}}
                        <label class="cursor-pointer">
                            <input type="radio" 
                                   name="ip" 
                                   value="IP54" 
                                   class="sr-only peer" 
                                   onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-black text-bals-blue">IP54</span>
                                <span class="text-gray-400 text-xs ml-1 block mt-1">Poussières + projections</span>
                            </div>
                        </label>

                        {{-- IP67 : Protection maximale (immersion temporaire) --}}
                        <label class="cursor-pointer">
                            <input type="radio" 
                                   name="ip" 
                                   value="IP67" 
                                   class="sr-only peer" 
                                   onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-black text-bals-blue">IP67</span>
                                <span class="text-gray-400 text-xs ml-1 block mt-1">Immersion temporaire</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- 🔌 SECTION 03 : CARACTÉRISTIQUES TECHNIQUES DES PRISES --}}
        {{-- CONFIGURATION COFFRET D'ÉTAGE selon PDF 510_802 :      --}}
        {{-- - 6x NF 10/16A (230V, 2P+T)                            --}}
        {{-- - 1x CEI 16A (400V, 3P+N+T)                            --}}
        {{-- - 1x CEI 32A (400V, 3P+N+T)                            --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s3')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                        03
                    </span>
                    <span class="font-bold text-lg">Caractéristiques Techniques des prises</span>
                </div>
                <span id="arrow-s3" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>

            {{-- Contenu CACHÉ au départ (hidden) --}}
            <div id="section-s3" class="hidden p-6">

                {{-- Information badge sur la configuration type --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-800">
                        <strong>💡 Configuration type Coffret d'Étage (510_802) :</strong>
                        6 prises domestiques NF 10/16A + 1 prise CEI 16A + 1 prise CEI 32A
                    </p>
                </div>

                {{-- 
                    📊 TABLEAU DES PRISES
                    Affiche toutes les prises disponibles avec :
                    - Type de prise (NF ou CEI)
                    - Contrôles +/- pour la quantité
                    - Sélecteurs pour brochage et tension
                --}}
                <div class="overflow-hidden rounded-xl border border-gray-100">
                    <table class="w-full text-sm">
                        
                        {{-- En-tête du tableau --}}
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-4 py-3 text-left font-black uppercase text-xs">Type de Prise</th>
                                <th class="px-4 py-3 text-center font-black uppercase text-xs">Quantité</th>
                                <th class="px-4 py-3 text-left font-black uppercase text-xs">Brochage</th>
                                <th class="px-4 py-3 text-left font-black uppercase text-xs">Tension</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-50">

                            {{-- 
                                🔸 LIGNE 1 : Prise NF 10/16A (domestique)
                                Quantité initiale : 6 (selon PDF 510_802)
                                Brochage : 2P+T (fixe)
                                Tension : 230V (fixe)
                            --}}
                            <tr class="bg-blue-50">
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">NF 10/16A</div>
                                    <div class="text-xs text-gray-400">Domestique - Configuration d'étage</div>
                                </td>
                                <td class="px-4 py-3">
                                    {{-- Contrôles +/- pour la quantité --}}
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                                onclick="changerQte(this, -1)"
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">
                                            −
                                        </button>
                                        {{-- ⭐ Valeur initiale = 6 pour l'étage --}}
                                        <span class="w-8 text-center font-bold text-gray-800">6</span>
                                        <button type="button"
                                                onclick="changerQte(this, 1)"
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">
                                            +
                                        </button>
                                    </div>
                                </td>
                                {{-- Brochage fixe pour prise domestique --}}
                                <td class="px-4 py-3 text-gray-700 text-sm">2P+T</td>
                                {{-- Tension fixe pour prise domestique --}}
                                <td class="px-4 py-3 text-gray-700 text-sm">230V</td>
                            </tr>

                            {{-- 
                                🔸 LIGNE 2 : Prise CEI 16A (industrielle)
                                Quantité initiale : 1 (selon PDF 510_802)
                                Brochage : 3P+N+T (par défaut)
                                Tension : 400V (par défaut)
                            --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">CEI 16A</div>
                                    <div class="text-xs text-gray-400">Industrielle</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" 
                                                onclick="changerQte(this, -1)" 
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">−</button>
                                        {{-- ⭐ Valeur initiale = 1 --}}
                                        <span class="w-8 text-center font-bold text-gray-800">1</span>
                                        <button type="button" 
                                                onclick="changerQte(this, 1)" 
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">+</button>
                                    </div>
                                </td>
                                {{-- Sélecteur de brochage --}}
                                <td class="px-4 py-3">
                                    <select onchange="mettreAJour()" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white">
                                        <option value="">--</option>
                                        <option value="3P+N+T" selected>3P+N+T</option>
                                        <option value="2P+T">2P+T</option>
                                        <option value="3P+T">3P+T</option>
                                    </select>
                                </td>
                                {{-- Sélecteur de tension --}}
                                <td class="px-4 py-3">
                                    <select onchange="mettreAJour()" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white">
                                        <option value="">--</option>
                                        <option value="400V" selected>400V</option>
                                        <option value="230V">230V</option>
                                    </select>
                                </td>
                            </tr>

                            {{-- 
                                🔸 LIGNE 3 : Prise CEI 32A (industrielle)
                                Quantité initiale : 1 (selon PDF 510_802)
                                Brochage : 3P+N+T (par défaut)
                                Tension : 400V (par défaut)
                            --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">CEI 32A</div>
                                    <div class="text-xs text-gray-400">Industrielle</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" 
                                                onclick="changerQte(this, -1)" 
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">−</button>
                                        {{-- ⭐ Valeur initiale = 1 --}}
                                        <span class="w-8 text-center font-bold text-gray-800">1</span>
                                        <button type="button" 
                                                onclick="changerQte(this, 1)" 
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">+</button>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <select onchange="mettreAJour()" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white">
                                        <option value="">--</option>
                                        <option value="3P+N+T" selected>3P+N+T</option>
                                        <option value="3P+T">3P+T</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <select onchange="mettreAJour()" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white">
                                        <option value="">--</option>
                                        <option value="400V" selected>400V</option>
                                    </select>
                                </td>
                            </tr>

                            {{-- 
                                🔸 LIGNE 4 : Prise CEI 63A (optionnelle)
                                Quantité initiale : 0
                                Option pour besoins spécifiques
                            --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">CEI 63A</div>
                                    <div class="text-xs text-gray-400">Option haute puissance</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" 
                                                onclick="changerQte(this, -1)" 
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">−</button>
                                        <span class="w-8 text-center font-bold text-gray-800">0</span>
                                        <button type="button" 
                                                onclick="changerQte(this, 1)" 
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">+</button>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <select onchange="mettreAJour()" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white">
                                        <option value="">--</option>
                                        <option value="3P+N+T">3P+N+T</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <select onchange="mettreAJour()" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white">
                                        <option value="">--</option>
                                        <option value="400V">400V</option>
                                    </select>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- 🛡️ SECTION 04 : PROTECTION DE TÊTE                    --}}
        {{-- Protection générale en amont de tout le coffret       --}}
        {{-- PAR DÉFAUT selon PDF : Inter différentiel + Disjoncteur --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s4')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                        04
                    </span>
                    <span class="font-bold text-lg">Protection de Tête</span>
                </div>
                <span id="arrow-s4" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>

            <div id="section-s4" class="hidden p-6">

                <p class="text-xs text-gray-400 mb-4 italic">
                    La protection de tête protège l'ensemble du coffret d'étage contre les surintensités et les défauts d'isolement.
                </p>

                {{-- Badge informatif sur la configuration recommandée --}}
                <div class="bg-blue-50 border-l-4 border-bals-blue p-3 mb-4 rounded">
                    <p class="text-xs text-blue-800">
                        <strong>Configuration recommandée (selon PDF) :</strong> Inter différentiel + Disjoncteur
                    </p>
                </div>

                {{-- 
                    Checkboxes : plusieurs protections peuvent être cochées
                    Format : 2 colonnes
                --}}
                <div class="grid grid-cols-2 gap-3">

                    {{-- Sans protection --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Sans" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    {{-- Interrupteur simple --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Interrupteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Interrupteur</span>
                        </div>
                    </label>

                    {{-- ⭐ Inter différentiel (recommandé) --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Inter différentiel" class="peer sr-only" onchange="mettreAJour()" checked>
                        <div class="border-2 border-bals-blue bg-blue-50 rounded-xl p-3 flex items-center gap-3 transition-all hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded bg-bals-blue border-2 border-bals-blue flex-shrink-0 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700">Inter différentiel ⭐</span>
                        </div>
                    </label>

                    {{-- ⭐ Disjoncteur (recommandé) --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()" checked>
                        <div class="border-2 border-bals-blue bg-blue-50 rounded-xl p-3 flex items-center gap-3 transition-all hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded bg-bals-blue border-2 border-bals-blue flex-shrink-0 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur ⭐</span>
                        </div>
                    </label>

                    {{-- Disjoncteur différentiel (combine les deux) --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur Diff." class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur Diff.</span>
                        </div>
                    </label>

                    {{-- Arrêt d'urgence (rouge) --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Arrêt d'urgence" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-red-600">Arrêt d'urgence</span>
                        </div>
                    </label>

                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- 🔒 SECTION 05 : PROTECTION DES PRISES                  --}}
        {{-- Protection individuelle ou par groupe                  --}}
        {{-- PAR DÉFAUT selon PDF : Disjoncteur                     --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s5')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                        05
                    </span>
                    <span class="font-bold text-lg">Protection des Prises</span>
                </div>
                <span id="arrow-s5" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>

            <div id="section-s5" class="hidden p-6">

                <p class="text-xs text-gray-400 mb-4 italic">
                    Protection individuelle ou par groupe pour chaque prise du coffret d'étage.
                </p>

                {{-- Badge informatif --}}
                <div class="bg-blue-50 border-l-4 border-bals-blue p-3 mb-4 rounded">
                    <p class="text-xs text-blue-800">
                        <strong>Configuration recommandée (selon PDF) :</strong> Disjoncteur par prise ou par groupe
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3">

                    {{-- Sans protection --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Sans" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    {{-- Par prise (protection individuelle) --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Par prise" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Par prise</span>
                        </div>
                    </label>

                    {{-- Par groupe de prises --}}
                    <label class="cursor-pointer col-span-2">
                        <input type="checkbox" name="prot_prises[]" value="Par groupe de prises" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Par groupe de prises</span>
                        </div>
                    </label>

                    {{-- ⭐ Disjoncteur (recommandé selon PDF) --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()" checked>
                        <div class="border-2 border-bals-blue bg-blue-50 rounded-xl p-3 flex items-center gap-3 transition-all hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded bg-bals-blue border-2 border-bals-blue flex-shrink-0 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur ⭐</span>
                        </div>
                    </label>

                    {{-- Disjoncteur différentiel --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Disjoncteur Diff." class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur Diff.</span>
                        </div>
                    </label>

                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- 📝 SECTION 06 : OBSERVATIONS                           --}}
        {{-- Zone de texte libre pour précisions                   --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s6')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                        06
                    </span>
                    <span class="font-bold text-lg">Observations</span>
                </div>
                <span id="arrow-s6" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>

            <div id="section-s6" class="hidden p-6">

                <p class="text-xs text-gray-400 mb-4 italic">
                    Ajoutez toute précision utile sur votre installation d'étage (nombre d'étages, besoins spécifiques, contraintes techniques...).
                </p>

                {{-- 
                    Zone de texte multilignes
                    - oninput déclenche mettreAJour() à chaque modification
                    - Redimensionnable verticalement (resize-y)
                --}}
                <textarea
                    id="observations"
                    name="observations"
                    rows="6"
                    placeholder="Ex : Installation au 3ème étage, besoin de mobilité, nombre de prises par pièce, contraintes d'accès..."
                    oninput="mettreAJour()"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50 resize-y">
                </textarea>

                {{-- Compteur de caractères (mis à jour en temps réel) --}}
                <p class="text-xs text-gray-400 mt-2 text-right">
                    <span id="nb-caracteres">0</span> caractère(s)
                </p>

            </div>
        </div>

    </div>
    {{-- FIN COLONNE GAUCHE --}}

    {{-- ========================================================== --}}
    {{-- 📦 COLONNE DROITE : Résumé + Actions                      --}}
    {{-- Position sticky : reste visible lors du scroll            --}}
    {{-- ========================================================== --}}
    <div class="w-80 flex flex-col gap-4" style="position: sticky; top: 24px; align-self: flex-start;">

        {{-- Carte de résumé --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête du résumé --}}
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-black text-gray-800 text-lg">Résumé de Configuration</h2>
                <p class="text-xs text-gray-400 mt-0.5">Devis Coffret d'Étage</p>
            </div>

            {{-- 
                Zone de contenu du résumé
                - Vide au départ
                - Remplie par JavaScript (fonction mettreAJour)
            --}}
            <div id="resume-zone" class="p-5 min-h-40 flex flex-col items-center justify-center text-center">
                <p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>
                <p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>
            </div>
        </div>

        {{-- 
            Boutons d'action
            - Cachés au départ (hidden)
            - Affichés dès qu'il y a des données dans le résumé
        --}}
        <div id="boutons-action" class="hidden flex flex-col gap-2">

            <div class="flex gap-2">
                {{-- Bouton Réinitialiser (rouge, icône X) --}}
                <button onclick="reinitialiser()"
                        class="w-10 h-10 rounded-xl border-2 border-red-200 text-red-400 hover:bg-red-50 flex items-center justify-center font-bold transition-all">
                    ✕
                </button>

                {{-- Bouton Copier (icône copie) --}}
                <button onclick="copierResume()"
                        class="flex-1 h-10 rounded-xl border-2 border-gray-200 text-gray-600 hover:bg-gray-50 font-bold text-sm flex items-center justify-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Copier
                </button>

                {{-- Bouton Envoyer (bleu, icône email) --}}
                <button onclick="envoyerDevis()"
                        class="flex-1 h-10 rounded-xl bg-bals-blue text-white font-bold text-sm flex items-center justify-center gap-2 hover:bg-blue-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Envoyer
                </button>
            </div>

            {{-- Adresse email de destination --}}
            <p class="text-center text-xs text-gray-400">
                Devis envoyé à :
                <a href="mailto:info@bals-france.fr" class="text-bals-blue font-bold hover:underline">
                    info@bals-france.fr
                </a>
            </p>
        </div>

    </div>
    {{-- FIN COLONNE DROITE --}}

</div>

@endsection

{{-- ============================================================ --}}
{{-- 🔧 SECTION SCRIPTS : JavaScript                             --}}
{{-- ============================================================ --}}
@section('scripts')
<script>
// ================================================================
// JAVASCRIPT DU CONFIGURATEUR COFFRET D'ÉTAGE BALS
// Gestion de l'interactivité, mise à jour du résumé, actions
// ================================================================

// ================================================================
// 1️⃣ GESTION DES ACCORDÉONS (sections repliables)
// ================================================================
/**
 * Fonction : toggleSection
 * Rôle : Ouvre ou ferme une section accordéon
 * 
 * @param {string} id - Identifiant de la section (ex: 's1', 's2'...)
 * 
 * Fonctionnement :
 * - Si la section est cachée → on l'ouvre
 * - Si la section est visible → on la cache
 * - La flèche change de direction (▲ ou ▼)
 */
function toggleSection(id) {
    // Récupération des éléments DOM
    const section = document.getElementById('section-' + id);
    const arrow   = document.getElementById('arrow-' + id);

    // Vérification de l'état actuel
    if (section.classList.contains('hidden')) {
        // Section fermée → on l'ouvre
        section.classList.remove('hidden');
        arrow.textContent = '▲';  // Flèche vers le haut
    } else {
        // Section ouverte → on la ferme
        section.classList.add('hidden');
        arrow.textContent = '▼';  // Flèche vers le bas
    }
}

// ================================================================
// 2️⃣ SÉLECTION DU TYPE DE COFFRET
// ================================================================
/**
 * Gestion des boutons de type de coffret
 * Ajoute un écouteur d'événement sur chaque bouton
 * Pour mettre en évidence le bouton actif
 */
document.querySelectorAll('.btn-type').forEach(function(btn) {
    btn.addEventListener('click', function() {
        // Réinitialiser tous les boutons (style inactif)
        document.querySelectorAll('.btn-type').forEach(function(b) {
            b.classList.remove('border-bals-blue', 'bg-bals-blue', 'text-white');
            b.classList.add('border-gray-200', 'text-gray-600');
        });

        // Activer le bouton cliqué (style actif)
        this.classList.remove('border-gray-200', 'text-gray-600');
        this.classList.add('border-bals-blue', 'bg-bals-blue', 'text-white');

        // Mettre à jour le résumé
        mettreAJour();
    });
});

// ================================================================
// 3️⃣ CONTRÔLE DES QUANTITÉS (boutons +/-)
// ================================================================
/**
 * Fonction : changerQte
 * Rôle : Augmente ou diminue la quantité d'une prise
 * 
 * @param {HTMLElement} btn - Le bouton cliqué (+ ou -)
 * @param {number} direction - +1 pour augmenter, -1 pour diminuer
 * 
 * Fonctionnement :
 * 1. Trouve le <span> qui contient la quantité actuelle
 * 2. Récupère la valeur numérique
 * 3. Ajoute la direction (+1 ou -1)
 * 4. Empêche les valeurs négatives (minimum = 0)
 * 5. Met à jour l'affichage
 * 6. Déclenche la mise à jour du résumé
 */
function changerQte(btn, direction) {
    // Trouver le span contenant la quantité
    const span  = btn.parentElement.querySelector('span');
    
    // Récupérer et convertir la valeur actuelle
    let valeur  = parseInt(span.textContent);

    // Modifier la valeur
    valeur += direction;

    // Empêcher les valeurs négatives
    if (valeur < 0) valeur = 0;

    // Mettre à jour l'affichage
    span.textContent = valeur;
    
    // Mettre à jour le résumé
    mettreAJour();
}

// ================================================================
// 4️⃣ MISE À JOUR DU RÉSUMÉ EN TEMPS RÉEL
// ================================================================
/**
 * Fonction : mettreAJour
 * Rôle : Met à jour le résumé et la barre de progression
 * 
 * Appelée à chaque modification du formulaire :
 * - Changement de champ texte (oninput)
 * - Sélection radio/checkbox (onchange)
 * - Modification de quantité (changerQte)
 * 
 * Étapes :
 * 1. Récupérer toutes les valeurs du formulaire
 * 2. Calculer le pourcentage de complétion
 * 3. Construire le HTML du résumé
 * 4. Afficher ou masquer les boutons d'action
 */
function mettreAJour() {
    
    // ============================================================
    // ÉTAPE 1 : Récupération des valeurs du formulaire
    // ============================================================
    
    // Champs de contact
    const distributeur       = document.getElementById('distributeur').value;
    const contactDist        = document.getElementById('contact_distributeur').value;
    const installateur       = document.getElementById('installateur').value;
    const contactInst        = document.getElementById('contact_installateur').value;
    const affaire            = document.getElementById('affaire').value;
    const telephone          = document.getElementById('telephone').value;
    const email              = document.getElementById('email').value;

    // Type de coffret sélectionné (bouton actif)
    const typeBoutonActif = document.querySelector('.btn-type.bg-bals-blue');
    const typeCoffret = typeBoutonActif ? typeBoutonActif.dataset.type : '';

    // Caractéristiques techniques
    const montageEl  = document.querySelector('input[name="montage"]:checked');
    const materiauEl = document.querySelector('input[name="materiau"]:checked');
    const ipEl       = document.querySelector('input[name="ip"]:checked');

    const montage  = montageEl  ? montageEl.value  : '';
    const materiau = materiauEl ? materiauEl.value : '';
    const ip       = ipEl       ? ipEl.value       : '';

    // Protections cochées (tableaux)
    const protTeteCoches = Array.from(
        document.querySelectorAll('input[name="prot_tete[]"]:checked')
    ).map(function(el) { return el.value; });

    const protPrisesCoches = Array.from(
        document.querySelectorAll('input[name="prot_prises[]"]:checked')
    ).map(function(el) { return el.value; });

    // Observations
    const observations = document.getElementById('observations').value;
    
    // Mise à jour du compteur de caractères
    document.getElementById('nb-caracteres').textContent = observations.length;

    // ============================================================
    // ÉTAPE 2 : Calcul de la progression (0-100%)
    // ============================================================
    
    // Liste des champs à vérifier (1 = rempli, 0 = vide)
    const champs = [
        distributeur     ? 1 : 0,  // Champ 1
        contactDist      ? 1 : 0,  // Champ 2
        installateur     ? 1 : 0,  // Champ 3
        email            ? 1 : 0,  // Champ 4
        typeCoffret      ? 1 : 0,  // Champ 5
        montage          ? 1 : 0,  // Champ 6
        materiau         ? 1 : 0,  // Champ 7
        ip               ? 1 : 0,  // Champ 8
        protTeteCoches.length   > 0 ? 1 : 0,  // Champ 9
        protPrisesCoches.length > 0 ? 1 : 0,  // Champ 10
    ];

    // Calcul du pourcentage
    const totalChamps   = champs.length;  // 10 champs au total
    const champsRemplis = champs.reduce(function(a, b) { return a + b; }, 0);  // Somme
    const pourcentage   = Math.round(champsRemplis / totalChamps * 100);

    // Mise à jour visuelle de la barre de progression
    document.getElementById('progression-barre').style.width = pourcentage + '%';
    document.getElementById('progression-texte').textContent = '(' + pourcentage + '%)';

    // ============================================================
    // ÉTAPE 3 : Construction du HTML du résumé
    // ============================================================
    
    const zoneResume = document.getElementById('resume-zone');

    // Si aucun champ n'est rempli → afficher le message par défaut
    if (champsRemplis === 0) {
        zoneResume.innerHTML = '<p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>'
                             + '<p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>';
        document.getElementById('boutons-action').classList.add('hidden');
        return;  // Sortir de la fonction
    }

    // Construction du HTML du résumé (concaténation de chaînes)
    let html = '<div class="w-full text-left space-y-3">';

    // Badge du type de coffret (bleu)
    if (typeCoffret) {
        html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">'
              + typeCoffret + '</div>';
    }

    // Section Contact
    if (distributeur || contactDist || installateur || email || telephone || affaire) {
        html += '<div class="space-y-1">';
        if (distributeur) html += '<p class="text-xs"><span class="text-gray-400">Distributeur :</span> <span class="font-bold text-gray-700">' + distributeur + '</span></p>';
        if (contactDist)  html += '<p class="text-xs"><span class="text-gray-400">Contact :</span> <span class="font-bold text-gray-700">' + contactDist + '</span></p>';
        if (installateur) html += '<p class="text-xs"><span class="text-gray-400">Installateur :</span> <span class="font-bold text-gray-700">' + installateur + '</span></p>';
        if (affaire)      html += '<p class="text-xs"><span class="text-gray-400">Affaire :</span> <span class="font-bold text-gray-700">' + affaire + '</span></p>';
        if (telephone)    html += '<p class="text-xs"><span class="text-gray-400">Tél :</span> <span class="font-bold text-gray-700">' + telephone + '</span></p>';
        if (email)        html += '<p class="text-xs"><span class="text-gray-400">Email :</span> <span class="font-bold text-gray-700">' + email + '</span></p>';
        html += '</div>';
    }

    // Section Caractéristiques techniques
    if (montage || materiau || ip) {
        html += '<div class="border-t border-gray-100 pt-2 space-y-1">';
        if (montage)  html += '<p class="text-xs"><span class="text-gray-400">Montage :</span> <span class="font-bold text-gray-700">' + montage + '</span></p>';
        if (materiau) html += '<p class="text-xs"><span class="text-gray-400">Matériau :</span> <span class="font-bold text-gray-700">' + materiau + '</span></p>';
        if (ip)       html += '<p class="text-xs"><span class="text-gray-400">Protection :</span> <span class="font-black text-bals-blue">' + ip + '</span></p>';
        html += '</div>';
    }

    // Section Protection de tête
    if (protTeteCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection de tête :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protTeteCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // Section Protection des prises
    if (protPrisesCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection des prises :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protPrisesCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // Section Observations (tronquée à 80 caractères)
    if (observations) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Observations :</p>';
        html += '<p class="text-xs text-gray-600 italic">' + observations.substring(0, 80);
        if (observations.length > 80) html += '...';
        html += '</p>';
        html += '</div>';
    }

    html += '</div>';

    // Injection du HTML dans la zone de résumé
    zoneResume.innerHTML = html;
    
    // Affichage des boutons d'action
    document.getElementById('boutons-action').classList.remove('hidden');
}

// ================================================================
// 5️⃣ BOUTONS D'ACTION
// ================================================================

/**
 * Fonction : copierResume
 * Rôle : Copie le résumé dans le presse-papiers
 * 
 * Utilise l'API Clipboard moderne du navigateur
 */
function copierResume() {
    // Récupération des données principales
    const distributeur = document.getElementById('distributeur').value;
    const email        = document.getElementById('email').value;
    const montageEl    = document.querySelector('input[name="montage"]:checked');
    const ipEl         = document.querySelector('input[name="ip"]:checked');

    // Construction du texte à copier
    const texte = 'DEVIS BALS - COFFRET D\'ÉTAGE\n'
                + 'Distributeur : ' + (distributeur || 'N/A') + '\n'
                + 'Email : '        + (email        || 'N/A') + '\n'
                + 'Montage : '      + (montageEl ? montageEl.value : 'N/A') + '\n'
                + 'IP : '           + (ipEl ? ipEl.value : 'N/A');

    // Copie dans le presse-papiers
    navigator.clipboard.writeText(texte).then(function() {
        alert('Résumé copié dans le presse-papiers !');
    });
}

/**
 * Fonction : envoyerDevis
 * Rôle : Ouvre le client email avec un sujet et corps pré-remplis
 * 
 * Utilise mailto: pour générer un lien email
 */
function envoyerDevis() {
    const distributeur = document.getElementById('distributeur').value;
    
    // Encodage URL pour éviter les problèmes de caractères spéciaux
    const sujet = encodeURIComponent('Demande de devis - Coffret d\'Étage - ' + distributeur);
    const corps = encodeURIComponent('Bonjour,\n\nVeuillez trouver ci-joint ma demande de devis pour un coffret d\'étage.\n\nDistributeur : ' + distributeur);

    // Ouverture du client email
    window.location.href = 'mailto:info@bals-france.fr?subject=' + sujet + '&body=' + corps;
}

/**
 * Fonction : reinitialiser
 * Rôle : Remet le formulaire aux valeurs PAR DÉFAUT du coffret d'étage
 * 
 * ⚠️ IMPORTANT : Ne vide PAS tous les champs, mais remet la configuration
 * recommandée selon le PDF du coffret d'étage :
 * - 6x NF 10/16A
 * - 1x CEI 16A
 * - 1x CEI 32A
 * - Mobile + Plastique + IP44
 * - Inter différentiel + Disjoncteur (tête)
 * - Disjoncteur (prises)
 */
function reinitialiser() {
    // ============================================================
    // ÉTAPE 1 : Vider tous les champs texte
    // ============================================================
    ['distributeur','contact_distributeur','installateur','contact_installateur','affaire','telephone','email','observations'].forEach(function(id) {
        document.getElementById(id).value = '';
    });

    // ============================================================
    // ÉTAPE 2 : Décocher TOUS les radios et checkboxes
    // ============================================================
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function(r) {
        r.checked = false;
    });

    // ============================================================
    // ÉTAPE 3 : Recocher les valeurs PAR DÉFAUT du coffret d'étage
    // ============================================================
    
    // Montage : Mobile (recommandé pour étage)
    document.querySelector('input[name="montage"][value="Mobile"]').checked = true;
    
    // Matériau : Plastique (seule option pour étage)
    document.querySelector('input[name="materiau"][value="Plastique"]').checked = true;
    
    // Protection : IP44 (recommandé)
    document.querySelector('input[name="ip"][value="IP44"]').checked = true;
    
    // Protection de tête : Inter différentiel + Disjoncteur (selon PDF)
    document.querySelector('input[name="prot_tete[]"][value="Inter différentiel"]').checked = true;
    document.querySelector('input[name="prot_tete[]"][value="Disjoncteur"]').checked = true;
    
    // Protection des prises : Disjoncteur (selon PDF)
    document.querySelector('input[name="prot_prises[]"][value="Disjoncteur"]').checked = true;

    // ============================================================
    // ÉTAPE 4 : Remettre les QUANTITÉS par défaut (selon PDF 510_802)
    // ============================================================
    const spans = document.querySelectorAll('#section-s3 tbody tr td:nth-child(2) span');
    if (spans.length >= 3) {
        spans[0].textContent = '6';  // NF 10/16A = 6 prises
        spans[1].textContent = '1';  // CEI 16A = 1 prise
        spans[2].textContent = '1';  // CEI 32A = 1 prise
        if (spans[3]) spans[3].textContent = '0';  // CEI 63A = 0 (option)
    }

    // Réinitialiser le compteur de caractères
    document.getElementById('nb-caracteres').textContent = '0';
    
    // Mettre à jour l'affichage du résumé
    mettreAJour();
}

// ================================================================
// 6️⃣ INITIALISATION AU CHARGEMENT DE LA PAGE
// ================================================================
/**
 * Exécuté quand le DOM est complètement chargé
 * Lance une première mise à jour pour calculer la progression initiale
 */
document.addEventListener('DOMContentLoaded', function() {
    mettreAJour();
});

</script>
@endsection