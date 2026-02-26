import './bootstrap';
// import initFranceMap  from './france-regions-map';



// Initialisation quand le DOM est chargé
document.addEventListener('DOMContentLoaded', () => {
    // Initialise la carte de France
    initFranceRegionsMap();
    
    // Initialise les boutons d'expansion des régions
    initRegionButtons();
});