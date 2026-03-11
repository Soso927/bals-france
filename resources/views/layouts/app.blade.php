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

     @vite(['resources/css/app.css', 'resources/js/app.js'])



    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


  

    {{-- ✅ Alpine.js : nécessaire pour le menu burger et les interactions --}}
    {{-- Doit être en defer et placé AVANT la fermeture du </head>        --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @yield('styles')

    {{-- Livewire styles --}}
    @livewireStyles
</head>

<body class="bg-gray-100 font-sans">

    

    {{-- ✅ Header Livewire --}}

    {{-- Contenu principal de chaque page --}}
    <main>
        @yield('content')
    </main>

    {{-- ✅ Footer Livewire --}}

    @yield('scripts')

    {{-- Livewire scripts (toujours en dernier) --}}
    @livewireScripts

</body>

</html>
