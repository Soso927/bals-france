# 🗺️ Carte Interactive des Régions de France — Bals France

> Module cartographique interactif du site **Bals France**.  
> Permet de localiser et contacter les agents commerciaux par région.

---

## Table des matières

1. [Stack technique](#stack-technique)
2. [Fichiers concernés](#fichiers-concernés)
3. [Comment fonctionne la carte](#comment-fonctionne-la-carte)
4. [Le GeoJSON : france.json](#le-geojson--francejson)
5. [D3.js : du JSON au SVG](#d3js--du-json-au-svg)
6. [Interactions utilisateur](#interactions-utilisateur)
7. [Données de contact](#données-de-contact)
8. [Charte graphique Bals](#charte-graphique-bals)
9. [Routes Laravel](#routes-laravel)

---

## Stack technique

| Technologie | Rôle | Version |
|---|---|---|
| **Laravel 12** | Framework PHP (routing, Blade) | 12.x |
| **D3.js** | Rendu cartographique SVG | v7 |
| **Tailwind CSS** | Utilitaires CSS | CDN |
| **GeoJSON** | Format de données géographiques | — |
| **Google Fonts (Exo 2)** | Typographie (substitut web d'Etelka) | — |

---

## Fichiers concernés

```
resources/views/
└── france-map.blade.php     ← Vue principale (HTML + CSS + JS)

public/data/
└── france.json              ← Données géographiques (101 features)

app/Http/Controllers/
└── MapController.php        ← Contrôleur Laravel

routes/
├── web.php                  ← Route GET /map
└── api.php                  ← Routes API JSON (/api/locations, etc.)
```

---

## Comment fonctionne la carte

### Vue d'ensemble

```
france.json  →  fetch()  →  D3.js  →  SVG  →  Interactions utilisateur
   (disque)    (réseau)   (rendu)   (DOM)      (clic, survol, reset)
```

### Séquence détaillée

```
1. Chargement de la page
        │
        ▼
2. fetch('/data/france.json')
   → Charge le fichier GeoJSON depuis public/data/
        │
        ▼
3. Filtrage des features
   → On garde latitude > 40°N (exclut DOM-TOM : Martinique, Guadeloupe, etc.)
   → Conserve 96 départements de France métropolitaine
        │
        ▼
4. Comptage des départements par région
   → deptCounts['Île-de-France'] = 8, etc.
   → Utilisé dans les badges de la liste latérale
        │
        ▼
5. Création du SVG via D3
   → d3.select('#map-container').append('svg')
   → Dimensions = largeur du conteneur × ratio 0.88
        │
        ▼
6. Calcul de la projection
   → d3.geoMercator().fitSize([W, H], features)
   → D3 calcule automatiquement l'échelle et la translation
     pour que la France remplisse exactement le SVG
        │
        ▼
7. Dessin des départements
   → Un <path> SVG par feature GeoJSON
   → d3.geoPath() convertit coordonnées géo → pixels SVG
   → Couleur = COLORS[région] (22 couleurs distinctes)
        │
        ▼
8. Attachement des événements
   → mousemove  : affiche le tooltip (nom département + zone Bals)
   → mouseleave : masque le tooltip
   → click      : appelle selectRegion()
   → dblclick   : appelle resetMap()
        │
        ▼
9. Génération de la liste latérale
   → Régions uniques extraites, triées alphabétiquement
   → Un <li> par région avec point de couleur + compteur
```

---

## Le GeoJSON : france.json

### Structure d'un feature

```json
{
  "type": "Feature",
  "geometry": {
    "type": "Polygon",
    "coordinates": [[[2.35, 48.85], [2.36, 48.86], "..."]]
  },
  "properties": {
    "name":      "Essonne",
    "region":    "Île-de-France",
    "latitude":  48.533,
    "longitude": 2.2595
  }
}
```

### Champs utilisés par le code

| Champ | Utilisation |
|---|---|
| `geometry` | D3 calcule le tracé SVG du département |
| `properties.name` | Affiché dans le tooltip et l'info-box |
| `properties.region` | Clé pour la couleur + les données de contact |
| `properties.latitude` | Filtre `> 40` pour exclure les DOM-TOM |

> **Note** : le GeoJSON utilise les **anciennes régions** (pré-2016, avant la réforme territoriale).  
> La carte affiche donc 22 régions (ex. : Alsace et Lorraine séparées, pas Grand Est).  
> Les zones commerciales Bals sont calquées sur cette nomenclature.

---

## D3.js : du JSON au SVG

### La projection — `d3.geoMercator().fitSize()`

```js
const projection = d3.geoMercator()
    .fitSize([W, H], { type: 'FeatureCollection', features });
```

`fitSize()` fait deux choses :
1. Calcule l'**échelle** (zoom) pour que les features remplissent `[W × H]` pixels
2. Calcule la **translation** pour centrer la carte dans le SVG

C'est cette méthode qui garantit que la carte remplit son conteneur, quelle que soit la taille d'écran.

### Le générateur de chemins — `d3.geoPath()`

```js
const path = d3.geoPath().projection(projection);
// path(feature) → "M 320 145 L 325 148 Z ..." (coordonnées SVG)
```

Convertit les coordonnées géographiques `[longitude, latitude]` en coordonnées pixel `[x, y]`.

### Le pattern Data Join de D3

```js
svg.selectAll('path')    // Sélectionne tous les <path> (0 au départ)
   .data(features)        // Lie les données GeoJSON
   .enter()               // Pour chaque donnée sans élément DOM...
   .append('path')        // ...crée un <path>
   .attr('d', path)       // Calcule les coordonnées SVG
   .attr('fill', d => COLORS[d.properties.region] || DEFAULT_COLOR);
```

### Responsive — recalcul au resize

```js
window.addEventListener('resize', () => {
    W = container.clientWidth;
    H = Math.round(W * 0.88);
    svg.attr('height', H).attr('viewBox', `0 0 ${W} ${H}`);
    projection.fitSize([W, H], { type: 'FeatureCollection', features });
    svg.selectAll('path').attr('d', path); // Redessine tous les chemins
});
```

---

## Interactions utilisateur

### Clic sur un département → `selectRegion(regionName, deptName)`

```
Clic sur <path>
    ├── Highlight carte
    │   ├── .dimmed sur tous les départements hors-région (opacity: 0.15)
    │   └── .active sur les départements de la région sélectionnée
    ├── Highlight liste latérale
    │   ├── .active sur le <li> correspondant
    │   └── scrollIntoView() pour faire défiler la liste
    ├── Mise à jour de l'info-box
    │   ├── Nom de la zone commerciale Bals
    │   ├── Nom du département cliqué
    │   └── Cartes agents : agence, nom, départements, téléphone, email
    └── Affichage du bouton "Réinitialiser"
```

### Double-clic ou bouton reset → `resetMap()`

```
resetMap()
    ├── Supprime .dimmed et .active de tous les paths
    ├── Supprime .active de tous les <li>
    ├── Remet l'info-box dans son état vide (placeholder)
    └── Masque le bouton reset
```

### Survol → Tooltip

```
mousemove sur <path>
    ├── Affiche le nom du département (properties.name)
    └── Affiche la zone commerciale Bals (CONTACTS[region].zone)

mouseleave
    └── Masque le tooltip (opacity: 0)
```

---

## Données de contact

Les contacts proviennent de **[bals-france.fr/reseau](https://www.bals-france.fr/reseau)** et sont intégrés statiquement dans le fichier Blade dans l'objet JavaScript `CONTACTS`.

### Structure de l'objet CONTACTS

```js
const CONTACTS = {
    'Nom région GeoJSON': {
        zone: 'NOM ZONE COMMERCIALE BALS',
        agents: [
            {
                agence:  'NOM AGENCE (si applicable)',
                nom:     'Prénom NOM',
                depts:   'Dépt. XX, YY, ZZ',
                tel:     '0X XX XX XX XX',   // formaté pour affichage
                telRaw:  '+33XXXXXXXXX',       // pour le lien href="tel:"
                email:   'adresse@domaine.fr'
            }
        ]
    }
}
```

### Correspondance régions GeoJSON → zones commerciales Bals

| Région GeoJSON | Zone commerciale Bals | Agent(s) |
|---|---|---|
| Basse-Normandie | NORMANDIE | Vincent CARPENTIER |
| Haute-Normandie | NORMANDIE | Vincent CARPENTIER |
| Bretagne | BRETAGNE | Isabelle ESPELLE (Agence Bonduelle) |
| Pays de la Loire | PAYS DE LA LOIRE | Isabelle ESPELLE (Agence Bonduelle) |
| Centre | VAL DE LOIRE | Yann GUYADER |
| Poitou-Charentes | VAL DE LOIRE | Yann GUYADER |
| Auvergne | AUVERGNE-LIMOUSIN | Ghislain MONIER |
| Limousin | AUVERGNE-LIMOUSIN | Ghislain MONIER |
| Aquitaine | AQUITAINE | C. NIETRZEBA + JC. SEBILE (RMEE) |
| Midi-Pyrénées | MIDI-PYRÉNÉES | C. RICAUD + S. LIENARD (REPELEC) |
| Languedoc-Roussillon | MÉDITERRANÉE | Fabien RENAUDI |
| Île-de-France | ÎLE-DE-FRANCE | 3 agents Agence DUMAS |
| Nord-Pas-de-Calais | NORD | Francis BESSA |
| Picardie | NORD / CHAMPAGNE | F. BESSA + A. FAUCHART-PETIT |
| Champagne-Ardenne | CHAMPAGNE-ARDENNES | Angéline FAUCHART-PETIT |
| Alsace | ALSACE LORRAINE | Christian VIERLING |
| Lorraine | ALSACE LORRAINE | Christian VIERLING |
| Bourgogne | BOURGOGNE FRANCHE-COMTÉ | Raphaël LEGRAND (Fanjoux) |
| Franche-Comté | BOURGOGNE FRANCHE-COMTÉ | Raphaël LEGRAND (Fanjoux) |
| Rhône-Alpes | RHÔNE-ALPES | 3 agents Agence XPE XPRO ELEC |
| Provence-Alpes-Côte-d'Azur | MÉDITERRANÉE | Fabien RENAUDI |
| Corse | MÉDITERRANÉE | Fabien RENAUDI |

> **Mise à jour des contacts** : modifier directement l'objet `CONTACTS` dans `france-map.blade.php`.  
> Pour une solution dynamique, alimenter ces données via l'API (`MapController::getRegionsData()`).

---

## Charte graphique Bals

Toutes les couleurs respectent le **Bals Style Guide V2016** (page 08 — Colours).

### Variables CSS

| Variable | Valeur | Source Style Guide |
|---|---|---|
| `--bals-blue` | `#0095DA` | Bals Blue — R0 G149 B218 |
| `--bals-red` | `#ED1C24` | Bals Red — R237 G28 B36 |
| `--bals-black` | `#1A1A1A` | Black (légèrement adouci) |
| `--bals-grey` | `#B3B3B3` | Light Grey — R179 G179 B179 |

### 22 couleurs distinctes des régions

Chaque région GeoJSON a sa propre couleur unique. Toutes sont visuellement différentes pour permettre à l'utilisateur de distinguer immédiatement chaque région sur la carte.

| Région | Couleur | Hex |
|---|---|---|
| Alsace | Cyan | `#06B6D4` |
| Aquitaine | Orange | `#F97316` |
| Auvergne | Bleu marine | `#1E3A8A` |
| Basse-Normandie | **Bals Blue officiel** | `#0095DA` |
| Bourgogne | Vert émeraude | `#059669` |
| Bretagne | **Bals Red officiel** | `#ED1C24` |
| Centre | Ambre doré | `#CA8A04` |
| Champagne-Ardenne | Jaune | `#FACC15` |
| Corse | Orange ambré | `#D97706` |
| Franche-Comté | Vert menthe | `#10B981` |
| Haute-Normandie | Bleu roi | `#2563EB` |
| Languedoc-Roussillon | Vert lime | `#65A30D` |
| Limousin | Bleu ciel | `#3B82F6` |
| Lorraine | Bleu canard | `#0891B2` |
| Midi-Pyrénées | Rose | `#EC4899` |
| Nord-Pas-de-Calais | Indigo | `#4F46E5` |
| Pays de la Loire | Violet | `#A855F7` |
| Picardie | Cyan clair | `#22D3EE` |
| Poitou-Charentes | Orange clair | `#FB923C` |
| Provence-Alpes-Côte-d'Azur | Bleu pétrole | `#0E7490` |
| Rhône-Alpes | Violet foncé | `#7C3AED` |
| Île-de-France | Rouge vif | `#DC2626` |

### Typographie

La police **Exo 2** (Google Fonts, gratuite) est utilisée comme substitut web de la police officielle **Etelka** (non disponible gratuitement). Même style géométrique aux angles arrondis, même famille sans-serif large et lisible.

---

## Routes Laravel

### web.php

```php
// Affiche la vue Blade avec la carte
Route::get('/map', [MapController::class, 'index'])->name('map.index');
```

### api.php

```php
// Retourne les régions avec leurs agents (JSON)
Route::get('/regions', [MapController::class, 'getRegionsData']);

// Retourne les agents d'une région spécifique
Route::get('/regions/{id}/agents', [MapController::class, 'getRegionAgents']);

// Recherche un agent
Route::get('/agents/search', [MapController::class, 'searchAgent']);
```

> **Évolution possible** : les données de contact actuellement codées en dur dans `CONTACTS`  
> pourraient être chargées dynamiquement via `fetch('/api/regions')` si elles sont  
> stockées en base de données et exposées via `MapController`.

---

*Documentation — Projet Bals France · Carte interactive des agents commerciaux*  
*Source des contacts : [bals-france.fr/reseau](https://www.bals-france.fr/reseau)*