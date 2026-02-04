{{-- ============================================ --}}
{{-- HEADER BALS FRANCE --}}
{{-- Ressemble à la maquette avec bannière marques + logo + navigation --}}
{{-- ============================================ --}}

<header>
    {{-- ============================================ --}}
    {{-- BANNIÈRE SUPÉRIEURE - MARQUES PARTENAIRES --}}
    {{-- ============================================ --}}
    <div class="bg-white py-3 border-b border-gray-200 rounded-5×1">
        <div class="container mx-auto px-4">
            <div class="flex justify-center items-center">
                {{-- Bannière des marques partenaires --}}
                <img src="{{ asset('images/banniere-partenaire-header.png') }}" alt="Marques Partenaires"
                    class="h-auto max-w-full rounded-lg">
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- SECTION PRINCIPALE - LOGO BALS + CONTACT --}}
    {{-- ============================================ --}}
    <div class="py-6 border-b border-gray-200 rounded-lg"
        style="background-image: url('{{ asset('images/fond-header-banniere.png') }}'); background-size: cover; background-position: center;">
        <div class="container mx-auto px-4">
            <div class="flex justify-center items-center">
                {{-- Logo Bals centré sur l'image de fond --}}
                <img src="{{ asset('images/logo-bals.png') }}" alt="Bals Logo" class="h-16">
            </div>
        </div>
        <div class="bg-white rounded-full px-4 py-2 flex items-center gap-3 shadow-md w-fit">
            <!-- Email section -->
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
                <a href="mailto:Info@bals-france.fr"
                    class="text-gray-800 text-sm font-normal hover:text-gray-600 transition whitespace-nowrap">
                    Info@bals-france.fr
                </a>
            </div>

            <!-- Phone section -->
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                </svg>
                <a href="tel:+33164786080"
                    class="text-gray-800 text-sm font-normal hover:text-gray-600 transition whitespace-nowrap">
                    01 64 78 60 80
                </a>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- NAVIGATION PRINCIPALE - MENU BLEU --}}
    {{-- ============================================ --}}
    <nav class="bg-[#009EE3] text-white shadow-md">
        <div class="container mx-auto px-4">
            <ul class="flex justify-center items-center gap-1">
                {{-- Accueil avec icône maison --}}
                <li>
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-2 px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </a>
                </li>

                {{-- Séparateur --}}
                <li class="text-white/50">|</li>

                {{-- Actualités --}}
                <li>
                    <a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">
                        Actualités
                    </a>
                </li>

                {{-- Séparateur --}}
                <li class="text-white/50">|</li>

                {{-- Qui sommes-nous --}}
                <li>
                    <a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">
                        Qui sommes-nous ?
                    </a>
                </li>

                {{-- Séparateur --}}
                <li class="text-white/50">|</li>

                {{-- Nos gammes --}}
                <li>
                    <a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">
                        Nos gammes
                    </a>
                </li>

                {{-- Séparateur --}}
                <li class="text-white/50">|</li>

                {{-- Téléchargements --}}
                <li>
                    <a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">
                        Téléchargements
                    </a>
                </li>

                {{-- Séparateur --}}
                <li class="text-white/50">|</li>

                {{-- Contact --}}
                <li>
                    <a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">
                        Contact
                    </a>
                </li>

                {{-- Séparateur --}}
                <li class="text-[#DA291C]">|</li>

                {{-- Configurateur avec icône --}}
                <div class="text-[#DA291C]">
                <li>
                    <a href="#"
                        class="flex items-center gap-2 px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">
                        Configurateur
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>
                </div>
            </ul>
        </div>
    </nav>
</header>
