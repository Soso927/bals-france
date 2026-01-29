{{-- ============================================ --}}
{{-- FOOTER BALS FRANCE --}}
{{-- ============================================ --}}

<footer class="bg-gray-100 mt-20">
    <div class="container mx-auto px-4 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            {{-- Colonne 1 : Navigation --}}
            <div>
                <h4 class="font-bold text-lg mb-4 text-gray-800">Navigation</h4>
                <ul class="space-y-2 text-gray-600">
                    <li><a href="#" class="hover:text-blue-600">Actualités</a></li>
                    <li><a href="#" class="hover:text-blue-600">Nos gammes</a></li>
                    <li><a href="#" class="hover:text-blue-600">Téléchargements</a></li>
                    <li><a href="#" class="hover:text-blue-600">Contact</a></li>
                </ul>
            </div>

            <div class="maps"></div>

            {{-- Colonne 2 : BALS France --}}
            <div>
                <h4 class="font-bold text-lg mb-4 text-gray-800">BALS France</h4>
                <p class="text-gray-600 text-sm mb-2">
                    25 chemin des Mazes<br>
                    77140 Nemours<br>
                    France
                </p>
                <p class="text-gray-600 text-sm mt-4">
                    <strong>Horaires de livraison :</strong><br>
                    du Lundi au Vendredi : 8h30-12h / 13h30-17h
                </p>
                <p class="text-gray-600 text-sm mt-4">
                    <strong>Horaires de bureau :</strong><br>
                    du Lundi au Vendredi : 8h30-12h / 13h30-17h
                </p>
            </div>

            {{-- Colonne 3 : Contact --}}
            <div>
                <h4 class="font-bold text-lg mb-4 text-gray-800">Contact</h4>
                <p class="text-gray-600 text-sm">
                    <a href="mailto:info@bals-france.fr" class="hover:text-blue-600">
                        info@bals-france.fr
                    </a>
                </p>
                <p class="text-gray-600 text-sm mt-2">
                    <a href="tel:0164786080" class="hover:text-blue-600">
                        01 64 78 60 80
                    </a>
                </p>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="bg-[#009EE3] text-white text-center py-4 text-sm">
        <p>&copy; {{ date('Y') }} BALS France - Tous droits réservés</p>
    </div>
</footer>