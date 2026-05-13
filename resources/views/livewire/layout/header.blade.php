<header class="sticky top-0 z-50 border-b border-stone-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

        {{-- Logo --}}
        
            <img src="{{ asset('images/logo-bals.png') }}" alt="Bals" class="h-10 w-auto">
        

        {{-- Navigation centrale --}}
        <nav class="flex items-center gap-1 text-sm">
            <a href="{{ route('map.index') }}"
               class="rounded-2xl px-4 py-2 text-stone-700 transition-colors hover:bg-stone-100">
                Carte réseau
            </a>

            {{-- Dropdown Configurateurs --}}
            <div class="group relative">
                <button class="flex items-center gap-1 rounded-2xl px-4 py-2 text-stone-700 transition-colors hover:bg-stone-100">
                    Configurateurs
                    <svg class="h-4 w-4 transition-transform group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div class="invisible absolute left-1/2 top-full mt-2 w-60 -translate-x-1/2 rounded-2xl border border-stone-100 bg-white p-2 opacity-0 shadow-lg transition-all group-hover:visible group-hover:opacity-100">
                    <a href="{{ route('configurateur.chantier') }}"
                       class="block rounded-xl px-4 py-2.5 text-sm text-stone-700 hover:bg-stone-50">
                        Coffret Chantier
                    </a>
                    <a href="{{ route('configurateur.etage') }}"
                       class="block rounded-xl px-4 py-2.5 text-sm text-stone-700 hover:bg-stone-50">
                        Coffret d'Étage
                    </a>
                    <a href="{{ route('configurateur.industrie') }}"
                       class="block rounded-xl px-4 py-2.5 text-sm text-stone-700 hover:bg-stone-50">
                        Coffret Industrie
                    </a>
                    <a href="{{ route('configurateur.evenementiel') }}"
                       class="block rounded-xl px-4 py-2.5 text-sm text-stone-700 hover:bg-stone-50">
                        Coffret Événementiel
                    </a>
                    <a href="{{ route('configurateur.prise-industrielle') }}"
                       class="block rounded-xl px-4 py-2.5 text-sm text-stone-700 hover:bg-stone-50">
                        Prise Industrielle
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>
