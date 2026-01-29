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
    {{-- SECTION HERO AVEC IMAGE DE FOND --}}
    {{-- ============================================ --}}
    <section class="relative bg-gray-800 text-white">
        {{-- Image de fond (si vous en avez une) --}}
        <div class="absolute inset-0 bg-cover bg-center opacity-40" 
             style="background-image: url('{{ asset('images/hero-background.jpg') }}');">
        </div>
        
        {{-- Contenu par-dessus l'image --}}
        <div class="relative container mx-auto px-4 py-20 text-center">
            {{-- Grand logo Bals --}}
            <img src="{{ asset('images/logo-bals.png') }}" 
                 alt="Bals" 
                 class="h-32 mx-auto mb-8">
            
            {{-- Informations de contact --}}
            <div class="flex justify-center items-center gap-8 text-lg">
                <a href="mailto:info@bals-france.fr" 
                   class="flex items-center gap-2 hover:text-blue-400 transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    info@bals-france.fr
                </a>
                
                <a href="tel:0164786080" 
                   class="flex items-center gap-2 hover:text-blue-400 transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                    </svg>
                    01 64 78 60 80
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- BANDES DIAGONALES BLEUE ET ROUGE --}}
    {{-- ============================================ --}}
    <div class="relative h-64 overflow-hidden bg-white">
        {{-- Bande bleue --}}
        <div class="absolute w-full h-full bg-[#009EE3] transform -skew-y-6 origin-top-left"></div>
        
        {{-- Bande rouge --}}
        <div class="absolute w-full h-full bg-[#ED1C24] transform -skew-y-6 origin-top-left" 
             style="left: 25%; top: 15%;"></div>
    </div>

    {{-- ============================================ --}}
    {{-- INCLUSION DU FOOTER --}}
    {{-- ============================================ --}}
    @include('livewire.layout.footer')

</body>
</html>