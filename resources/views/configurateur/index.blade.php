@extends('layouts.configurateur')

@section('title', 'Configurateurs de devis — BALS')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- En-tête --}}
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-black text-gray-900">Configurateurs de devis</h1>
        <p class="text-gray-500 mt-2">Choisissez le type de coffret pour démarrer votre configuration personnalisée.</p>
    </div>

    {{-- Grille des configurateurs --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        {{-- Coffret Chantier --}}
        <a href="{{ route('configurateur.chantier') }}"
           class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:border-bals-blue hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-bals-blue/10 flex items-center justify-center mb-4 group-hover:bg-bals-blue/20 transition-colors">
                <svg class="w-6 h-6 text-bals-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h2 class="font-black text-gray-900 text-lg group-hover:text-bals-blue transition-colors">Coffret Chantier</h2>
            <p class="text-gray-500 text-sm mt-1">Distribution électrique mobile ou fixe pour chantiers BTP.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-bals-blue text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                Configurer →
            </span>
        </a>

        {{-- Coffret d'Étage --}}
        <a href="{{ route('configurateur.etage') }}"
           class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:border-bals-blue hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-bals-blue/10 flex items-center justify-center mb-4 group-hover:bg-bals-blue/20 transition-colors">
                <svg class="w-6 h-6 text-bals-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <h2 class="font-black text-gray-900 text-lg group-hover:text-bals-blue transition-colors">Coffret d'Étage</h2>
            <p class="text-gray-500 text-sm mt-1">Distribution par niveau pour immeubles et bâtiments tertiaires.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-bals-blue text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                Configurer →
            </span>
        </a>

        {{-- Coffret Industrie --}}
        <a href="{{ route('configurateur.industrie') }}"
           class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:border-bals-blue hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-bals-blue/10 flex items-center justify-center mb-4 group-hover:bg-bals-blue/20 transition-colors">
                <svg class="w-6 h-6 text-bals-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h2 class="font-black text-gray-900 text-lg group-hover:text-bals-blue transition-colors">Coffret Industrie</h2>
            <p class="text-gray-500 text-sm mt-1">Solutions robustes pour environnements industriels exigeants.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-bals-blue text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                Configurer →
            </span>
        </a>

        {{-- Coffret Événementiel --}}
        <a href="{{ route('configurateur.evenementiel') }}"
           class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:border-bals-blue hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-bals-blue/10 flex items-center justify-center mb-4 group-hover:bg-bals-blue/20 transition-colors">
                <svg class="w-6 h-6 text-bals-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
            <h2 class="font-black text-gray-900 text-lg group-hover:text-bals-blue transition-colors">Coffret Événementiel</h2>
            <p class="text-gray-500 text-sm mt-1">Distribution électrique pour spectacles, concerts et événements.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-bals-blue text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                Configurer →
            </span>
        </a>

        {{-- Prise Industrielle --}}
        <a href="{{ route('configurateur.prise-industrielle') }}"
           class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:border-bals-blue hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-bals-blue/10 flex items-center justify-center mb-4 group-hover:bg-bals-blue/20 transition-colors">
                <svg class="w-6 h-6 text-bals-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h2 class="font-black text-gray-900 text-lg group-hover:text-bals-blue transition-colors">Prise Industrielle</h2>
            <p class="text-gray-500 text-sm mt-1">Prises CEE et connecteurs pour applications industrielles.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-bals-blue text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                Configurer →
            </span>
        </a>

    </div>

    {{-- Bandeau aide --}}
    <div class="mt-10 bg-bals-blue/5 border border-bals-blue/20 rounded-2xl p-6 flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-bals-blue/10 flex items-center justify-center">
            <svg class="w-5 h-5 text-bals-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="font-bold text-gray-800 text-sm">Besoin d'aide pour choisir ?</p>
            <p class="text-gray-500 text-sm">Contactez votre agent BALS régional ou appelez-nous — nous vous orientons vers la solution adaptée.</p>
        </div>
    </div>

</div>
@endsection
