{{-- ============================================ --}}
{{-- FOOTER BALS FRANCE --}}
{{-- mt-0 : margin-top à 0 pour coller au bloc précédent --}}
{{-- (on a retiré mt-20 qui créait un espace) --}}
{{-- ============================================ --}}

{{-- background-image : image de fond du footer --}}
{{-- background-size: cover : l'image couvre tout l'espace --}}
{{-- background-position: center : l'image est centrée --}}
<footer class="mt-0" style="background-image: url('{{ asset('images/fond-footer.png') }}'); background-size: cover; background-position: center;">
    
    {{-- Conteneur principal du footer --}}
    {{-- w-full : largeur 100% --}}
    {{-- px-4 py-10 : padding horizontal et vertical --}}
    <div class="w-full px-4 py-10">
        
        {{-- container mx-auto : centre le contenu avec une largeur maximale --}}
        <div class="container mx-auto">
            
            {{-- grid : système de grille CSS --}}
            {{-- grid-cols-1 : 1 colonne sur mobile --}}
            {{-- md:grid-cols-3 : 3 colonnes sur écrans moyens et plus --}}
            {{-- gap-8 : espacement entre les colonnes --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- ============================================ --}}
                {{-- COLONNE 1 : Carte Google Maps + Adresse --}}
                {{-- ============================================ --}}
                <div class="flex gap-4">
                    
                    {{-- Google Maps intégré via iframe --}}
                    {{-- shrink-0 : empêche la carte de rétrécir --}}
                    <div class="shrink-0">
                        {{-- iframe : permet d'intégrer une page externe (Google Maps) --}}
                        {{-- loading="lazy" : charge la carte uniquement quand visible --}}
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
                    
                    {{-- Informations de l'entreprise --}}
                    <div class="text-black">
                        {{-- Nom de l'entreprise --}}
                        {{-- font-bold : texte en gras --}}
                        {{-- text-lg : taille de texte grande --}}
                        {{-- mb-4 : marge en bas --}}
                        <h4 class="font-bold text-lg mb-4">BALS France</h4>
                        
                        {{-- Adresse --}}
                        {{-- text-sm : texte petit --}}
                        {{-- <br> : retour à la ligne --}}
                        <p class="text-sm mb-2">
                            23 chemin des Mazes<br>
                            77140 Nemours<br>
                            France
                        </p>
                        
                        {{-- Coordonnées de contact --}}
                        {{-- hover:text-blue-600 : texte bleu au survol --}}
                        <p class="text-sm mt-4">
                            <strong>Contact :</strong><br>
                            {{-- Lien email cliquable --}}
                            <a href="mailto:info@bals-france.fr" class="hover:text-blue-600">
                                info@bals-france.fr
                            </a><br>
                            {{-- Lien téléphone cliquable --}}
                            <a href="tel:+33164786080" class="hover:text-blue-600">
                                01 64 78 60 80
                            </a>
                        </p>
                    </div>
                </div>

                {{-- ============================================ --}}
                {{-- COLONNE 2 : Horaires --}}
                {{-- ============================================ --}}
                <div class="text-black">
                    <h4 class="font-bold text-lg mb-4">Horaires</h4>
                    
                    {{-- Horaires de livraison --}}
                    <p class="text-sm mb-4">
                        <strong>Horaires de livraison :</strong><br>
                        du Lundi au Vendredi :<br>
                        8h30-12h / 13h30-17h
                    </p>
                    
                    {{-- Horaires de bureau --}}
                    <p class="text-sm">
                        <strong>Horaires de bureau :</strong><br>
                        du Lundi au Vendredi :<br>
                        8h30-12h / 13h30-17h
                    </p>
                </div>

                {{-- ============================================ --}}
                {{-- COLONNE 3 : Mentions légales + Image --}}
                {{-- ============================================ --}}
                <div class="flex flex-col items-center text-black">
                    <h4 class="font-bold text-lg mb-4">Mentions légales</h4>
                    
                    {{-- Image du bâtiment BALS --}}
                    {{-- object-cover : l'image garde ses proportions --}}
                    {{-- h-32 : hauteur fixe de 8rem --}}
                    <img src="{{ asset('images/batiment-bals.png') }}" 
                         alt="Bâtiment BALS" 
                         class="h-32 object-cover">
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- BARRE DE COPYRIGHT --}}
    {{-- bg-[#009EE3] : couleur de fond bleu BALS --}}
    {{-- text-center : texte centré --}}
    {{-- ============================================ --}}
    <div class="bg-[#009EE3] text-white text-center py-4 text-sm">
        {{-- date('Y') : affiche l'année actuelle automatiquement --}}
        <p>&copy; {{ date('Y') }} BALS France - Tous droits réservés</p>
    </div>
</footer>