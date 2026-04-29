{{--
    ============================================================
    PARTIAL : configurateur/partials/panneau-resume
    ============================================================
    Affiche la colonne droite "Résumé de la demande".
    Identique dans les 5 formulaires — extrait ici.

    Le JavaScript de chaque formulaire :
        - remplace le contenu de #resume-zone via innerHTML
        - affiche/masque #boutons-action selon si le formulaire est rempli

    Les 3 fonctions appelées en onclick (envoyerDevis, copierResume,
    reinitialiser) sont définies comme fonctions globales dans chacun
    des fichiers JS (chantier.js, etage.js, evenementiel.js,
    prise-industrielle.js).

    Utilisation :
        @include('configurateur.partials.panneau-resume')

    Aucune variable nécessaire.
    ============================================================
--}}

<div class="lg:col-span-1">
    <div class="sticky top-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">

        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-3">Résumé de la demande</p>

        {{-- Zone de résumé : remplie dynamiquement par le JS du formulaire --}}
        <div id="resume-zone" class="min-h-[120px] flex flex-col items-center justify-center text-center">
            <p class="text-bals-blue font-bold text-sm opacity-40">Configurez votre coffret</p>
            <p class="text-gray-400 text-xs mt-1">Les informations apparaîtront ici</p>
        </div>

        {{-- Boutons d'action — masqués par défaut, affichés par le JS quand le formulaire est rempli --}}
        <div id="boutons-action" class="hidden mt-4 space-y-2 border-t border-gray-100 pt-4">

            <button onclick="envoyerDevis()"
                    class="w-full rounded-xl bg-bals-blue text-white font-bold py-3 text-sm hover:opacity-90 transition-opacity">
                ✉ Envoyer le devis
            </button>

            <button onclick="copierResume()"
                    class="w-full rounded-xl border border-gray-200 text-gray-700 font-bold py-2.5 text-sm hover:bg-gray-50 transition-colors">
                Copier le résumé
            </button>

            <button onclick="soumettrePDF()" class="w-full rounded-xl border border-gray-200 text-gray-700 font-bold py-2.5 text-sm hover:bg-gray-50 transition-colors id="btn-soumettre-pdf">Générer mon devis PDF</button>

            <button onclick="reinitialiser()"
                    class="w-full rounded-xl border border-red-100 text-red-500 font-bold py-2.5 text-sm hover:bg-red-50 transition-colors">
                Réinitialiser
            </button>

        </div>
    </div>
</div>
