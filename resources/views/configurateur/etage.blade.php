{{-- ============================================================ --}}
{{-- FICHIER : resources/views/configurateur/etage.blade.php      --}}
{{-- PRODUIT : COFFRET D'ÉTAGE BALS                                --}}
{{-- RÉFÉRENCE : 510_802 (configuration par défaut)                --}}
{{-- VERSION : CORRIGÉE (4 bugs résolus)                           --}}
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

    🐛 CORRECTIONS APPLIQUÉES :
       - [BUG 1] Bouton actif : classes bleues déplacées sur "Coffret d'Étage"
                 (elles étaient par erreur sur "Coffret Événementiel")
       - [BUG 2] Checkboxes pré-cochées : styles statiques remplacés par
                 peer-checked: pour que reinitialiser() fonctionne visuellement
       - [BUG 3] Spans des quantités : ajout d'attributs data-type/data-brochage
                 précis pour un ciblage fiable dans reinitialiser()
       - [BUG 4] Résumé incomplet : ajout de la lecture et l'affichage
                 des prises sélectionnées dans mettreAJour()
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
    <a href="/" class="absolute left-32 top-24 z-50" title="Accueil">
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
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">
                Type de Coffret
            </p>

            {{-- 
                ✅ CORRECTION BUG 1 :
                Dans la version originale, les classes "border-bals-blue bg-bals-blue text-white"
                (qui donnent l'aspect "bouton actif bleu") étaient appliquées PAR ERREUR sur
                le bouton "Coffret Événementiel" au lieu de "Coffret d'Étage".

                Conséquence JS : mettreAJour() cherche le bouton actif avec
                document.querySelector('.btn-type.bg-bals-blue') → elle trouvait
                "Coffret Événementiel" et l'affichait dans le résumé.

                CORRECTION :
                - Coffret d'Étage  → on ajoute : border-bals-blue bg-bals-blue text-white
                                     on retire : border-gray-200 text-gray-600
                - Coffret Événementiel → on retire : border-bals-blue bg-bals-blue text-white
                                          on ajoute : border-gray-200 text-gray-600 + hover:*
            --}}
            <div class="flex flex-wrap gap-3" id="type-coffret-buttons">

                <a href="{{ route('configurateur.chantier') }}"
                   class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret Chantier">
                    Coffret Chantier
                </a>

                {{-- ✅ BUG 1 CORRIGÉ : "Coffret d'Étage" est maintenant le bouton actif --}}
                <a href="#"
                   class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white cursor-default"
                   data-type="Coffret d'Étage">
                    Coffret d'Étage
                </a>

                <a href="{{ route('configurateur.industrie') }}"
                   class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret Industrie">
                    Coffret Industrie
                </a>

                {{-- ✅ BUG 1 CORRIGÉ : "Coffret Événementiel" n'est plus actif par erreur --}}
                <a href="{{ route('configurateur.evenementiel') }}"
                   class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Coffret Événementiel">
                    Coffret Événementiel
                </a>

                <a href="{{ route('configurateur.prise-industrielle') }}"
                   class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
                   data-type="Prise industrielle">
                    Prise industrielle
                </a>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- 📊 BARRE DE PROGRESSION DU DEVIS                       --}}
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
        {{-- 📋 SECTION 01 : INFORMATIONS DE CONTACT                --}}
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
        {{-- ⚙️ SECTION 02 : CARACTÉRISTIQUES TECHNIQUES GÉNÉRALES --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                 onclick="toggleSection('s2')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">02</span>
                    <span class="font-bold text-lg">Caractéristiques Techniques générales</span>
                </div>
                <span id="arrow-s2" class="text-white text-lg transition-transform duration-300">▲</span>
            </div>

            <div id="section-s2" class="p-6 flex flex-col gap-7">

                {{-- Type de montage --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Type de coffret <span class="text-red-500">*</span>
                    </label>
                    <div class="bg-blue-50 border-l-4 border-bals-blue p-3 mb-3 rounded">
                        <p class="text-xs text-blue-800">
                            <strong>Configuration Coffret d'Étage :</strong>
                            Mobile avec boîtier Plastique - Conçu pour une installation facile et rapide dans les étages.
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-3" id="type-montage">
                        <label class="cursor-pointer">
                            <input type="radio" name="montage" value="Mobile" class="sr-only peer" onchange="mettreAJour()" checked>
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-bold text-sm text-gray-700">Mobile</span>
                                <span class="block text-xs text-bals-blue mt-1">Recommandé</span>
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

                {{-- Matériaux --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Matériaux <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="materiau" value="Plastique" class="sr-only peer" onchange="mettreAJour()" checked>
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 cursor-pointer">
                                <span class="font-bold text-gray-700">Plastique</span>
                                <span class="block text-xs text-bals-blue mt-1">
                                    Matériau standard pour coffrets d'étage - Léger et résistant
                                </span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Indice de Protection --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Indice de Protection (IP) <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="ip" value="IP44" class="sr-only peer" onchange="mettreAJour()" checked>
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-black text-bals-blue">IP44</span>
                                <span class="text-gray-400 text-xs ml-1 block mt-1">Projections d'eau</span>
                                <span class="text-xs text-bals-blue block mt-1">Recommandé</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="ip" value="IP54" class="sr-only peer" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                <span class="font-black text-bals-blue">IP54</span>
                                <span class="text-gray-400 text-xs ml-1 block mt-1">Poussières + projections</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="ip" value="IP67" class="sr-only peer" onchange="mettreAJour()">
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
                                <td class="px-5 py-4 font-bold text-gray-400 text-sm border-r border-gray-100 w-28">10/16A</td>
                                <td class="px-5 py-4 border-r border-gray-100">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="changerQte(this, -1)"
                                            class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">−</button>
                                        {{--
                                            ✅ CORRECTION BUG 3 :
                                            Ajout de data-type="NF" et data-brochage="10-16A"
                                            pour permettre un ciblage précis dans reinitialiser().
                                            Sans ces attributs, le code utilisait spans[0], spans[1]...
                                            ce qui casse dès que la structure du DOM change.
                                        --}}
                                        <span class="w-10 text-center font-bold text-gray-800 text-sm"
                                              data-type="NF"
                                              data-brochage="10-16A">0</span>
                                        <button type="button" onclick="changerQte(this, 1)"
                                            class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">+</button>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    {{--
                                        ✅ CORRECTION TENSION BUG 1 :
                                        Le select NF n'avait pas d'attribut data-brochage.
                                        Sans lui, le sélecteur JS
                                        select[data-type="NF"][data-brochage="10-16A"]
                                        ne trouvait rien et la tension restait vide.
                                        On ajoute data-brochage="10-16A" pour que le JS
                                        puisse faire le lien entre ce select et son span.
                                    --}}
                                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-bals-blue"
                                        data-type="NF"
                                        data-brochage="10-16A"
                                        data-field="tension"
                                        onchange="mettreAJour()">
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
                                            ✅ CORRECTION BUG 3 :
                                            Chaque span reçoit maintenant data-type="{{ $cei }}"
                                            ET data-brochage="{{ $brochage }}" (valeur Blade).
                                            Cela crée des identifiants uniques comme :
                                              data-type="CEI 16A" data-brochage="2P+T"
                                              data-type="CEI 16A" data-brochage="3P+T"
                                            etc. — utilisés par reinitialiser() et mettreAJour().
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
                        <span class="font-black text-bals-blue text-lg">Prise domestiques CEI 24A</span>
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
        {{-- 🛡️ SECTION 04 : PROTECTION DE TÊTE                    --}}
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
                    La protection de tête protège l'ensemble du coffret d'étage contre les surintensités et les défauts d'isolement.
                </p>

                <div class="bg-blue-50 border-l-4 border-bals-blue p-3 mb-4 rounded">
                    <p class="text-xs text-blue-800">
                        <strong>Configuration recommandée (selon PDF) :</strong> Inter différentiel + Disjoncteur
                    </p>
                </div>

                {{--
                    ✅ CORRECTION BUG 2 — CHECKBOXES PROT. DE TÊTE :
                    
                    PROBLÈME ORIGINAL :
                    Les checkboxes pré-cochées (Inter différentiel, Disjoncteur) avaient
                    leurs styles "actifs" (border-bals-blue, bg-blue-50, bg-bals-blue sur l'icône)
                    codés en DUR dans le HTML :
                        <div class="border-2 border-bals-blue bg-blue-50 ...">
                        <div class="w-5 h-5 rounded bg-bals-blue border-2 border-bals-blue ...">
                    
                    CONSÉQUENCE :
                    Quand reinitialiser() exécutait r.checked = false, le CSS changeait bien
                    (peer-checked: disparaissait), MAIS les classes statiques restaient dans le HTML.
                    Visuellement la checkbox semblait toujours cochée même décochée.
                    
                    CORRECTION :
                    Toutes les checkboxes utilisent maintenant UNIQUEMENT peer-checked:
                    pour le style actif. Aucun style "actif" n'est écrit en dur dans le HTML.
                    Tailwind gère le style dynamiquement selon l'état checked/unchecked.
                    
                    RÈGLE À RETENIR :
                    Si un état visuel doit pouvoir changer → utiliser peer-checked:
                    Si un état visuel est permanent → on peut coder en dur
                --}}
                <div class="grid grid-cols-2 gap-3">

                    {{-- Sans protection --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Sans" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 peer-checked:bg-bals-blue peer-checked:border-bals-blue flex-shrink-0 flex items-center justify-center"></div>
                            <span class="text-sm font-bold text-gray-700">Sans</span>
                        </div>
                    </label>

                    {{-- Interrupteur --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Interrupteur" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Interrupteur</span>
                        </div>
                    </label>

                    {{-- ✅ BUG 2 CORRIGÉ : Inter différentiel pré-coché --}}
                    {{-- Style actif géré par peer-checked: (plus de classes en dur) --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Inter différentiel" class="peer sr-only" onchange="mettreAJour()" checked>
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0 flex items-center justify-center peer-checked:bg-bals-blue peer-checked:border-bals-blue">
                                <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700">Inter différentiel ⭐</span>
                        </div>
                    </label>

                    {{-- ✅ BUG 2 CORRIGÉ : Disjoncteur pré-coché --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()" checked>
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0 flex items-center justify-center peer-checked:bg-bals-blue peer-checked:border-bals-blue">
                                <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur ⭐</span>
                        </div>
                    </label>

                    {{-- Disjoncteur différentiel --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_tete[]" value="Disjoncteur Diff." class="peer sr-only" onchange="mettreAJour()">
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0"></div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur Diff.</span>
                        </div>
                    </label>

                    {{-- Arrêt d'urgence --}}
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
                    Protection individuelle ou par groupe pour chaque prise du coffret d'étage.
                </p>

                <div class="bg-blue-50 border-l-4 border-bals-blue p-3 mb-4 rounded">
                    <p class="text-xs text-blue-800">
                        <strong>Configuration recommandée (selon PDF) :</strong> Disjoncteur par prise ou par groupe
                    </p>
                </div>

                {{--
                    ✅ CORRECTION BUG 2 — CHECKBOXES PROT. DES PRISES :
                    Même logique que pour la section 04.
                    Le Disjoncteur pré-coché utilisait des classes statiques en dur.
                    Désormais peer-checked: gère tout dynamiquement.
                --}}
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

                    {{-- ✅ BUG 2 CORRIGÉ : Disjoncteur pré-coché --}}
                    <label class="cursor-pointer">
                        <input type="checkbox" name="prot_prises[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()" checked>
                        <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-300 flex-shrink-0 flex items-center justify-center peer-checked:bg-bals-blue peer-checked:border-bals-blue">
                                <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700">Disjoncteur ⭐</span>
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
        {{-- 📝 SECTION 06 : OBSERVATIONS                           --}}
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
                    Ajoutez toute précision utile sur votre installation d'étage (nombre d'étages, besoins spécifiques, contraintes techniques...).
                </p>

                <textarea
                    id="observations"
                    name="observations"
                    rows="6"
                    placeholder="Ex : Installation au 3ème étage, besoin de mobilité, nombre de prises par pièce, contraintes d'accès..."
                    oninput="mettreAJour()"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50 resize-y">
                </textarea>

                <p class="text-xs text-gray-400 mt-2 text-right">
                    <span id="nb-caracteres">0</span> caractère(s)
                </p>
            </div>
        </div>

    </div>
    {{-- FIN COLONNE GAUCHE --}}

    {{-- ========================================================== --}}
    {{-- 📦 COLONNE DROITE : Résumé + Actions                      --}}
    {{-- ========================================================== --}}
    <div class="w-80 flex flex-col gap-4" style="position: sticky; top: 24px; align-self: flex-start;">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-black text-gray-800 text-lg">Résumé de Configuration</h2>
                <p class="text-xs text-gray-400 mt-0.5">Devis Coffret d'Étage</p>
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
// VERSION CORRIGÉE — 4 bugs résolus
// ================================================================


// ================================================================
// 1️⃣ GESTION DES ACCORDÉONS (sections repliables)
// ================================================================
/**
 * Fonction : toggleSection
 * Rôle : Ouvre ou ferme une section accordéon
 * @param {string} id - ex: 's1', 's2'...
 */
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
// 2️⃣ SÉLECTION DU TYPE DE COFFRET
// ================================================================
/**
 * Gère le style actif/inactif des boutons de type de coffret.
 * Note : le bouton "Coffret d'Étage" a déjà les classes actives
 * dans le HTML (correction BUG 1). Ce code gère les clics suivants.
 */
document.querySelectorAll('.btn-type').forEach(function(btn) {
    btn.addEventListener('click', function() {
        // Désactiver tous les boutons
        document.querySelectorAll('.btn-type').forEach(function(b) {
            b.classList.remove('border-bals-blue', 'bg-bals-blue', 'text-white');
            b.classList.add('border-gray-200', 'text-gray-600');
        });
        // Activer le bouton cliqué
        this.classList.remove('border-gray-200', 'text-gray-600');
        this.classList.add('border-bals-blue', 'bg-bals-blue', 'text-white');

        mettreAJour();
    });
});


// ================================================================
// 3️⃣ CONTRÔLE DES QUANTITÉS (boutons +/-)
// ================================================================
/**
 * Fonction : changerQte
 * @param {HTMLElement} btn  - Le bouton + ou - cliqué
 * @param {number} direction - +1 ou -1
 */
function changerQte(btn, direction) {
    const span = btn.parentElement.querySelector('span');
    let valeur = parseInt(span.textContent);
    valeur += direction;
    if (valeur < 0) valeur = 0;
    span.textContent = valeur;
    mettreAJour();
}


// ================================================================
// 4️⃣ MISE À JOUR DU RÉSUMÉ EN TEMPS RÉEL
// ================================================================
/**
 * Fonction : mettreAJour
 * Rôle : Recalcule la progression et reconstruit le résumé.
 *
 * ✅ CORRECTION BUG 4 :
 * La version originale ne lisait PAS les prises de la section 03.
 * On a ajouté un bloc qui parcourt tous les spans de quantité,
 * lit leur data-type et data-brochage, et les affiche dans le résumé
 * si leur quantité est supérieure à 0.
 */
function mettreAJour() {

    // ── Champs de contact ──────────────────────────────────────
    const distributeur = document.getElementById('distributeur').value;
    const contactDist  = document.getElementById('contact_distributeur').value;
    const installateur = document.getElementById('installateur').value;
    const contactInst  = document.getElementById('contact_installateur').value;
    const affaire      = document.getElementById('affaire').value;
    const telephone    = document.getElementById('telephone').value;
    const email        = document.getElementById('email').value;

    // ── Type de coffret (bouton actif) ─────────────────────────
    // ✅ Fonctionne correctement depuis la correction du BUG 1 :
    // le bon bouton a maintenant la classe bg-bals-blue
    const typeBoutonActif = document.querySelector('.btn-type.bg-bals-blue');
    const typeCoffret = typeBoutonActif ? typeBoutonActif.dataset.type : '';

    // ── Caractéristiques techniques ────────────────────────────
    const montageEl  = document.querySelector('input[name="montage"]:checked');
    const materiauEl = document.querySelector('input[name="materiau"]:checked');
    const ipEl       = document.querySelector('input[name="ip"]:checked');

    const montage  = montageEl  ? montageEl.value  : '';
    const materiau = materiauEl ? materiauEl.value : '';
    const ip       = ipEl       ? ipEl.value       : '';

    // ── Protections ────────────────────────────────────────────
    const protTeteCoches = Array.from(
        document.querySelectorAll('input[name="prot_tete[]"]:checked')
    ).map(function(el) { return el.value; });

    const protPrisesCoches = Array.from(
        document.querySelectorAll('input[name="prot_prises[]"]:checked')
    ).map(function(el) { return el.value; });

    // ── Observations ───────────────────────────────────────────
    const observations = document.getElementById('observations').value;
    document.getElementById('nb-caracteres').textContent = observations.length;

    // ──────────────────────────────────────────────────────────
    // ✅ CORRECTION BUG 4 + CORRECTION TENSION :
    //
    // On parcourt tous les spans qui ont un data-type défini.
    // Pour chaque span avec quantité > 0 :
    //   1. On lit data-type et data-brochage du span
    //   2. On cherche le select de tension correspondant
    //      via le même data-type + data-brochage + data-field="tension"
    //      (possible car la Correction Tension BUG 1 a ajouté
    //       data-brochage="10-16A" sur le select de la carte NF)
    //   3. On construit la ligne : "6x NF / 10-16A — 230V"
    //      Si la tension n'est pas choisie, on ne l'affiche pas
    //      pour éviter un affichage du type "6x NF / 10-16A — --"
    // ──────────────────────────────────────────────────────────
    const prises = [];
    document.querySelectorAll('#section-s3 span[data-type]').forEach(function(span) {
        const qte = parseInt(span.textContent);
        if (qte > 0) {
            const type     = span.dataset.type;     // ex: "NF" ou "CEI 16A"
            const brochage = span.dataset.brochage; // ex: "10-16A" ou "2P+T"

            // ✅ CORRECTION TENSION :
            // On cherche le select qui partage les mêmes data-type et data-brochage.
            // Sans data-brochage sur le select NF (Correction Tension BUG 1),
            // ce querySelector retournait null et la tension ne s'affichait jamais.
            const selectTension = document.querySelector(
                '#section-s3 select[data-type="' + type + '"]'
                + '[data-brochage="' + brochage + '"]'
                + '[data-field="tension"]'
            );

            // Récupère la valeur du select, ou chaîne vide si non trouvé / non choisi
            const tension = selectTension ? selectTension.value : '';

            // Construit la ligne lisible
            // Exemples de résultats :
            //   "6x NF / 10-16A — 230V"      (tension choisie)
            //   "1x CEI 16A / 3P+N+T — 400V" (tension choisie)
            //   "2x CEI 32A / 2P+T"           (tension non choisie → rien après le brochage)
            prises.push(
                qte + 'x ' + type
                + (brochage ? ' / ' + brochage : '')
                + (tension  ? ' — ' + tension  : '') // ← tension ajoutée ici
            );
        }
    });

    // ── Calcul de la progression ───────────────────────────────
    const champs = [
        distributeur              ? 1 : 0,
        contactDist               ? 1 : 0,
        installateur              ? 1 : 0,
        email                     ? 1 : 0,
        typeCoffret               ? 1 : 0,
        montage                   ? 1 : 0,
        materiau                  ? 1 : 0,
        ip                        ? 1 : 0,
        protTeteCoches.length   > 0 ? 1 : 0,
        protPrisesCoches.length > 0 ? 1 : 0,
    ];

    const totalChamps   = champs.length;
    const champsRemplis = champs.reduce(function(a, b) { return a + b; }, 0);
    const pourcentage   = Math.round(champsRemplis / totalChamps * 100);

    document.getElementById('progression-barre').style.width = pourcentage + '%';
    document.getElementById('progression-texte').textContent = '(' + pourcentage + '%)';

    // ── Construction du résumé ─────────────────────────────────
    const zoneResume = document.getElementById('resume-zone');

    if (champsRemplis === 0 && prises.length === 0) {
        zoneResume.innerHTML = '<p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>'
                             + '<p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>';
        document.getElementById('boutons-action').classList.add('hidden');
        return;
    }

    let html = '<div class="w-full text-left space-y-3">';

    // Badge type de coffret
    if (typeCoffret) {
        html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 text-sm font-bold text-center">'
              + typeCoffret + '</div>';
    }

    // Contact
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

    // Caractéristiques techniques
    if (montage || materiau || ip) {
        html += '<div class="border-t border-gray-100 pt-2 space-y-1">';
        if (montage)  html += '<p class="text-xs"><span class="text-gray-400">Montage :</span> <span class="font-bold text-gray-700">' + montage + '</span></p>';
        if (materiau) html += '<p class="text-xs"><span class="text-gray-400">Matériau :</span> <span class="font-bold text-gray-700">' + materiau + '</span></p>';
        if (ip)       html += '<p class="text-xs"><span class="text-gray-400">Protection :</span> <span class="font-black text-bals-blue">' + ip + '</span></p>';
        html += '</div>';
    }

    // ✅ CORRECTION BUG 4 : Affichage des prises dans le résumé
    if (prises.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Prises :</p>';
        prises.forEach(function(p) {
            html += '<p class="text-xs font-bold text-gray-700">• ' + p + '</p>';
        });
        html += '</div>';
    }

    // Protection de tête
    if (protTeteCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection de tête :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protTeteCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // Protection des prises
    if (protPrisesCoches.length > 0) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Protection des prises :</p>';
        html += '<p class="text-xs font-bold text-gray-700">' + protPrisesCoches.join(', ') + '</p>';
        html += '</div>';
    }

    // Observations
    if (observations) {
        html += '<div class="border-t border-gray-100 pt-2">';
        html += '<p class="text-xs text-gray-400 font-bold mb-1">Observations :</p>';
        html += '<p class="text-xs text-gray-600 italic">' + observations.substring(0, 80);
        if (observations.length > 80) html += '...';
        html += '</p></div>';
    }

    html += '</div>';

    zoneResume.innerHTML = html;
    document.getElementById('boutons-action').classList.remove('hidden');
}


// ================================================================
// 5️⃣ BOUTONS D'ACTION
// ================================================================

/**
 * Fonction : copierResume
 * Copie un résumé texte dans le presse-papiers.
 */
function copierResume() {
    const distributeur = document.getElementById('distributeur').value;
    const email        = document.getElementById('email').value;
    const montageEl    = document.querySelector('input[name="montage"]:checked');
    const ipEl         = document.querySelector('input[name="ip"]:checked');

    const texte = 'DEVIS BALS - COFFRET D\'ÉTAGE\n'
                + 'Distributeur : ' + (distributeur || 'N/A') + '\n'
                + 'Email : '        + (email        || 'N/A') + '\n'
                + 'Montage : '      + (montageEl ? montageEl.value : 'N/A') + '\n'
                + 'IP : '           + (ipEl ? ipEl.value : 'N/A');

    navigator.clipboard.writeText(texte).then(function() {
        alert('Résumé copié dans le presse-papiers !');
    });
}

/**
 * Fonction : envoyerDevis
 * Ouvre le client email avec un message pré-rempli.
 */
function envoyerDevis() {
    const distributeur = document.getElementById('distributeur').value;
    const sujet = encodeURIComponent('Demande de devis - Coffret d\'Étage - ' + distributeur);
    const corps = encodeURIComponent('Bonjour,\n\nVeuillez trouver ci-joint ma demande de devis pour un coffret d\'étage.\n\nDistributeur : ' + distributeur);
    window.location.href = 'mailto:info@bals-france.fr?subject=' + sujet + '&body=' + corps;
}

/**
 * Fonction : reinitialiser
 * Remet le formulaire aux valeurs par défaut du PDF 510_802.
 *
 * ✅ CORRECTION BUG 3 :
 * On remplace le ciblage fragile par index (spans[0], spans[1]...)
 * par un ciblage précis via les attributs data-type / data-brochage
 * ajoutés dans le HTML.
 *
 * La fonction setQte() est un helper local qui évite la répétition
 * et rend le code lisible : setQte('NF', '10-16A', 6) est clair,
 * spans[0].textContent = '6' ne l'est pas.
 */
function reinitialiser() {

    // ── Vider les champs texte ─────────────────────────────────
    ['distributeur','contact_distributeur','installateur',
     'contact_installateur','affaire','telephone','email','observations'
    ].forEach(function(id) {
        document.getElementById(id).value = '';
    });

    // ── Décocher tout ──────────────────────────────────────────
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function(r) {
        r.checked = false;
    });

    // ── Recocher les valeurs par défaut ────────────────────────
    document.querySelector('input[name="montage"][value="Mobile"]').checked            = true;
    document.querySelector('input[name="materiau"][value="Plastique"]').checked        = true;
    document.querySelector('input[name="ip"][value="IP44"]').checked                   = true;
    document.querySelector('input[name="prot_tete[]"][value="Inter différentiel"]').checked = true;
    document.querySelector('input[name="prot_tete[]"][value="Disjoncteur"]').checked   = true;
    document.querySelector('input[name="prot_prises[]"][value="Disjoncteur"]').checked = true;

    // ──────────────────────────────────────────────────────────
    // ✅ CORRECTION BUG 3 : Réinitialisation des quantités
    //
    // Helper setQte : cible un span précis via data-type + data-brochage
    // Avantage : si on réorganise le DOM, ça continue de fonctionner.
    //
    // On commence par remettre TOUTES les quantités à 0,
    // puis on applique les valeurs par défaut du PDF 510_802.
    // ──────────────────────────────────────────────────────────

    // Remettre tous les compteurs à 0
    document.querySelectorAll('#section-s3 span[data-type]').forEach(function(span) {
        span.textContent = '0';
    });

    // Helper de ciblage précis
    function setQte(type, brochage, valeur) {
        var span = document.querySelector(
            '#section-s3 span[data-type="' + type + '"][data-brochage="' + brochage + '"]'
        );
        if (span) {
            span.textContent = valeur;
        } else {
            // Message d'avertissement en console si le span est introuvable
            console.warn('setQte : span introuvable pour type="' + type + '" brochage="' + brochage + '"');
        }
    }

    // Valeurs par défaut selon PDF 510_802 :
    setQte('NF',      '10-16A', 6);  // 6x NF 10/16A
    setQte('CEI 16A', '3P+N+T', 1); // 1x CEI 16A / 3P+N+T
    setQte('CEI 32A', '3P+N+T', 1); // 1x CEI 32A / 3P+N+T
    // CEI 63A et CEI 125A restent à 0 (non définis dans le PDF)

    // ── Remettre le compteur de caractères ────────────────────
    document.getElementById('nb-caracteres').textContent = '0';

    mettreAJour();
}


// ================================================================
// 6️⃣ INITIALISATION AU CHARGEMENT DE LA PAGE
// ================================================================
document.addEventListener('DOMContentLoaded', function() {
    mettreAJour();
});

</script>
@endsection