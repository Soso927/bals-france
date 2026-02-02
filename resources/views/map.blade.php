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
        // Initialisation de la carte
        var map = L.map('map').setView([48.8566, 2.3522], 13); // Paris

        // Ajouter un fond de carte (tiles)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Ajouter un marqueur
        L.marker([48.8566, 2.3522]).addTo(map)
            .bindPopup('Paris, France')
            .openPopup();
    </script>
</body>
</html>
