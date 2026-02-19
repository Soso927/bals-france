{{-- ============================================================ --}}
{{-- FICHIER : resources/views/layouts/app.blade.php             --}}
{{-- RÔLE    : Layout principal - structure commune à toutes      --}}
{{--           les pages du configurateur                         --}}
{{-- ============================================================ --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Titre dynamique : chaque page peut définir son propre titre --}}
    <title>@yield('title', 'Configurateur BALS')</title>

    {{-- Google Fonts : police Outfit pour un look professionnel --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"> 

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- Tailwind CSS via CDN (remplacer par Vite en production) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        /*
         * CONFIGURATION TAILWIND
         * On définit les couleurs BALS pour les utiliser dans les classes
         * Exemple : bg-bals-blue, text-bals-red, border-bals-blue
         */
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'bals-blue': '#009EE3',   /* Bleu BALS principal */
                        'bals-red':  '#DA291C',   /* Rouge BALS accentuation */
                    },
                    fontFamily: {
                        'sans': ['Outfit', 'sans-serif'], /* Police par défaut */
                    }
                }
            }
        }
    </script>

    {{-- Styles CSS supplémentaires injectés par chaque page si besoin --}}
    @yield('styles')
</head>

{{-- ============================================================ --}}
{{-- BODY : fond gris clair, police Outfit                        --}}
{{-- ============================================================ --}}
<body class="bg-gray-100 font-sans">

    {{-- ============================================================ --}}
    {{-- CONTENU PRINCIPAL                                            --}}
    {{-- @yield('content') = emplacement réservé pour le contenu     --}}
    {{-- de chaque page enfant qui fait @extends('layouts.app')      --}}
    {{-- ============================================================ --}}
    @yield('content')

    {{-- ============================================================ --}}
    {{-- SCRIPTS JAVASCRIPT                                           --}}
    {{-- @yield('scripts') = chaque page peut ajouter ses scripts    --}}
    {{-- ============================================================ --}}
    @yield('scripts')

</body>
</html>