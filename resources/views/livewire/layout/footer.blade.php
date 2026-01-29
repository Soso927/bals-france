{{-- ============================================ --}}
{{-- FOOTER BALS FRANCE --}}
{{-- ============================================ --}}

<footer class="mt-20" style="background-image: url('{{ asset('images/fond-footer.png') }}'); background-size: cover; background-position: center;">
    <div class="w-full px-4 py-10">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Colonne 1 : Carte + Informations de l'entreprise --}}
                <div class="flex gap-4">
                    {{-- Google Maps --}}
                    <div class="flex-shrink-0">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2655.3829814438495!2d2.7034770765165304!3d48.276247471259275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e5898684b4e3e1%3A0xf27c8cc56bc92ec3!2sBals%20France%20SA!5e0!3m2!1sfr!2sfr!4v1769697753068!5m2!1sfr!2sfr" width="250" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    
                    {{-- Nom et adresse de l'entreprise --}}
                    <div class="text-black">
                        <h4 class="font-bold text-lg mb-4">BALS France</h4>
                        <p class="text-sm mb-2">
                            25 chemin des Mazes<br>
                            77140 Nemours<br>
                            France
                        </p>
                        <p class="text-sm mt-4">
                            <strong>Contact :</strong><br>
                            <a href="mailto:info@bals-france.fr" class="hover:text-blue-600">
                                info@bals-france.fr
                            </a><br>
                            <a href="tel:0164786080" class="hover:text-blue-600">
                                01 64 78 60 80
                            </a>
                        </p>
                    </div>
                </div>

                {{-- Colonne 2 : Horaires --}}
                <div class="text-black">
                    <h4 class="font-bold text-lg mb-4">Horaires</h4>
                    <p class="text-sm mb-4">
                        <strong>Horaires de livraison :</strong><br>
                        du Lundi au Vendredi<br>
                        8h30-12h / 13h30-17h
                    </p>
                    <p class="text-sm">
                        <strong>Horaires de bureau :</strong><br>
                        du Lundi au Vendredi<br>
                        8h30-12h / 13h30-17h
                    </p>
                </div>

                {{-- Colonne 3 : Mention légales + Image --}}
                <div class="flex flex-col items-center text-black">
                    <h4 class="font-bold text-lg mb-4">Mentions légales</h4>
                    <img src="{{ asset('images/batiment-bals.png') }}" 
                         alt="Bâtiment BALS" 
                         class="h-32 object-cover">
                </div>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="bg-[#009EE3] text-white text-center py-4 text-sm">
        <p>&copy; {{ date('Y') }} BALS France - Tous droits réservés</p>
    </div>
</footer>