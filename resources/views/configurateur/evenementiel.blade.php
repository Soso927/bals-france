{{-- ============================================================ --}}
{{-- FICHIER : resources/views/configurateur/evenementiel.blade.php --}}
{{-- RÔLE    : Page configurateur Coffret Événementiel BALS        --}}
{{-- EXTENDS : On hérite du layout principal (app.blade.php)        --}}
{{-- ============================================================ --}}
@extends('layouts.app')

{{-- Titre de l'onglet du navigateur --}}
@section('title', 'Configurateur - Coffret Événementiel BALS')

{{-- ============================================================ --}}
{{-- SECTION CONTENT : tout le HTML de la page va ici            --}}
{{-- ============================================================ --}}
@section('content')

{{-- ============================================================ --}}
{{-- STRUCTURE GÉNÉRALE : deux colonnes côte à côte              --}}
{{--   - Colonne gauche (flex-1) : le formulaire                  --}}
{{--   - Colonne droite (w-80)   : le résumé de configuration     --}}
{{-- min-h-screen : la page occupe au moins tout l'écran          --}}
{{-- ============================================================ --}}
<div class="flex min-h-screen gap-6 p-6 max-w-7xl mx-auto">

    {{-- ========================================================== --}}
    {{-- COLONNE GAUCHE : Formulaire principal                       --}}
    {{-- flex-1 = prend tout l'espace disponible après la sidebar   --}}
    {{-- ========================================================== --}}
    <div class="flex-1 flex flex-col gap-5">

        {{-- ====================================================== --}}
        {{-- ENTÊTE : Logo BALS + Titre de la page                  --}}
        {{-- ====================================================== --}}
        <div class="text-center py-4">

            {{-- Logo BALS (image) --}}
            <div class="flex justify-center mb-3">
                <img src="{{ asset('images/logo-bals.png') }}"
                     alt="Logo BALS"
                     class="h-10"
                     onerror="this.style.display='none'; document.getElementById('logo-fallback').style.display='flex'">

                {{-- Fallback si l'image n'existe pas : affiche le logo en SVG --}}
                <div id="logo-fallback" class="items-center gap-2" style="display:none">
                    {{-- Icône SVG représentant le logo BALS --}}
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                        <rect x="0" y="2"  width="22" height="7" fill="#009EE3"/>
                        <rect x="12" y="11" width="24" height="7" fill="#DA291C"/>
                        <rect x="0" y="20" width="22" height="7" fill="#009EE3"/>
                        <rect x="12" y="29" width="24" height="7" fill="#DA291C"/>
                    </svg>
                    <span class="text-3xl font-black text-bals-blue ml-1">Bals</span>
                </div>
            </div>

            {{-- Titre principal de la page --}}
            <h1 class="text-3xl font-black text-gray-800">Configurateur de Devis</h1>

            {{-- Sous-titre indiquant le type de produit --}}
            <p class="text-gray-400 font-medium mt-1">Coffret Événementiel BALS</p>

            {{-- Ligne décorative bleue sous le titre --}}
            <div class="h-1 bg-bals-blue rounded-full mt-4 max-w-lg mx-auto"></div>
        </div>

        {{-- ====================================================== --}}
        {{-- CARTE 1 : Sélection du TYPE DE COFFRET                 --}}
        {{-- L'utilisateur choisit ici quel produit il veut configurer --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

            {{-- Titre de la section --}}
            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">
                Type de Coffret
            </p>

            {{-- Boutons de sélection du type de coffret --}}
            {{-- data-type : valeur envoyée au JavaScript pour mettre à jour le résumé --}}
            <div class="flex flex-wrap gap-3" id="type-coffret-buttons">
                {{-- Boutons de navigation par type de coffret --}}
                <a href="{{ route('configurateur.chantier') }}" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret Chantier">
                    Coffret Chantier
                </a>

                <a href="{{ route('configurateur.etage') }}" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret d'Étage">
                    Coffret d'Étage
                </a>

                <a href="{{ route('configurateur.industrie') }}" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret Industrie">
                    Coffret Industrie
                </a>

                {{-- Bouton actif (page courante) --}}
                <a href="#" class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white transition-all cursor-default"
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
        {{-- BARRE DE PROGRESSION                                    --}}
        {{-- Affiche le % de complétion du formulaire en temps réel --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl px-6 py-4 shadow-sm border border-gray-100">

            {{-- Texte du pourcentage (mis à jour par JavaScript) --}}
            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2">
                Progression du Devis
                <span id="progression-texte" class="text-bals-blue">(0%)</span>
            </p>

            {{-- Barre de progression : fond gris avec remplissage bleu --}}
            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                {{-- La largeur (width) est mise à jour par JavaScript --}}
                <div id="progression-barre"
                     class="h-full bg-bals-blue rounded-full transition-all duration-500"
                     style="width: 0%">
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- SECTION 01 : INFORMATIONS DE CONTACT                   --}}
        {{-- Accordéon : clic sur le titre pour ouvrir/fermer       --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête de section (cliquable pour ouvrir/fermer l'accordéon) --}}
            {{-- onclick="toggleSection('s1')" : appelle la fonction JavaScript --}}
            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s1')">
                <div class="flex items-center gap-3">
                    {{-- Numéro de la section --}}
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                        01
                    </span>
                    <span class="font-bold text-lg">Informations de Contact</span>
                </div>
                {{-- Flèche indiquant l'état ouvert/fermé --}}
                <span id="arrow-s1" class="text-white text-lg transition-transform duration-300">▲</span>
            </div>

            {{-- Contenu de la section (masqué/affiché par JavaScript) --}}
            <div id="section-s1" class="p-6 flex flex-col gap-5">

                {{-- Champ Distributeur --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Distributeur</label>
                    {{-- oninput="mettreAJour()" : met à jour le résumé en temps réel --}}
                    <input type="text"
                           id="distributeur"
                           placeholder="Nom du distributeur"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- Champ Contact Distributeur --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact Distributeur</label>
                    <input type="text"
                           id="contact_distributeur"
                           placeholder="Nom du contact"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- Champ Installateur --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Installateur</label>
                    <input type="text"
                           id="installateur"
                           placeholder="Nom de l'installateur"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- Champ Contact Installateur --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact Installateur</label>
                    <input type="text"
                           id="contact_installateur"
                           placeholder="Nom du contact"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- Champ Référence Affaire --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Référence Affaire</label>
                    <input type="text"
                           id="affaire"
                           placeholder="Référence de l'affaire"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- Champ Téléphone --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Téléphone</label>
                    <input type="tel"
                           id="telephone"
                           placeholder="+33 1 23 45 67 89"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- Champ Email --}}
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
        {{-- SECTION 02 : CARACTÉRISTIQUES TECHNIQUES GÉNÉRAL       --}}
        {{-- Cette section est adaptée au Coffret Événementiel      --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête cliquable --}}
            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s2')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                        02
                    </span>
                    <span class="font-bold text-lg">Caractéristiques Techniques général</span>
                </div>
                <span id="arrow-s2" class="text-white text-lg transition-transform duration-300">▲</span>
            </div>

            {{-- Contenu --}}
            <div id="section-s2" class="p-6 flex flex-col gap-7">

                {{-- ---- TYPE DE COFFRET ÉVÉNEMENTIEL ---- --}}
                {{-- Options spécifiques aux événements : Mobile, Mobile sur pied --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Type de coffret <span class="text-red-500">*</span>
                    </label>

                    {{-- 4 cartes cliquables avec icônes SVG --}}
                    <div class="grid grid-cols-2 gap-3" id="type-montage">

                        {{-- Carte Fixe --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="montage" value="Fixe" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                {{-- Icône SVG : armoire/tableau --}}
                                <svg class="w-8 h-8 mx-auto mb-2 text-gray-500 peer-checked:text-bals-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <line x1="3" y1="9" x2="21" y2="9" stroke="currentColor" stroke-width="1.5"/>
                                    <line x1="12" y1="3" x2="12" y2="9" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                <span class="font-bold text-sm text-gray-700">Fixe</span>
                            </div>
                        </label>

                        {{-- Carte Mobile (option par défaut pour l'événementiel) --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="montage" value="Mobile" class="sr-only peer" onchange="mettreAJour()" checked>
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <rect x="2" y="4" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <circle cx="7" cy="20" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="17" cy="20" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                                    <line x1="4" y1="11" x2="20" y2="11" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                <span class="font-bold text-sm text-gray-700">Mobile</span>
                            </div>
                        </label>

                        {{-- Carte Mobile sur pied --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="montage" value="Mobile sur pied" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
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

                {{-- ---- MATÉRIAUX POUR ÉVÉNEMENTIEL ---- --}}
                {{-- Options : Caoutchouc, Métallique fixe, Plastique, Gamme EVOBOX, Flight-cases --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Matériaux <span class="text-red-500">*</span>
                    </label>

                    {{-- Grille de 5 options --}}
                    <div class="grid grid-cols-3 gap-3">
                        
                        {{-- Caoutchouc --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="materiau" value="Caoutchouc" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-xs text-gray-700">Caoutchouc</span>
                            </div>
                        </label>

                        {{-- Métallique (fixe) --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="materiau" value="Métallique (fixe)" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-xs text-gray-700">Métallique (fixe)</span>
                            </div>
                        </label>

                        {{-- Plastique --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="materiau" value="Plastique" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-xs text-gray-700">Plastique</span>
                            </div>
                        </label>

                        {{-- Gamme EVOBOX (mobile) - Option premium pour événementiel --}}
                        <label class="cursor-pointer col-span-2">
                            <input type="radio" name="materiau" value="Gamme EVOBOX (mobile)" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-xs text-gray-700">Gamme EVOBOX</span>
                                <span class="text-xs text-gray-400 ml-1">(mobile)</span>
                            </div>
                        </label>

                        {{-- Flight-cases (mobile) --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="materiau" value="Flight-cases (mobile)" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-xs text-gray-700">Flight-cases</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- ---- INDICE DE PROTECTION IP ---- --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Indice de Protection (IP) <span class="text-red-500">*</span>
                    </label>

                    {{-- 3 cartes pour le niveau IP --}}
                    <div class="grid grid-cols-3 gap-3">

                        <label class="cursor-pointer">
                            <input type="radio" name="ip" value="IP44" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-black text-bals-blue">IP44</span>
                                <span class="text-gray-400 text-xs ml-1">Projections d'eau</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="ip" value="IP54" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-black text-bals-blue">IP54</span>
                                <span class="text-gray-400 text-xs ml-1">Poussières + projections</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="ip" value="IP67" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-black text-bals-blue">IP67</span>
                                <span class="text-gray-400 text-xs ml-1">Immersion temporaire</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- SECTION 03 : CARACTÉRISTIQUES TECHNIQUES DES PRISES    --}}
        {{-- Configuration adaptée au coffret événementiel          --}}
        {{-- Selon le PDF: 1x NF 10/16A + 3x CEI 32A                --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête cliquable (section fermée par défaut) --}}
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

                {{-- Information pour l'événementiel --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-800">
                        <strong>💡 Configuration type événementiel :</strong> 
                        1 prise domestique NF 10/16A + 3 prises industrielles CEI 32A
                    </p>
                </div>

                {{-- Tableau des prises --}}
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

                            {{-- Ligne 1 : Prise NF 10/16A (domestique) - Quantité initiale : 1 --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">NF 10/16A</div>
                                    <div class="text-xs text-gray-400">Domestique</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                                onclick="changerQte(this, -1)"
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">
                                            −
                                        </button>
                                        {{-- Valeur initiale = 1 pour l'événementiel --}}
                                        <span class="w-8 text-center font-bold text-gray-800">1</span>
                                        <button type="button"
                                                onclick="changerQte(this, 1)"
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">
                                            +
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-700 text-sm">2P+T</td>
                                <td class="px-4 py-3 text-gray-700 text-sm">230V</td>
                            </tr>

                            {{-- Ligne 2 : Prise CEI 32A - Quantité initiale : 3 pour l'événementiel --}}
                            <tr class="bg-blue-50">
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">CEI 32A</div>
                                    <div class="text-xs text-gray-400">Industrielle - Configuration événementielle</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="changerQte(this, -1)" class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">−</button>
                                        {{-- Valeur initiale = 3 selon le PDF événementiel --}}
                                        <span class="w-8 text-center font-bold text-gray-800">3</span>
                                        <button type="button" onclick="changerQte(this, 1)" class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">+</button>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <select onchange="mettreAJour()" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white">
                                        <option value="">--</option>
                                        <option value="3x2P+T">3x 2P+T</option>
                                        <option value="2x3P+N+T">2x 3P+N+T</option>
                                        <option value="3P+N+T">3P+N+T</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <select onchange="mettreAJour()" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white">
                                        <option value="">--</option>
                                        <option value="230V">230V</option>
                                        <option value="400V">400V</option>
                                    </select>
                                </td>
                            </tr>

                            {{-- Ligne 3 : Prises additionnelles (si besoin de CEI 63A pour événements plus importants) --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">CEI 63A</div>
                                    <div class="text-xs text-gray-400">Option - Grands événements</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="changerQte(this, -1)" class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">−</button>
                                        <span class="w-8 text-center font-bold text-gray-800">0</span>
                                        <button type="button" onclick="changerQte(this, 1)" class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">+</button>
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
        {{-- SECTION 04 : PROTECTION DE TÊTE                       --}}
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
                    La protection de tête protège l'ensemble du coffret événementiel.
                </p>

                <div class="grid grid-cols-2 gap-3">

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Sans" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Interrupteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Interrupteur</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Inter différentiel" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Inter différentiel</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur Diff." class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur Diff.</span>
                        </div>
                    </label>

                    {{-- Arrêt d'urgence important pour l'événementiel --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Arrêt d'urgence" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-red-600">Arrêt d'urgence ⚠️</span>
                        </div>
                    </label>

                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- SECTION 05 : PROTECTION DES PRISES                     --}}
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
                    Configuration de la protection individuelle ou par groupe pour l'événementiel.
                </p>

                <div class="grid grid-cols-2 gap-3">

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Sans" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Par prise" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Par prise</span>
                        </div>
                    </label>

                    <label class="cursor-pointer col-span-2">
                        <input type="checkbox" name="prot_prises[]" value="Par groupe de prises" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Par groupe de prises</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur</span>
                        </div>
                    </label>

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
        {{-- SECTION 06 : OBSERVATIONS                              --}}
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
                    Spécifications particulières pour votre événement (type d'événement, durée, conditions particulières...).
                </p>

                <textarea
                    id="observations"
                    name="observations"
                    rows="6"
                    placeholder="Ex : Festival en extérieur du 15 au 20 juillet, besoin de mobilité, installation rapide requise..."
                    oninput="mettreAJour()"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50 resize-y">
                </textarea>

                <p class="text-xs text-gray-400 mt-2 text-right">
                    <span id="nb-caracteres">0</span> caractère(s)
                </p>

            </div>
        </div>

    </div>
    {{-- Fin colonne gauche --}}

    {{-- ========================================================== --}}
    {{-- COLONNE DROITE : Résumé de Configuration                  --}}
    {{-- ========================================================== --}}
    <div class="w-80 flex flex-col gap-4" style="position: sticky; top: 24px; align-self: flex-start;">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-black text-gray-800 text-lg">Résumé de Configuration</h2>
                <p class="text-xs text-gray-400 mt-0.5">Devis Événementiel</p>
            </div>

            <div id="resume-zone" class="p-5 min-h-40 flex flex-col items-center justify-center text-center">
                <p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>
                <p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>
            </div>
        </div>

        <div id="boutons-action" class="hidden flex flex-col gap-2">

            <div class="flex gap-2">
                <button onclick="reinitialiser()"
                        class="w-10 h-10 rounded-xl border-2 border-red-200 text-red-400 hover:bg-red-50 flex items-center justify-center font-bold transition-all">
                    ✕
                </button>

                <button onclick="copierResume()"
                        class="flex-1 h-10 rounded-xl border-2 border-gray-200 text-gray-600 hover:bg-gray-50 font-bold text-sm flex items-center justify-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Copier
                </button>

                <button onclick="envoyerDevis()"
                        class="flex-1 h-10 rounded-xl bg-bals-blue text-white font-bold text-sm flex items-center justify-center gap-2 hover:bg-blue-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Envoyer
                </button>
            </div>

            <p class="text-center text-xs text-gray-400">
                Devis envoyé à :
                <a href="mailto:info@bals-france.fr" class="text-bals-blue font-bold hover:underline">
                    info@bals-france.fr
                </a>
            </p>
        </div>

    </div>

</div>

@endsection

{{-- ============================================================ --}}
{{-- SECTION SCRIPTS : JavaScript                                --}}
{{-- ============================================================ --}}
@section('scripts')
<script>
// ================================================================
// JAVASCRIPT DU CONFIGURATEUR ÉVÉNEMENTIEL BALS
// ================================================================

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
// 3. CONTRÔLE DES QUANTITÉS
// ================================================================
function changerQte(btn, direction) {
    const span  = btn.parentElement.querySelector('span');
    let valeur  = parseInt(span.textContent);

    valeur += direction;

    if (valeur < 0) valeur = 0;

    span.textContent = valeur;
    mettreAJour();
}

// ================================================================
// 4. MISE À JOUR DU RÉSUMÉ
// ================================================================
function mettreAJour() {
    
    // Lecture des champs
    const distributeur       = document.getElementById('distributeur').value;
    const contactDist        = document.getElementById('contact_distributeur').value;
    const installateur       = document.getElementById('installateur').value;
    const contactInst        = document.getElementById('contact_installateur').value;
    const affaire            = document.getElementById('affaire').value;
    const telephone          = document.getElementById('telephone').value;
    const email              = document.getElementById('email').value;

    const typeBoutonActif = document.querySelector('.btn-type.bg-bals-blue');
    const typeCoffret = typeBoutonActif ? typeBoutonActif.dataset.type : '';

    const montageEl  = document.querySelector('input[name="montage"]:checked');
    const materiauEl = document.querySelector('input[name="materiau"]:checked');
    const ipEl       = document.querySelector('input[name="ip"]:checked');

    const montage  = montageEl  ? montageEl.value  : '';
    const materiau = materiauEl ? materiauEl.value : '';
    const ip       = ipEl       ? ipEl.value       : '';

    const protTeteCoches = Array.from(
        document.querySelectorAll('input[name="prot_tete[]"]:checked')
    ).map(function(el) { return el.value; });

    const protPrisesCoches = Array.from(
        document.querySelectorAll('input[name="prot_prises[]"]:checked')
    ).map(function(el) { return el.value; });

    const observations = document.getElementById('observations').value;
    document.getElementById('nb-caracteres').textContent = observations.length;

    // Calcul de progression
    const champs = [
        distributeur     ? 1 : 0,
        contactDist      ? 1 : 0,
        installateur     ? 1 : 0,
        email            ? 1 : 0,
        typeCoffret      ? 1 : 0,
        montage          ? 1 : 0,
        materiau         ? 1 : 0,
        ip               ? 1 : 0,
        protTeteCoches.length   > 0 ? 1 : 0,
        protPrisesCoches.length > 0 ? 1 : 0,
    ];

    const totalChamps   = champs.length;
    const champsRemplis = champs.reduce(function(a, b) { return a + b; }, 0);
    const pourcentage   = Math.round(champsRemplis / totalChamps * 100);

    document.getElementById('progression-barre').style.width = pourcentage + '%';
    document.getElementById('progression-texte').textContent = '(' + pourcentage + '%)';

    const zoneResume = document.getElementById('resume-zone');

    if (champsRemplis === 0) {
        zoneResume.innerHTML = '<p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>'
                             + '<p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>';
        document.getElementById('boutons-action').classList.add('hidden');
        return;
    }

    // Construction du résumé HTML
    let html = '<div class="w-full text-left space-y-3">';

    if (typeCoffret) {
        html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">'
              + typeCoffret + '</div>';
    }

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

    if (montage || materiau || ip) {
        html += '<div class="border-t border-gray-100 pt-2 space-y-1">';
        if (montage)  html += '<p class="text-xs"><span class="text-gray-400">Montage :</span> <span class="font-bold text-gray-700">' + montage + '</span></p>';
        if (materiau) html += '<p class="text-xs"><span class="text-gray-400">Matériau :</span> <span class="font-bold text-gray-700">' + materiau + '</span></p>';
        if (ip)       html += '<p class="text-xs"><span class="text-gray-400">Protection :</span> <span class="font-black text-bals-blue">' + ip + '</span></p>';
        html += '</div>';
    }

    if (protTeteCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection de tête :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protTeteCoches.join(', ') + '</p>';
        html += '</div>';
    }

    if (protPrisesCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection des prises :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protPrisesCoches.join(', ') + '</p>';
        html += '</div>';
    }

    if (observations) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Observations :</p>';
        html += '<p class="text-xs text-gray-600 italic">' + observations.substring(0, 80);
        if (observations.length > 80) html += '...';
        html += '</p>';
        html += '</div>';
    }

    html += '</div>';

    zoneResume.innerHTML = html;
    document.getElementById('boutons-action').classList.remove('hidden');
}

// ================================================================
// 5. BOUTONS D'ACTION
// ================================================================
function copierResume() {
    const distributeur = document.getElementById('distributeur').value;
    const email        = document.getElementById('email').value;
    const montageEl    = document.querySelector('input[name="montage"]:checked');
    const ipEl         = document.querySelector('input[name="ip"]:checked');

    const texte = 'DEVIS BALS ÉVÉNEMENTIEL\n'
                + 'Distributeur : ' + (distributeur || 'N/A') + '\n'
                + 'Email : '        + (email        || 'N/A') + '\n'
                + 'Montage : '      + (montageEl ? montageEl.value : 'N/A') + '\n'
                + 'IP : '           + (ipEl ? ipEl.value : 'N/A');

    navigator.clipboard.writeText(texte).then(function() {
        alert('Résumé copié !');
    });
}

function envoyerDevis() {
    const distributeur = document.getElementById('distributeur').value;
    const sujet        = encodeURIComponent('Demande de devis Événementiel - ' + distributeur);
    const corps        = encodeURIComponent('Bonjour,\n\nVeuillez trouver ci-joint ma demande de devis pour un coffret événementiel.\n\nDistributeur : ' + distributeur);

    window.location.href = 'mailto:info@bals-france.fr?subject=' + sujet + '&body=' + corps;
}

function reinitialiser() {
    ['distributeur','contact_distributeur','installateur','contact_installateur','affaire','telephone','email','observations'].forEach(function(id) {
        document.getElementById(id).value = '';
    });

    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function(r) {
        r.checked = false;
    });

    // Remettre les quantités par défaut pour l'événementiel
    const spans = document.querySelectorAll('#section-s3 tbody tr td:nth-child(2) span');
    if (spans.length >= 2) {
        spans[0].textContent = '1';  // NF 10/16A = 1
        spans[1].textContent = '3';  // CEI 32A = 3
        if (spans[2]) spans[2].textContent = '0';  // CEI 63A = 0
    }

    document.getElementById('nb-caracteres').textContent = '0';
    mettreAJour();
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    mettreAJour();
});

</script>
@endsection