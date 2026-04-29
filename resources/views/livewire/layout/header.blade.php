<header class="border-b border-stone-200 bg-white/90 backdrop-blur">
    <div class="mx-auto grid max-w-7xl grid-cols-3 items-center px-6 py-4">
        <div>
            <a href="{{ route('home') }}" class="text-lg font-semibold">Accueil</a>
            <p class="text-sm text-stone-500">Solutions électriques BALS France</p>
        </div>

        <div class="flex justify-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo-Bals.png') }}" alt="Bals" class="h-10 w-auto">
            </a>
        </div>

        <nav class="flex items-center justify-end gap-3 text-sm">
            <a href="{{ route('map.index') }}" class="rounded-2xl px-4 py-2 text-stone-700 hover:bg-stone-100">Carte réseau</a>
            <a href="{{ route('configurateur.index') }}" class="rounded-2xl px-4 py-2 text-stone-700 hover:bg-stone-100">Configurateur</a>
        </nav>
    </div>
</header>