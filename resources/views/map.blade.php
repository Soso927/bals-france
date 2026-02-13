<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notre réseau d'agents commerciaux - Bals France</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    {{-- Conteneur principal --}}
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        {{-- En-tête de la page --}}
        <header class="mb-8">
            <h1 class="text-3xl font-light text-gray-700 mb-4">
                Notre réseau d'agents commerciaux
            </h1>
            
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Conseil et assistance
            </h2>
            
            <p class="text-gray-600 leading-relaxed max-w-4xl">
                Notre équipe de représentants locaux se tient à votre disposition pour vous informer des nouveautés, 
                vous déposer une documentation, vous guider dans le choix des matériels et dans la conception de vos 
                coffrets de prises. Pour connaître les coordonnées de votre agent local, nous vous invitons à consulter 
                la liste ci-contre ou à appeler notre service commercial au 01 64 78 60 80 qui se fera un plaisir de vous renseigner.
            </p>
        </header>

        {{-- Grille : Carte + Liste des régions --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- CARTE DE FRANCE (2/3 de la largeur) --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg p-4">
                    {{-- Canvas où Chart.js dessine la carte --}}
                    <div class="relative w-full" style="height: 650px;">
                        <canvas id="france-regions-map"></canvas>
                    </div>
                </div>
            </div>

            {{-- LISTE DES RÉGIONS (1/3 de la largeur) --}}
            <div class="lg:col-span-1">
                <div class="space-y-1">
                    
                    {{-- Chaque région est un bouton cliquable --}}
                    
                    {{-- NORMANDIE --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="NORMANDIE" 
                                style="border-left: 4px solid #0095DA;">
                            <span class="text-sm font-semibold text-gray-800">NORMANDIE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        {{-- Zone des contacts (cachée par défaut) --}}
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Normandie...</p>
                        </div>
                    </div>

                    {{-- BRETAGNE --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="BRETAGNE" 
                                style="border-left: 4px solid #ED1C24;">
                            <span class="text-sm font-semibold text-gray-800">BRETAGNE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Bretagne...</p>
                        </div>
                    </div>

                    {{-- PAYS DE LA LOIRE --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="PAYS DE LA LOIRE" 
                                style="border-left: 4px solid #A855F7;">
                            <span class="text-sm font-semibold text-gray-800">PAYS DE LA LOIRE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Pays de la Loire...</p>
                        </div>
                    </div>

                    {{-- VAL DE LOIRE --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="VAL DE LOIRE" 
                                style="border-left: 4px solid #FFD700;">
                            <span class="text-sm font-semibold text-gray-800">VAL DE LOIRE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Val de Loire...</p>
                        </div>
                    </div>

                    {{-- AUVERGNE-LIMOUSIN --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="AUVERGNE-LIMOUSIN" 
                                style="border-left: 4px solid #1E3A8A;">
                            <span class="text-sm font-semibold text-gray-800">AUVERGNE-LIMOUSIN</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Auvergne-Limousin...</p>
                        </div>
                    </div>

                    {{-- AQUITAINE (1ère occurrence) --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="AQUITAINE" 
                                style="border-left: 4px solid #F97316;">
                            <span class="text-sm font-semibold text-gray-800">AQUITAINE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Aquitaine (zone 1)...</p>
                        </div>
                    </div>

                    {{-- AQUITAINE (2ème occurrence) --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="AQUITAINE" 
                                style="border-left: 4px solid #F97316;">
                            <span class="text-sm font-semibold text-gray-800">AQUITAINE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Aquitaine (zone 2)...</p>
                        </div>
                    </div>

                    {{-- MIDI-PYRENEES (1ère occurrence) --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="MIDI-PYRENEES" 
                                style="border-left: 4px solid #EC4899;">
                            <span class="text-sm font-semibold text-gray-800">MIDI-PYRENEES</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Midi-Pyrénées (zone 1)...</p>
                        </div>
                    </div>

                    {{-- MIDI-PYRENEES (2ème occurrence) --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="MIDI-PYRENEES" 
                                style="border-left: 4px solid #EC4899;">
                            <span class="text-sm font-semibold text-gray-800">MIDI-PYRENEES</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Midi-Pyrénées (zone 2)...</p>
                        </div>
                    </div>

                    {{-- ILE DE FRANCE (1ère occurrence) --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="ILE DE FRANCE" 
                                style="border-left: 4px solid #EF4444;">
                            <span class="text-sm font-semibold text-gray-800">ILE DE FRANCE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Île-de-France (zone 1)...</p>
                        </div>
                    </div>

                    {{-- ILE DE FRANCE (2ème occurrence) --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="ILE DE FRANCE" 
                                style="border-left: 4px solid #EF4444;">
                            <span class="text-sm font-semibold text-gray-800">ILE DE FRANCE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Île-de-France (zone 2)...</p>
                        </div>
                    </div>

                    {{-- ILE DE FRANCE (3ème occurrence) --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="ILE DE FRANCE" 
                                style="border-left: 4px solid #EF4444;">
                            <span class="text-sm font-semibold text-gray-800">ILE DE FRANCE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Île-de-France (zone 3)...</p>
                        </div>
                    </div>

                    {{-- NORD --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="NORD" 
                                style="border-left: 4px solid #3B82F6;">
                            <span class="text-sm font-semibold text-gray-800">NORD</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Nord...</p>
                        </div>
                    </div>

                    {{-- CHAMPAGNE-ARDENNES --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="CHAMPAGNE-ARDENNES" 
                                style="border-left: 4px solid #FACC15;">
                            <span class="text-sm font-semibold text-gray-800">CHAMPAGNE-ARDENNES</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Champagne-Ardennes...</p>
                        </div>
                    </div>

                    {{-- ALSACE LORRAINE --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="ALSACE LORRAINE" 
                                style="border-left: 4px solid #06B6D4;">
                            <span class="text-sm font-semibold text-gray-800">ALSACE LORRAINE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Alsace Lorraine...</p>
                        </div>
                    </div>

                    {{-- BOURGOGNE FRANCHE-COMTE --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="BOURGOGNE FRANCHE-COMTE" 
                                style="border-left: 4px solid #10B981;">
                            <span class="text-sm font-semibold text-gray-800">BOURGOGNE FRANCHE-COMTE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Bourgogne Franche-Comté...</p>
                        </div>
                    </div>

                    {{-- RHONE-ALPES (1ère occurrence) --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="RHONE-ALPES" 
                                style="border-left: 4px solid #8B5CF6;">
                            <span class="text-sm font-semibold text-gray-800">RHONE-ALPES</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Rhône-Alpes (zone 1)...</p>
                        </div>
                    </div>

                    {{-- RHONE-ALPES (2ème occurrence) --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="RHONE-ALPES" 
                                style="border-left: 4px solid #8B5CF6;">
                            <span class="text-sm font-semibold text-gray-800">RHONE-ALPES</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Rhône-Alpes (zone 2)...</p>
                        </div>
                    </div>

                    {{-- RHONE-ALPES (3ème occurrence) --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="RHONE-ALPES" 
                                style="border-left: 4px solid #8B5CF6;">
                            <span class="text-sm font-semibold text-gray-800">RHONE-ALPES</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Rhône-Alpes (zone 3)...</p>
                        </div>
                    </div>

                    {{-- MEDITERRANEE --}}
                    <div class="border border-gray-300">
                        <button class="region-expand-btn w-full flex items-center justify-between px-4 py-2 hover:bg-gray-50 transition-colors" 
                                data-region="MEDITERRANEE" 
                                style="border-left: 4px solid #0E7490;">
                            <span class="text-sm font-semibold text-gray-800">MEDITERRANEE</span>
                            <span class="text-lg font-bold text-gray-600">+</span>
                        </button>
                        <div class="region-contacts hidden px-4 py-2 bg-gray-50 text-sm text-gray-600">
                            <p>Contacts de la région Méditerranée...</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- Pied de page --}}
        <footer class="mt-12 pt-6 border-t border-gray-200 text-center text-sm text-gray-600">
            <p>© Bals France | réalisé par Quall'T Com | Mentions Légales</p>
        </footer>

    </div>
</body>
</html>