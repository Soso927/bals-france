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
    <a href="/" class="absolute left-32 top-24 z-50" title="Accueil">
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

                {{-- Bouton actif : page courante, non cliquable --}}
                <span class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white cursor-default"
                      data-type="Coffret Industrie">
                    Coffret Industrie
                </span>

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
                    <div class="grid grid-cols-3 gap-3" id="montage">

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
        {{-- ⚡ MODIFIÉE : 5 cartes séparées, brochages en lignes,  --}}
        {{--               padding agrandi, @foreach Blade           --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- En-tête cliquable --}}
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
            <div id="section-s3" class="hidden p-6 flex flex-col gap-6">

                {{-- ── CARTE NF ── --}}
                <div class="rounded-xl border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                        <span class="font-black text-gray-800 text-sm">NF</span>
                    </div>

                    <table class="min-w-full text-sm">
                        <thead class="bg-bals-blue text-white">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-black uppercase border-r border-white/20">Brochage</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold border-r border-white/20">Quantité</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold">Tension</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white">
                                <td class="px-5 py-4 font-bold text-gray-400 text-sm border-r border-gray-100 w-28">—</td>
                                <td class="px-5 py-4 border-r border-gray-100">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="changerQte(this, -1)"
                                            class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">−</button>
                                        <span class="w-10 text-center font-bold text-gray-800 text-sm" data-type="NF">0</span>
                                        <button type="button" onclick="changerQte(this, 1)"
                                            class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">+</button>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-bals-blue"
                                        data-type="NF" data-field="tension" onchange="mettreAJour()">
                                        <option value="">--</option>
                                        <option value="230V">230V</option>
                                        <option value="400V">400V</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- ── CARTES CEI (16A, 32A, 63A, 125A) générées par @foreach ── --}}
                @foreach(['CEI 16A', 'CEI 32A', 'CEI 63A', 'CEI 125A'] as $cei)
                <div class="rounded-xl border border-gray-200 overflow-hidden">

                    {{-- En-tête de la carte --}}
                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                        <span class="font-black text-bals-blue text-sm">{{ $cei }}</span>
                    </div>

                    <table class="min-w-full text-sm">
                        <thead class="bg-bals-blue text-white">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-black uppercase border-r border-white/20">Brochage</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold border-r border-white/20">Quantité</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold">Tension</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(['2P+T', '3P+T', '3P+N+T'] as $brochage)
                            <tr class="{{ !$loop->last ? 'border-b border-gray-100' : '' }} {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">

                                {{-- Brochage --}}
                                <td class="px-5 py-4 font-black text-bals-blue text-sm border-r border-gray-100 w-28">
                                    {{ $brochage }}
                                </td>

                                {{-- Quantité --}}
                                <td class="px-5 py-4 border-r border-gray-100">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="changerQte(this, -1)"
                                            class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">−</button>
                                        <span class="w-10 text-center font-bold text-gray-800 text-sm"
                                            data-type="{{ $cei }}"
                                            data-brochage="{{ $brochage }}">0</span>
                                        <button type="button" onclick="changerQte(this, 1)"
                                            class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">+</button>
                                    </div>
                                </td>

                                {{-- Tension --}}
                                <td class="px-5 py-4">
                                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-bals-blue"
                                        data-type="{{ $cei }}"
                                        data-brochage="{{ $brochage }}"
                                        data-field="tension"
                                        onchange="mettreAJour()">
                                        <option value="">--</option>
                                        <option value="230V">230V</option>
                                        <option value="400V">400V</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach

                    {{-- ── CARTE CEI 24A ── --}}
                    <div class="rounded-xl border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                            <span class="font-black text-bals-blue text-sm">CEI 24A</span>
                        </div>
                        <table class="min-w-full text-sm">
                            <thead class="bg-bals-blue text-white">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-black uppercase border-r border-white/20">Brochage</th>
                                    <th class="px-5 py-3 text-center text-xs font-semibold border-r border-white/20">Quantité</th>
                                    <th class="px-5 py-3 text-center text-xs font-semibold">Tension</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(['2P', '3P'] as $brochage)
                                <tr class="{{ !$loop->last ? 'border-b border-gray-100' : '' }} {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                    {{-- Brochage --}}
                                    <td class="px-5 py-4 font-black text-bals-blue text-sm border-r border-gray-100 w-28">
                                        {{ $brochage }}
                                    </td>
                                    {{-- Quantité --}}
                                    <td class="px-5 py-4 border-r border-gray-100">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" onclick="changerQte(this, -1)"
                                                class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">−</button>
                                            <span class="w-10 text-center font-bold text-gray-800 text-sm"
                                                data-type="CEI 24A"
                                                data-brochage="{{ $brochage }}">0</span>
                                            <button type="button" onclick="changerQte(this, 1)"
                                                class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">+</button>
                                        </div>
                                    </td>
                                    {{-- Tension --}}
                                    <td class="px-5 py-4">
                                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-bals-blue"
                                            data-type="CEI 24A"
                                            data-brochage="{{ $brochage }}"
                                            data-field="tension"
                                            onchange="mettreAJour()">
                                            <option value="">--</option>
                                            <option value="24V">24V</option>
                                            <option value="48V">48V</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
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
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex items-center justify-center shrink-0 peer-checked:bg-bals-blue peer-checked:border-bals-blue">
                            </div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    {{-- Option 2 : Interrupteur --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Interrupteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Interrupteur</span>
                        </div>
                    </label>

                    {{-- Option 3 : Inter différentiel --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Inter différentiel" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Inter différentiel</span>
                        </div>
                    </label>

                    {{-- Option 4 : Disjoncteur --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur</span>
                        </div>
                    </label>

                    {{-- Option 5 : Disjoncteur Différentiel --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur Diff." class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur Diff.</span>
                        </div>
                    </label>

                    {{-- Option 6 : Arrêt d'urgence --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Arrêt d'urgence" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
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
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    {{-- Option 2 : Protection par prise individuelle --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Par prise" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Par prise</span>
                        </div>
                    </label>

                    {{-- Option 3 : Protection par groupe --}}
                    {{-- col-span-2 = cette case occupe les 2 colonnes --}}
                    <label class="cursor-pointer col-span-2">
                        <input type="checkbox" name="prot_prises[]" value="Par groupe de prises" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Par groupe de prises</span>
                        </div>
                    </label>

                    {{-- Option 4 : Disjoncteur --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur</span>
                        </div>
                    </label>

                    {{-- Option 5 : Disjoncteur Différentiel --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Disjoncteur Diff." class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
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


@section('scripts')
    <script src="{{ asset('configurateur/js/configurateur.js') }}"></script>
    <script src="{{ asset('configurateur/js/chantier.js') }}"></script>
@endsection