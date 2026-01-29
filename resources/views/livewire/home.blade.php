<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bals France - Accueil</title>
    
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    {{-- ============================================ --}}
    {{-- INCLUSION DU HEADER --}}
    {{-- ============================================ --}}
    @include('livewire.layout.header')

    
    {{-- ============================================ --}}
    {{-- INCLUSION DU FOOTER --}}
    {{-- ============================================ --}}
    @include('livewire.layout.footer')

</body>
</html>