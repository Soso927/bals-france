{{--
    admin.blade.php
    ─────────────────────────────────────────────────────────────
    Vue : Back-office de gestion des agents commerciaux BALS France.

    Route associée : GET /admin  (définie dans routes/web.php)

    Ce fichier contient uniquement la structure HTML de la page.
    Les styles et le JavaScript sont dans des fichiers séparés :

      Styles     → public/css/admin.css
      JavaScript → public/js/admin.js

    Fonctionnement :
      - Au chargement, JavaScript lit les agents depuis localStorage
      - L'admin peut modifier, supprimer ou ajouter des agents
      - Toute modification est sauvegardée dans localStorage
      - La carte interactive (/france-map) lit la même clé localStorage
        → les deux pages restent synchronisées automatiquement
--}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-office — Gestion des agents | Bals France</title>

    {{-- Police Exo 2 (même police que la carte interactive) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS (framework utilitaire pour le style rapide) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Styles spécifiques à cette page --}}
    <link rel="stylesheet" href="/css/admin.css">
</head>

<body>

    {{-- Barre bleue→rouge (identité visuelle BALS, commune à tout le site) --}}
    <div class="brand-bar"></div>

    {{-- ══════════════ CONTENU PRINCIPAL ══════════════ --}}
    <div class="max-w-4xl mx-auto px-6 py-10">

        {{-- ── EN-TÊTE ── --}}
        <div class="mb-8">

            {{-- Lien de retour vers la carte interactive --}}
            <a href="{{ route('map.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium mb-4"
               style="color: var(--bals-blue);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Retour à la carte
            </a>

            <h1 class="text-3xl font-extrabold" style="color: var(--bals-black);">
                Gestion des agents
                <span style="color: var(--bals-red);">commerciaux</span>
            </h1>

            <p class="text-sm mt-2" style="color: #6b7280;">
                Modifiez les informations des agents directement ici.
                Les changements seront visibles immédiatement sur la carte interactive.
            </p>
        </div>


        {{-- ── BARRE D'ACTIONS ── --}}
        <div class="flex items-center justify-between mb-6">

            {{-- Compteur total d'agents (mis à jour par JavaScript) --}}
            <span class="text-sm font-bold uppercase tracking-wider"
                  style="color: var(--bals-grey);"
                  id="total-agents">
                — agents au total
            </span>

            {{-- Bouton d'ajout --}}
            <button onclick="afficherFormulaireAjout()"
                    class="text-white text-sm font-semibold px-5 py-2.5 rounded-lg
                           transition-all hover:brightness-110"
                    style="background: var(--bals-blue);">
                + Ajouter un agent
            </button>
        </div>


        {{-- ── FORMULAIRE D'AJOUT (masqué par défaut) ── --}}
        <div id="formulaire-ajout"
             class="hidden mb-8 bg-white border border-dashed rounded-xl p-6"
             style="border-color: var(--bals-blue);">

            <h3 class="text-base font-bold mb-4" style="color: var(--bals-blue);">
                Nouvel agent
            </h3>

            <div class="edit-form">

                {{-- Sélection de la région --}}
                <label class="block text-xs font-semibold uppercase tracking-wider mb-1"
                       style="color: var(--bals-grey);">
                    Région
                </label>
                <select id="new-region"
                        class="w-full p-2 border rounded-md text-sm mb-3"
                        style="border-color: #E2E6EA; font-family: 'Exo 2', sans-serif;">
                    {{-- Options remplies dynamiquement par remplirMenuRegions() dans admin.js --}}
                </select>

                <input type="text"  id="new-agence" placeholder="Agence (optionnel)">
                <input type="text"  id="new-nom"    placeholder="Nom complet *" required>
                <input type="text"  id="new-depts"  placeholder="Départements (ex: Dépt. 75, 92)">
                <input type="text"  id="new-tel"    placeholder="Téléphone (ex: 06 12 34 56 78)">
                <input type="text"  id="new-telRaw" placeholder="Tél. brut (ex: +33612345678)">
                <input type="email" id="new-email"  placeholder="Email *" required>

                <div class="flex gap-3 mt-3">
                    <button onclick="ajouterAgent()"
                            class="text-white text-sm font-semibold px-4 py-2 rounded-lg"
                            style="background: #059669;">
                        Valider
                    </button>
                    <button onclick="cacherFormulaireAjout()"
                            class="text-sm font-semibold px-4 py-2 rounded-lg border"
                            style="color: var(--bals-grey); border-color: #E2E6EA;">
                        Annuler
                    </button>
                </div>
            </div>
        </div>


        {{-- ── LISTE DES RÉGIONS ET AGENTS ──
             Ce conteneur est entièrement généré par afficherTout() dans admin.js --}}
        <div id="liste-regions"></div>

    </div>


    {{-- Toast : message de confirmation (affiché 2 secondes après chaque action) --}}
    <div class="toast" id="toast">Modifications enregistrées !</div>

    {{-- Logique JavaScript du back-office (chargé après le DOM) --}}
    <script src="/js/admin.js"></script>

</body>

</html>
