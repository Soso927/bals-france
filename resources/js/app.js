import './bootstrap';
// import initFranceMap  from './france-regions-map';
import {
  Chart,
  ChoroplethController,
  GeoFeature,
  ColorScale,
  ProjectionScale
} from 'chartjs-chart-geo';


Chart.register(
  ChoroplethController,
  GeoFeature,
  ColorScale,
  ProjectionScale
);


// Initialisation quand le DOM est chargé
document.addEventListener('DOMContentLoaded', () => {
    // Initialise la carte de France
    initFranceRegionsMap();
    
    // Initialise les boutons d'expansion des régions
    initRegionButtons();
});