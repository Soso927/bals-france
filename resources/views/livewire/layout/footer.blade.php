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
                        du lundi au vendredi : 8h30 - 12h 13h30 - 16h
                    </p>
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