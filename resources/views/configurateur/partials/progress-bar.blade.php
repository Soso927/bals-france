{{--
    ============================================================
    PARTIAL : configurateur/partials/progress-bar
    ============================================================
    Affiche la barre de progression de complétion du formulaire.
    Le JavaScript de chaque formulaire met à jour ces deux éléments
    en temps réel via leurs IDs fixes :
        #progression-barre → largeur CSS (ex : style="width: 60%")
        #progression-texte → pourcentage affiché (ex : "(60%)")

    Utilisation :
        @include('configurateur.partials.progress-bar')

    Aucune variable nécessaire.
    ============================================================
--}}

<div class="mt-6 bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-2">
        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Complétion</span>
        <span id="progression-texte" class="text-xs font-bold text-bals-blue">(0%)</span>
    </div>
    <div class="w-full bg-gray-100 rounded-full h-2">
        {{-- transition-all assure une animation fluide du remplissage --}}
        <div id="progression-barre" class="bg-bals-blue h-2 rounded-full transition-all" style="width:0%"></div>
    </div>
</div>
