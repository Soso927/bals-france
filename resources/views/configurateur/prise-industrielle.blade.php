{{-- ============================================================ --}}
{{-- FICHIER : resources/views/configurateur/prise-industrielle.blade.php --}}
{{-- RÔLE    : Page configurateur Prises Industrielles BALS       --}}
{{-- ============================================================ --}}
@extends('layouts.app')

@section('subtitle', 'Prises Industrielles BALS')

@section('content')

<div class="flex min-h-screen gap-6 p-6 max-w-7xl mx-auto">

    {{-- ========================================================== --}}
    {{-- COLONNE GAUCHE : Formulaire principal                       --}}
    {{-- ========================================================== --}}
    <div class="flex-1 flex flex-col gap-5">

        {{-- ENTÊTE --}}
        <div class="text-center py-4">
            <div class="flex justify-center mb-3">
                 {{-- Placeholder Logo --}}
                 <div class="flex items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                        <rect x="0" y="2"  width="22" height="7" fill="#009EE3"/>
                        <rect x="12" y="11" width="24" height="7" fill="#DA291C"/>
                        <rect x="0" y="20" width="22" height="7" fill="#009EE3"/>
                        <rect x="12" y="29" width="24" height="7" fill="#DA291C"/>
                    </svg>
                    <span class="text-3xl font-black text-bals-blue ml-1">Bals</span>
                </div>
            </div>
            <h1 class="text-3xl font-black text-gray-800">Configurateur de Prises</h1>
            <p class="text-gray-400 font-medium mt-1">Prises Industrielles (NF EN 60 309-1/2)</p>
            <div class="h-1 bg-bals-blue rounded-full mt-4 max-w-lg mx-auto"></div>
        </div>

        {{-- Navigation entre types de coffrets --}}
        @include('configurateur.partials.nav-type')

        {{-- BARRE DE PROGRESSION --}}
        <div class="bg-white rounded-2xl px-6 py-4 shadow-sm border border-gray-100">
            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2">
                Progression <span id="progression-texte" class="text-bals-blue">(0%)</span>
            </p>
            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                <div id="progression-barre" class="h-full bg-bals-blue rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- SECTION 01 : INFORMATIONS DE CONTACT                   --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer" onclick="toggleSection('s1')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">01</span>
                    <span class="font-bold text-lg">Informations de Contact</span>
                </div>
                <span id="arrow-s1" class="text-white text-lg transition-transform duration-300">▲</span>
            </div>
            <div id="section-s1" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Société / Distributeur</label>
                    <input type="text" id="societe" oninput="mettreAJour()" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue" placeholder="Nom de la société">
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact</label>
                    <input type="text" id="contact" oninput="mettreAJour()" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue" placeholder="Nom du contact">
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Installateur</label>
                    <input type="text" id="installateur" oninput="mettreAJour()" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue" placeholder="Nom de l'installateur">
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Affaire</label>
                    <input type="text" id="affaire" oninput="mettreAJour()" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue" placeholder="Référence affaire">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" oninput="mettreAJour()" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue" placeholder="contact@exemple.fr">
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- SECTION 02 : TYPE DE PRODUIT                           --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer" onclick="toggleSection('s2')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">02</span>
                    <span class="font-bold text-lg">Type de Produit</span>
                </div>
                <span id="arrow-s2" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>
            
            <div id="section-s2" class="hidden p-6 flex flex-col gap-6">
                
                {{-- Choix principal : Socle, Fiche, Prolongateur --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Famille de produit <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach(['Socle de prise', 'Prolongateur', 'Fiche', 'Socle connecteur'] as $prod)
                        <label class="cursor-pointer group">
                            <input type="radio" name="produit" value="{{ $prod }}" class="peer sr-only" onchange="gererTypeProduit(); mettreAJour()">
                            <div class="h-full border-2 border-gray-200 rounded-xl p-4 text-center peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue transition-all">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg mx-auto mb-2 text-gray-400 flex items-center justify-center group-hover:bg-white group-hover:text-bals-blue transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <span class="text-xs font-black uppercase leading-tight text-gray-700">{{ $prod }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Choix secondaire : Montage (uniquement si Socle ou Connecteur) --}}
                <div id="zone-montage" class="hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Type de montage</label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach(['Saillie', 'Tableau droit', 'Tableau incliné'] as $montage)
                        <label class="cursor-pointer">
                            <input type="radio" name="montage_type" value="{{ $montage }}" class="peer sr-only" onchange="mettreAJour()">
                            <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue transition-all">
                                <span class="text-xs font-bold text-gray-700">{{ $montage }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- SECTION 03 : TENSION ET FRÉQUENCE                      --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer" onclick="toggleSection('s3')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">03</span>
                    <span class="font-bold text-lg">Tension & Fréquence</span>
                </div>
                <span id="arrow-s3" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>

            <div id="section-s3" class="hidden p-6 space-y-6">
                
                {{-- Très Basse Tension (TBT) < 50V --}}
                <div>
                    <p class="text-xs font-bold uppercase text-gray-400 mb-2">Très Basse Tension (< 50V)</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        @php
                            $tbt = [
                                ['v' => '24V', 'c' => 'bg-purple-600', 'hz' => '50-60Hz', 'text' => 'text-white'],
                                ['v' => '42V', 'c' => 'bg-white border-2 border-gray-300', 'hz' => '50-60Hz', 'text' => 'text-gray-800'],
                                ['v' => 'CC', 'c' => 'bg-white border-2 border-gray-300', 'hz' => 'Courant Continu', 'text' => 'text-gray-800'],
                            ];
                        @endphp
                        @foreach($tbt as $item)
                        <label class="cursor-pointer">
                            <input type="radio" name="tension" value="{{ $item['v'] }}" class="peer sr-only" onchange="mettreAJour()">
                            <div class="border border-gray-200 rounded-lg overflow-hidden peer-checked:ring-2 peer-checked:ring-bals-blue transition-all">
                                <div class="{{ $item['c'] }} h-3 w-full"></div>
                                <div class="p-2 text-center">
                                    <div class="font-black text-sm {{ isset($item['text']) ? '' : 'text-gray-800' }}">{{ $item['v'] }}</div>
                                    <div class="text-[9px] text-gray-400 leading-tight">{{ $item['hz'] }}</div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Basse Tension (BT) > 50V --}}
                <div>
                    <p class="text-xs font-bold uppercase text-gray-400 mb-2">Basse Tension (> 50V)</p>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                        @php
                            $bt = [
                                ['v' => '110V', 'c' => 'bg-yellow-400', 'hz' => '50-60Hz'],
                                ['v' => '230V', 'c' => 'bg-blue-500', 'hz' => '50-60Hz'],
                                ['v' => '400V', 'c' => 'bg-red-600', 'hz' => '50-60Hz'],
                                ['v' => '500V', 'c' => 'bg-black', 'hz' => '50-60Hz'],
                                ['v' => '>50V', 'c' => 'bg-green-600', 'hz' => '100-300Hz'],
                                ['v' => '>50V', 'c' => 'bg-green-600', 'hz' => '300-500Hz'],
                            ];
                        @endphp
                        @foreach($bt as $item)
                        <label class="cursor-pointer">
                            <input type="radio" name="tension" value="{{ $item['v'] }} ({{$item['hz']}})" class="peer sr-only" onchange="mettreAJour()">
                            <div class="border border-gray-200 rounded-lg overflow-hidden peer-checked:ring-2 peer-checked:ring-bals-blue transition-all hover:shadow-md">
                                <div class="{{ $item['c'] }} h-3 w-full"></div>
                                <div class="p-2 text-center">
                                    <div class="font-black text-sm text-gray-800">{{ $item['v'] }}</div>
                                    <div class="text-[9px] text-gray-400 leading-tight">{{ $item['hz'] }}</div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                         {{-- Tension Libre --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="tension" value="Tension libre" class="peer sr-only" onchange="mettreAJour()">
                            <div class="h-full border border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center p-2 peer-checked:bg-gray-50 peer-checked:border-bals-blue peer-checked:border-solid">
                                <span class="text-[10px] font-black uppercase text-gray-500">Autre / Libre</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- SECTION 04 : AMPÉRAGE & POLARITÉ                       --}}
        {{-- ====================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Ampérage --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-bals-blue text-white px-6 py-3 font-bold text-sm uppercase">Intensité</div>
                <div class="p-4 grid grid-cols-2 gap-2">
                    @foreach(['16A', '32A', '63A', '125A'] as $amp)
                    <label class="cursor-pointer">
                        <input type="radio" name="amp" value="{{ $amp }}" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border border-gray-200 rounded-lg p-3 text-center peer-checked:bg-blue-50 peer-checked:border-bals-blue peer-checked:text-bals-blue font-bold text-gray-600 transition-all">
                            {{ $amp }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Polarité --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-bals-blue text-white px-6 py-3 font-bold text-sm uppercase">Polarité</div>
                <div class="p-4 grid grid-cols-2 gap-2">
                    @foreach(['2P', '2P+T', '3P', '3P+T', '3P+N+T'] as $pol)
                    <label class="cursor-pointer">
                        <input type="radio" name="pol" value="{{ $pol }}" class="peer sr-only" onchange="mettreAJour()">
                        <div class="border border-gray-200 rounded-lg p-3 text-center peer-checked:bg-blue-50 peer-checked:border-bals-blue peer-checked:text-bals-blue font-bold text-gray-600 text-xs transition-all">
                            {{ $pol }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- SECTION 05 : INDICE DE PROTECTION (IP)                 --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer" onclick="toggleSection('s5')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">05</span>
                    <span class="font-bold text-lg">Indice de Protection</span>
                </div>
                <span id="arrow-s5" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>
            <div id="section-s5" class="hidden p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach(['IP44' => 'Contre corps >1mm & projections.', 'IP54' => 'Contre poussière & projections.', 'IP67' => 'Étanche & immersion temporaire.'] as $val => $desc)
                    <label class="cursor-pointer h-full">
                        <input type="radio" name="ip" value="{{ $val }}" class="peer sr-only" onchange="mettreAJour()">
                        <div class="h-full border-2 border-gray-200 rounded-xl p-4 flex flex-col justify-between peer-checked:border-bals-blue peer-checked:bg-blue-50 transition-all hover:border-gray-300">
                            <div>
                                <span class="block text-2xl font-black text-gray-800 mb-1">{{ $val }}</span>
                                <span class="text-xs text-gray-500 block leading-snug">{{ $desc }}</span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- SECTION 06 : QUANTITÉ ET OBSERVATIONS                  --}}
        {{-- ====================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer" onclick="toggleSection('s6')">
                <div class="flex items-center gap-3">
                    <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">06</span>
                    <span class="font-bold text-lg">Détails & Quantité</span>
                </div>
                <span id="arrow-s6" class="text-white text-lg transition-transform duration-300">▼</span>
            </div>
            <div id="section-s6" class="hidden p-6 space-y-4">
                
                {{-- Quantité --}}
                <div class="flex items-center gap-4">
                    <label class="font-bold text-gray-700">Quantité souhaitée :</label>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="changerQteGlobale(-1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 font-bold">-</button>
                        <input type="number" id="quantite" value="1" min="1" class="w-16 text-center border border-gray-200 rounded-lg p-1 font-bold" oninput="mettreAJour()">
                        <button type="button" onclick="changerQteGlobale(1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 font-bold">+</button>
                    </div>
                </div>

                {{-- Observations --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Observations / Commentaires</label>
                    <textarea id="observations" rows="4" oninput="mettreAJour()" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue bg-gray-50" placeholder="Précisions supplémentaires..."></textarea>
                </div>
            </div>
        </div>

    </div>

    {{-- ========================================================== --}}
    {{-- COLONNE DROITE : RÉSUMÉ (STICKY)                           --}}
    {{-- ========================================================== --}}
    <div class="w-80 flex flex-col gap-4" style="position: sticky; top: 24px; align-self: flex-start;">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="font-black text-gray-800 text-lg">Votre Configuration</h2>
                <p class="text-xs text-gray-400">Synthèse du devis</p>
            </div>
            
            <div id="resume-zone" class="p-5 min-h-40 flex flex-col items-center justify-center text-center">
                <p class="text-bals-blue font-bold text-sm opacity-40">En attente de saisie...</p>
            </div>
        </div>

        {{-- Boutons d'action --}}
        <div id="boutons-action" class="hidden flex flex-col gap-2">
            <div class="flex gap-2">
                <button onclick="reinitialiser()" class="w-12 h-10 rounded-xl border-2 border-red-100 text-red-400 hover:bg-red-50 flex items-center justify-center font-bold transition-all" title="Réinitialiser">✕</button>
                <button onclick="copierResume()" class="flex-1 h-10 rounded-xl border-2 border-gray-200 text-gray-600 hover:bg-gray-50 font-bold text-sm flex items-center justify-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                    Copier
                </button>
                <button onclick="envoyerDevis()" class="flex-1 h-10 rounded-xl bg-bals-blue text-white font-bold text-sm flex items-center justify-center gap-2 hover:bg-blue-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Envoyer
                </button>
            </div>
             <p class="text-center text-xs text-gray-400">Email : info@bals-france.fr</p>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
/**
 * GESTION DYNAMIQUE DU FORMULAIRE PRISE INDUSTRIELLE
 */

// 1. GESTION DE L'ACCORDÉON
function toggleSection(id) {
    const section = document.getElementById('section-' + id);
    const arrow = document.getElementById('arrow-' + id);
    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden');
        arrow.textContent = '▲';
    } else {
        section.classList.add('hidden');
        arrow.textContent = '▼';
    }
}

// 2. LOGIQUE MÉTIER
function gererTypeProduit() {
    const produitEl = document.querySelector('input[name="produit"]:checked');
    const zoneMontage = document.getElementById('zone-montage');
    
    if (produitEl) {
        const val = produitEl.value;
        if (val.includes('Socle')) {
            zoneMontage.classList.remove('hidden');
        } else {
            zoneMontage.classList.add('hidden');
            document.querySelectorAll('input[name="montage_type"]').forEach(r => r.checked = false);
        }
    }
}

// 3. GESTION QUANTITÉ
function changerQteGlobale(delta) {
    const input = document.getElementById('quantite');
    let val = parseInt(input.value) || 0;
    val += delta;
    if(val < 1) val = 1;
    input.value = val;
    mettreAJour();
}

// 4. MOTEUR DE MISE À JOUR
function mettreAJour() {
    const contact = {
        societe: document.getElementById('societe').value,
        nom: document.getElementById('contact').value,
        email: document.getElementById('email').value,
    };

    const produitEl = document.querySelector('input[name="produit"]:checked');
    const produit = produitEl ? produitEl.value : null;

    const montageEl = document.querySelector('input[name="montage_type"]:checked');
    const montage = montageEl ? montageEl.value : null;

    const tensionEl = document.querySelector('input[name="tension"]:checked');
    const tension = tensionEl ? tensionEl.value : null;

    const ampEl = document.querySelector('input[name="amp"]:checked');
    const amp = ampEl ? ampEl.value : null;

    const polEl = document.querySelector('input[name="pol"]:checked');
    const pol = polEl ? polEl.value : null;

    const ipEl = document.querySelector('input[name="ip"]:checked');
    const ip = ipEl ? ipEl.value : null;

    const qte = document.getElementById('quantite').value;
    const obs = document.getElementById('observations').value;

    // --- CALCUL PROGRESSION ---
    const steps = [
        contact.societe ? 1 : 0,
        contact.email ? 1 : 0,
        produit ? 1 : 0,
        (produit && produit.includes('Socle')) ? (montage ? 1 : 0) : 1, 
        tension ? 1 : 0,
        amp ? 1 : 0,
        pol ? 1 : 0,
        ip ? 1 : 0
    ];
    
    const total = steps.length;
    const filled = steps.reduce((a,b) => a+b, 0);
    const percent = Math.round((filled / total) * 100);

    document.getElementById('progression-barre').style.width = percent + '%';
    document.getElementById('progression-texte').textContent = '(' + percent + '%)';

    // --- GÉNÉRATION HTML RÉSUMÉ ---
    const zone = document.getElementById('resume-zone');
    const btnBox = document.getElementById('boutons-action');

    if (filled === 0 && !obs) {
        zone.innerHTML = '<p class="text-bals-blue font-bold text-sm opacity-40">En attente de saisie...</p>';
        btnBox.classList.add('hidden');
        return;
    }

    let html = '<div class="w-full text-left space-y-3 text-sm">';
    
    if (produit) {
        html += '<div class="bg-bals-blue text-white rounded-lg px-3 py-2 font-bold text-center">' + produit;
        if (montage) html += ' <span class="block text-xs font-normal text-blue-100">' + montage + '</span>';
        html += '</div>';
    }

    if (tension || amp || pol || ip) {
        html += '<div class="bg-gray-50 rounded-lg p-3 border border-gray-100 space-y-1">';
        if (tension) html += '<div class="flex justify-between"><span>Tension:</span> <span class="font-bold text-gray-800">' + tension + '</span></div>';
        if (amp) html += '<div class="flex justify-between"><span>Intensité:</span> <span class="font-bold text-gray-800">' + amp + '</span></div>';
        if (pol) html += '<div class="flex justify-between"><span>Polarité:</span> <span class="font-bold text-gray-800">' + pol + '</span></div>';
        if (ip) html += '<div class="flex justify-between"><span>Protection:</span> <span class="font-black text-bals-blue">' + ip + '</span></div>';
        html += '</div>';
    }

    html += '<div class="text-center font-bold text-gray-700 py-2 border-t border-b border-gray-100">Quantité : ' + qte + '</div>';

    if (contact.societe || contact.email) {
        html += '<div class="text-xs text-gray-500 italic text-center">';
        if(contact.societe) html += contact.societe + '<br>';
        if(contact.email) html += contact.email;
        html += '</div>';
    }

    html += '</div>';
    
    zone.innerHTML = html;
    btnBox.classList.remove('hidden');
}

function copierResume() {
    const resumeText = document.getElementById('resume-zone').innerText;
    navigator.clipboard.writeText("DEMANDE DE PRIX BALS :\n\n" + resumeText).then(() => alert('Résumé copié !'));
}

function envoyerDevis() {
    const soc = document.getElementById('societe').value;
    const resumeText = document.getElementById('resume-zone').innerText;
    const body = encodeURIComponent("Bonjour,\n\nVoici ma configuration :\n\n" + resumeText);
    window.location.href = `mailto:info@bals-france.fr?subject=Devis Prise - ${soc}&body=${body}`;
}

function reinitialiser() {
    location.reload();
}

document.addEventListener('DOMContentLoaded', () => mettreAJour());

</script>
<script src="{{ asset('configurateur/js/configurateur.js') }}"></script>
@endsection