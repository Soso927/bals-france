{{-- ============================================================
     HEADER BALS FRANCE — Version 100% responsive
     ============================================================
     Corrections apportées :
     1. Bannière section : min-h adaptative + padding bottom suffisant
     2. Pilule contact : responsive avec empilement sur très petits écrans
     3. Pilule recherche : pas de débordement sur mobile
     4. Marquee : vitesse et espacement adaptatifs
     5. Navigation mobile : améliorée pour tous écrans
     6. Aucune valeur fixe qui bloque le redimensionnement
     ============================================================ --}}

<header>

    {{-- ============================================================
         BANNIÈRE SUPÉRIEURE — Défilement CSS pur (marquee)
         ============================================================ --}}

    <style>
        /* ── Conteneur du défilement ────────────────────────────── */
        .marquee {
            overflow: hidden;
            background: white;
            border-bottom: 1px #e5e7eb;
            padding: 8px 0;
        }

        @media (min-width: 640px) {
            .marquee {
                padding: 12px 0;
            }
        }

        /* ── Piste de défilement ────────────────────────────────── */
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marquee-scroll 20s linear infinite;
        }

        /* Ralentir sur mobile pour meilleure lisibilité */
        @media (max-width: 639px) {
            .marquee-track {
                animation-duration: 14s;
            }
        }

        .marquee-track:hover {
            animation-play-state: paused;
        }

        /* ── Logos ────────────────────────────────────────────────
           clamp() : hauteur fluide entre les breakpoints.
           360px → ~16px | 768px → ~24px | 1440px → 35px */
        .marquee-track img {
            height: clamp(16px, 3vw, 35px);
            width: auto;
            margin: 0 clamp(8px, 1.8vw, 30px);
            object-fit: contain;
            flex-shrink: 0;
        }

        /* ── Animation ───────────────────────────────────────────── */
        @keyframes marquee-scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* ── Section bannière fond ───────────────────────────────
           L'image source fait 3840 × 681 px → ratio 3840/681.
           aspect-ratio force le conteneur à garder EXACTEMENT
           les proportions de l'image : la hauteur s'adapte
           automatiquement à la largeur de l'écran.
           background-size:100% auto → l'image remplit la largeur
           et conserve sa hauteur proportionnelle.
           Résultat : image toujours affichée en entier, jamais
           rognée, jamais étirée, sur TOUS les écrans. */
        .bals-header-banner {
            position: relative;
            width: 100%;
            aspect-ratio: 3840 / 681;
            background-size: 100% auto;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
        }

        /* ── Pilule contact — positionnement ─────────────────────
           Toujours en bas à gauche, avec marge adaptative. */
        .bals-contact-pill {
            position: absolute;
            bottom: 0.75rem;
            left: 0.75rem;
        }

        @media (min-width: 640px) {
            .bals-contact-pill {
                bottom: 1rem;
                left: 2rem;
            }
        }

        /* ── Pilule contact — contenu ─────────────────────────── */
        .bals-contact-pill-inner {
            background: white;
            border-radius: 9999px;
            padding: 0.375rem 0.625rem;
            display: inline-flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.25rem 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .15);
            max-width: calc(100vw - 1.5rem);
        }

        @media (min-width: 640px) {
            .bals-contact-pill-inner {
                padding: 0.5rem 0.75rem;
                gap: 0.25rem 0.75rem;
            }
        }

        /* Sur très petit écran, passer en colonne
           pour que email + tel ne débordent pas */
        @media (max-width: 359px) {
            .bals-contact-pill-inner {
                flex-direction: column;
                align-items: flex-start;
                border-radius: 0.75rem;
            }
        }

        /* ── Pilule recherche — positionnement ───────────────── */
        .bals-search-pill {
            position: absolute;
            top: 0.5rem;
            right: 0.75rem;
            background: white;
            border-radius: 9999px;
            padding: 0.375rem 0.625rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .15);
            max-width: calc(100vw - 1.5rem);
        }

        @media (min-width: 640px) {
            .bals-search-pill {
                top: 1rem;
                right: 2rem;
                padding: 0.5rem 0.75rem;
            }
        }

        /* ── Champ de recherche ──────────────────────────────── */
        .bals-ref-input {
            width: 6.5rem;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            color: #1f2937;
        }

        .bals-ref-input::placeholder {
            color: #6b7280;
        }

        .bals-ref-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px #009EE3;
        }

        @media (min-width: 640px) {
            .bals-ref-input {
                width: 11rem;
                font-size: 0.8125rem;
            }
        }

        @media (min-width: 768px) {
            .bals-ref-input {
                width: 13rem;
                font-size: 0.875rem;
            }
        }
    </style>

    {{-- ── Marquee logos ──────────────────────────────────────── --}}
    <div class="marquee">
        <div class="marquee-track">
            {{-- Bloc 1 --}}
            <img src="{{ asset('images/banniere1.png') }}" alt="Partenaire 1">
            <img src="{{ asset('images/banniere2.png') }}" alt="Partenaire 2">
            <img src="{{ asset('images/banniere3.png') }}" alt="Partenaire 3">
            <img src="{{ asset('images/banniere4.png') }}" alt="Partenaire 4">
            <img src="{{ asset('images/banniere5.png') }}" alt="Partenaire 5">
            <img src="{{ asset('images/banniere6.png') }}" alt="Partenaire 6">
            <img src="{{ asset('images/banniere7.png') }}" alt="Partenaire 7">
            <img src="{{ asset('images/banniere8.png') }}" alt="Partenaire 8">
            {{-- Bloc 2 : copie pour boucle fluide --}}
            <img src="{{ asset('images/banniere1.png') }}" alt="Partenaire 1">
            <img src="{{ asset('images/banniere2.png') }}" alt="Partenaire 2">
            <img src="{{ asset('images/banniere3.png') }}" alt="Partenaire 3">
            <img src="{{ asset('images/banniere4.png') }}" alt="Partenaire 4">
            <img src="{{ asset('images/banniere5.png') }}" alt="Partenaire 5">
            <img src="{{ asset('images/banniere6.png') }}" alt="Partenaire 6">
            <img src="{{ asset('images/banniere7.png') }}" alt="Partenaire 7">
            <img src="{{ asset('images/banniere8.png') }}" alt="Partenaire 8">
        </div>
    </div>

    {{-- ============================================================
         SECTION LOGO + CONTACT + RECHERCHE
         ============================================================ --}}
    <div class="bals-header-banner" style="background-image: url('{{ asset('images/fond-header-banniere.png') }}');">

        {{-- Logo centré (commenté dans l'original, conservé) --}}
        <div class="container mx-auto px-4">
            <div class="flex justify-center items-center">
                {{-- <img src="{{ asset('images/logo-bals.png') }}" alt="Bals Logo" class="h-12 sm:h-16"> --}}
            </div>
        </div>

        {{-- ── Pilule CONTACT ─────────────────────────────────── --}}
        <div class="bals-contact-pill">
            <div class="bals-contact-pill-inner">
                {{-- Email --}}
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5 text-gray-700 shrink-0" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    <a href="mailto:Info@bals-france.fr"
                        class="text-gray-800 text-[0.6875rem] sm:text-sm font-normal
                              hover:text-gray-600 transition whitespace-nowrap">
                        Info@bals-france.fr
                    </a>
                </div>
                {{-- Téléphone --}}
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5 text-gray-700 shrink-0" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    <a href="tel:+33164786080"
                        class="text-gray-800 text-[0.6875rem] sm:text-sm font-normal
                              hover:text-gray-600 transition whitespace-nowrap">
                        01 64 78 60 80
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Pilule RECHERCHE ───────────────────────────────── --}}
        <div class="bals-search-pill">
            <button id="bals-ref-search-toggle" type="button" aria-expanded="false"
                aria-controls="bals-ref-search-wrap"
                class="flex items-center gap-1.5 sm:gap-2 text-gray-800
                           text-[0.6875rem] sm:text-sm font-normal
                           hover:text-gray-600 transition whitespace-nowrap">
                <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5 text-gray-700 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
                <span class="hidden xs:inline">Référence</span>
            </button>
            <form id="bals-ref-search-wrap" action="#" method="get" class="hidden">
                <input id="bals-ref-search-input" name="reference" type="search" placeholder="Saisir une référence"
                    class="bals-ref-input">
            </form>
        </div>

    </div>{{-- fin section bannière --}}


    {{-- ============================================================
         NAVIGATION
         ============================================================ --}}
    <nav class="bg-[#009EE3] text-white shadow-md">
        <div class="container mx-auto px-4">

            {{-- Menu DESKTOP (md+) --}}
            <ul class="hidden md:flex flex-wrap justify-center items-center gap-0">
                <li>
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-2 px-3 lg:px-4 py-3
                  hover:text-[#DA291C] transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </a>
                </li>
                <li class="hidden lg:flex items-center">
                    <div class="w-[2px] h-5 rounded-full"></div>
                </li>
                <li><a href="#"
                        class="block px-3 lg:px-4 py-3 text-sm lg:text-base hover:text-[#DA291C] transition-colors duration-200">Actualités</a>
                </li>
                <li class="hidden lg:flex items-center">
                    <div class="w-[2px] h-5  rounded-full"></div>
                </li>
                <li><a href="#"
                        class="block px-3 lg:px-4 py-3 text-sm lg:text-base hover:text-[#DA291C] transition-colors duration-200">Qui
                        sommes-nous ?</a></li>
                <li class="hidden lg:flex items-center">
                    <div class="w-[2px] h-5  rounded-full"></div>
                </li>
                <li><a href="#"
                        class="block px-3 lg:px-4 py-3 text-sm lg:text-base hover:text-[#DA291C] transition-colors duration-200">Nos
                        gammes</a></li>
                <li class="hidden lg:flex items-center">
                    <div class="w-[2px] h-5  rounded-full"></div>
                </li>
                <li><a href="#"
                        class="block px-3 lg:px-4 py-3 text-sm lg:text-base hover:text-[#DA291C] transition-colors duration-200">Téléchargements</a>
                </li>
                <li class="hidden lg:flex items-center">
                    <div class="w-[2px] h-5  rounded-full"></div>
                </li>
                <li><a href="#"
                        class="block px-3 lg:px-4 py-3 text-sm lg:text-base hover:text-[#DA291C] transition-colors duration-200">Contact</a>
                </li>
                <li class="hidden lg:flex items-center">
                    <div class="w-[2px] h-5 rounded-full"></div>
                </li>
                <li>
                    <a href="{{ route('configurateur.chantier') }}"
                        class="flex items-center gap-2 px-3 lg:px-4 py-3
                  text-[#DA291C] font-bold text-sm lg:text-base
                  hover:text-white transition-colors duration-200">
                        Configurateur
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                        </svg>
                    </a>
                </li>
            </ul>

            {{-- Barre MOBILE --}}
            <div class="flex md:hidden items-center justify-between py-2">
                <span class="text-white font-semibold text-sm tracking-wide">BALS France</span>
                <button id="bals-burger-btn" aria-label="Ouvrir le menu" aria-expanded="false"
                    aria-controls="bals-menu-mobile"
                    class="w-10 h-10 flex flex-col justify-center items-center gap-[5px]
                               rounded focus:outline-none focus:ring-2 focus:ring-white/50">
                    <span id="bals-line-1" class="block w-6 h-[2px] bg-white rounded"
                        style="transition: transform .3s ease, opacity .3s ease;"></span>
                    <span id="bals-line-2" class="block w-6 h-[2px] bg-white rounded"
                        style="transition: opacity .3s ease;"></span>
                    <span id="bals-line-3" class="block w-6 h-[2px] bg-white rounded"
                        style="transition: transform .3s ease, opacity .3s ease;"></span>
                </button>
            </div>

        </div>

        {{-- Menu mobile déroulant --}}
        <div id="bals-menu-mobile" class="md:hidden bg-[#007bbf] border-t border-white/20 overflow-hidden"
            style="max-height: 0; transition: max-height .35s ease;">
            <div class="container mx-auto px-4 py-3 flex flex-col gap-1">
                <a href="{{ route('home') }}"
                    class="bals-nav-link flex items-center gap-3 px-4 py-3 text-white rounded
                          hover:bg-[#009EE3] transition-colors border-b border-white/10">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Accueil
                </a>
                <a href="#"
                    class="bals-nav-link block px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">Actualités</a>
                <a href="#"
                    class="bals-nav-link block px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">Qui
                    sommes-nous ?</a>
                <a href="#"
                    class="bals-nav-link block px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">Nos
                    gammes</a>
                <a href="#"
                    class="bals-nav-link block px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">Téléchargements</a>
                <a href="#"
                    class="bals-nav-link block px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">Contact</a>
                <a href="{{ route('configurateur.chantier') }}"
                    class="bals-nav-link flex items-center gap-3 px-4 py-3 mt-1 rounded
                          bg-[#DA291C] hover:bg-[#b8200f] text-white font-semibold transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                            clip-rule="evenodd" />
                    </svg>
                    Configurateur
                </a>
            </div>
        </div>

    </nav>
</header>


{{-- ============================================================
     JAVASCRIPT — Burger menu + Recherche par référence
     ============================================================ --}}
<script>
    (function() {

        function initBurger() {
            var btn = document.getElementById('bals-burger-btn');
            var menu = document.getElementById('bals-menu-mobile');
            var l1 = document.getElementById('bals-line-1');
            var l2 = document.getElementById('bals-line-2');
            var l3 = document.getElementById('bals-line-3');

            if (!btn || !menu || !l1 || !l2 || !l3) return;
            if (btn.dataset.init === '1') return;
            btn.dataset.init = '1';

            var open = false;

            function open_menu() {
                open = true;
                menu.style.maxHeight = menu.scrollHeight + 'px';
                btn.setAttribute('aria-expanded', 'true');
                l1.style.transform = 'translateY(7px) rotate(45deg)';
                l2.style.opacity = '0';
                l3.style.transform = 'translateY(-7px) rotate(-45deg)';
            }

            function close_menu() {
                open = false;
                menu.style.maxHeight = '0';
                btn.setAttribute('aria-expanded', 'false');
                l1.style.transform = '';
                l2.style.opacity = '1';
                l3.style.transform = '';
            }

            btn.addEventListener('click', function() {
                open ? close_menu() : open_menu();
            });

            menu.querySelectorAll('a.bals-nav-link').forEach(function(a) {
                a.addEventListener('click', close_menu);
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) close_menu();
            });
        }

        function initReferenceSearch() {
            var toggleBtn = document.getElementById('bals-ref-search-toggle');
            var searchWrap = document.getElementById('bals-ref-search-wrap');
            var searchInput = document.getElementById('bals-ref-search-input');

            if (!toggleBtn || !searchWrap || !searchInput) return;
            if (toggleBtn.dataset.init === '1') return;
            toggleBtn.dataset.init = '1';

            var opened = false;

            function openSearch() {
                opened = true;
                searchWrap.classList.remove('hidden');
                toggleBtn.setAttribute('aria-expanded', 'true');
                searchInput.focus();
            }

            function closeSearch() {
                opened = false;
                searchWrap.classList.add('hidden');
                toggleBtn.setAttribute('aria-expanded', 'false');
            }

            toggleBtn.addEventListener('click', function() {
                opened ? closeSearch() : openSearch();
            });

            document.addEventListener('click', function(event) {
                if (!opened) return;
                if (toggleBtn.contains(event.target) || searchWrap.contains(event.target)) return;
                closeSearch();
            });

            searchInput.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeSearch();
                    toggleBtn.focus();
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                initBurger();
                initReferenceSearch();
            });
        } else {
            initBurger();
            initReferenceSearch();
        }

        document.addEventListener('livewire:navigated', initBurger);
        document.addEventListener('livewire:navigated', initReferenceSearch);

    })();
</script>
