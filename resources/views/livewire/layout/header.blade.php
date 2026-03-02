{{-- HEADER BALS FRANCE — Burger JS Vanilla --}}

<header>

    {{-- BANNIÈRE SUPÉRIEURE --}}
    <div class="bg-white py-3 border-b border-gray-200 rounded-5×1">
        <div class="container mx-auto px-4">
            <div class="flex justify-center items-center">
                <img src="{{ asset('images/banniere-partenaire-header.png') }}" alt="Marques Partenaires"
                    class="h-auto max-w-full rounded-lg hidden sm:block">
                <img src="{{ asset('images/logo-bals.png') }}" alt="BALS France"
                    class="h-10 sm:hidden">
            </div>
        </div>
    </div>

    {{-- SECTION LOGO + CONTACT (identique à l'original) --}}
    <div class="w-full h-36 py-6 border-b border-gray-200 overflow-hidden"
         style="background-image: url('{{ asset('images/fond-header-banniere.png') }}'); background-size: cover; background-position: center;">
        <div class=" container mx-auto px-4">
            <div class="flex justify-center items-center">
                {{-- <img src="{{ asset('images/logo-bals.png') }}" alt="Bals Logo" class="h-16"> --}}
            </div>
        </div>
        <div class="bg-white rounded-full px-4 py-2 flex items-center gap-3 shadow-md w-fit ml-auto mt-16">
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
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                </svg>
                <a href="tel:+33164786080"
                    class="text-gray-800 text-sm font-normal hover:text-gray-600 transition whitespace-nowrap">
                    01 64 78 60 80
                </a>
            </div>
        </div>
    </div>

    {{-- NAVIGATION --}}
    <nav class="bg-[#009EE3] text-white shadow-md">
        <div class="container mx-auto px-4">

            {{-- Desktop --}}
            <ul class="hidden md:flex justify-center items-center gap-1">
                <li>
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-2 px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </a>
                </li>
                <li class="text-white/50">|</li>
                <li><a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">Actualités</a></li>
                <li class="text-white/50">|</li>
                <li><a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">Qui sommes-nous ?</a></li>
                <li class="text-white/50">|</li>
                <li><a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">Nos gammes</a></li>
                <li class="text-white/50">|</li>
                <li><a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">Téléchargements</a></li>
                <li class="text-white/50">|</li>
                <li><a href="#" class="block px-4 py-3 hover:text-[#DA291C] transition-colors duration-200">Contact</a></li>
                <li class="text-[#DA291C]">|</li>
                <li>
                    <a href="{{ route('configurateur.chantier') }}"
                        class="flex items-center gap-2 px-4 py-3 text-[#DA291C] font-semibold hover:text-white transition-colors duration-200">
                        Configurateur
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>
            </ul>

            {{-- Mobile : barre + bouton burger --}}
            <div class="flex md:hidden items-center justify-between py-2">
                <span class="text-white font-semibold text-sm tracking-wide">BALS France</span>
                <button
                    id="bals-burger-btn"
                    aria-label="Ouvrir le menu"
                    aria-expanded="false"
                    aria-controls="bals-menu-mobile"
                    class="w-10 h-10 flex flex-col justify-center items-center gap-[5px] rounded focus:outline-none focus:ring-2 focus:ring-white/50"
                >
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
        <div
            id="bals-menu-mobile"
            class="md:hidden bg-[#007bbf] border-t border-white/20 overflow-hidden"
            style="max-height: 0; transition: max-height .35s ease;"
        >
            <div class="container mx-auto px-4 py-3 flex flex-col gap-1">
                <a href="{{ route('home') }}" class="bals-nav-link flex items-center gap-3 px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                    Accueil
                </a>
                <a href="#" class="bals-nav-link block px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">Actualités</a>
                <a href="#" class="bals-nav-link block px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">Qui sommes-nous ?</a>
                <a href="#" class="bals-nav-link block px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">Nos gammes</a>
                <a href="#" class="bals-nav-link block px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">Téléchargements</a>
                <a href="#" class="bals-nav-link block px-4 py-3 text-white rounded hover:bg-[#009EE3] transition-colors border-b border-white/10">Contact</a>
                <a href="{{ route('configurateur.chantier') }}"
                   class="bals-nav-link flex items-center gap-3 px-4 py-3 mt-1 rounded bg-[#DA291C] hover:bg-[#b8200f] text-white font-semibold transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>
                    Configurateur
                </a>
            </div>
        </div>

    </nav>
</header>

<script>
(function () {
    function initBurger() {
        var btn   = document.getElementById('bals-burger-btn');
        var menu  = document.getElementById('bals-menu-mobile');
        var l1    = document.getElementById('bals-line-1');
        var l2    = document.getElementById('bals-line-2');
        var l3    = document.getElementById('bals-line-3');

        if (!btn || !menu || !l1 || !l2 || !l3) return;
        if (btn.dataset.init === '1') return;
        btn.dataset.init = '1';

        var open = false;

        function open_menu() {
            open = true;
            menu.style.maxHeight = menu.scrollHeight + 'px';
            btn.setAttribute('aria-expanded', 'true');
            l1.style.transform = 'translateY(7px) rotate(45deg)';
            l2.style.opacity   = '0';
            l3.style.transform = 'translateY(-7px) rotate(-45deg)';
        }

        function close_menu() {
            open = false;
            menu.style.maxHeight = '0';
            btn.setAttribute('aria-expanded', 'false');
            l1.style.transform = '';
            l2.style.opacity   = '1';
            l3.style.transform = '';
        }

        btn.addEventListener('click', function () { open ? close_menu() : open_menu(); });
        menu.querySelectorAll('a.bals-nav-link').forEach(function (a) { a.addEventListener('click', close_menu); });
        window.addEventListener('resize', function () { if (window.innerWidth >= 768) close_menu(); });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBurger);
    } else {
        initBurger();
    }

    // Relance après navigation Livewire
    document.addEventListener('livewire:navigated', initBurger);
})();
</script>