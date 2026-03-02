{{-- ============================================ --}}
{{-- FOOTER BALS FRANCE — Responsive           --}}
{{-- ============================================ --}}
<footer class="mt-0"
        style="background-image: url('{{ asset('images/fond-footer.png') }}'); background-size: cover; background-position: center;">

    <div class="w-full px-4 py-10">
        <div class="container mx-auto">

            {{-- ============================================ --}}
            {{-- GRILLE RESPONSIVE                          --}}
            {{-- Mobile  : 1 colonne (empilées)             --}}
            {{-- Tablette : 2 colonnes                      --}}
            {{-- Desktop : 3 colonnes côte à côte           --}}
            {{-- ============================================ --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-6">

                {{-- ============================================ --}}
                {{-- COLONNE 1 : Carte + Adresse               --}}
                {{-- ============================================ --}}
                <div class="flex flex-col sm:flex-row gap-4 items-start">

                    {{-- Carte Google Maps — responsive --}}
                    <div class="shrink-0 w-full sm:w-auto">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2655.3829814438495!2d2.7034770765165304!3d48.276247471259275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e5898684b4e3e1%3A0xf27c8cc56bc92ec3!2sBals%20France%20SA!5e0!3m2!1sfr!2sfr!4v1769697753068!5m2!1sfr!2sfr"
                            class="w-full sm:w-[200px] h-[200px] border-0 rounded"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    {{-- Adresse --}}
                    <div class="text-black">
                        <h4 class="font-bold text-lg mb-3">BALS France</h4>
                        <address class="not-italic text-sm leading-relaxed">
                            23 chemin des Mazes<br>
                            77140 Nemours<br>
                            France
                        </address>
                        <div class="text-sm mt-4 space-y-1">
                            <p class="font-semibold">Contact :</p>
                            <a href="mailto:info@bals-france.fr"
                               class="block hover:text-bals-blue transition-colors">
                                info@bals-france.fr
                            </a>
                            <a href="tel:+33164786080"
                               class="block hover:text-bals-blue transition-colors">
                                01 64 78 60 80
                            </a>
                        </div>
                    </div>

                </div>

                {{-- ============================================ --}}
                {{-- COLONNE 2 : Horaires + Contact rapide      --}}
                {{-- ============================================ --}}
                <div class="text-black">
                    <h4 class="font-bold text-lg mb-3">Horaires de livraison :</h4>
                    <p class="text-sm mb-5">
                        du lundi au vendredi : 8h30 - 12h / 13h30 - 16h30
                    </p>

                    <h4 class="font-bold text-lg mb-3">Horaires de bureau :</h4>
                    <p class="text-sm mb-6">
                        du lundi au vendredi : 8h30 - 12h / 13h30 - 16h30
                    </p>

                    {{-- Pastille contact rapide --}}
                    <div class="bg-white rounded-full px-4 py-2 flex flex-wrap items-center gap-3 shadow-md w-fit">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-bals-blue shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            <a href="mailto:Info@bals-france.fr"
                               class="text-gray-800 text-sm hover:text-bals-blue transition whitespace-nowrap">
                                Info@bals-france.fr
                            </a>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-bals-blue shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            <a href="tel:+33164786080"
                               class="text-gray-800 text-sm hover:text-bals-blue transition whitespace-nowrap">
                                01 64 78 60 80
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ============================================ --}}
                {{-- COLONNE 3 : Mentions légales + Bâtiment   --}}
                {{-- ============================================ --}}
                <div class="flex flex-col items-center sm:items-start lg:items-center text-black">
                    <h4 class="font-bold text-lg mb-4">Mentions légales</h4>
                    <img src="{{ asset('images/batiment-bals.png') }}"
                         alt="Bâtiment BALS"
                         class="h-32 w-auto object-cover rounded">
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- BARRE COPYRIGHT                            --}}
    {{-- ============================================ --}}
    <div class="bg-[#009EE3] text-white text-center py-4 px-4 text-sm">
        <p>&copy; {{ date('Y') }} BALS France — Tous droits réservés</p>
    </div>

</footer>