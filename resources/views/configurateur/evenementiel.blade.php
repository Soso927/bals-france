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

            <h1 class="text-3xl font-black text-gray-800">Configurateur de Devis</h1>
            <p class="text-gray-400 font-medium mt-1">Coffret Événementiel BALS</p>
            <div class="h-1 bg-bals-blue rounded-full mt-4 max-w-lg mx-auto"></div>
        </div>

        {{-- ====================================================== --}}
        {{-- CARTE 1 : Sélection du TYPE DE COFFRET                 --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">
                Type de Coffret
            </p>

            {{--
                CORRECTION 1 :
                Les boutons de navigation (.btn-type) sont des liens <a href="..."> qui
                redirigent vers d'autres pages. L'ancien code JS tentait de changer leur style
                au clic via un addEventListener, mais la navigation était déclenchée avant que
                le JS ait le temps d'agir (sauf pour le bouton courant).
                → On supprime le JS sur ces liens et on gère l'état actif uniquement en PHP/HTML :
                  le bouton de la page courante reçoit les classes "actif" directement ici,
                  les autres sont de simples liens sans manipulation JS.
            --}}
            <div class="flex flex-wrap gap-3" id="type-coffret-buttons">

                <a href="{{ route('configurateur.chantier') }}"
                   class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret Chantier">
                    Coffret Chantier
                </a>

                <a href="{{ route('configurateur.etage') }}"
                   class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret d'Étage">
                    Coffret d'Étage
                </a>

                <a href="{{ route('configurateur.industrie') }}"
                   class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret Industrie">
                    Coffret Industrie
                </a>

                {{-- Bouton actif : page courante, non cliquable --}}
                <span class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white cursor-default"
                      data-type="Coffret Événementiel">
                    Coffret Événementiel
                </span>

                <a href="{{ route('configurateur.prise-industrielle') }}"
                   class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
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
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">01</span>
                    <span class="font-bold text-lg">Informations de Contact</span>
                </div>
                <span id="arrow-s1" class="text-white text-lg transition-transform duration-300">▲</span>
            </div>

            <div id="section-s1" class="p-6 flex flex-col gap-5">

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Distributeur</label>
                    <input type="text" id="distributeur" placeholder="Nom du distributeur"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact Distributeur</label>
                    <input type="text" id="contact_distributeur" placeholder="Nom du contact"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Installateur</label>
                    <input type="text" id="installateur" placeholder="Nom de l'installateur"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact Installateur</label>
                    <input type="text" id="contact_installateur" placeholder="Nom du contact"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Référence Affaire</label>
                    <input type="text" id="affaire" placeholder="Référence de l'affaire"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Téléphone</label>
                    <input type="tel" id="telephone" placeholder="+33 1 23 45 67 89"
                           oninput="mettreAJour()"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" placeholder="contact@exemple.fr"
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
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">02</span>
                    <span class="font-bold text-lg">Caractéristiques Techniques général</span>
                </div>
                <span id="arrow-s2" class="text-white text-lg transition-transform duration-300">▲</span>
            </div>

            <div id="section-s2" class="p-6 flex flex-col gap-7">

                {{-- ---- TYPE DE COFFRET ÉVÉNEMENTIEL ---- --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Type de coffret <span class="text-red-500">*</span>
                    </label>

                    <div class="grid grid-cols-2 gap-3" id="type-montage">

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

                        <label class="cursor-pointer">
                            <input type="radio" name="materiau" value="Caoutchouc" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-xs text-gray-700">Caoutchouc</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="materiau" value="Métallique (fixe)" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-xs text-gray-700">Métallique (fixe)</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="materiau" value="Plastique" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-xs text-gray-700">Plastique</span>
                            </div>
                        </label>

                        <label class="cursor-pointer col-span-2">
                            <input type="radio" name="materiau" value="Gamme EVOBOX (mobile)" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-xs text-gray-700">Gamme EVOBOX</span>
                                <span class="text-xs text-gray-400 ml-1">(mobile)</span>
                            </div>
                        </label>

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

            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s3')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">03</span>
                    <span class="font-bold text-lg">Caractéristiques Techniques des prises</span>
                </div>
                <span id="arrow-s3" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>

            <div id="section-s3" class="hidden p-6 flex flex-col gap-6">

                {{-- ── CARTE NF ── --}}
                <div class="rounded-xl border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                        <span class="font-black text-gray-800 text-lg">Prise domestiques NF</span>
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
                                {{-- Brochage NF : pas de brochage spécifique, on affiche un tiret --}}
                                <td class="px-5 py-4 font-bold text-gray-400 text-sm border-r border-gray-100 w-28">—</td>

                                {{-- Quantité NF : data-type="NF" suffit (pas de data-brochage car brochage unique) --}}
                                <td class="px-5 py-4 border-r border-gray-100">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="changerQte(this, -1)"
                                            class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">−</button>
                                        <span class="w-10 text-center font-bold text-gray-800 text-sm"
                                              data-type="NF"
                                              data-brochage="—">0</span>
                                        <button type="button" onclick="changerQte(this, 1)"
                                            class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">+</button>
                                    </div>
                                </td>

                                {{-- Tension NF --}}
                                <td class="px-5 py-4">
                                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-bals-blue"
                                        data-type="NF" data-brochage="—" data-field="tension" onchange="mettreAJour()">
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
                @foreach(['Prise domestiques CEI 16A', 'Prise domestiques CEI 32A', 'Prise domestiques CEI 63A', 'Prise domestiques CEI 125A'] as $cei)
                <div class="rounded-xl border border-gray-200 overflow-hidden">

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

                                <td class="px-5 py-4 font-black text-bals-blue text-sm border-r border-gray-100 w-28">
                                    {{ $brochage }}
                                </td>

                                <td class="px-5 py-4 border-r border-gray-100">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="changerQte(this, -1)"
                                            class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">−</button>
                                        {{--
                                            data-type et data-brochage permettent à JS de retrouver
                                            précisément quelle ligne modifier lors de la lecture dans mettreAJour()
                                        --}}
                                        <span class="w-10 text-center font-bold text-gray-800 text-sm"
                                            data-type="{{ $cei }}"
                                            data-brochage="{{ $brochage }}">0</span>
                                        <button type="button" onclick="changerQte(this, 1)"
                                            class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">+</button>
                                    </div>
                                </td>

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
                                <td class="px-5 py-4 font-black text-bals-blue text-sm border-r border-gray-100 w-28">
                                    {{ $brochage }}
                                </td>
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
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">04</span>
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
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">05</span>
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
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">06</span>
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
//
// toggleSection(id) : ouvre ou ferme une section accordéon.
//
// Fonctionnement :
//   - Cherche l'élément #section-{id} (le contenu) et #arrow-{id} (la flèche)
//   - Si la section a la classe "hidden" → on la retire pour afficher et on
//     change la flèche en ▲
//   - Sinon → on rajoute "hidden" pour masquer et on passe la flèche à ▼
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
// 2. CORRECTION — SUPPRESSION DU GESTIONNAIRE DE CLIC SUR .btn-type
//
// PROBLÈME ORIGINAL :
//   L'ancien code ajoutait un addEventListener('click') sur tous les boutons
//   .btn-type pour modifier leur style (actif/inactif). Mais ces boutons sont
//   des liens <a href="..."> qui naviguent vers d'autres pages. La navigation
//   est déclenchée immédiatement, avant que le JS ait pu agir de façon utile.
//   Ce code était donc sans effet réel sur les vrais liens.
//
// CORRECTION :
//   Le bouton de la page courante est rendu actif directement en HTML (classe
//   bg-bals-blue etc. appliquée statiquement dans le Blade). C'est un <span>
//   et non un <a>, donc il n'est pas cliquable et n'a pas besoin de JS.
//   Les autres boutons restent de simples liens, sans manipulation JS.
//
// → AUCUN addEventListener sur .btn-type ici, c'est intentionnel.
// ================================================================


// ================================================================
// 3. CONTRÔLE DES QUANTITÉS
//
// changerQte(btn, direction) :
//   Incrémente (+1) ou décrémente (-1) la quantité d'une prise.
//
// Paramètres :
//   - btn       : le bouton + ou − cliqué
//   - direction : +1 pour augmenter, -1 pour diminuer
//
// Fonctionnement :
//   On remonte au parentElement du bouton (le div flex) pour trouver
//   le <span> frère qui affiche la quantité, puis on met à jour sa valeur.
//   On bloque à 0 minimum (pas de quantité négative).
//   Enfin, on appelle mettreAJour() pour rafraîchir le résumé et la progression.
// ================================================================
function changerQte(btn, direction) {
    // Le <span> portant la quantité est dans le même div flex que les boutons + et −
    const span  = btn.parentElement.querySelector('span');
    let valeur  = parseInt(span.textContent);

    valeur += direction;

    // Plancher à 0 : on ne peut pas avoir une quantité négative
    if (valeur < 0) valeur = 0;

    span.textContent = valeur;

    // Mise à jour immédiate du résumé
    mettreAJour();
}


// ================================================================
// 4. LECTURE DES PRISES (SECTION 03) — FONCTION UTILITAIRE
//
// lirePrises() :
//   Parcourt tous les <span data-type data-brochage> de la section 03
//   et collecte les lignes ayant une quantité > 0, en associant
//   le type de prise, le brochage, la quantité et la tension choisie.
//
// Retourne un tableau d'objets :
//   [{ type, brochage, qte, tension }, ...]
//
// CORRECTION PRINCIPALE :
//   Dans l'original, la section 03 n'était jamais lue par mettreAJour().
//   Ces données n'apparaissaient donc jamais dans le résumé, ne contribuaient
//   pas à la progression, et n'étaient pas incluses dans les emails/copie.
//   Cette fonction corrige ce problème en centralisant la lecture des prises.
// ================================================================
function lirePrises() {
    const prises = [];

    // On sélectionne tous les <span> portant une quantité dans la section 03.
    // Chaque span a : data-type (ex: "CEI 32A") et data-brochage (ex: "2P+T")
    document.querySelectorAll('#section-s3 span[data-type]').forEach(function(span) {
        const qte = parseInt(span.textContent);

        // On ne s'intéresse qu'aux lignes ayant au moins 1 prise
        if (qte > 0) {
            const type     = span.dataset.type;
            const brochage = span.dataset.brochage || '—';

            // On cherche le <select> de tension correspondant à cette ligne.
            // Il porte les mêmes data-type et data-brochage, plus data-field="tension"
            const selectTension = document.querySelector(
                '#section-s3 select[data-type="' + type + '"][data-brochage="' + brochage + '"][data-field="tension"]'
            );
            const tension = selectTension ? selectTension.value : '';

            prises.push({
                type:     type,
                brochage: brochage,
                qte:      qte,
                tension:  tension
            });
        }
    });

    return prises;
}


// ================================================================
// 5. MISE À JOUR DU RÉSUMÉ
//
// mettreAJour() :
//   Appelée à chaque interaction (saisie, clic, changement de select).
//   1. Lit tous les champs du formulaire
//   2. Calcule la progression (nombre de champs remplis / total)
//   3. Met à jour la barre de progression
//   4. Reconstruit le HTML du résumé dans la colonne droite
//   5. Affiche ou masque les boutons d'action (Copier / Envoyer)
//
// CORRECTIONS :
//   - Lecture et affichage des prises (section 03) ajoutés
//   - La section 03 contribue maintenant à la progression
// ================================================================
function mettreAJour() {

    // ── Lecture des champs Section 01 : Contact ──────────────────
    const distributeur    = document.getElementById('distributeur').value.trim();
    const contactDist     = document.getElementById('contact_distributeur').value.trim();
    const installateur    = document.getElementById('installateur').value.trim();
    const contactInst     = document.getElementById('contact_installateur').value.trim();
    const affaire         = document.getElementById('affaire').value.trim();
    const telephone       = document.getElementById('telephone').value.trim();
    const email           = document.getElementById('email').value.trim();

    // ── Type de coffret (bouton actif dans la navigation) ─────────
    // On cherche le .btn-type qui a les classes d'état actif (bg-bals-blue).
    // Sur cette page c'est toujours "Coffret Événementiel" (bouton statique),
    // mais on le lit dynamiquement pour rester générique.
    const typeBoutonActif = document.querySelector('.btn-type.bg-bals-blue');
    const typeCoffret     = typeBoutonActif ? typeBoutonActif.dataset.type : 'Coffret Événementiel';

    // ── Lecture Section 02 : Caractéristiques techniques ─────────
    const montageEl  = document.querySelector('input[name="montage"]:checked');
    const materiauEl = document.querySelector('input[name="materiau"]:checked');
    const ipEl       = document.querySelector('input[name="ip"]:checked');

    const montage  = montageEl  ? montageEl.value  : '';
    const materiau = materiauEl ? materiauEl.value : '';
    const ip       = ipEl       ? ipEl.value       : '';

    // ── CORRECTION : Lecture Section 03 : Prises ─────────────────
    // On utilise la fonction utilitaire lirePrises() créée plus haut.
    // Dans l'original, cette lecture n'existait pas du tout.
    const prises = lirePrises();

    // ── Lecture Section 04 : Protection de tête ──────────────────
    const protTeteCoches = Array.from(
        document.querySelectorAll('input[name="prot_tete[]"]:checked')
    ).map(function(el) { return el.value; });

    // ── Lecture Section 05 : Protection des prises ───────────────
    const protPrisesCoches = Array.from(
        document.querySelectorAll('input[name="prot_prises[]"]:checked')
    ).map(function(el) { return el.value; });

    // ── Lecture Section 06 : Observations ────────────────────────
    const observations = document.getElementById('observations').value;
    // Met à jour le compteur de caractères en bas du textarea
    document.getElementById('nb-caracteres').textContent = observations.length;


    // ── Calcul de la progression ──────────────────────────────────
    // Chaque critère vaut 1 s'il est rempli, 0 sinon.
    // CORRECTION : on ajoute la présence de prises comme critère de progression.
    // Dans l'original, les prises ne contribuaient jamais à la progression,
    // même remplies.
    const champs = [
        distributeur            ? 1 : 0,  // Champ Distributeur
        contactDist             ? 1 : 0,  // Champ Contact Distributeur
        installateur            ? 1 : 0,  // Champ Installateur
        email                   ? 1 : 0,  // Champ Email
        montage                 ? 1 : 0,  // Type de coffret (radio)
        materiau                ? 1 : 0,  // Matériau (radio)
        ip                      ? 1 : 0,  // Indice IP (radio)
        prises.length > 0       ? 1 : 0,  // ← NOUVEAU : au moins 1 prise configurée
        protTeteCoches.length   > 0 ? 1 : 0,  // Protection de tête
        protPrisesCoches.length > 0 ? 1 : 0,  // Protection des prises
    ];

    const totalChamps   = champs.length;
    const champsRemplis = champs.reduce(function(a, b) { return a + b; }, 0);
    const pourcentage   = Math.round(champsRemplis / totalChamps * 100);

    // Mise à jour visuelle de la barre de progression
    document.getElementById('progression-barre').style.width = pourcentage + '%';
    document.getElementById('progression-texte').textContent = '(' + pourcentage + '%)';


    // ── Résumé : si aucun champ n'est rempli, on affiche le message par défaut ──
    const zoneResume = document.getElementById('resume-zone');

    if (champsRemplis === 0) {
        zoneResume.innerHTML =
              '<p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>'
            + '<p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>';
        document.getElementById('boutons-action').classList.add('hidden');
        return; // On sort early, rien d'autre à afficher
    }


    // ── Construction du HTML du résumé ───────────────────────────
    let html = '<div class="w-full text-left space-y-3">';

    // --- Bandeau type de coffret ---
    html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">'
          + typeCoffret
          + '</div>';

    // --- Bloc contact ---
    if (distributeur || contactDist || installateur || contactInst || email || telephone || affaire) {
        html += '<div class="space-y-1">';
        if (distributeur) html += '<p class="text-xs"><span class="text-gray-400">Distributeur :</span> <span class="font-bold text-gray-700">' + distributeur + '</span></p>';
        if (contactDist)  html += '<p class="text-xs"><span class="text-gray-400">Contact dist. :</span> <span class="font-bold text-gray-700">' + contactDist + '</span></p>';
        if (installateur) html += '<p class="text-xs"><span class="text-gray-400">Installateur :</span> <span class="font-bold text-gray-700">' + installateur + '</span></p>';
        if (contactInst)  html += '<p class="text-xs"><span class="text-gray-400">Contact inst. :</span> <span class="font-bold text-gray-700">' + contactInst + '</span></p>';
        if (affaire)      html += '<p class="text-xs"><span class="text-gray-400">Affaire :</span> <span class="font-bold text-gray-700">' + affaire + '</span></p>';
        if (telephone)    html += '<p class="text-xs"><span class="text-gray-400">Tél :</span> <span class="font-bold text-gray-700">' + telephone + '</span></p>';
        if (email)        html += '<p class="text-xs"><span class="text-gray-400">Email :</span> <span class="font-bold text-gray-700">' + email + '</span></p>';
        html += '</div>';
    }

    // --- Bloc caractéristiques techniques ---
    if (montage || materiau || ip) {
        html += '<div class="border-t border-gray-100 pt-2 space-y-1">';
        if (montage)  html += '<p class="text-xs"><span class="text-gray-400">Montage :</span> <span class="font-bold text-gray-700">' + montage + '</span></p>';
        if (materiau) html += '<p class="text-xs"><span class="text-gray-400">Matériau :</span> <span class="font-bold text-gray-700">' + materiau + '</span></p>';
        if (ip)       html += '<p class="text-xs"><span class="text-gray-400">Protection :</span> <span class="font-black text-bals-blue">' + ip + '</span></p>';
        html += '</div>';
    }

    // --- CORRECTION : Bloc prises (section 03) ---
    // Dans l'original, ce bloc n'existait pas. Les prises configurées
    // n'apparaissaient donc jamais dans le résumé.
    if (prises.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Prises :</p>';

        prises.forEach(function(p) {
            // On affiche sur une ligne : type + brochage (si différent de —) + quantité + tension
            const brochageLabel = (p.brochage && p.brochage !== '—') ? ' ' + p.brochage : '';
            const tensionLabel  = p.tension ? ' <span class="text-bals-blue font-bold">' + p.tension + '</span>' : '';

            html += '<p class="text-xs text-gray-700 font-bold">'
                  + '× ' + p.qte + ' — ' + p.type + brochageLabel
                  + tensionLabel
                  + '</p>';
        });

        html += '</div>';
    }

    // --- Bloc protection de tête ---
    if (protTeteCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection de tête :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protTeteCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // --- Bloc protection des prises ---
    if (protPrisesCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection des prises :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protPrisesCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // --- Bloc observations (tronqué à 80 caractères dans le résumé) ---
    if (observations.trim()) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Observations :</p>';
        html += '<p class="text-xs text-gray-600 italic">'
              + observations.substring(0, 80)
              + (observations.length > 80 ? '…' : '')
              + '</p>';
        html += '</div>';
    }

    html += '</div>';

    // Injection du résumé dans le DOM
    zoneResume.innerHTML = html;

    // Affiche les boutons Copier / Envoyer dès qu'il y a du contenu
    document.getElementById('boutons-action').classList.remove('hidden');
}


// ================================================================
// 6. COPIER LE RÉSUMÉ DANS LE PRESSE-PAPIER
//
// copierResume() :
//   Construit un texte récapitulatif complet (toutes les sections)
//   et le copie dans le presse-papier via l'API navigator.clipboard.
//
// CORRECTION :
//   Dans l'original, seuls 4 champs étaient inclus (distributeur, email,
//   montage, IP). Tous les autres champs (contact, installateur, matériau,
//   prises, protections, observations) étaient ignorés, rendant la copie
//   inutilisable pour produire un vrai devis.
//   On utilise lirePrises() pour inclure les prises dans le texte copié.
// ================================================================
function copierResume() {

    // Lecture de tous les champs nécessaires au texte complet
    const distributeur   = document.getElementById('distributeur').value.trim();
    const contactDist    = document.getElementById('contact_distributeur').value.trim();
    const installateur   = document.getElementById('installateur').value.trim();
    const contactInst    = document.getElementById('contact_installateur').value.trim();
    const affaire        = document.getElementById('affaire').value.trim();
    const telephone      = document.getElementById('telephone').value.trim();
    const email          = document.getElementById('email').value.trim();
    const montageEl      = document.querySelector('input[name="montage"]:checked');
    const materiauEl     = document.querySelector('input[name="materiau"]:checked');
    const ipEl           = document.querySelector('input[name="ip"]:checked');
    const observations   = document.getElementById('observations').value.trim();

    const montage        = montageEl  ? montageEl.value  : 'N/A';
    const materiau       = materiauEl ? materiauEl.value : 'N/A';
    const ip             = ipEl       ? ipEl.value       : 'N/A';

    const prises = lirePrises();

    const protTeteCoches = Array.from(
        document.querySelectorAll('input[name="prot_tete[]"]:checked')
    ).map(function(el) { return el.value; });

    const protPrisesCoches = Array.from(
        document.querySelectorAll('input[name="prot_prises[]"]:checked')
    ).map(function(el) { return el.value; });

    // Construction du texte ligne par ligne
    let lignes = [
        '=== DEVIS BALS ÉVÉNEMENTIEL ===',
        '',
        '-- CONTACT --',
        'Distributeur      : ' + (distributeur  || 'N/A'),
        'Contact dist.     : ' + (contactDist   || 'N/A'),
        'Installateur      : ' + (installateur  || 'N/A'),
        'Contact inst.     : ' + (contactInst   || 'N/A'),
        'Référence affaire : ' + (affaire        || 'N/A'),
        'Téléphone         : ' + (telephone     || 'N/A'),
        'Email             : ' + (email         || 'N/A'),
        '',
        '-- CARACTÉRISTIQUES --',
        'Montage   : ' + montage,
        'Matériau  : ' + materiau,
        'IP        : ' + ip,
        '',
    ];

    // Section prises : une ligne par référence configurée
    if (prises.length > 0) {
        lignes.push('-- PRISES --');
        prises.forEach(function(p) {
            const brochageLabel = (p.brochage && p.brochage !== '—') ? ' ' + p.brochage : '';
            const tensionLabel  = p.tension ? ' / ' + p.tension : '';
            lignes.push('x' + p.qte + '  ' + p.type + brochageLabel + tensionLabel);
        });
        lignes.push('');
    }

    if (protTeteCoches.length > 0) {
        lignes.push('-- PROTECTION DE TÊTE --');
        lignes.push(protTeteCoches.join(', '));
        lignes.push('');
    }

    if (protPrisesCoches.length > 0) {
        lignes.push('-- PROTECTION DES PRISES --');
        lignes.push(protPrisesCoches.join(', '));
        lignes.push('');
    }

    if (observations) {
        lignes.push('-- OBSERVATIONS --');
        lignes.push(observations);
        lignes.push('');
    }

    lignes.push('================================');

    const texte = lignes.join('\n');

    // Copie dans le presse-papier via l'API moderne (nécessite HTTPS ou localhost)
    navigator.clipboard.writeText(texte).then(function() {
        alert('Résumé copié dans le presse-papier !');
    }).catch(function() {
        // Fallback si l'API clipboard n'est pas disponible (contexte non sécurisé)
        alert('Impossible de copier automatiquement. Veuillez copier manuellement le résumé.');
    });
}


// ================================================================
// 7. ENVOI DU DEVIS PAR EMAIL
//
// envoyerDevis() :
//   Ouvre le client mail de l'utilisateur avec un objet et un corps
//   pré-remplis contenant TOUTES les informations du configurateur.
//
// CORRECTION :
//   Dans l'original, le corps de l'email ne contenait que le nom du
//   distributeur et un texte générique. Aucune donnée technique
//   (prises, IP, matériau, protections...) n'était incluse, rendant
//   l'email inutilisable directement par l'équipe BALS.
//   On réutilise la même logique que copierResume() pour construire
//   un corps d'email complet.
// ================================================================
function envoyerDevis() {

    const distributeur   = document.getElementById('distributeur').value.trim();
    const contactDist    = document.getElementById('contact_distributeur').value.trim();
    const installateur   = document.getElementById('installateur').value.trim();
    const contactInst    = document.getElementById('contact_installateur').value.trim();
    const affaire        = document.getElementById('affaire').value.trim();
    const telephone      = document.getElementById('telephone').value.trim();
    const email          = document.getElementById('email').value.trim();
    const montageEl      = document.querySelector('input[name="montage"]:checked');
    const materiauEl     = document.querySelector('input[name="materiau"]:checked');
    const ipEl           = document.querySelector('input[name="ip"]:checked');
    const observations   = document.getElementById('observations').value.trim();

    const montage   = montageEl  ? montageEl.value  : 'N/A';
    const materiau  = materiauEl ? materiauEl.value : 'N/A';
    const ip        = ipEl       ? ipEl.value       : 'N/A';

    const prises = lirePrises();

    const protTeteCoches = Array.from(
        document.querySelectorAll('input[name="prot_tete[]"]:checked')
    ).map(function(el) { return el.value; });

    const protPrisesCoches = Array.from(
        document.querySelectorAll('input[name="prot_prises[]"]:checked')
    ).map(function(el) { return el.value; });

    // Construction de l'objet de l'email
    const sujet = 'Demande de devis Coffret Événementiel'
                + (distributeur ? ' — ' + distributeur : '')
                + (affaire      ? ' / Aff. ' + affaire  : '');

    // Construction du corps de l'email
    let lignes = [
        'Bonjour,',
        '',
        'Veuillez trouver ci-dessous ma demande de devis pour un Coffret Événementiel BALS.',
        '',
        '=== CONTACT ===',
        'Distributeur      : ' + (distributeur  || 'N/A'),
        'Contact dist.     : ' + (contactDist   || 'N/A'),
        'Installateur      : ' + (installateur  || 'N/A'),
        'Contact inst.     : ' + (contactInst   || 'N/A'),
        'Référence affaire : ' + (affaire        || 'N/A'),
        'Téléphone         : ' + (telephone     || 'N/A'),
        'Email de retour   : ' + (email         || 'N/A'),
        '',
        '=== CARACTÉRISTIQUES TECHNIQUES ===',
        'Type de montage : ' + montage,
        'Matériau        : ' + materiau,
        'Indice IP       : ' + ip,
        '',
    ];

    // Ajout des prises si au moins une a été configurée
    if (prises.length > 0) {
        lignes.push('=== PRISES SOUHAITÉES ===');
        prises.forEach(function(p) {
            const brochageLabel = (p.brochage && p.brochage !== '—') ? ' ' + p.brochage : '';
            const tensionLabel  = p.tension ? ' / ' + p.tension : ' / tension non précisée';
            lignes.push('x' + p.qte + '  ' + p.type + brochageLabel + tensionLabel);
        });
        lignes.push('');
    }

    if (protTeteCoches.length > 0) {
        lignes.push('=== PROTECTION DE TÊTE ===');
        lignes.push(protTeteCoches.join(', '));
        lignes.push('');
    }

    if (protPrisesCoches.length > 0) {
        lignes.push('=== PROTECTION DES PRISES ===');
        lignes.push(protPrisesCoches.join(', '));
        lignes.push('');
    }

    if (observations) {
        lignes.push('=== OBSERVATIONS ===');
        lignes.push(observations);
        lignes.push('');
    }

    lignes.push('Cordialement,');
    lignes.push(distributeur || 'Le demandeur');

    const corps = lignes.join('\n');

    // Ouverture du client mail avec subject et body encodés
    window.location.href = 'mailto:info@bals-france.fr'
        + '?subject=' + encodeURIComponent(sujet)
        + '&body='    + encodeURIComponent(corps);
}


// ================================================================
// 8. RÉINITIALISATION DU FORMULAIRE
//
// reinitialiser() :
//   Remet tous les champs du formulaire à leur état initial (vide / décoché).
//
// CORRECTION :
//   L'original contenait un bug qui affectait des valeurs arbitraires (1 et 3)
//   à certaines quantités de prises via un sélecteur CSS fragile
//   (td:nth-child(2) span), ce qui :
//     1. Ne correspondait à aucune logique métier documentée
//     2. Pouvait sélectionner les mauvaises cellules selon l'ordre du DOM
//     3. Laissait toutes les autres prises à des valeurs non réinitialisées
//
//   CORRECTION : on remet TOUS les spans de quantité à 0 via data-type,
//   ce qui est cohérent avec l'état initial défini dans le HTML (value="0").
//   On remet également tous les selects de tension à leur valeur par défaut ("").
// ================================================================
function reinitialiser() {

    // Vider les champs texte / email / tel / textarea
    ['distributeur', 'contact_distributeur', 'installateur', 'contact_installateur',
     'affaire', 'telephone', 'email', 'observations'].forEach(function(id) {
        document.getElementById(id).value = '';
    });

    // Décocher tous les radio et checkbox
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function(input) {
        input.checked = false;
    });

    // CORRECTION : remettre TOUTES les quantités de la section 03 à 0.
    // On cible précisément les spans avec data-type dans la section 03,
    // sans dépendre de leur position dans le DOM (plus robuste).
    document.querySelectorAll('#section-s3 span[data-type]').forEach(function(span) {
        span.textContent = '0';
    });

    // CORRECTION : remettre tous les selects de tension à la valeur vide
    document.querySelectorAll('#section-s3 select[data-field="tension"]').forEach(function(sel) {
        sel.value = '';
    });

    // Remettre le compteur de caractères à zéro
    document.getElementById('nb-caracteres').textContent = '0';

    // Rafraîchir le résumé (qui va revenir à l'état vide)
    mettreAJour();
}


// ================================================================
// 9. INITIALISATION AU CHARGEMENT DE LA PAGE
//
// On appelle mettreAJour() une première fois pour s'assurer que
// le résumé et la progression sont correctement initialisés même si
// des champs avaient des valeurs pré-remplies (via l'historique du
// navigateur par exemple).
// ================================================================
document.addEventListener('DOMContentLoaded', function() {
    mettreAJour();
});

</script>
@endsection