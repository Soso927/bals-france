// Importation des librairies Chart.js et chartjs-chart-geo
import { Chart } from 'chart.js';
import { ChoroplethController, GeoFeature, ColorScale, ProjectionScale } from 'chartjs-chart-geo';
// Enregistrement des composants pour les cartes géographiques
Chart.register(ChoroplethController, GeoFeature, ColorScale, ProjectionScale);

/**
 * Configuration des couleurs pour chaque région française
 * Ces couleurs correspondent à celles de la capture d'écran 
 */
const regionColors = {
    'Normandie': '#0095DA',              // Bleu
    'Bretagne': '#ED1C24',               // Rouge
    'Pays de la Loire': '#A855F7',       // Violet
    'Val de Loire': '#FFD700',           // Jaune doré
    'Auvergne-Limousin': '#1E3A8A',      // Bleu marine
    'Aquitaine': '#F97316',              // Orange
    'Midi-Pyrénées': '#EC4899',          // Rose
    'Île-de-France': '#EF4444',          // Rouge clair
    'Nord': '#3B82F6',                   // Bleu ciel
    'Champagne-Ardennes': '#FACC15',     // Jaune
    'Alsace Lorraine': '#06B6D4',        // Cyan
    'Bourgogne Franche-Comté': '#10B981', // Vert
    'Rhône-Alpes': '#8B5CF6',            // Violet foncé
    'Méditerranée': '#0E7490',           // Bleu turquoise
    'Centre': '#84CC16',                 // Vert lime
    'Nouvelle-Aquitaine': '#F59E0B'      // Orange ambré
};

/**
 * Données des agents commerciaux par région
 * Structure : nom de la région et informations de contact
 */
const regionsData = [
    { name: 'NORMANDIE', color: '#0095DA', contacts: [] },
    { name: 'BRETAGNE', color: '#ED1C24', contacts: [] },
    { name: 'PAYS DE LA LOIRE', color: '#A855F7', contacts: [] },
    { name: 'VAL DE LOIRE', color: '#FFD700', contacts: [] },
    { name: 'AUVERGNE-LIMOUSIN', color: '#1E3A8A', contacts: [] },
    { name: 'AQUITAINE', color: '#F97316', contacts: [] },
    { name: 'AQUITAINE', color: '#F97316', contacts: [] }, // Doublon dans la capture
    { name: 'MIDI-PYRENEES', color: '#EC4899', contacts: [] },
    { name: 'MIDI-PYRENEES', color: '#EC4899', contacts: [] },
    { name: 'ILE DE FRANCE', color: '#EF4444', contacts: [] },
    { name: 'ILE DE FRANCE', color: '#EF4444', contacts: [] },
    { name: 'ILE DE FRANCE', color: '#EF4444', contacts: [] },
    { name: 'NORD', color: '#3B82F6', contacts: [] },
    { name: 'CHAMPAGNE-ARDENNES', color: '#FACC15', contacts: [] },
    { name: 'ALSACE LORRAINE', color: '#06B6D4', contacts: [] },
    { name: 'BOURGOGNE FRANCHE-COMTE', color: '#10B981', contacts: [] },
    { name: 'RHONE-ALPES', color: '#8B5CF6', contacts: [] },
    { name: 'RHONE-ALPES', color: '#8B5CF6', contacts: [] },
    { name: 'RHONE-ALPES', color: '#8B5CF6', contacts: [] },
    { name: 'MEDITERRANEE', color: '#0E7490', contacts: [] }
];

/**
 * Fonction principale pour initialiser la carte de France par régions
 */
export function initFranceRegionsMap(regionsGeoJSON) {
    // Récupération du canvas HTML où dessiner la carte
    const canvas = document.getElementById('france-regions-map');
    if (!canvas) {
        console.error('Canvas #france-regions-map non trouvé');
        return;
    }

    try {
        // Préparation des données pour chaque région
        const regionData = regionsGeoJSON.features.map(feature => {
            const regionName = feature.properties.nom || feature.properties.name;
            // Attribution de la couleur personnalisée selon la région
            const color = regionColors[regionName] || '#94A3B8'; // Gris par défaut
            return {
                feature: feature,      // Géométrie de la région
                value: 1,              // Valeur (ici fixe, peut être dynamique)
                color: color           // Couleur assignée
            };
        });

        // Création de la carte avec Chart.js
        const chart = new Chart(canvas.getContext('2d'), {
            type: 'choropleth',  // Type : carte choroplèthe (colorée par zones)
            data: {
                labels: regionsGeoJSON.features.map(d => d.properties.nom || d.properties.name),  // Noms des régions
                datasets: [{
                    label: 'Régions françaises',
                    data: regionData,
                    // Fonction pour définir la couleur de fond de chaque région
                    backgroundColor: (context) => {
                        if (context.dataIndex === undefined) return '#94A3B8';
                        return context.raw.color;  // Utilise la couleur définie ci-dessus
                    },
                    borderColor: '#FFFFFF',  // Bordure blanche entre les régions
                    borderWidth: 2,          // Épaisseur de la bordure
                    // Effet au survol de la souris
                    hoverBackgroundColor: (context) => {
                        if (context.dataIndex === undefined) return '#64748B';
                        // Assombrit légèrement la couleur au survol
                        return context.raw.color + 'CC';
                    },
                    hoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,              // La carte s'adapte à son conteneur
                maintainAspectRatio: true,     // Garde les proportions
                plugins: {
                    legend: {
                        display: false  // Pas de légende (liste à droite à la place)
                    },
                    tooltip: {
                        // Configuration de l'info-bulle au survol
                        enabled: true,
                        callbacks: {
                            title: (items) => items[0].raw.feature.properties.nom || items[0].raw.feature.properties.name,
                            label: () => 'Cliquez pour voir les contacts'
                        }
                    }
                },
                scales: {
                    projection: {
                        axis: 'x',
                        projection: 'mercator'  // Projection Mercator (standard)
                    }
                },
                // Gestion du clic sur une région
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        const regionName = regionsGeoJSON.features[index].properties.nom || regionsGeoJSON.features[index].properties.name;
                        console.log('Région cliquée:', regionName);
                        // Vous pouvez ajouter ici l'ouverture d'une modal avec les contacts
                    }
                }
            }
        });

    } catch (error) {
        console.error('Erreur lors du chargement de la carte:', error);
    }
}

/**
 * Fonction pour gérer les clics sur les boutons "+" de la liste
 */
export function initRegionButtons() {
    // Sélection de tous les boutons d'expansion
    const expandButtons = document.querySelectorAll('.region-expand-btn');
    
    expandButtons.forEach(button => {
        button.addEventListener('click', function() {
            const regionName = this.dataset.region;  // Récupération du nom de région
            const contactsDiv = this.nextElementSibling;  // Div contenant les contacts
            
            if (contactsDiv && contactsDiv.classList.contains('region-contacts')) {
                // Toggle de l'affichage des contacts
                if (contactsDiv.style.display === 'none' || !contactsDiv.style.display) {
                    contactsDiv.style.display = 'block';
                    this.textContent = '−';  // Change le "+" en "−"
                } else {
                    contactsDiv.style.display = 'none';
                    this.textContent = '+';
                }
            }
            
            console.log('Région sélectionnée:', regionName);
        });
    });
}