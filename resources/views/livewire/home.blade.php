<!DOCTYPE html>
<html lang="fr">
<head>
    {{-- ============================================ --}}
    {{-- CONFIGURATION DE BASE DE LA PAGE --}}
    {{-- charset: définit l'encodage des caractères (UTF-8 pour les accents français) --}}
    {{-- viewport: permet au site d'être responsive (adapté aux mobiles) --}}
    {{-- ============================================ --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bals France - Accueil</title>
    
    {{-- Tailwind CSS : framework CSS pour styliser rapidement --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    {{-- ============================================ --}}
    {{-- INCLUSION DU HEADER (en-tête du site) --}}
    {{-- @include permet d'insérer un autre fichier Blade ici --}}
    {{-- ============================================ --}}
    @include('livewire.layout.header')


    <div class="flex items-center justify-center min-h-screen bg-white">
    
    {{-- Conteneur des bandes diagonales --}}
    <div class="relative w-full max-w-4xl h-screen overflow-hidden">
        
        {{-- Bande bleue (gauche) --}}
        <div class="absolute w-64 h-full bg-[#0095DA] transform -skew-x-12 left-1/4"></div>
        
        {{-- Bande rouge (droite) --}}
        <div class="absolute w-64 h-full bg-[#ED1C24] transform -skew-x-12 left-1/2"></div>
        
    </div>

</div>

    {{-- ============================================ --}}
    {{-- BLOC DE NAVIGATION + FOOTER COLLÉS --}}
    {{-- On enlève le margin-top (mt-20) du footer pour qu'ils soient collés --}}
    {{-- ============================================ --}}
    
    {{-- NAVIGATION PRINCIPALE --}}
    {{-- bg-cyan-500 : couleur de fond bleu cyan --}}
    {{-- rounded-full : bords arrondis --}}
    {{-- shadow-lg : ombre portée --}}
    <nav class="bg-cyan-500 rounded-full px-8 py-4 shadow-lg mx-4">
        {{-- flex : disposition en ligne --}}
        {{-- items-start : aligne les éléments en haut --}}
        {{-- justify-between : espace égal entre les éléments --}}
        {{-- gap-6 : espacement de 1.5rem entre chaque élément --}}
        <div class="flex items-start justify-between gap-6">
            
            {{-- Lien Home (Accueil) --}}
            {{-- text-white : texte blanc --}}
            {{-- font-semibold : texte semi-gras --}}
            {{-- hover:opacity-80 : devient légèrement transparent au survol --}}
            {{-- transition : animation fluide --}}
            <a href="#" class="text-white font-semibold hover:opacity-80 transition">
                Home
            </a>

            {{-- Section Actualités avec sous-menus --}}
            {{-- flex-col : disposition en colonne (vertical) --}}
            {{-- gap-1 : petit espacement entre les liens --}}
            <div class="flex flex-col gap-1">
                <a href="#" class="text-white font-semibold hover:opacity-80 transition">
                    Actualités
                </a>
                {{-- text-sm : texte plus petit pour les sous-liens --}}
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Important</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Nouveauté</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Nos réalisations</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Nos vidéos</a>
            </div>

            {{-- Section Qui sommes-nous ? --}}
            <div class="flex flex-col gap-1">
                <a href="#" class="text-white font-semibold hover:opacity-80 transition">
                    Qui sommes-nous ?
                </a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Histoire</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">L'équipe</a>
            </div>

            {{-- Section Nos gammes (produits) --}}
            <div class="flex flex-col gap-1">
                <a href="#" class="text-white font-semibold hover:opacity-80 transition">
                    Nos gammes
                </a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Chantier</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Industrie</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Événementiel</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Urbain</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Prises</a>
            </div>

            {{-- Section Téléchargements --}}
            <div class="flex flex-col gap-1">
                <a href="#" class="text-white font-semibold hover:opacity-80 transition">
                    Téléchargements
                </a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Catalogues</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Brochures</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Formulaires sur mesure</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Fiches technique</a>
            </div>

            {{-- Section Contact --}}
            <div class="flex flex-col gap-1">
                <a href="#" class="text-white font-semibold hover:opacity-80 transition">
                    Contact
                </a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Nous contacter</a>
                <a href="#" class="text-white text-sm hover:opacity-80 transition">Carte interactive</a>
            </div>

            {{-- Lien Configurateur en rouge pour attirer l'attention --}}
            <a href="#" class="text-red-500 font-semibold hover:opacity-80 transition">
                Configurateur
            </a>

            {{-- Bouton de recherche par référence --}}
            {{-- bg-white : fond blanc --}}
            {{-- rounded-full : bouton arrondi --}}
            {{-- flex items-center gap-2 : icône et texte alignés --}}
            <button class="bg-white text-gray-700 px-6 py-2 rounded-full font-medium hover:bg-gray-100 transition flex items-center gap-2">
                {{-- Icône loupe en SVG --}}
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                </svg>
                Référence
            </button>
        </div>
    </nav>

    {{-- ============================================ --}}
    {{-- INCLUSION DU FOOTER (pied de page) --}}
    {{-- Le footer est maintenant collé à la navigation --}}
    {{-- ============================================ --}}
    @include('livewire.layout.footer')

</body>
</html>