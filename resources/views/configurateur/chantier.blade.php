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
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">
                Type de Coffret
            </p>

            <div class="flex flex-wrap gap-3" id="type-coffret-buttons">

                {{-- Bouton actif : page courante, non cliquable --}}
                <span class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white cursor-default"
                      data-type="Coffret Chantier">
                    Coffret Chantier
                </span>

                <a href="{{ route('configurateur.etage') }}" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret d'Étage">
                    Coffret d'Étage
                </a>

                <a href="{{ route('configurateur.industrie') }}" class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
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
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl px-6 py-4 shadow-sm border border-gray-100">

            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2">
                Progression du Devis
                <span id="progression-texte" class="text-bals-blue">(0%)</span>
            </p>

            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                <div id="progression-barre"
                     class="h-full bg-bals-blue rounded-full transition-all duration-500"
                     style="width: 0%">
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- SECTION 01 : INFORMATIONS DE CONTACT                   --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s1')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                        01
                    </span>
                    <span class="font-bold text-lg">Informations de Contact</span>
                </div>
                <span id="arrow-s1" class="text-white text-lg transition-transform duration-300">▲</span>
            </div>

            <div id="section-s1" class="p-6 flex flex-col gap-5">

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Société</label>
                    <input type="text"
                           id="societe"
                           placeholder="Nom de la société"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact de la Société</label>
                    <input type="text"
                           id="contact"
                           placeholder="Nom du contact"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Installateur</label>
                    <input type="text"
                           id="installateur"
                           placeholder="Nom de l'installateur"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Référence Affaire</label>
                    <input type="text"
                           id="affaire"
                           placeholder="Référence de l'affaire"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

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

            <div id="section-s2" class="p-6 flex flex-col gap-7">

                {{-- ---- TYPE DE COFFRET ---- --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Type de coffret <span class="text-red-500">*</span>
                    </label>

                    <div class="grid grid-cols-3 gap-3" id="type-montage">

                        <label class="cursor-pointer">
                            <input type="radio" name="montage" value="Fixe" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-sm text-gray-700">Fixe</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="montage" value="Mobile" class="sr-only peer" onchange="mettreAJour()" checked>
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-sm text-gray-700">Mobile</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="montage" value="Mobile sur pied" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
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
                        <span class="font-black text-gray-800 text-lg">Prises domestiques NF</span>
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
                @foreach(['Prises domestiques CEI 16A', 'Prises domestiques CEI 32A', 'Prises domestiques CEI 63A', 'Prises domestiques CEI 125A'] as $cei)
                <div class="rounded-xl border border-gray-200 overflow-hidden">

                    {{-- En-tête de la carte --}}
                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                        <span class="font-black text-bals-blue text-lg">{{ $cei }}</span>
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
                            <span class="font-black text-bals-blue text-lg">Prise Domestiques CEI 24A</span>
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
                    La protection de tête protège l'ensemble du coffret.
                    Elle est placée en amont de toutes les prises.
                </p>

                <div class="grid grid-cols-2 gap-3">

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Sans" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex items-center justify-center shrink-0 peer-checked:bg-bals-blue peer-checked:border-bals-blue">
                            </div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Interrupteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Interrupteur</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Inter différentiel" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Inter différentiel</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur Diff." class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur Diff.</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Arrêt d'urgence" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-red-600">Arrêt d'urgence</span>
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
                    La protection des prises protège chaque prise individuellement
                    ou par groupe de prises.
                </p>

                <div class="grid grid-cols-2 gap-3">

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Sans" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Par prise" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Par prise</span>
                        </div>
                    </label>

                    <label class="cursor-pointer col-span-2">
                        <input type="checkbox" name="prot_prises[]" value="Par groupe de prises" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Par groupe de prises</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur</span>
                        </div>
                    </label>

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
                    Ajoutez ici toutes les remarques, besoins spécifiques
                    ou informations complémentaires pour votre devis.
                </p>

                <textarea
                    id="observations"
                    name="observations"
                    rows="6"
                    placeholder="Ex : Besoin d'un coffret étanche pour un usage extérieur, câblage spécifique, délai de livraison souhaité..."
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
    {{-- COLONNE DROITE : Résumé de Configuration (Sidebar)         --}}
    {{-- ========================================================== --}}
    <div class="w-80 flex flex-col gap-4" style="position: sticky; top: 24px; align-self: flex-start;">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-black text-gray-800 text-lg">Résumé de Configuration</h2>
                <p class="text-xs text-gray-400 mt-0.5">Devis en temps réel</p>
            </div>

            <div id="resume-zone" class="p-5 min-h-40 flex flex-col items-center justify-center text-center">
                <p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>
                <p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>
            </div>
        </div>

        <div id="boutons-action" class="hidden">
            <div class="flex flex-col gap-2">

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
    {{-- Fin colonne droite --}}

</div>
{{-- Fin structure générale --}}

@endsection


{{-- ============================================================ --}}
{{-- SECTION SCRIPTS : JavaScript de la page                      --}}
{{-- ============================================================ --}}
@section('scripts')

    <script src="{{ asset('configurateur/js/configurateur.js') }}"></script>
    <script src="{{ asset('configurateur/js/chantier.js') }}"></script>
@endsection