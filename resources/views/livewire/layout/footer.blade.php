{{-- ============================================ --}}
{{-- FOOTER BALS FRANCE --}}
{{-- ============================================ --}}
<footer class="mt-0" style="background-image: url('{{ asset('images/fond-footer.png') }}'); background-size: cover; background-position: center;">
    
    <div class="w-full px-4 py-10">
        <div class="container mx-auto">
            
            {{-- 
                DISPOSITION EN 3 COLONNES CÔTE À CÔTE
                flex : affichage flexible en ligne
                flex-row : les éléments se placent horizontalement
                justify-between : espace maximum entre les colonnes
                items-start : alignement en haut
                gap-4 : petit espacement entre les colonnes
            --}}
            <div class="flex flex-row justify-between items-start gap-4">
                
                {{-- ============================================ --}}
                {{-- COLONNE 1 : Carte Google Maps + Adresse BALS France --}}
                {{-- flex-shrink-0 : garde sa taille fixe --}}
                {{-- ============================================ --}}
                <div class="flex-shrink-0">
                    {{-- Sous-grille pour la carte et les infos côte à côte --}}
                    <div class="flex gap-4">
                        {{-- Carte Google Maps --}}
                        <div class="shrink-0">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2655.3829814438495!2d2.7034770765165304!3d48.276247471259275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e5898684b4e3e1%3A0xf27c8cc56bc92ec3!2sBals%20France%20SA!5e0!3m2!1sfr!2sfr!4v1769697753068!5m2!1sfr!2sfr" 
                                width="250" 
                                height="250" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        
                        {{-- Informations BALS France --}}
                        <div class="text-black">
                            <h4 class="font-bold text-lg mb-4">BALS France</h4>
                            <p class="text-sm mb-2">
                                23 chemin des Mazes<br>
                                77140 Nemours<br>
                                France
                            </p>
                            <p class="text-sm mt-4">
                                <strong>Contact :</strong><br>
                                <a href="mailto:info@bals-france.fr" class="hover:text-blue-600">
                                    info@bals-france.fr
                                </a><br>
                                <a href="tel:+33164786080" class="hover:text-blue-600">
                                    01 64 78 60 80
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ============================================ --}}
                {{-- COLONNE 2 : Horaires (au milieu) --}}
                {{-- flex-shrink-0 : garde sa taille, ne rétrécit pas --}}
                {{-- ============================================ --}}
                <div class="text-black flex-shrink-0">
                    {{-- 
                        Cette colonne est au centre
                        Elle garde sa taille naturelle sans s'étirer
                    --}}
                    <h4 class="font-bold text-lg mb-4">Horaires de livraison :</h4>
                    
                    {{-- Horaires de livraison --}}
                    <p class="text-sm mb-4">
                        du lundi au vendredi : 8h30 - 12h 13h30 - 16h30
                    </p>
                    
                    {{-- Horaires de bureau --}}
                    <h4 class="font-bold text-lg mb-2">Horaires de bureau :</h4>
                    <p class="text-sm">
                        du lundi au vendredi : 8h30 - 12h 13h30 - 16h30
                    </p>
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

                {{-- ============================================ --}}
                {{-- COLONNE 3 : Mentions légales + Image (à droite) --}}
                {{-- flex-shrink-0 : garde sa taille fixe --}}
                {{-- ============================================ --}}
                <div class="flex flex-col items-center text-black flex-shrink-0">
                    <h4 class="font-bold text-lg mb-4">Mentions légales</h4>
                    
                    {{-- Image du bâtiment BALS --}}
                    <img src="{{ asset('images/batiment-bals.png') }}" 
                         alt="Bâtiment BALS" 
                         class="h-32 object-cover">
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- BARRE DE COPYRIGHT (en bas) --}}
    {{-- ============================================ --}}
    <div class="bg-[#009EE3] text-white text-center py-4 text-sm">
        <p>&copy; {{ date('Y') }} BALS France - Tous droits réservés</p>
    </div>
</footer>