/**
 * resources/js/app.js
 *
 * Point d'entrée JavaScript principal de l'application BALS France.
 * Ce fichier est compilé par Vite et chargé sur toutes les pages
 * qui utilisent le layout principal (layouts/app.blade.php).
 *
 * Rôle :
 *   - Importer les dépendances globales (Axios pour les requêtes HTTP)
 *   - Initialiser les comportements communs à toutes les pages
 *
 * Note :
 *   Les scripts spécifiques à une page sont dans public/js/ :
 *     - public/js/france-map.js  → carte interactive
 *     - public/js/admin.js       → back-office agents
 */

import './bootstrap';
