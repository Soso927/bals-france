<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte interactive - Bals France</title>

    {{-- Tailwind CSS pour le style --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Chart.js via CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-geo@4.1.1/dist/index.umd.min.js"></script>
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
                <div class="w-full h-[800px] border-2 border-transparent">
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
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM chargé');
    const canvas = document.getElementById('france-regions-map');
    console.log('Canvas trouvé:', canvas);
    
    fetch('/data/france.json')
        .then(response => {
            console.log('Réponse fetch:', response.status);
            return response.json();
        })
        .then(geojson => {
            console.log('GeoJSON chargé, features:', geojson.features?.length);
            
            // 1. LE FILTRE RADICAL (La clé du problème)
            // On ne garde que les zones dont la latitude est supérieure à 40°.
            // Cela exclut instantanément tous les DOM-TOM qui font "dézoomer" la carte.
            const metropoleFeatures = geojson.features.filter(f => {
                return f.properties.latitude > 40; 
            });

            console.log("Nombre de régions après filtrage :", metropoleFeatures.length);
            
            initCarte(metropoleFeatures);
        })
        .catch(error => {
            console.error('Erreur chargement JSON:', error);
        });
});

function setupCanvasResizer(canvas) {
    const container = canvas.parentElement;
    if (!container) return;

    const applySize = () => {
        const width = container.clientWidth;
        const height = container.clientHeight;

        if (width > 0 && height > 0) {
            canvas.style.width = `${width}px`;
            canvas.style.height = `${height}px`;
            canvas.width = width;
            canvas.height = height;
        }
    };

    // Appliquer immédiatement
    applySize();

    // Re-appliquer lors du redimensionnement
    if (typeof ResizeObserver !== 'undefined') {
        const observer = new ResizeObserver(() => applySize());
        observer.observe(container);
    }

    window.addEventListener('resize', applySize);
}

function initCarte(features) {
    const canvas = document.getElementById('france-regions-map');
    
    setupCanvasResizer(canvas);
    
    const chart = new Chart(canvas, {
        type: 'choropleth',
        data: {
            labels: features.map(f => f.properties.name),
            datasets: [{
                label: 'Régions',
                data: features.map(f => ({
                    feature: f,
                    value: 1
                })),
                // On récupère la couleur depuis votre objet regionColors
                backgroundColor: context => {
                    const name = context.raw?.feature.properties.name;
                    return regionColors[name] || '#CBD5E1';
                },
                borderColor: '#ffffff',
                borderWidth: 1.5
            }]
        },
        options: {
            responsive: true,
            // 2. IMPORTANT : On autorise le canvas à s'étirer
            maintainAspectRatio: false, 
            
            layout: {
                padding: 0 // Supprime les marges internes de Chart.js
            },
            
            scales: {
                projection: {
                    axis: 'x',
                    projection: 'mercator', 
                    // 3. FORCE la carte à prendre toute la place disponible
                    padding: 0,
                    fitMargins: true 
                },
                color: { display: false }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: (items) => items[0].raw.feature.properties.name
                    }
                }
            }
        }
    });
}
    </script>

</body>
</html>