<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
    <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Type de Coffret</p>

    {{-- 
        ✅ CORRECTION BUG 1 :
        Dans la version originale, aucun bouton n'avait les classes "border-bals-blue bg-bals-blue text-white"
        (qui donnent l'aspect "bouton actif bleu").

        Conséquence JS : mettreAJour() cherche le bouton actif avec
        document.querySelector('.btn-type.bg-bals-blue') → trouvait nothing
        et l'affichage du type de coffret était vide dans le résumé.

        CORRECTION :
        - Prise industrielle → on ajoute : border-bals-blue bg-bals-blue text-white + data-type
                               on retire : border-gray-200 text-gray-600
        - Les autres boutons → on ajoute : border-2 border-gray-200 text-gray-600 + class="btn-type"
                               Pour permettre au JS de les gérer
    --}}
    <div class="flex flex-wrap gap-3" id="type-coffret-buttons">

        <a href="{{ url('/configurateur/chantier') }}"
           class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
           data-type="Coffret Chantier">
            Coffret Chantier
        </a>

        <a href="{{ url('/configurateur/etage') }}"
           class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
           data-type="Coffret d'Étage">
            Coffret d'Étage
        </a>

        <a href="{{ url('/configurateur/coffret-industrie') }}"
           class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
           data-type="Coffret Industrie">
            Coffret Industrie
        </a>

        <a href="{{ url('/configurateur/coffret-evenementiel') }}"
           class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
           data-type="Coffret Événementiel">
            Coffret Événementiel
        </a>

        {{-- ✅ BUG 1 CORRIGÉ : "Prise industrielle" est maintenant le bouton actif --}}
        <a href="{{ url('/configurateur/prise-industrielle') }}"
           class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white cursor-default"
           data-type="Prise industrielle">
            Prise industrielle
        </a>
    </div>
</div>
