{{-- ============================================================
     HEADER BALS FRANCE — Version responsive commentée
     ============================================================
     Corrections apportées :
     - Hauteur fixe h-[21rem] → min-h adaptative par breakpoint
     - Marge fixe mt-48 → positionnement absolu bottom-4 left-4
     - Pilule de recherche réduite sur mobile
     - Logos du marquee avec clamp() fluide
     - Plus aucune valeur fixe qui "bloque" le redimensionnement
     ============================================================ --}}

<header>

    {{-- ============================================================
     BANNIÈRE SUPÉRIEURE — Défilement CSS pur (marquee)
     ============================================================ --}}

    <style>
        /* ── Conteneur du défilement ──────────────────────────────
       overflow:hidden cache la partie de la piste qui dépasse.
       La bordure basse sépare visuellement la bannière du reste. */
        .marquee {
            overflow: hidden;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 0;
        }

        /* ── Piste de défilement ─────────────────────────────────
       display:flex + width:max-content = les logos se mettent
       tous en ligne sans jamais passer à la ligne.
       L'animation déplace la piste vers la gauche en continu. */
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marquee-scroll 20s linear infinite;
        }

        /* ── Pause au survol (confort UX) ────────────────────────
       L'utilisateur peut stopper le défilement en passant
       la souris dessus pour lire un logo en particulier. */
        .marquee-track:hover {
            animation-play-state: paused;
        }

        /* ── Logos de la piste ───────────────────────────────────
       clamp(min, valeur-fluide, max) : la hauteur s'adapte
       PROGRESSIVEMENT entre les breakpoints, sans saut brutal.
       Sur 360px → ≈18px | Sur 768px → ≈26px | Sur 1440px → 35px
       object-fit:contain empêche toute déformation du logo,
       quelle que soit sa proportion d'origine. */
        .marquee-track img {
            height: clamp(18px, 3.5vw, 35px);
            width: auto;
            margin: 0 clamp(10px, 2vw, 30px);
            /* espacement lui aussi fluide */
            object-fit: contain;
            flex-shrink: 0;
            /* les logos ne se compriment jamais */
        }

        /* ── Animation ────────────────────────────────────────────
       On ne translate que de -50% car le contenu est DOUBLÉ
       dans le HTML (bloc 1 + bloc 2 identiques).
       Quand la piste a avancé de la moitié de sa largeur,
       on se retrouve visuellement au même point qu'au départ :
       la boucle est donc parfaitement invisible. */
        @keyframes marquee-scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }
    </style>

    <div class="marquee">
        <div class="marquee-track">
            {{-- ── Bloc 1 : images réelles ─────────────────────────── --}}
            <img src="{{ asset('images/banniere1.png') }}" alt="Partenaire 1">
            <img src="{{ asset('images/banniere2.png') }}" alt="Partenaire 2">
            <img src="{{ asset('images/banniere3.png') }}" alt="Partenaire 3">
            <img src="{{ asset('images/banniere4.png') }}" alt="Partenaire 4">
            <img src="{{ asset('images/banniere5.png') }}" alt="Partenaire 5">
            <img src="{{ asset('images/banniere6.png') }}" alt="Partenaire 6">
            <img src="{{ asset('images/banniere7.png') }}" alt="Partenaire 7">
            <img src="{{ asset('images/banniere8.png') }}" alt="Partenaire 8">

            {{-- ── Bloc 2 : copie exacte ───────────────────────────────
             Sans cette copie, la piste s'arrête net au dernier logo
             avant de repartir du début (saut visible).
             Avec la copie, pendant qu'on lit la fin du bloc 1,
             le début du bloc 2 est déjà en attente → boucle fluide. --}}
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
     ============================================================
     AVANT : h-[21rem] → hauteur fixe = débordement sur mobile.
     APRÈS  : min-h-[14rem] md:min-h-[21rem]
              → hauteur MINIMALE qui peut grandir si besoin.
     pb-6   → padding bas pour que les éléments absolus
              (contact, recherche) ne collent pas au bord.
     relative → nécessaire pour que les enfants `absolute`
                se positionnent par rapport à CE conteneur. --}}
<div class="w-full 
            min-h-[14rem] md:min-h-[21rem]
            pt-12 md:pt-[5.5rem] pb-6
            bg-contain bg-center bg-no-repeat
            border-gray-200 overflow-hidden relative"
     style="background-image: url('{{ asset('images/fond-header-banniere.png') }}');">

        {{-- ── Logo centré (commenté dans l'original, conservé) ── --}}
        <div class="container mx-auto px-4">
            <div class="flex justify-center items-center">
                {{-- <img src="{{ asset('images/logo-bals.png') }}" alt="Bals Logo" class="h-16"> --}}
            </div>
        </div>

        {{-- ── Pilule CONTACT ───────────────────────────────────────
         AVANT : ml-[1rem] mt-48
                 → mt-48 = marge fixe de 192px depuis le haut.
                   Sur mobile (hauteur totale ~224px), ça débordait.
         APRÈS  : absolute bottom-4 left-4
                 → collée en bas à gauche du conteneur relatif,
                   QUELLE QUE SOIT la hauteur de ce conteneur.
         sm:left-8 → un peu plus de marge latérale sur tablette. --}}
        <div class="absolute bottom-4 left-4 sm:left-8 w-fit">

            {{-- flex-wrap → si l'écran est très étroit, email et
             téléphone passent l'un sous l'autre plutôt que
             de déborder hors du conteneur. --}}
            <div
                class="bg-white rounded-full px-3 py-2
                    flex flex-wrap items-center gap-x-3 gap-y-1
                    shadow-md w-fit">

                {{-- Email ──────────────────────────────────────────── --}}
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        {{-- shrink-0 empêche l'icône de se comprimer --}}
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    {{-- text-xs sur mobile, text-sm à partir de sm --}}
                    <a href="mailto:Info@bals-france.fr"
                        class="text-gray-800 text-xs sm:text-sm font-normal
                          hover:text-gray-600 transition whitespace-nowrap">
                        Info@bals-france.fr
                    </a>
                </div>

                {{-- Téléphone ──────────────────────────────────────── --}}
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    <a href="tel:+33164786080"
                        class="text-gray-800 text-xs sm:text-sm font-normal
                          hover:text-gray-600 transition whitespace-nowrap">
                        01 64 78 60 80
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Pilule RECHERCHE ─────────────────────────────────────
         Positionnement absolu conservé (top-4 right-4).
         sm:right-8 → marge latérale adaptative.
         La pilule reste dans son coin haut-droit sur tous
         les écrans, sans jamais croiser la pilule de contact
         (qui est en bas-gauche). --}}
        <div
            class="absolute top-4 right-4 sm:right-8
                bg-white rounded-full px-3 py-2
                flex items-center gap-2 shadow-md w-fit">

            <button id="bals-ref-search-toggle" type="button" aria-expanded="false"
                aria-controls="bals-ref-search-wrap"
                class="flex items-center gap-2 text-gray-800
                   text-xs sm:text-sm font-normal
                   hover:text-gray-600 transition whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
                Référence
            </button>

            {{-- Champ de recherche (caché par défaut, révélé par JS)
             w-28 sm:w-44 md:w-52 → largeur progressive :
             très petit sur mobile pour ne pas déborder,
             plus large sur tablette et desktop. --}}
            <form id="bals-ref-search-wrap" action="#" method="get" class="hidden">
                <input id="bals-ref-search-input" name="reference" type="search" placeholder="Saisir une référence"
                    class="w-28 sm:w-44 md:w-52
                       bg-gray-50 border border-gray-200 rounded-full
                       px-3 py-1 text-xs sm:text-sm text-gray-800
                       placeholder-gray-500
                       focus:outline-none focus:ring-2 focus:ring-[#009EE3]">
            </form>
        </div>

    </div>{{-- fin section bannière --}}


    {{-- ============================================================
     NAVIGATION
     ============================================================ --}}
    <nav class="bg-[#009EE3] text-white shadow-md">
        <div class="container mx-auto px-4">

            {{-- ── Menu DESKTOP (md et au-dessus) ───────────────────
             hidden md:flex → invisible sur mobile,
             visible en flex à partir de 768px. --}}
            <ul class="hidden md:flex justify-center items-center gap-1">
                <li>
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-2 px-4 py-3
                          hover:text-[#DA291C] transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </a>
                </li>
                <li class="text-white/50">|</li>
                <li><a href="#"
                        class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">Actualités</a></li>
                <li class="text-white/50">|</li>
                <li><a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">Qui
                        sommes-nous ?</a></li>
                <li class="text-white/50">|</li>
                <li><a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">Nos
                        gammes</a></li>
                <li class="text-white/50">|</li>
                <li><a href="#"
                        class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">Téléchargements</a>
                </li>
                <li class="text-white/50">|</li>
                <li><a href="#"
                        class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">Contact</a></li>
                <li class="text-[#DA291C]">|</li>
                <li>
                    <a href="{{ route('configurateur.chantier') }}"
                        class="flex items-center gap-2 px-4 py-3
                          text-[#DA291C] font-semibold
                          hover:text-white transition-colors duration-200">
                        Configurateur
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>
            </ul>

            {{-- ── Barre MOBILE : titre + bouton burger ──────────────
             flex md:hidden → visible seulement sous 768px.
             items-center justify-between → titre à gauche,
             burger à droite, sur la même ligne. --}}
            <div class="flex md:hidden items-center justify-between py-2">
                <span class="text-white font-semibold text-sm tracking-wide">BALS France</span>

                {{-- Bouton burger ─────────────────────────────────────
                 Les 3 spans sont les "barres" du burger.
                 Le JS les anime en croix à l'ouverture du menu.
                 aria-expanded / aria-controls → accessibilité. --}}
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

        {{-- ── Menu mobile déroulant ─────────────────────────────────
         max-height:0 + overflow:hidden = replié par défaut.
         Le JS passe max-height à scrollHeight pour l'ouvrir.
         La transition CSS sur max-height crée l'effet accordéon
         sans aucune bibliothèque externe. --}}
        <div id="bals-menu-mobile" class="md:hidden bg-[#007bbf] border-t border-white/20 overflow-hidden"
            style="max-height: 0; transition: max-height .35s ease;">
            <div class="container mx-auto px-4 py-3 flex flex-col gap-1">

                {{-- Accueil ──────────────────────────────────────────── --}}
                <a href="{{ route('home') }}"
                    class="bals-nav-link flex items-center gap-3 px-4 py-3 text-white rounded
                      hover:bg-[#009EE3] transition-colors border-b border-white/10">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Accueil
                </a>

                {{-- Liens standards ──────────────────────────────────── --}}
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

                {{-- Configurateur — mis en valeur en rouge ───────────── --}}
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
     ============================================================
     Tout est dans une IIFE (fonction auto-invoquée) pour éviter
     de polluer le scope global avec des variables comme `open`
     ou `btn` qui pourraient entrer en conflit avec d'autres
     scripts sur la page.
     ============================================================ --}}
<script>
    (function() {

        /* ── BURGER MENU ────────────────────────────────────────────
           Gère l'animation des 3 barres → croix et le dépliage
           du menu mobile via une transition sur max-height. */
        function initBurger() {
            var btn = document.getElementById('bals-burger-btn');
            var menu = document.getElementById('bals-menu-mobile');
            var l1 = document.getElementById('bals-line-1');
            var l2 = document.getElementById('bals-line-2');
            var l3 = document.getElementById('bals-line-3');

            /* Sécurité : on sort si l'un des éléments manque dans le DOM */
            if (!btn || !menu || !l1 || !l2 || !l3) return;

            /* Anti-double initialisation (important avec Livewire qui
               peut ré-injecter le HTML sans recharger la page) */
            if (btn.dataset.init === '1') return;
            btn.dataset.init = '1';

            var open = false; /* état interne du menu */

            function open_menu() {
                open = true;
                /* scrollHeight = hauteur réelle du contenu caché.
                   On l'assigne à max-height → la transition CSS anime
                   le dépliage de 0 jusqu'à cette valeur. */
                menu.style.maxHeight = menu.scrollHeight + 'px';
                btn.setAttribute('aria-expanded', 'true');
                /* Animation croix : barre 1 descend + pivote 45°,
                   barre 2 disparaît, barre 3 monte + pivote -45° */
                l1.style.transform = 'translateY(7px) rotate(45deg)';
                l2.style.opacity = '0';
                l3.style.transform = 'translateY(-7px) rotate(-45deg)';
            }

            function close_menu() {
                open = false;
                menu.style.maxHeight = '0'; /* repli animé */
                btn.setAttribute('aria-expanded', 'false');
                /* Réinitialise les barres à leur état burger */
                l1.style.transform = '';
                l2.style.opacity = '1';
                l3.style.transform = '';
            }

            /* Clic sur le bouton → bascule ouvert/fermé */
            btn.addEventListener('click', function() {
                open ? close_menu() : open_menu();
            });

            /* Clic sur un lien du menu → ferme le menu automatiquement */
            menu.querySelectorAll('a.bals-nav-link').forEach(function(a) {
                a.addEventListener('click', close_menu);
            });

            /* Redimensionnement → ferme le menu si on passe en desktop
               (evite un menu fantôme ouvert mais invisible) */
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) close_menu();
            });
        }

        /* ── RECHERCHE PAR RÉFÉRENCE ────────────────────────────────
           Affiche/masque le champ de saisie à côté du bouton loupe. */
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
                searchWrap.classList.remove('hidden'); /* rend le champ visible */
                toggleBtn.setAttribute('aria-expanded', 'true');
                searchInput.focus(); /* focus automatique = UX fluide */
            }

            function closeSearch() {
                opened = false;
                searchWrap.classList.add('hidden');
                toggleBtn.setAttribute('aria-expanded', 'false');
            }

            /* Bouton loupe → bascule */
            toggleBtn.addEventListener('click', function() {
                opened ? closeSearch() : openSearch();
            });

            /* Clic en dehors de la pilule → ferme le champ.
               On vérifie que le clic n'est PAS dans le bouton
               ni dans le formulaire avant de fermer. */
            document.addEventListener('click', function(event) {
                if (!opened) return;
                if (toggleBtn.contains(event.target) || searchWrap.contains(event.target)) return;
                closeSearch();
            });

            /* Touche Échap → ferme le champ et redonne le focus
               au bouton (accessibilité clavier) */
            searchInput.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeSearch();
                    toggleBtn.focus();
                }
            });
        }

        /* ── INITIALISATION ─────────────────────────────────────────
           Si le DOM est déjà prêt (script chargé après le HTML)
           on lance directement. Sinon on attend DOMContentLoaded. */
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                initBurger();
                initReferenceSearch();
            });
        } else {
            initBurger();
            initReferenceSearch();
        }

        /* ── COMPATIBILITÉ LIVEWIRE ──────────────────────────────────
           Livewire peut naviguer entre pages sans rechargement complet
           (SPA-like). L'événement livewire:navigated signale que le
           nouveau HTML est injecté → on ré-initialise les listeners. */
        document.addEventListener('livewire:navigated', initBurger);
        document.addEventListener('livewire:navigated', initReferenceSearch);

    })();
</script>
