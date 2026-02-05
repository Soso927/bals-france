{{-- 
=============================================================================
FICHIER LAYOUT - TEMPLATE PRINCIPAL
=============================================================================

EXPLICATION SIMPLE :
Ce fichier est le "squelette" de toutes les pages du configurateur.
Il contient tout ce qui est commun à toutes les pages :
- L'en-tête HTML (head)
- Le lien vers le CSS
- La structure générale (2 colonnes)
- Le résumé sur la droite
- Les scripts JavaScript

FICHIER À PLACER DANS : resources/views/configurateur/layout.blade.php

Les autres pages (coffret-chantier, coffret-etage, etc.) vont "hériter" 
de ce layout avec la directive @extends('configurateur.layout')
============================================================================= 
--}}

<!DOCTYPE html>
{{-- 
    EXPLICATION : app()->getLocale() récupère la langue de l'application
    str_replace remplace les "_" par "-" (ex: fr_FR devient fr-FR)
--}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- ================================================================
         BALISES META
         Informations sur la page pour le navigateur
    ================================================================ --}}
    
    {{-- Encodage des caractères (accents français) --}}
    <meta charset="UTF-8">
    
    {{-- Adaptation aux mobiles (responsive design) --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- 
        CSRF Token : Protection contre les attaques CSRF
        Laravel utilise ce token pour sécuriser les formulaires
    --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- ================================================================
         TITRE DE LA PAGE
         @yield('titre') = récupère le titre défini dans la page enfant
         'Configurateur de Devis BALS' = valeur par défaut si non défini
    ================================================================ --}}
    <title>@yield('titre', 'Configurateur de Devis BALS')</title>
    
    {{-- ================================================================
         FEUILLE DE STYLE CSS
         
         asset() génère le chemin complet vers le fichier CSS
         Résultat : /css/configurateur.css
         
         Ce lien est dans le layout donc TOUTES les pages auront ce CSS
         automatiquement (pas besoin de le répéter dans chaque fichier)
    ================================================================ --}}
    <link rel="stylesheet" href="{{ asset('css/configurateur.css') }}">
    
    {{-- 
        @stack('styles') permet aux pages enfants d'ajouter 
        des styles CSS supplémentaires si besoin
    --}}
    @stack('styles')
</head>

<body>
    {{-- ================================================================
         CONTENEUR PRINCIPAL
         Structure en 2 colonnes : Formulaire | Résumé
    ================================================================ --}}
    <div class="app-container">
        
        {{-- ============================================================
             COLONNE GAUCHE : FORMULAIRE
             Le contenu varie selon la page (chantier, étage, industrie...)
        ============================================================ --}}
        <div class="form-column">
            <div class="form-wrapper">
                {{-- 
                    @yield('contenu') 
                    = Ici sera injecté le contenu de la page enfant
                    Chaque page définit son contenu avec @section('content')
                --}}
                @yield('contenu')
                @push('styles')
            </div>
        </div>
        
        {{-- ============================================================
             COLONNE DROITE : RÉSUMÉ EN TEMPS RÉEL
             Cette partie est identique sur toutes les pages
        ============================================================ --}}
        <div class="summary-column">
            <div class="summary-sticky">
                
                {{-- Titre du résumé --}}
                <div class="summary-header">
                    <h3>Résumé de Configuration</h3>
                    <p class="summary-subtitle">Devis en temps réel</p>
                </div>
                
                {{-- 
                    Zone qui sera remplie par JavaScript
                    Affiche les informations saisies en temps réel
                --}}
                <div class="summary-content" id="summaryList">
                    {{-- État vide par défaut (avant saisie) --}}
                    <div class="empty-state">
                        {{-- Icône SVG de document --}}
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15M9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.10457 15 5M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5M12 12H15M12 16H15M9 12H9.01M9 16H9.01"
                                stroke="rgba(255,255,255,0.3)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p>Configurez votre produit</p>
                        <small>Les informations apparaîtront ici</small>
                    </div>
                </div>
                
                {{-- ========================================================
                     BOUTONS D'ACTION
                     Reset | Copier | Envoyer par email
                ======================================================== --}}
                <div class="summary-footer">
                    <div class="summary-actions">
                        
                        {{-- Bouton pour réinitialiser le formulaire --}}
                        <button type="button" class="btn btn-icon" onclick="resetForm()" title="Réinitialiser">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 7L5 21M5 7L19 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        
                        {{-- Bouton pour copier le résumé --}}
                        <button type="button" class="btn btn-secondary" onclick="copierTexte()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 16H6C4.89543 16 4 15.1046 4 14V6C4 4.89543 4.89543 4 6 4H14C15.1046 4 16 4.89543 16 6V8M10 20H18C19.1046 20 20 19.1046 20 18V10C20 8.89543 19.1046 8 18 8H10C8.89543 8 8 8.89543 8 10V18C8 19.1046 8.89543 20 10 20Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Copier
                        </button>
                        
                        {{-- Bouton pour envoyer par email --}}
                        <button type="button" class="btn btn-primary" onclick="generateMailto()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 8L10.89 13.26C11.2187 13.4793 11.6049 13.5963 12 13.5963C12.3951 13.5963 12.7813 13.4793 13.11 13.26L21 8M5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Envoyer
                        </button>
                    </div>
                    
                    {{-- Adresse email de destination --}}
                    <p class="summary-help">
                        Destination : <strong><a href="mailto:info@bals-france.fr">info@bals-france.fr</a></strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================
         SCRIPTS JAVASCRIPT
         
         @yield('scripts') permet aux pages enfants d'ajouter 
         leurs propres scripts JavaScript
    ================================================================ --}}
    @yield('scripts')
    
    {{-- 
        @stack('scripts') est une alternative à @yield
        Permet d'empiler plusieurs scripts avec @push
    --}}
    @stack('scripts')
</body>
</html>

{{-- 
=============================================================================
NOTES POUR LE JURY - COMPRENDRE LE SYSTÈME DE LAYOUT
=============================================================================

PRINCIPE DU LAYOUT (Template Inheritance) :
-------------------------------------------
Le layout est comme un "moule" pour toutes les pages.
Les pages enfants viennent "remplir" les zones @yield du layout.

EXEMPLE CONCRET :
-----------------
1. Le layout définit : @yield('contenu')
2. La page coffret-chantier définit : @section('contenu') ... @endsection
3. Laravel remplace @yield('contenu') par le contenu de la section

AVANTAGES :
-----------
✓ Le CSS est chargé UNE SEULE FOIS dans le layout
✓ Pas de duplication de code
✓ Modification facile (changer le layout = toutes les pages changent)
✓ Code plus propre et maintenable

DIRECTIVES BLADE UTILISÉES :
----------------------------
@yield('nom')      → Définit une zone à remplir
@section('nom')    → Remplit une zone @yield
@extends('layout') → Hérite d'un layout
@stack('nom')      → Zone pour empiler du contenu
@push('nom')       → Ajoute du contenu à un @stack
{{ }}              → Affiche une variable (sécurisé)
{!! !!}            → Affiche du HTML brut (non sécurisé)
============================================================================= 
--}}