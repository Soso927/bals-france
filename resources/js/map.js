/**
 * ============================================
 * CARTE INTERACTIVE BALS - VERSION SIMPLIFIÉE
 * ============================================
 * 
 * Ce fichier permet d'afficher une carte de France
 * avec les emplacements BALS (distributeurs, installateurs, showrooms)
 * 
 * Technologies utilisées :
 * - Leaflet.js : bibliothèque pour afficher des cartes
 * - OpenStreetMap : fournit les images de la carte (gratuit)
 * - Laravel : backend qui fournit les données des emplacements
 */


// ============================================
// PARTIE 1 : VARIABLES GLOBALES
// ============================================

// La carte Leaflet (on la stocke pour pouvoir la manipuler partout)
let map;

// Groupe qui contient tous les marqueurs (points sur la carte)
let markersCluster;

// Tableau qui stocke tous les emplacements chargés depuis la base de données
let allLocations = [];


// ============================================
// PARTIE 2 : DÉMARRAGE AU CHARGEMENT DE LA PAGE
// ============================================

// Cette fonction s'exécute automatiquement quand la page est prête
document.addEventListener('DOMContentLoaded', function() {
    
    // Étape 1 : Créer la carte
    initMap();
    
    // Étape 2 : Charger les emplacements depuis Laravel
    loadLocations();
    
    // Étape 3 : Activer les boutons (recherche, filtres, etc.)
    attachEventListeners();
});


// ============================================
// PARTIE 3 : CRÉATION DE LA CARTE (FRANCE UNIQUEMENT)
// ============================================

function initMap() {
    
    // --- CONFIGURATION POUR AFFICHER LA FRANCE ---
    
    // Coordonnées GPS du centre de la France
    const centreFrance = {
        latitude: 46.603354,   // Position nord-sud
        longitude: 1.888334    // Position est-ouest
    };
    
    // Limites de la France (rectangle qui englobe le pays)
    // La carte ne pourra pas sortir de ce rectangle
    const limitesFrance = [
        [41.0, -5.5],   // Coin SUD-OUEST (vers les Pyrénées/Espagne)
        [51.5, 9.5]     // Coin NORD-EST (vers la Belgique/Allemagne)
    ];
    
    // Niveau de zoom par défaut (6 = on voit toute la France)
    const zoomParDefaut = 6;
    
    
    // --- CRÉATION DE LA CARTE ---
    
    // Créer la carte dans l'élément HTML qui a l'id "map"
    map = L.map('map').setView(
        [centreFrance.latitude, centreFrance.longitude],  // Centre
        zoomParDefaut                                      // Zoom
    );
    
    
    // --- BLOQUER LA CARTE SUR LA FRANCE ---
    
    // Empêche l'utilisateur de naviguer en dehors de la France
    map.setMaxBounds(limitesFrance);
    
    // Empêche de trop dézoomer (5 = minimum, sinon on voit le monde entier)
    map.setMinZoom(5);
    
    
    // --- AJOUTER LE FOND DE CARTE ---
    
    // On utilise OpenStreetMap (gratuit et libre de droits)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        
        // Texte affiché en bas de la carte (obligatoire pour OpenStreetMap)
        attribution: '© OpenStreetMap',
        
        // Zoom maximum autorisé (19 = très proche, on voit les bâtiments)
        maxZoom: 19,
        
        // Zoom minimum autorisé (5 = on reste sur la France)
        minZoom: 5
        
    }).addTo(map);  // .addTo(map) ajoute cette couche à notre carte
    
    
    // --- CRÉER LE GROUPE DE MARQUEURS ---
    
    // MarkerClusterGroup regroupe les marqueurs proches automatiquement
    // Exemple : 50 points proches deviennent un cercle avec "50"
    markersCluster = L.markerClusterGroup({
        
        // Distance en pixels pour regrouper les marqueurs
        maxClusterRadius: 80,
        
        // Quand on clique sur un groupe, on zoome dessus
        zoomToBoundsOnClick: true,
        
        // Fonction pour personnaliser l'apparence des groupes
        iconCreateFunction: function(cluster) {
            
            // Compter combien de marqueurs dans ce groupe
            const nombre = cluster.getChildCount();
            
            // Choisir la couleur selon le nombre
            let couleur = '#0095DA';  // Bleu BALS par défaut
            if (nombre > 50) {
                couleur = '#ED1C24';  // Rouge si beaucoup de points
            }
            
            // Créer l'icône du groupe (cercle avec le nombre)
            return L.divIcon({
                html: '<div style="background:' + couleur + '; color:white; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; font-weight:bold;">' + nombre + '</div>',
                className: 'marker-cluster',
                iconSize: [40, 40]
            });
        }
    });
    
    // Ajouter le groupe de marqueurs à la carte
    map.addLayer(markersCluster);
}


// ============================================
// PARTIE 4 : CHARGER LES EMPLACEMENTS (APPEL API)
// ============================================

async function loadLocations(filtres = {}) {
    
    // Afficher "Chargement en cours..."
    showLoading(true);
    
    try {
        // Construire l'URL de l'API avec les filtres
        // Exemple : /api/locations?type=distributeur&region=Paris
        const parametres = new URLSearchParams(filtres);
        const url = '/api/locations?' + parametres.toString();
        
        // Appeler l'API Laravel (fetch = requête HTTP)
        const reponse = await fetch(url);
        
        // Convertir la réponse en objet JavaScript
        const donnees = await reponse.json();
        
        // Vérifier si la requête a réussi
        if (donnees.success) {
            
            // Stocker les emplacements
            allLocations = donnees.locations;
            
            // Afficher les marqueurs sur la carte
            displayMarkers(allLocations);
            
            // Afficher la liste des résultats dans la sidebar
            displayResultsList(allLocations);
            
            // Mettre à jour le compteur "X résultats"
            updateResultsCount(donnees.count);
        }
        
    } catch (erreur) {
        // En cas d'erreur, afficher un message
        console.error('Erreur:', erreur);
        alert('Impossible de charger les emplacements');
    }
    
    // Masquer "Chargement en cours..."
    showLoading(false);
}


// ============================================
// PARTIE 5 : AFFICHER LES MARQUEURS SUR LA CARTE
// ============================================

function displayMarkers(locations) {
    
    // Vider les anciens marqueurs
    markersCluster.clearLayers();
    
    // Pour chaque emplacement, créer un marqueur
    locations.forEach(function(location) {
        
        // Créer le marqueur
        const marqueur = createMarker(location);
        
        // L'ajouter au groupe
        markersCluster.addLayer(marqueur);
    });
    
    // Ajuster la vue pour voir tous les marqueurs
    if (locations.length > 0) {
        const limites = markersCluster.getBounds();
        map.fitBounds(limites, { padding: [50, 50] });
    }
}


// ============================================
// PARTIE 6 : CRÉER UN MARQUEUR
// ============================================

function createMarker(location) {
    
    // Choisir la couleur selon le type d'emplacement
    let couleur;
    switch (location.type) {
        case 'distributeur':
            couleur = '#0095DA';  // Bleu BALS
            break;
        case 'installateur':
            couleur = '#ED1C24';  // Rouge BALS
            break;
        case 'showroom':
            couleur = '#000000';  // Noir
            break;
        default:
            couleur = '#0095DA';  // Bleu par défaut
    }
    
    // Créer l'icône personnalisée (forme de goutte)
    const icone = L.divIcon({
        html: '<div style="background:' + couleur + '; width:30px; height:30px; border-radius:50% 50% 50% 0; transform:rotate(-45deg); display:flex; align-items:center; justify-content:center; border:2px solid white;"><span style="transform:rotate(45deg);">' + location.icone + '</span></div>',
        className: 'custom-marker',
        iconSize: [30, 30],
        iconAnchor: [15, 30]  // Point d'ancrage (bas du marqueur)
    });
    
    // Créer le marqueur à la position GPS
    const marqueur = L.marker(
        [location.latitude, location.longitude],
        { icon: icone }
    );
    
    // Créer le contenu de la popup (bulle d'info au clic)
    const contenuPopup = `
        <div style="font-family: Arial, sans-serif;">
            <h3 style="color: #0095DA; margin: 0 0 10px 0;">
                ${location.icone} ${location.nom}
            </h3>
            <p style="margin: 5px 0;">
                <strong>Type :</strong> ${location.type}
            </p>
            <p style="margin: 5px 0;">
                <strong>Adresse :</strong> ${location.adresse}
            </p>
            <p style="margin: 5px 0;">
                <strong>Ville :</strong> ${location.ville}
            </p>
            ${location.telephone ? '<p style="margin: 5px 0;"><strong>Tél :</strong> ' + location.telephone + '</p>' : ''}
            ${location.email ? '<p style="margin: 5px 0;"><strong>Email :</strong> ' + location.email + '</p>' : ''}
            <a href="https://www.google.com/maps/search/?api=1&query=${location.latitude},${location.longitude}" 
               target="_blank" 
               style="display:inline-block; margin-top:10px; padding:8px 16px; background:#0095DA; color:white; text-decoration:none; border-radius:5px;">
                Itinéraire
            </a>
        </div>
    `;
    
    // Attacher la popup au marqueur
    marqueur.bindPopup(contenuPopup);
    
    return marqueur;
}


// ============================================
// PARTIE 7 : AFFICHER LA LISTE DES RÉSULTATS
// ============================================

function displayResultsList(locations) {
    
    // Récupérer l'élément HTML où afficher la liste
    const container = document.getElementById('results-list');
    
    // Vider l'ancien contenu
    container.innerHTML = '';
    
    // Si aucun résultat
    if (locations.length === 0) {
        container.innerHTML = '<p style="text-align:center; color:#999;">Aucun emplacement trouvé</p>';
        return;
    }
    
    // Pour chaque emplacement, créer une carte dans la liste
    locations.forEach(function(location) {
        
        // Créer l'élément HTML
        const carte = document.createElement('div');
        carte.className = 'result-card';
        carte.setAttribute('data-id', location.id);
        
        // Remplir le contenu
        carte.innerHTML = `
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="font-size:24px;">${location.icone}</span>
                <div>
                    <strong>${location.nom}</strong>
                    <br>
                    <small style="color:#666;">${location.ville}</small>
                </div>
            </div>
        `;
        
        // Au clic, zoomer sur cet emplacement
        carte.addEventListener('click', function() {
            focusOnLocation(location.id);
        });
        
        // Ajouter la carte à la liste
        container.appendChild(carte);
    });
}


// ============================================
// PARTIE 8 : ZOOMER SUR UN EMPLACEMENT
// ============================================

function focusOnLocation(locationId) {
    
    // Chercher l'emplacement dans notre tableau
    const location = allLocations.find(function(loc) {
        return loc.id === locationId;
    });
    
    if (location) {
        // Centrer la carte sur cet emplacement
        map.setView([location.latitude, location.longitude], 15);
        
        // Trouver et ouvrir le marqueur correspondant
        markersCluster.eachLayer(function(marqueur) {
            if (marqueur.getLatLng().lat === location.latitude &&
                marqueur.getLatLng().lng === location.longitude) {
                marqueur.openPopup();
            }
        });
    }
}


// ============================================
// PARTIE 9 : GÉRER LES BOUTONS ET FILTRES
// ============================================

function attachEventListeners() {
    
    // Bouton "Rechercher"
    document.getElementById('btn-search').addEventListener('click', applyFilters);
    
    // Bouton "Réinitialiser"
    document.getElementById('btn-reset').addEventListener('click', resetFilters);
    
    // Bouton "Me géolocaliser"
    document.getElementById('btn-geolocation').addEventListener('click', findNearestLocation);
}


// Appliquer les filtres sélectionnés
function applyFilters() {
    
    // Récupérer les valeurs des filtres
    const filtres = {
        type: document.getElementById('filter-type').value,
        region: document.getElementById('filter-region').value,
        ville: document.getElementById('filter-ville').value
    };
    
    // Supprimer les filtres vides
    if (!filtres.type || filtres.type === 'all') delete filtres.type;
    if (!filtres.region) delete filtres.region;
    if (!filtres.ville) delete filtres.ville;
    
    // Recharger les emplacements avec ces filtres
    loadLocations(filtres);
}


// Réinitialiser tous les filtres
function resetFilters() {
    
    // Remettre les valeurs par défaut
    document.getElementById('filter-type').value = 'all';
    document.getElementById('filter-region').value = '';
    document.getElementById('filter-ville').value = '';
    
    // Recharger tous les emplacements
    loadLocations();
}


// ============================================
// PARTIE 10 : GÉOLOCALISATION
// ============================================

function findNearestLocation() {
    
    // Vérifier si le navigateur supporte la géolocalisation
    if (!navigator.geolocation) {
        alert('Votre navigateur ne supporte pas la géolocalisation');
        return;
    }
    
    // Demander la position de l'utilisateur
    navigator.geolocation.getCurrentPosition(
        
        // Si succès
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            // Ajouter un marqueur "Vous êtes ici"
            L.marker([lat, lng])
                .addTo(map)
                .bindPopup('📍 Vous êtes ici')
                .openPopup();
            
            // Centrer la carte sur la position
            map.setView([lat, lng], 12);
        },
        
        // Si erreur
        function(erreur) {
            alert('Impossible de vous localiser. Vérifiez les permissions.');
        }
    );
}


// ============================================
// PARTIE 11 : FONCTIONS UTILITAIRES
// ============================================

// Afficher ou masquer l'indicateur de chargement
function showLoading(afficher) {
    const indicateur = document.getElementById('loading-indicator');
    if (indicateur) {
        indicateur.style.display = afficher ? 'block' : 'none';
    }
}


// Mettre à jour le compteur de résultats
function updateResultsCount(nombre) {
    const compteur = document.getElementById('results-count');
    if (compteur) {
        compteur.textContent = nombre;
    }
}


// ============================================
// FIN DU SCRIPT
// ============================================
console.log('✅ Script de la carte chargé avec succès !');