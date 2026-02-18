<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte interactive - Bals France</title>

    {{-- Tailwind CSS pour le style --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{--
        IMPORTANT : On charge Chart.js et le plugin geo via CDN classique (sans type="module")
        Cela évite tous les problèmes de chemin et de module ES
    --}}
    <!-- ✅ Fichiers locaux, plus de blocage CDN -->
<script src="/configurateur/js/vendor/chart.umd.min.js"></script>
<script src="/configurateur/js/vendor/index.umd.min.js"></script>
</head>
<body class="bg-gray-50">

    {{-- En-tête du site --}}
    @include('livewire.layout.header')

    <div class="max-w-7xl mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-light text-gray-700 mb-4">
                Carte interactive des régions de France
            </h1>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Conseil et assistance
            </h2>
            <p class="text-gray-600 leading-relaxed max-w-4xl">
                Retrouvez votre agent local en cliquant sur une région de la carte ou dans la liste à droite.
                Pour toute question, contactez notre service commercial au
                <a href="tel:+33164786080">01 64 78 60 80</a>.
            </p>
        </header>

        {{-- Grille : Carte (2/3) + Liste des régions (1/3) --}}
        <div class="w-full">
            <div class="bg-white rounded-lg p-4">
                <div class="relative w-full h-[900px]">
                    {{-- C'est ici que la carte sera dessinée --}}
                    <canvas id="france-regions-map" width="1200" height="900" style="width:100%;height:100%;display:block;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Pied de page --}}
    @include('livewire.layout.footer')


    {{-- ============================================================
         SCRIPT PRINCIPAL DE LA CARTE
         Tout est ici, pas de fichier JS externe = pas de problème de chemin
         ============================================================ --}}
    <script>
        // Couleurs personnalisées pour chaque région
        const regionColors = {
            'Normandie':                '#0095DA',
            'Bretagne':                 '#ED1C24',
            'Pays de la Loire':         '#A855F7',
            'Centre-Val de Loire':      '#FFD700',
            'Nouvelle-Aquitaine':       '#F97316',
            'Occitanie':                '#EC4899',
            'Île-de-France':            '#EF4444',
            'Hauts-de-France':          '#3B82F6',
            'Grand Est':                '#06B6D4',
            'Bourgogne-Franche-Comté':  '#10B981',
            'Auvergne-Rhône-Alpes':     '#8B5CF6',
            'Provence-Alpes-Côte d\'Azur': '#0E7490',
            'Occitanie':                '#84CC16',
        };

        // Quand la page est entièrement chargée
        document.addEventListener('DOMContentLoaded', function () {

            // On charge le fichier GeoJSON depuis le dossier public/data/
            // IMPORTANT : le fichier DOIT être dans public/data/france.json
            fetch('/data/france.json')
                .then(function(response) {
                    // Si le serveur ne trouve pas le fichier, on affiche une erreur claire
                    if (!response.ok) {
                        throw new Error('Fichier france.json introuvable. Vérifie qu\'il est bien dans public/data/');
                    }
                    return response.json(); // On convertit la réponse en JSON
                })
                .then(function(geojson) {
                    // Le JSON est chargé, on initialise la carte
                    initCarte(geojson);
                })
                .catch(function(error) {
                    // En cas d'erreur, on affiche un message dans la console
                    console.error('Erreur chargement JSON :', error.message);
                });
        });


        /**
         * Fonction qui crée la carte avec Chart.js
         * @param {Object} geojson - Les données géographiques des régions
         */
        function initCarte(geojson) {
            const canvas = document.getElementById('france-regions-map');
            if (!canvas) {
                console.error('Canvas #france-regions-map non trouvé dans le HTML');
                return;
            }

            // Préparation des données : pour chaque région, on associe une couleur
            const donnees = geojson.features.map(function(feature) {
                // On récupère le nom de la région (selon le fichier GeoJSON)
                const nom = feature.properties.nom || feature.properties.name || '';
                // On cherche la couleur dans notre tableau, gris par défaut
                const couleur = regionColors[nom] || '#94A3B8';

                return {
                    feature: feature,   // La géométrie (forme) de la région
                    value: 1,           // Valeur numérique (obligatoire pour choropleth)
                    couleur: couleur    // Notre couleur personnalisée
                };
            });

            // Création du graphique carte
            new Chart(canvas, {
                type: 'choropleth', // Type "carte choroplèthe" = carte colorée par zones

                data: {
                    // Labels = noms des régions (pour les tooltips)
                    labels: geojson.features.map(function(f) {
                        return f.properties.nom || f.properties.name;
                    }),
                    datasets: [{
                        label: 'Régions françaises',
                        data: donnees,

                        // Couleur de fond de chaque région
                        backgroundColor: function(context) {
                            if (!context.raw) return '#94A3B8';
                            return context.raw.couleur;
                        },

                        borderColor: '#FFFFFF', // Bordure blanche entre régions
                        borderWidth: 1,

                        // Couleur au survol (légèrement transparente)
                        hoverBackgroundColor: function(context) {
                            if (!context.raw) return '#64748B';
                            return context.raw.couleur + 'BB'; // BB = 73% opacité
                        },
                        hoverBorderWidth: 2
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false, // On laisse le conteneur définir la hauteur

                    plugins: {
                        legend: { display: false }, // Pas de légende

                        tooltip: {
                            callbacks: {
                                // Titre du tooltip = nom de la région
                                title: function(items) {
                                    return items[0].raw.feature.properties.nom
                                        || items[0].raw.feature.properties.name;
                                },
                                label: function() {
                                    return 'Cliquez pour voir les contacts';
                                }
                            }
                        }
                    },

                    scales: {
                        // Projection cartographique : mercator = projection standard
                        projection: {
                            axis: 'x',
                            projection: 'mercator'
                        }
                    },

                    // Gestion du clic sur une région
                    onClick: function(event, elements) {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const nom = geojson.features[index].properties.nom
                                     || geojson.features[index].properties.name;
                            console.log('Région cliquée :', nom);
                            // TODO : afficher les contacts de la région
                        }
                    }
                }
            });
        }
    </script>

</body>
</html>