/**
 * ============================================
 * CARTE INTERACTIVE BALS - JavaScript
 * ============================================
 * 
 * Ce fichier gère toute l'interactivité de la carte :
 * - Initialisation de Leaflet
 * - Chargement des données depuis l'API Laravel
 * - Filtres et recherche
 * - Géolocalisation
 * - Clustering des marqueurs
 * - Popups et interactions
 */

// ============================================
// VARIABLES GLOBALES
// ============================================
let map; // Instance de la carte Leaflet
let markersCluster; // Groupe de marqueurs avec clustering
let allLocations = []; // Toutes les locations chargées
let currentMarkers = []; // Marqueurs actuellement affichés

// ============================================
// INITIALISATION AU CHARGEMENT DE LA PAGE
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🗺️ Initialisation de la carte BALS...');
    
    // 1. Initialiser la carte Leaflet
    initMap();
    
    // 2. Charger les emplacements depuis l'API
    loadLocations();
    
    // 3. Attacher les événements aux boutons et filtres
    attachEventListeners();
    
    console.log('✅ Carte initialisée avec succès !');
});

// ============================================
// INITIALISATION DE LA CARTE LEAFLET
// ============================================
function initMap() {
    console.log('📍 Création de la carte Leaflet...');
    
    // Créer la carte centrée sur la France
    map = L.map('map').setView(
        [window.MAP_CONFIG.centerLat, window.MAP_CONFIG.centerLng], 
        window.MAP_CONFIG.defaultZoom
    );
    
    // Ajouter le fond de carte (tuiles OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
        minZoom: 5
    }).addTo(map);
    
    // Initialiser le groupe de clustering
    // Cela regroupe automatiquement les marqueurs proches
    markersCluster = L.markerClusterGroup({
        // Options de clustering
        maxClusterRadius: 80, // Rayon de regroupement en pixels
        spiderfyOnMaxZoom: true, // Déployer les marqueurs au zoom max
        showCoverageOnHover: true, // Montrer la zone couverte au survol
        zoomToBoundsOnClick: true, // Zoomer sur le cluster au clic
        
        // Personnalisation de l'icône du cluster
        iconCreateFunction: function(cluster) {
            const count = cluster.getChildCount();
            let size = 'small';
            let color = window.MAP_CONFIG.colors.blue;
            
            // Taille et couleur selon le nombre de marqueurs
            if (count > 50) {
                size = 'large';
                color = window.MAP_CONFIG.colors.red;
            } else if (count > 20) {
                size = 'medium';
            }
            
            return L.divIcon({
                html: `<div style="background: ${color}"><span>${count}</span></div>`,
                className: `marker-cluster marker-cluster-${size}`,
                iconSize: L.point(40, 40)
            });
        }
    });
    
    map.addLayer(markersCluster);
    
    console.log('✅ Carte créée !');
}

// ============================================
// CHARGEMENT DES EMPLACEMENTS DEPUIS L'API
// ============================================
async function loadLocations(filters = {}) {
    console.log('📥 Chargement des emplacements...', filters);
    
    // Afficher l'indicateur de chargement
    showLoading(true);
    
    try {
        // Construire l'URL avec les paramètres de filtres
        const params = new URLSearchParams(filters);
        const url = `${window.MAP_CONFIG.apiUrl}?${params.toString()}`;
        
        // Appel API vers Laravel
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            allLocations = data.locations;
            console.log(`✅ ${data.count} emplacements chargés`);
            
            // Afficher les marqueurs sur la carte
            displayMarkers(allLocations);
            
            // Afficher la liste des résultats
            displayResultsList(allLocations);
            
            // Mettre à jour le compteur
            updateResultsCount(data.count);
        } else {
            throw new Error('Erreur dans la réponse API');
        }
        
    } catch (error) {
        console.error('❌ Erreur lors du chargement:', error);
        showError('Impossible de charger les emplacements. Veuillez réessayer.');
    } finally {
        showLoading(false);
    }
}

// ============================================
// AFFICHER LES MARQUEURS SUR LA CARTE
// ============================================
function displayMarkers(locations) {
    console.log(`📍 Affichage de ${locations.length} marqueurs...`);
    
    // Effacer les anciens marqueurs
    markersCluster.clearLayers();
    currentMarkers = [];
    
    // Créer un marqueur pour chaque emplacement
    locations.forEach(location => {
        const marker = createMarker(location);
        currentMarkers.push(marker);
        markersCluster.addLayer(marker);
    });
    
    // Si au moins un marqueur, ajuster la vue pour tout voir
    if (locations.length > 0) {
        const bounds = markersCluster.getBounds();
        if (bounds.isValid()) {
            map.fitBounds(bounds, { padding: [50, 50] });
        }
    }
    
    console.log('✅ Marqueurs affichés !');
}

// ============================================
// CRÉER UN MARQUEUR PERSONNALISÉ
// ============================================
function createMarker(location) {
    // Choisir la couleur selon le type
    const color = getColorForType(location.type);
    
    // Créer l'icône personnalisée
    const icon = L.divIcon({
        html: `
            <div class="custom-marker" style="background: ${color}">
                <span class="marker-emoji">${location.icone}</span>
            </div>
        `,
        className: 'custom-marker-container',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });
    
    // Créer le marqueur
    const marker = L.marker([location.latitude, location.longitude], { icon });
    
    // Créer le contenu de la popup
    const popupContent = createPopupContent(location);
    marker.bindPopup(popupContent, {
        maxWidth: 300,
        className: 'custom-popup'
    });
    
    // Événements du marqueur
    marker.on('click', function() {
        highlightResult(location.id);
    });
    
    // Stocker l'ID dans le marqueur pour le retrouver
    marker.locationId = location.id;
    
    return marker;
}

// ============================================
// CRÉER LE CONTENU DE LA POPUP
// ============================================
function createPopupContent(location) {
    return `
        <div class="popup-content">
            <div class="popup-header">
                ${location.icone} ${location.nom}
            </div>
            <div class="popup-type">
                <span class="result-type ${location.type}">${location.type}</span>
            </div>
            <div class="popup-info">
                <p><strong>📍 Adresse :</strong><br>${location.adresse}</p>
                ${location.telephone ? `<p><strong>📞 Téléphone :</strong><br>${location.telephone}</p>` : ''}
                ${location.email ? `<p><strong>✉️ Email :</strong><br>${location.email}</p>` : ''}
                ${location.description ? `<p>${location.description}</p>` : ''}
            </div>
            <a href="https://www.google.com/maps/search/?api=1&query=${location.latitude},${location.longitude}" 
               target="_blank" 
               class="popup-btn">
                🗺️ Ouvrir dans Google Maps
            </a>
        </div>
    `;
}

// ============================================
// AFFICHER LA LISTE DES RÉSULTATS
// ============================================
function displayResultsList(locations) {
    const container = document.getElementById('results-list');
    
    if (locations.length === 0) {
        container.innerHTML = `
            <p class="text-muted text-center">
                Aucun résultat trouvé.<br>
                Essayez de modifier vos filtres.
            </p>
        `;
        return;
    }
    
    // Générer le HTML pour chaque résultat
    const html = locations.map(location => `
        <div class="result-card" data-id="${location.id}" onclick="focusOnLocation(${location.id})">
            <div class="result-header">
                <span class="result-icon">${location.icone}</span>
                <span class="result-title">${location.nom}</span>
                <span class="result-type ${location.type}">${location.type}</span>
            </div>
            <div class="result-address">${location.adresse}</div>
            ${location.telephone ? `<div class="result-contact">📞 ${location.telephone}</div>` : ''}
        </div>
    `).join('');
    
    container.innerHTML = html;
}

// ============================================
// FOCUS SUR UN EMPLACEMENT SPÉCIFIQUE
// ============================================
function focusOnLocation(locationId) {
    console.log(`🎯 Focus sur l'emplacement ${locationId}`);
    
    // Trouver le marqueur correspondant
    const marker = currentMarkers.find(m => m.locationId === locationId);
    
    if (marker) {
        // Zoomer sur le marqueur
        map.setView(marker.getLatLng(), 14, {
            animate: true,
            duration: 0.5
        });
        
        // Ouvrir la popup
        setTimeout(() => {
            marker.openPopup();
        }, 500);
        
        // Surligner dans la liste
        highlightResult(locationId);
    }
}

// ============================================
// SURLIGNER UN RÉSULTAT DANS LA LISTE
// ============================================
function highlightResult(locationId) {
    // Retirer l'ancienne surbrillance
    document.querySelectorAll('.result-card').forEach(card => {
        card.classList.remove('active');
    });
    
    // Ajouter la surbrillance au nouveau
    const card = document.querySelector(`.result-card[data-id="${locationId}"]`);
    if (card) {
        card.classList.add('active');
        card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// ============================================
// ATTACHER LES ÉVÉNEMENTS AUX BOUTONS
// ============================================
function attachEventListeners() {
    // Bouton de recherche
    document.getElementById('btn-search').addEventListener('click', applyFilters);
    
    // Bouton de géolocalisation
    document.getElementById('btn-geolocation').addEventListener('click', findNearestLocation);
    
    // Bouton reset
    document.getElementById('btn-reset').addEventListener('click', resetFilters);
    
    // Bouton plein écran
    document.getElementById('btn-fullscreen').addEventListener('click', toggleFullscreen);
    
    // Bouton "ma position"
    document.getElementById('btn-my-location').addEventListener('click', centerOnUserLocation);
    
    // Recherche en temps réel sur la ville
    const villeInput = document.getElementById('filter-ville');
    let searchTimeout;
    villeInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 500); // Attendre 500ms après la saisie
    });
}

// ============================================
// APPLIQUER LES FILTRES
// ============================================
function applyFilters() {
    const filters = {
        type: document.getElementById('filter-type').value,
        region: document.getElementById('filter-region').value,
        ville: document.getElementById('filter-ville').value
    };
    
    // Supprimer les valeurs vides
    Object.keys(filters).forEach(key => {
        if (!filters[key] || filters[key] === 'all') {
            delete filters[key];
        }
    });
    
    console.log('🔍 Application des filtres:', filters);
    loadLocations(filters);
}

// ============================================
// RÉINITIALISER LES FILTRES
// ============================================
function resetFilters() {
    document.getElementById('filter-type').value = 'all';
    document.getElementById('filter-region').value = '';
    document.getElementById('filter-ville').value = '';
    
    loadLocations();
}

// ============================================
// TROUVER L'EMPLACEMENT LE PLUS PROCHE
// ============================================
async function findNearestLocation() {
    console.log('📍 Recherche de l\'emplacement le plus proche...');
    
    if (!navigator.geolocation) {
        alert(window.MAP_CONFIG.lang.geolocationNotSupported);
        return;
    }
    
    showLoading(true);
    
    navigator.geolocation.getCurrentPosition(
        async (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            try {
                const response = await fetch(
                    `${window.MAP_CONFIG.apiClosestUrl}?lat=${lat}&lng=${lng}`
                );
                const data = await response.json();
                
                if (data.success) {
                    const location = data.location;
                    console.log(`✅ Emplacement le plus proche: ${location.nom} (${data.distance_km} km)`);
                    
                    // Zoomer sur cet emplacement
                    focusOnLocation(location.id);
                    
                    // Afficher une notification
                    alert(`📍 L'emplacement le plus proche est "${location.nom}" à ${data.distance_km} km de vous.`);
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('❌ Erreur:', error);
                alert('Erreur lors de la recherche du plus proche.');
            } finally {
                showLoading(false);
            }
        },
        (error) => {
            console.error('❌ Erreur de géolocalisation:', error);
            alert(window.MAP_CONFIG.lang.geolocationError);
            showLoading(false);
        }
    );
}

// ============================================
// CENTRER SUR LA POSITION DE L'UTILISATEUR
// ============================================
function centerOnUserLocation() {
    if (!navigator.geolocation) {
        alert(window.MAP_CONFIG.lang.geolocationNotSupported);
        return;
    }
    
    navigator.geolocation.getCurrentPosition(
        (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            // Ajouter un marqueur temporaire
            L.marker([lat, lng], {
                icon: L.divIcon({
                    html: '<div style="font-size: 30px;">📍</div>',
                    className: 'user-location-marker'
                })
            }).addTo(map)
              .bindPopup('📍 Vous êtes ici')
              .openPopup();
            
            // Centrer la carte
            map.setView([lat, lng], 12);
        },
        (error) => {
            console.error('❌ Erreur de géolocalisation:', error);
            alert(window.MAP_CONFIG.lang.geolocationError);
        }
    );
}

// ============================================
// PLEIN ÉCRAN
// ============================================
function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        document.exitFullscreen();
    }
}

// ============================================
// UTILITAIRES
// ============================================

// Afficher/masquer le chargement
function showLoading(show) {
    document.getElementById('loading-indicator').style.display = show ? 'block' : 'none';
}

// Afficher une erreur
function showError(message) {
    alert('❌ ' + message);
}

// Mettre à jour le compteur de résultats
function updateResultsCount(count) {
    document.getElementById('results-count').textContent = count;
}

// Obtenir la couleur selon le type
function getColorForType(type) {
    const colors = window.MAP_CONFIG.colors;
    switch(type) {
        case 'distributeur': return colors.blue;
        case 'installateur': return colors.red;
        case 'showroom': return colors.black;
        default: return colors.blue;
    }
}

// ============================================
// STYLES CSS ADDITIONNELS POUR LES MARQUEURS
// ============================================
const style = document.createElement('style');
style.textContent = `
    .custom-marker {
        width: 40px;
        height: 40px;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        border: 2px solid white;
    }
    
    .custom-marker .marker-emoji {
        transform: rotate(45deg);
        font-size: 20px;
    }
    
    .marker-cluster {
        border-radius: 50%;
        text-align: center;
        font-weight: bold;
        color: white;
    }
    
    .marker-cluster div {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
`;
document.head.appendChild(style);

console.log('✅ Script de carte chargé !');