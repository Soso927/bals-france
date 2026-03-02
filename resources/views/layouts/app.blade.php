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

    {{-- Google Fonts : police Outfit --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'bals-blue': '#009EE3',
                        'bals-red':  '#DA291C',
                    },
                    fontFamily: {
                        'sans': ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- ✅ Alpine.js : nécessaire pour le menu burger et les interactions --}}
    {{-- Doit être en defer et placé AVANT la fermeture du </head>        --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @yield('styles')

    {{-- Livewire styles --}}
    @livewireStyles
</head>

<body class="bg-gray-100 font-sans">

    {{-- ✅ Header Livewire --}}
    @livewire('header')

    {{-- Contenu principal de chaque page --}}
    <main>
        @yield('content')
    </main>

    {{-- ✅ Footer Livewire --}}
    @livewire('footer')

    @yield('scripts')

    {{-- Livewire scripts (toujours en dernier) --}}
    @livewireScripts

</body>
</html>