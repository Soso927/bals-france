{{-- ============================================================ --}}
{{-- FICHIER : resources/views/configurateur/chantier.blade.php  --}}
{{-- RÔLE    : Page configurateur Coffret de Chantier BALS        --}}
{{-- EXTENDS : On hérite du layout principal (app.blade.php)      --}}
{{-- ============================================================ --}}
@extends('layouts.app')

{{-- Titre de l'onglet du navigateur --}}
@section('title', 'Configurateur - Coffret de Chantier BALS')

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
<div class="relative flex min-h-screen gap-6 p-6 max-w-7xl mx-auto">

    <!-- Bouton Accueil en haut à gauche -->
    <a href="/" class="absolute left-6 top-6 z-50" title="Accueil">
        <i class="fa-solid fa-house" style="color: rgb(116, 192, 252); font-size: 2rem;"></i>
    </a>

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
            <p class="text-gray-400 font-medium mt-1">Coffret de Chantier BALS</p>

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
                <a href="{{ route('configurateur.chantier') }}" class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white transition-all cursor-default"
                   data-type="Coffret Chantier">
                    Coffret Chantier
                </a>

                <a href="{{ route('configurateur.etage') }}" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret d'Étage">
                    Coffret d'Étage
                </a>

                <a href="#" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret Industrie">
                    Coffret Industrie
                </a>

                <a href="{{ route('configurateur.evenementiel') }}" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
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

                {{-- Champ Société --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Société</label>
                    {{-- oninput="mettreAJour()" : met à jour le résumé en temps réel --}}
                    <input type="text"
                           id="societe"
                           placeholder="Nom de la société"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                {{-- Champ Contact de la Société --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact de la Société</label>
                    <input type="text"
                           id="contact"
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

                {{-- Champ Référence Affaire --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Référence Affaire</label>
                    <input type="text"
                           id="affaire"
                           placeholder="Référence de l'affaire"
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

                {{-- ---- TYPE DE COFFRET (Fixe / Mobile / Mobile sur pied) ---- --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Type de coffret <span class="text-red-500">*</span>
                    </label>

                    {{-- 3 cartes cliquables avec icônes SVG --}}
                    <div class="grid grid-cols-3 gap-3" id="type-montage">

                        {{-- Carte Fixe --}}
                        <label class="cursor-pointer">
                            {{-- sr-only = caché visuellement mais lisible par les lecteurs d'écran --}}
                            <input type="radio" name="montage" value="Fixe" class="sr-only peer" onchange="mettreAJour()">
                            {{-- La classe peer-checked change le style quand le radio est coché --}}
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

                        {{-- Carte Mobile --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="montage" value="Mobile" class="sr-only peer" onchange="mettreAJour()" checked>
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                {{-- Icône SVG : coffret avec roues --}}
                                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <rect x="2" y="4" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <circle cx="7" cy="20" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="17" cy="20" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                                    <line x1="7" y1="18" x2="7" y2="18" stroke="currentColor" stroke-width="1.5"/>
                                    <line x1="4" y1="11" x2="20" y2="11" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                <span class="font-bold text-sm text-gray-700">Mobile</span>
                            </div>
                        </label>

                        {{-- Carte Mobile sur pied --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="montage" value="Mobile sur pied" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                {{-- Icône SVG : coffret sur pied --}}
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

                {{-- ---- MATÉRIAUX ---- --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Matériaux <span class="text-red-500">*</span>
                    </label>

                    {{-- 3 cartes pour le matériau --}}
                    <div class="grid grid-cols-3 gap-3">
                        @foreach(['Caoutchouc', 'Métallique', 'Plastique'] as $mat)
                        <label class="cursor-pointer">
                            <input type="radio" name="materiau" value="{{ $mat }}" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-sm text-gray-700">{{ $mat }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- ---- INDICE DE PROTECTION IP ---- --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Indice de Protection (IP) <span class="text-red-500">*</span>
                    </label>

                    {{-- 3 cartes pour le niveau IP --}}
                    {{-- Chaque carte montre le code IP + une description courte --}}
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
                {{-- Flèche vers le bas = section fermée --}}
                <span id="arrow-s3" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>

            {{-- Contenu CACHÉ au départ (hidden) --}}
            <div id="section-s3" class="hidden p-6">

                {{-- Tableau des prises avec quantités --}}
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
                        {{-- Corps du tableau --}}
                        <tbody class="divide-y divide-gray-50">

                            {{-- Ligne 1 : Prise NF 10/16A (domestique) --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">NF 10/16A</div>
                                    <div class="text-xs text-gray-400">Domestique</div>
                                </td>
                                <td class="px-4 py-3">
                                    {{-- Contrôle +/- pour la quantité --}}
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                                onclick="changerQte(this, -1)"
                                                class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 font-bold">
                                            −
                                        </button>
                                        <span class="w-8 text-center font-bold text-gray-800">0</span>
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

                            {{-- Ligne 2 : Prise CEI 16A --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">CEI 16A</div>
                                    <div class="text-xs text-gray-400">Industrielle</div>
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
                                        <option value="2P+T">2P+T</option>
                                        <option value="3P+T">3P+T</option>
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

                            {{-- Ligne 3 : Prise CEI 32A --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">CEI 32A</div>
                                    <div class="text-xs text-gray-400">Industrielle</div>
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
                                        <option value="3P+T">3P+T</option>
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

                            {{-- Ligne 4 : Prise CEI 63A --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">CEI 63A</div>
                                    <div class="text-xs text-gray-400">Industrielle</div>
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

                            {{-- Ligne 5 : Prise CEI 125A --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800">CEI 125A</div>
                                    <div class="text-xs text-gray-400">Industrielle</div>
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
        {{-- La protection de tête = le disjoncteur général du      --}}
        {{-- coffret, qui protège toutes les prises en même temps   --}}
        {{-- Source PDF : cases à cocher "Protection de tête"       --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête cliquable --}}
            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s4')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                        04
                    </span>
                    <span class="font-bold text-lg">Protection de Tête</span>
                </div>
                {{-- Flèche vers le bas = section fermée par défaut --}}
                <span id="arrow-s4" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>

            {{-- Contenu caché par défaut --}}
            <div id="section-s4" class="hidden p-6">

                {{-- Explication pour le jury --}}
                <p class="text-xs text-gray-400 mb-4 italic">
                    La protection de tête protège l'ensemble du coffret.
                    Elle est placée en amont de toutes les prises.
                </p>

                {{-- Grille des options de protection de tête --}}
                {{-- On utilise des checkboxes car plusieurs options peuvent être combinées --}}
                <div class="grid grid-cols-2 gap-3">

                    {{-- Option 1 : Sans protection --}}
                    <label class="cursor-pointer">
                        {{-- peer = classe CSS qui surveille l'état checked du checkbox --}}
                        <input type="checkbox" name="prot_tete[]" value="Sans" class="peer sr-only" onchange="mettreAJour()">
                        {{-- peer-checked:border-bals-blue = bordure bleue si coché --}}
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            {{-- Icône checkmark (visible si coché via CSS peer) --}}
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex items-center justify-center flex-shrink-0 peer-checked:bg-bals-blue peer-checked:border-bals-blue">
                            </div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    {{-- Option 2 : Interrupteur --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Interrupteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Interrupteur</span>
                        </div>
                    </label>

                    {{-- Option 3 : Inter différentiel --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Inter différentiel" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Inter différentiel</span>
                        </div>
                    </label>

                    {{-- Option 4 : Disjoncteur --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur</span>
                        </div>
                    </label>

                    {{-- Option 5 : Disjoncteur Différentiel --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur Diff." class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur Diff.</span>
                        </div>
                    </label>

                    {{-- Option 6 : Arrêt d'urgence --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Arrêt d'urgence" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            {{-- Texte en rouge pour indiquer le caractère critique --}}
                            <span class="text-sm font-bold text-red-600">Arrêt d'urgence</span>
                        </div>
                    </label>

                </div>
            </div>
        </div>


        {{-- ====================================================== --}}
        {{-- SECTION 05 : PROTECTION DES PRISES                     --}}
        {{-- La protection des prises = protection individuelle ou  --}}
        {{-- par groupe pour chaque prise du coffret                --}}
        {{-- Source PDF : cases à cocher "Protection des prises"    --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête cliquable --}}
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

            {{-- Contenu caché par défaut --}}
            <div id="section-s5" class="hidden p-6">

                <p class="text-xs text-gray-400 mb-4 italic">
                    La protection des prises protège chaque prise individuellement
                    ou par groupe de prises.
                </p>

                {{-- Grille des options --}}
                <div class="grid grid-cols-2 gap-3">

                    {{-- Option 1 : Sans protection par prise --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Sans" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    {{-- Option 2 : Protection par prise individuelle --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Par prise" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Par prise</span>
                        </div>
                    </label>

                    {{-- Option 3 : Protection par groupe --}}
                    {{-- col-span-2 = cette case occupe les 2 colonnes --}}
                    <label class="cursor-pointer col-span-2">
                        <input type="checkbox" name="prot_prises[]" value="Par groupe de prises" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Par groupe de prises</span>
                        </div>
                    </label>

                    {{-- Option 4 : Disjoncteur --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur</span>
                        </div>
                    </label>

                    {{-- Option 5 : Disjoncteur Différentiel --}}
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
        {{-- Zone de texte libre pour ajouter des remarques,        --}}
        {{-- des besoins spécifiques ou des précisions sur le devis --}}
        {{-- Source PDF : zone "Observations" en bas du formulaire  --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête cliquable --}}
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

            {{-- Contenu caché par défaut --}}
            <div id="section-s6" class="hidden p-6">

                <p class="text-xs text-gray-400 mb-4 italic">
                    Ajoutez ici toutes les remarques, besoins spécifiques
                    ou informations complémentaires pour votre devis.
                </p>

                {{-- Zone de texte libre --}}
                {{-- textarea = champ multi-lignes (contrairement à input type="text") --}}
                {{-- rows="6" = hauteur initiale de 6 lignes                          --}}
                {{-- resize-y = l'utilisateur peut agrandir verticalement             --}}
                <textarea
                    id="observations"
                    name="observations"
                    rows="6"
                    placeholder="Ex : Besoin d'un coffret étanche pour un usage extérieur, câblage spécifique, délai de livraison souhaité..."
                    oninput="mettreAJour()"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50 resize-y">
                </textarea>

                {{-- Compteur de caractères (mis à jour par JavaScript) --}}
                <p class="text-xs text-gray-400 mt-2 text-right">
                    <span id="nb-caracteres">0</span> caractère(s)
                </p>

            </div>
        </div>

    </div>
    {{-- Fin colonne gauche --}}


    {{-- ========================================================== --}}
    {{-- COLONNE DROITE : Résumé de Configuration (Sidebar)         --}}
    {{-- sticky top-6 = reste visible quand on fait défiler         --}}
    {{-- w-80 = largeur fixe de 320px                               --}}
    {{-- ========================================================== --}}
    <div class="w-80 flex flex-col gap-4" style="position: sticky; top: 24px; align-self: flex-start;">

        {{-- Carte principale du résumé --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête de la sidebar --}}
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-black text-gray-800 text-lg">Résumé de Configuration</h2>
                <p class="text-xs text-gray-400 mt-0.5">Devis en temps réel</p>
            </div>

            {{-- Zone d'affichage du résumé (mise à jour par JavaScript) --}}
            <div id="resume-zone" class="p-5 min-h-40 flex flex-col items-center justify-center text-center">
                {{-- Message par défaut avant de remplir le formulaire --}}
                <p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>
                <p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- BOUTONS D'ACTION : Copier / Envoyer                    --}}
        {{-- Cachés au départ (hidden), affichés quand le formulaire --}}
        {{-- est rempli (géré par JavaScript)                        --}}
        {{-- ====================================================== --}}
        <div id="boutons-action" class="hidden flex flex-col gap-2">

            {{-- Bouton Annuler (croix rouge) --}}
            <div class="flex gap-2">
                <button onclick="reinitialiser()"
                        class="w-10 h-10 rounded-xl border-2 border-red-200 text-red-400 hover:bg-red-50 flex items-center justify-center font-bold transition-all">
                    ✕
                </button>

                {{-- Bouton Copier le résumé --}}
                <button onclick="copierResume()"
                        class="flex-1 h-10 rounded-xl border-2 border-gray-200 text-gray-600 hover:bg-gray-50 font-bold text-sm flex items-center justify-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Copier
                </button>

                {{-- Bouton Envoyer (bleu BALS) --}}
                <button onclick="envoyerDevis()"
                        class="flex-1 h-10 rounded-xl bg-bals-blue text-white font-bold text-sm flex items-center justify-center gap-2 hover:bg-blue-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Envoyer
                </button> 
                {{-- <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-home"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.707 2.293l9 9c.63 .63 .184 1.707 -.707 1.707h-1v6a3 3 0 0 1 -3 3h-1v-7a3 3 0 0 0 -2.824 -2.995l-.176 -.005h-2a3 3 0 0 0 -3 3v7h-1a3 3 0 0 1 -3 -3v-6h-1c-.89 0 -1.337 -1.077 -.707 -1.707l9 -9a1 1 0 0 1 1.414 0m.293 11.707a1 1 0 0 1 1 1v7h-4v-7a1 1 0 0 1 .883 -.993l.117 -.007z" /></svg>
                    Retour vers l'accueil
                </button> --}}
            </div>

            {{-- Lien email de destination --}}
            <p class="text-center text-xs text-gray-400">
                Devis envoyé à :
                <a href="mailto:info@bals-france.fr" class="text-bals-blue font-bold hover:underline">
                    info@bals-france.fr
                </a>
            </p>
        </div>

    </div>
    {{-- Fin colonne droite --}}

</div>
{{-- Fin structure générale --}}

@endsection


{{-- ============================================================ --}}
{{-- SECTION SCRIPTS : JavaScript de la page                      --}}
{{-- ============================================================ --}}
@section('scripts')
<script>
/*
 * ================================================================
 * JAVASCRIPT DU CONFIGURATEUR BALS
 * ================================================================
 *
 * Ce fichier gère :
 * 1. Les accordéons (ouvrir/fermer les sections)
 * 2. La mise à jour du résumé en temps réel
 * 3. La barre de progression
 * 4. Les boutons d'action
 *
 * PRINCIPE GÉNÉRAL :
 * Chaque fois que l'utilisateur modifie un champ,
 * la fonction mettreAJour() est appelée.
 * Elle recalcule le résumé et la progression.
 */


// ================================================================
// 1. GESTION DES ACCORDÉONS
// ================================================================

/**
 * toggleSection(id) : ouvre ou ferme une section accordéon
 *
 * PARAMÈTRE : id = identifiant de la section (ex: 's1', 's2', 's3')
 *
 * FONCTIONNEMENT :
 * - On récupère l'élément HTML avec document.getElementById()
 * - On ajoute ou retire la classe CSS 'hidden' pour cacher/afficher
 * - On fait pivoter la flèche pour indiquer l'état
 */
function toggleSection(id) {
    // Récupère le contenu de la section
    const section = document.getElementById('section-' + id);
    // Récupère la flèche de la section
    const arrow   = document.getElementById('arrow-' + id);

    // Si la section est cachée : on l'affiche
    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden'); // Afficher
        arrow.textContent = '▲';            // Flèche vers le haut = ouvert
    } else {
        // Sinon : on la cache
        section.classList.add('hidden');    // Cacher
        arrow.textContent = '▼';            // Flèche vers le bas = fermé
    }
}


// ================================================================
// 2. SÉLECTION DU TYPE DE COFFRET (boutons du haut)
// ================================================================

/**
 * Gestion des boutons "Type de coffret" en haut de page
 * Au clic sur un bouton : on le met en bleu, les autres en blanc
 */
document.querySelectorAll('.btn-type').forEach(function(btn) {
    btn.addEventListener('click', function() {

        // Enlève le style "actif" de TOUS les boutons
        document.querySelectorAll('.btn-type').forEach(function(b) {
            b.classList.remove('border-bals-blue', 'bg-bals-blue', 'text-white');
            b.classList.add('border-gray-200', 'text-gray-600');
        });

        // Met le style "actif" sur le bouton cliqué
        this.classList.remove('border-gray-200', 'text-gray-600');
        this.classList.add('border-bals-blue', 'bg-bals-blue', 'text-white');

        // Met à jour le résumé
        mettreAJour();
    });
});


// ================================================================
// 3. CONTRÔLE DES QUANTITÉS (+/-)
// ================================================================

/**
 * changerQte(btn, direction) : augmente ou diminue une quantité
 *
 * PARAMÈTRES :
 * - btn       : le bouton cliqué (+ ou -)
 * - direction : +1 pour augmenter, -1 pour diminuer
 */
function changerQte(btn, direction) {
    // Trouve le span de la quantité (frère du bouton)
    const span  = btn.parentElement.querySelector('span');
    // Lit la valeur actuelle (parseInt = convertit le texte en nombre)
    let valeur  = parseInt(span.textContent);

    // Modifie la valeur
    valeur += direction;

    // Empêche les valeurs négatives (minimum = 0)
    if (valeur < 0) valeur = 0;

    // Affiche la nouvelle valeur
    span.textContent = valeur;

    // Met à jour le résumé
    mettreAJour();
}


// ================================================================
// 4. MISE À JOUR DU RÉSUMÉ EN TEMPS RÉEL
// ================================================================

/**
 * mettreAJour() : relit tous les champs et affiche le résumé
 *
 * Cette fonction est appelée chaque fois qu'un champ change.
 * Elle :
 * 1. Lit les valeurs de tous les champs
 * 2. Construit le texte du résumé
 * 3. Met à jour la barre de progression
 * 4. Affiche ou cache les boutons d'action
 */
function mettreAJour() {

    // ----------------------------------------------------------------
    // LECTURE DES CHAMPS DE CONTACT
    // ----------------------------------------------------------------
    const societe      = document.getElementById('societe').value;
    const contact      = document.getElementById('contact').value;
    const installateur = document.getElementById('installateur').value;
    const affaire      = document.getElementById('affaire').value;
    const email        = document.getElementById('email').value;

    // ----------------------------------------------------------------
    // LECTURE DU TYPE DE COFFRET (bouton actif en bleu)
    // ----------------------------------------------------------------
    const typeBoutonActif = document.querySelector('.btn-type.bg-bals-blue');
    const typeCoffret = typeBoutonActif ? typeBoutonActif.dataset.type : '';

    // ----------------------------------------------------------------
    // LECTURE DES BOUTONS RADIO (un seul choix possible)
    // querySelector cherche le premier radio coché dans la page
    // ----------------------------------------------------------------
    const montageEl  = document.querySelector('input[name="montage"]:checked');
    const materiauEl = document.querySelector('input[name="materiau"]:checked');
    const ipEl       = document.querySelector('input[name="ip"]:checked');

    const montage  = montageEl  ? montageEl.value  : '';
    const materiau = materiauEl ? materiauEl.value  : '';
    const ip       = ipEl       ? ipEl.value        : '';

    // ----------------------------------------------------------------
    // LECTURE DES CHECKBOXES PROTECTION DE TÊTE
    // querySelectorAll = récupère TOUS les checkboxes cochés
    // Array.from().map() = transforme la liste en tableau de textes
    // ----------------------------------------------------------------
    const protTeteCoches = Array.from(
        document.querySelectorAll('input[name="prot_tete[]"]:checked')
    ).map(function(el) { return el.value; });
    // Exemple de résultat : ['Disjoncteur', 'Arrêt d\'urgence']

    // ----------------------------------------------------------------
    // LECTURE DES CHECKBOXES PROTECTION DES PRISES
    // ----------------------------------------------------------------
    const protPrisesCoches = Array.from(
        document.querySelectorAll('input[name="prot_prises[]"]:checked')
    ).map(function(el) { return el.value; });

    // ----------------------------------------------------------------
    // LECTURE DE LA ZONE OBSERVATIONS
    // ----------------------------------------------------------------
    const observations = document.getElementById('observations').value;

    // Met à jour le compteur de caractères
    document.getElementById('nb-caracteres').textContent = observations.length;

    // ----------------------------------------------------------------
    // CALCUL DE LA PROGRESSION
    // Chaque champ vaut 1 point s'il est rempli, 0 sinon
    // ----------------------------------------------------------------
    const champs = [
        societe          ? 1 : 0,   // Société remplie ?
        contact          ? 1 : 0,   // Contact rempli ?
        installateur     ? 1 : 0,   // Installateur rempli ?
        email            ? 1 : 0,   // Email rempli ?
        typeCoffret      ? 1 : 0,   // Type coffret sélectionné ?
        montage          ? 1 : 0,   // Montage sélectionné ?
        materiau         ? 1 : 0,   // Matériau sélectionné ?
        ip               ? 1 : 0,   // IP sélectionné ?
        protTeteCoches.length   > 0 ? 1 : 0,  // Au moins une protection de tête ?
        protPrisesCoches.length > 0 ? 1 : 0,  // Au moins une protection des prises ?
    ];

    // Additionne les 1 pour obtenir le nombre de champs remplis
    // reduce(a, b) => a + b : parcourt le tableau et additionne tout
    const totalChamps   = champs.length;
    const champsRemplis = champs.reduce(function(a, b) { return a + b; }, 0);
    const pourcentage   = Math.round(champsRemplis / totalChamps * 100);

    // Met à jour la barre de progression dans le DOM
    document.getElementById('progression-barre').style.width = pourcentage + '%';
    document.getElementById('progression-texte').textContent = '(' + pourcentage + '%)';

    // ----------------------------------------------------------------
    // CONSTRUCTION DU RÉSUMÉ HTML
    // ----------------------------------------------------------------
    const zoneResume = document.getElementById('resume-zone');

    // Si aucun champ n'est rempli : message par défaut
    if (champsRemplis === 0) {
        zoneResume.innerHTML = '<p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>'
                             + '<p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>';
        document.getElementById('boutons-action').classList.add('hidden');
        return;
    }

    // Commence à construire le HTML du résumé
    let html = '<div class="w-full text-left space-y-3">';

    // Bloc 1 : Type de coffret (badge bleu)
    if (typeCoffret) {
        html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">'
              + typeCoffret + '</div>';
    }

    // Bloc 2 : Informations de contact
    if (societe || contact || email || installateur || affaire) {
        html += '<div class="space-y-1">';
        if (societe)      html += '<p class="text-xs"><span class="text-gray-400">Société :</span> <span class="font-bold text-gray-700">' + societe + '</span></p>';
        if (contact)      html += '<p class="text-xs"><span class="text-gray-400">Contact :</span> <span class="font-bold text-gray-700">' + contact + '</span></p>';
        if (installateur) html += '<p class="text-xs"><span class="text-gray-400">Installateur :</span> <span class="font-bold text-gray-700">' + installateur + '</span></p>';
        if (affaire)      html += '<p class="text-xs"><span class="text-gray-400">Affaire :</span> <span class="font-bold text-gray-700">' + affaire + '</span></p>';
        if (email)        html += '<p class="text-xs"><span class="text-gray-400">Email :</span> <span class="font-bold text-gray-700">' + email + '</span></p>';
        html += '</div>';
    }

    // Bloc 3 : Caractéristiques techniques
    if (montage || materiau || ip) {
        html += '<div class="border-t border-gray-100 pt-2 space-y-1">';
        if (montage)  html += '<p class="text-xs"><span class="text-gray-400">Montage :</span> <span class="font-bold text-gray-700">' + montage + '</span></p>';
        if (materiau) html += '<p class="text-xs"><span class="text-gray-400">Matériau :</span> <span class="font-bold text-gray-700">' + materiau + '</span></p>';
        if (ip)       html += '<p class="text-xs"><span class="text-gray-400">Protection :</span> <span class="font-black text-bals-blue">' + ip + '</span></p>';
        html += '</div>';
    }

    // Bloc 4 : Protection de tête (si au moins une option cochée)
    if (protTeteCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection de tête :</p>';
        // join(', ') = sépare les éléments du tableau par une virgule
        html += '<p class="text-xs font-bold text-gray-700">' + protTeteCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // Bloc 5 : Protection des prises (si au moins une option cochée)
    if (protPrisesCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection des prises :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protPrisesCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // Bloc 6 : Observations (si remplies)
    if (observations) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Observations :</p>';
        // substring(0, 80) = affiche max 80 caractères dans le résumé
        html += '<p class="text-xs text-gray-600 italic">' + observations.substring(0, 80);
        if (observations.length > 80) html += '...'; // Ajoute "..." si texte trop long
        html += '</p>';
        html += '</div>';
    }

    html += '</div>';

    // Injecte le HTML construit dans la zone résumé
    zoneResume.innerHTML = html;

    // Affiche les boutons d'action
    document.getElementById('boutons-action').classList.remove('hidden');
}


// ================================================================
// 5. BOUTONS D'ACTION
// ================================================================

/**
 * copierResume() : copie le résumé dans le presse-papiers
 */
function copierResume() {
    const societe  = document.getElementById('societe').value;
    const email    = document.getElementById('email').value;
    const montageEl= document.querySelector('input[name="montage"]:checked');
    const ipEl     = document.querySelector('input[name="ip"]:checked');

    const texte = 'DEVIS BALS\n'
                + 'Société : ' + (societe || 'N/A') + '\n'
                + 'Email : '   + (email   || 'N/A') + '\n'
                + 'Montage : ' + (montageEl ? montageEl.value : 'N/A') + '\n'
                + 'IP : '      + (ipEl     ? ipEl.value     : 'N/A');

    // Copie dans le presse-papiers
    navigator.clipboard.writeText(texte).then(function() {
        alert('Résumé copié !');
    });
}

/**
 * envoyerDevis() : ouvre le client mail avec le résumé pré-rempli
 */
function envoyerDevis() {
    const societe = document.getElementById('societe').value;
    const sujet   = encodeURIComponent('Demande de devis - ' + societe);
    const corps   = encodeURIComponent('Bonjour,\n\nVeuillez trouver ci-joint ma demande de devis.\n\nSociété : ' + societe);

    // Ouvre le client email
    window.location.href = 'mailto:info@bals-france.fr?subject=' + sujet + '&body=' + corps;
}

/**
 * reinitialiser() : remet tout le formulaire à zéro
 */
function reinitialiser() {
    // Vide tous les champs texte
    ['societe','contact','installateur','affaire','email','observations'].forEach(function(id) {
        document.getElementById(id).value = '';
    });

    // Décoche tous les radios ET checkboxes
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function(r) {
        r.checked = false;
    });

    // Remet le compteur de caractères à 0
    document.getElementById('nb-caracteres').textContent = '0';

    // Met à jour le résumé
    mettreAJour();
}


// ================================================================
// 6. INITIALISATION AU CHARGEMENT DE LA PAGE
// ================================================================

// Quand la page est chargée, met à jour une première fois
document.addEventListener('DOMContentLoaded', function() {
    mettreAJour();
});

</script>
    <script src="{{ asset('configurateur/js/configurateur.js') }}"></script>
@endsection