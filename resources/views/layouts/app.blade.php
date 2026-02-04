<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bals France</title>
    
    {{-- Vite : charge Tailwind CSS et JavaScript --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- ============================================ --}}
    {{-- STYLES POUR LE FORMAT 16:9 --}}
    {{-- ============================================ --}}
    <style>
        /*
            EXPLICATION DU FORMAT 16:9 POUR LE JURY :
            
            Le ratio 16:9 signifie :
            - Largeur = 16 unités
            - Hauteur = 9 unités
            
            Exemple : 1920px × 1080px (Full HD)
            
            On utilise "aspect-ratio: 16 / 9" en CSS
            Le conteneur garde toujours ces proportions.
        */
        
        /* Conteneur principal au format 16:9 */
        .conteneur-16-9 {
            /* Force le ratio 16:9 */
            aspect-ratio: 16 / 9;
            
            /* Ne dépasse jamais l'écran */
            max-height: 100vh;
            max-width: 100vw;
            
            /* Prend toute la largeur disponible */
            width: 100%;
        }
    </style>
</head>

{{-- ============================================ --}}
{{-- BODY : FOND GRIS + CONTENEUR CENTRÉ --}}
{{-- 
    min-h-screen : hauteur minimum = tout l'écran
    flex items-center justify-center : centre le conteneur
    bg-gray-900 : fond gris foncé (visible si écran pas 16:9)
--}}
{{-- ============================================ --}}
<body class="min-h-screen flex items-center justify-center bg-gray-900">

    {{-- ============================================ --}}
    {{-- CONTENEUR PRINCIPAL 16:9 --}}
    {{-- 
        conteneur-16-9 : notre classe CSS personnalisée
        bg-white : fond blanc pour le contenu
        shadow-2xl : ombre pour effet de profondeur
        overflow-hidden : cache ce qui dépasse
        flex flex-col : éléments empilés verticalement
    --}}
    {{-- ============================================ --}}
    <div class="conteneur-16-9 bg-white shadow-2xl overflow-hidden flex flex-col">
        
        {{-- ============================================ --}}
        {{-- HEADER (taille fixe, ne rétrécit pas) --}}
        {{-- flex-shrink-0 : garde sa taille naturelle --}}
        {{-- ============================================ --}}
        <div class="flex-shrink-0">
            <livewire:layout.header />
        </div>

        {{-- ============================================ --}}
        {{-- CONTENU PRINCIPAL --}}
        {{-- 
            flex-grow : prend tout l'espace restant
            overflow-y-auto : scroll si contenu trop grand
        --}}
        {{-- ============================================ --}}
        <main class="flex-grow overflow-y-auto">
            {{ $slot }}
        </main>

        {{-- ============================================ --}}
        {{-- FOOTER (taille fixe, ne rétrécit pas) --}}
        {{-- flex-shrink-0 : garde sa taille naturelle --}}
        {{-- ============================================ --}}
        <div class="flex-shrink-0">
            <livewire:layout.footer />
        </div>
        
    </div>

</body>
</html>