<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Configurateur de devis — BALS France')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


    @yield('styles')

    @livewireStyles
</head>
<body class="bg-gray-50 font-sans flex flex-col min-h-screen">

    {{-- ── Header client centré ───────────────────────────────────────── --}}
    <header class="bg-white border-b border-stone-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-end px-6 py-4">

            {{-- Contact --}}
            <div class="flex items-center gap-3">
                <a href="mailto:info@bals-france.fr"
                   class="hidden sm:flex items-center gap-1.5 text-sm text-stone-600 hover:text-bals-blue transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Nous contacter
                </a>
                <a href="tel:+33164786080"
                   class="hidden sm:flex items-center gap-2 bg-bals-blue text-white text-sm font-bold px-4 py-2 rounded-xl hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                    </svg>
                    01 64 78 60 83
                </a>

                {{-- Burger mobile --}}
                <button class="sm:hidden p-2 rounded-lg hover:bg-gray-100"
                        onclick="document.getElementById('mobile-menu-cfg').classList.toggle('hidden')">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Menu mobile --}}
        <div id="mobile-menu-cfg" class="hidden sm:hidden bg-white border-t border-gray-100 px-4 py-3 space-y-2 text-sm font-semibold text-gray-700">
            <a href="mailto:info@bals-france.fr" class="block py-2 hover:text-bals-blue">Nous contacter</a>
            <a href="tel:+33164786080" class="block py-2 hover:text-bals-blue">01 64 78 60 80</a>
        </div>
    </header>

    {{-- ── Contenu principal ───────────────────────────────────────────── --}}
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 py-8">
        @yield('content')
    </main>

    {{-- ── Footer ──────────────────────────────────────────────────────── --}}
    @unless(View::hasSection('hideFooter'))
    @include('livewire.layout.footer')
    @endunless

    @yield('scripts')

    @livewireScripts
</body>
</html>
