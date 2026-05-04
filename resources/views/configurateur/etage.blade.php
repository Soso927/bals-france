@extends('layouts.configurateur')

@section('title', "Configurateur Coffret d'Étage — BALS")

@section('content')
<div>

    @include('configurateur.partials.header')
    @include('configurateur.partials.nav-type', ['activeType' => 'etage'])
    @include('configurateur.partials.progress-bar')

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-4">

            {{-- SECTION 01 : INFORMATIONS DE CONTACT --}}
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
                        <input type="text" id="distributeur" placeholder="Nom du distributeur" oninput="mettreAJour()"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Contact Distributeur</label>
                        <input type="text" id="contact_distributeur" placeholder="Nom du contact" oninput="mettreAJour()"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Installateur</label>
                        <input type="text" id="installateur" placeholder="Nom de l'installateur" oninput="mettreAJour()"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Contact Installateur</label>
                        <input type="text" id="contact_installateur" placeholder="Nom du contact" oninput="mettreAJour()"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Référence Affaire</label>
                        <input type="text" id="affaire" placeholder="Référence de l'affaire" oninput="mettreAJour()"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Téléphone</label>
                        <input type="tel" id="telephone" placeholder="+33 1 23 45 67 89" oninput="mettreAJour()"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" placeholder="contact@exemple.fr" oninput="mettreAJour()"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50">
                    </div>
                </div>
            </div>

            {{-- SECTION 02 : CARACTÉRISTIQUES TECHNIQUES --}}
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

                    {{-- Type de coffret --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Type de coffret <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
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

                    {{-- Matériaux --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Matériaux <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="materiau" value="Plastique" class="sr-only peer" onchange="mettreAJour()" checked>
                                <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                    <span class="font-bold text-sm text-gray-700">Plastique</span>
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
                {{-- SECTION ALIMENTATION : Tension, Polarité, Raccordement --}}
                {{-- ====================================================== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    {{-- En-tête bleu, plus d'accordéon --}}
                    <div class="bg-bals-blue text-white px-6 py-4 flex items-center gap-3">
                        <span
                            class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">
                            03
                        </span>
                        <span class="font-bold text-lg uppercase tracking-wide">Alimentation</span>
                    </div>

                    {{-- Corps : 3 lignes en style formulaire --}}
                    <div class="divide-y divide-gray-200">

                        {{-- Ligne TENSION --}}
                        <div class="flex items-center px-6 py-4 bg-gray-100">
                            <span class="flex-1 text-xs font-bold text-gray-600 uppercase tracking-widest">
                                Tension
                            </span>
                            <select name="tension"
                                id="alim-tension"
                                onchange="gererInteractiviteTension()"
                                class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-700 w-64 bg-white
               focus:outline-none focus:ring-2 focus:ring-bals-blue">
                                <option value="230V" onchange="mettreAJour()">230V</option>
                                <option value="400V" onchange="mettreAJour()">400V</option>
                                <option value="Tri 230V" onchange="mettreAJour()">TRI 230V</option>

                            </select>
                        </div>

                        {{-- Ligne POLARITE --}}
                        <div class="flex items-center px-6 py-4 bg-gray-50">
                            <span class="flex-1 text-xs font-bold text-gray-600 uppercase tracking-widest">
                                Polarité
                            </span>
                            <select name="polarite"
                                class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-700 w-64 bg-white
                                focus:outline-none focus:ring-2 focus:ring-bals-blue">
                                <option value="2P+T">2P+T</option>
                                <option value="3P+T">3P+T</option>
                                <option value="3P+N+T">3P+N+T</option>
                            </select>
                        </div>

                        {{-- Ligne RACCORDEMENT (dropdown) --}}
                        {{-- Les 5 anciennes sous-sections deviennent des options ici --}}
                        <div class="flex items-center px-6 py-4 bg-gray-100">
                            <span class="flex-1 text-xs font-bold text-gray-600 uppercase tracking-widest">
                                Raccordement
                            </span>
                            <select name="raccordement"
                                class="border border-gray-300 rounded px-3 py-2 text-sm text-gray-700 w-64 bg-white
                       focus:outline-none focus:ring-2 focus:ring-bals-blue">
                                <option value="protection-tete">Protection de Tête</option>
                                <option value="bornier">Bornier</option>
                                <option value="socle-connecteur">Socle Connecteur</option>
                                <option value="cable">Câble</option>
                                <option value="cable-fiche">Câble + Fiche</option>
                            </select>
                        </div>

                    </div>
                </div>

            {{-- SECTION 04 : CARACTÉRISTIQUES TECHNIQUES DES PRISES --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                     onclick="toggleSection('s3')">
                    <div class="flex items-center gap-3">
                        <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">04</span>
                        <span class="font-bold text-lg">Caractéristiques Techniques des prises</span>
                    </div>
                    <span id="arrow-s3" class="text-white text-lg transition-transform duration-300">▼</span>
                </div>
                <div id="section-s3" class="hidden p-6 space-y-6">

                    {{-- Prises NF --}}
                    <div class="rounded-xl border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                            <span class="font-black text-gray-800 text-lg">Prises NF</span>
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
                                            <button type="button" onclick="changerQte(this, -1)" class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">−</button>
                                            <span class="w-10 text-center font-bold text-gray-800 text-sm" data-type="NF" data-brochage="—">0</span>
                                            <button type="button" onclick="changerQte(this, 1)" class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">+</button>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-700 bg-gray-50">
                                            <span>230V</span>
                                            <input type="hidden" data-type="NF" data-brochage="—" data-field="tension" value="230V">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Prises CEI --}}
                    @foreach (['Prises CEI 16A', 'Prises CEI 32A', 'Prises CEI 63A', 'Prises CEI 125A'] as $cei)
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
                                    @foreach (['2P+T', '3P+T', '3P+N+T'] as $brochage)
                                        <tr class="{{ !$loop->last ? 'border-b border-gray-100' : '' }} {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                            <td class="px-5 py-4 font-black text-bals-blue text-sm border-r border-gray-100 w-28">{{ $brochage }}</td>
                                            <td class="px-5 py-4 border-r border-gray-100">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button" onclick="changerQte(this, -1)" class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">−</button>
                                                    <span class="w-10 text-center font-bold text-gray-800 text-sm" data-type="{{ $cei }}" data-brochage="{{ $brochage }}">0</span>
                                                    <button type="button" onclick="changerQte(this, 1)" class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">+</button>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4">
                                                @if ($brochage === '2P+T')
                                                    <div class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-700 bg-gray-50 text-center">
                                                        <span class="font-semibold">230V</span>
                                                        <input type="hidden" data-type="{{ $cei }}" data-brochage="{{ $brochage }}" data-field="tension" value="230V">
                                                    </div>
                                                @else
                                                    <div class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-700 bg-gray-50 text-center">
                                                        <span class="font-semibold">400V</span>
                                                        <input type="hidden" data-type="{{ $cei }}" data-brochage="{{ $brochage }}" data-field="tension" value="400V">
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach

                    {{-- Prise CEI TBT --}}
                    <div class="rounded-xl border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                            <span class="font-black text-bals-blue text-lg">Prise CEI TBT</span>
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
                                @foreach (['2P', '3P'] as $brochage)
                                    <tr class="{{ !$loop->last ? 'border-b border-gray-100' : '' }} {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                        <td class="px-5 py-4 font-black text-bals-blue text-sm border-r border-gray-100 w-28">{{ $brochage }}</td>
                                        <td class="px-5 py-4 border-r border-gray-100">
                                            <div class="flex items-center justify-center gap-2">
                                                <button type="button" onclick="changerQte(this, -1)" class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">−</button>
                                                <span class="w-10 text-center font-bold text-gray-800 text-sm" data-type="CEI TBT" data-brochage="{{ $brochage }}">0</span>
                                                <button type="button" onclick="changerQte(this, 1)" class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-bold">+</button>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-bals-blue"
                                                    data-type="CEI TBT" data-brochage="{{ $brochage }}" data-field="tension" onchange="mettreAJour()">
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

            {{-- SECTION 05 : PROTECTION DE TÊTE --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                     onclick="toggleSection('s4')">
                    <div class="flex items-center gap-3">
                        <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">05</span>
                        <span class="font-bold text-lg">Protection de Tête</span>
                    </div>
                    <span id="arrow-s4" class="text-white text-lg transition-transform duration-300">▼</span>
                </div>
                <div id="section-s4" class="hidden p-6">
                    <p class="text-xs text-gray-400 mb-4 italic">La protection de tête protège l'ensemble du coffret. Elle est placée en amont de toutes les prises.</p>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach ([
                            ['Sans', 'text-gray-700'],
                            ['Interrupteur', 'text-gray-700'],
                            ['Inter différentiel', 'text-gray-700'],
                            ['Disjoncteur', 'text-gray-700'],
                            ['Disjoncteur Diff.', 'text-gray-700'],
                            ["Arrêt d'urgence", 'text-red-600'],
                        ] as [$val, $color])
                            <label class="cursor-pointer {{ $val === 'Par groupe de prises' ? 'col-span-2' : '' }}">
                                <input type="checkbox" name="prot_tete[]" value="{{ $val }}" class="peer sr-only"
                                       onchange="mettreAJour()"
                                       @if(in_array($val, ['Inter différentiel', 'Disjoncteur'])) checked @endif>
                                <div class="border-2 border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all peer-checked:border-bals-blue peer-checked:bg-blue-50 hover:border-bals-blue cursor-pointer">
                                    <div class="w-5 h-5 rounded border-2 border-gray-300 shrink-0"></div>
                                    <span class="text-sm font-bold {{ $color }}">{{ $val }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- SECTION 06 : PROTECTION DES PRISES --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                     onclick="toggleSection('s5')">
                    <div class="flex items-center gap-3">
                        <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">06</span>
                        <span class="font-bold text-lg">Protection des Prises</span>
                    </div>
                    <span id="arrow-s5" class="text-white text-lg transition-transform duration-300">▼</span>
                </div>
                <div id="section-s5" class="hidden p-6">
                    <p class="text-xs text-gray-400 mb-4 italic">La protection des prises protège chaque prise individuellement ou par groupe de prises.</p>
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
                            <input type="checkbox" name="prot_prises[]" value="Disjoncteur" class="peer sr-only" onchange="mettreAJour()" checked>
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

            {{-- SECTION 07 : OBSERVATIONS --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                     onclick="toggleSection('s6')">
                    <div class="flex items-center gap-3">
                        <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">07</span>
                        <span class="font-bold text-lg">Observations</span>
                    </div>
                    <span id="arrow-s6" class="text-white text-lg transition-transform duration-300">▼</span>
                </div>
                <div id="section-s6" class="hidden p-6">
                    <p class="text-xs text-gray-400 mb-4 italic">Ajoutez toute précision utile sur votre installation d'étage (nombre d'étages, besoins spécifiques, contraintes techniques...).</p>
                    <textarea id="observations" name="observations" rows="6"
                              placeholder="Ex : Installation au 3ème étage, besoin de mobilité, nombre de prises par pièce..."
                              oninput="mettreAJour()"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-bals-blue focus:border-transparent transition-all bg-gray-50 resize-y"></textarea>
                    <p class="text-xs text-gray-400 mt-2 text-right"><span id="nb-caracteres">0</span> caractère(s)</p>
                </div>
            </div>

            {{-- SECTION 08 : PIÈCES JOINTES --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-bals-blue text-white px-6 py-4 flex items-center justify-between cursor-pointer"
                     onclick="toggleSection('s7')">
                    <div class="flex items-center gap-3">
                        <span class="bg-white text-bals-blue font-black text-sm w-8 h-8 rounded-lg flex items-center justify-center">08</span>
                        <span class="font-bold text-lg">Pièces Jointes</span>
                    </div>
                    <span id="arrow-s7" class="text-white text-lg transition-transform duration-300">▼</span>
                </div>
                <div id="section-s7" class="hidden p-6">
                    <p class="text-xs text-gray-400 mb-4 italic">Joignez vos plans, schémas ou tout document utile à la configuration (PDF, JPG, PNG — max 10 Mo par fichier).</p>
                    <div id="drop-zone"
                         class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-bals-blue hover:bg-blue-50 transition-all"
                         onclick="document.getElementById('fichiers-input').click()"
                         ondragover="event.preventDefault(); this.classList.add('border-bals-blue','bg-blue-50')"
                         ondragleave="this.classList.remove('border-bals-blue','bg-blue-50')"
                         ondrop="gererDrop(event)">
                        <svg class="mx-auto mb-3 w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                        <p class="text-sm font-bold text-gray-500">Glissez vos fichiers ici</p>
                        <p class="text-xs text-gray-400 mt-1">ou cliquez pour parcourir</p>
                        <input type="file" id="fichiers-input" name="fichiers[]" multiple accept=".pdf,.jpg,.jpeg,.png" class="hidden" onchange="ajouterFichiers(this.files)">
                    </div>
                    <ul id="liste-fichiers" class="mt-4 flex flex-col gap-2"></ul>
                </div>
            </div>

        </div>{{-- fin lg:col-span-2 --}}

        @include('configurateur.partials.panneau-resume')

    </div>{{-- fin grid --}}
</div>
@endsection

@section('scripts')
<script>
    window.COFFRET = { nom: "Coffret d'Étage", type: 'coffret', slug: 'etage' };
</script>
<script src="{{ asset('configurateur/js/configurateur.js') }}"></script>
@endsection
