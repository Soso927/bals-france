<!DOCTYPE html>
<html>
<head>
    <title>Carte interactive</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <style>
        #map { height: 500px; }
    </style>
</head>
<body>
    <div id="map"></div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  // Bornes approx. France métropolitaine (inclut Corse)
  const FR_METRO_BOUNDS = L.latLngBounds(
    [41.0, -5.5],  // Sud-Ouest (proche Espagne / Atlantique)
    [51.6,  9.8]   // Nord-Est (proche Belgique / Allemagne)
  );

  // Initialisation de la carte (sans setView fixe)
  const map = L.map('map', {
    maxBounds: FR_METRO_BOUNDS,
    maxBoundsViscosity: 1.0,   // empêche de "sortir" des limites
  });

  // Affiche automatiquement la France à l'écran
  map.fitBounds(FR_METRO_BOUNDS);

  // Fond de carte
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // Limites de zoom (optionnel mais recommandé)
  map.setMinZoom(5);  // évite de trop dézoomer (voir l'Europe)
  map.setMaxZoom(12); // évite de trop zoomer si tu veux une vue "réseau"
</script>


</body>
</html>
