@extends('layouts.app')

@section('title', 'Devis - Coffret Industrie')
@section('page_title', 'Demande de Devis')
@section('subtitle', 'Coffret Industrie BALS')

@section('content')
    {{-- Section Contact (Utilise le même bloc que Chantier) --}}
    @include('partials.form-contact')

    {{-- Navigation entre types de coffrets --}}
    @include('configurateur.partials.nav-type')

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
        <div class="bg-bals-blue text-white px-6 py-3 font-black italic uppercase tracking-widest text-center">
            Caractéristiques Techniques
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Matériau --}}
            <div class="space-y-3">
                @foreach(['Caoutchouc', 'Métallique', 'Plastique'] as $mat)
                <label class="flex items-center gap-3 p-3 border border-slate-100 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                    <input type="radio" name="materiau" value="{{ $mat }}" class="w-5 h-5 accent-bals-blue">
                    <span class="font-bold text-slate-700">{{ $mat }}</span>
                </label>
                @endforeach
            </div>

            {{-- IP --}}
            <div class="border-l border-slate-100 pl-8">
                <p class="text-xs font-black uppercase text-slate-400 mb-4 italic">Indice de protection :</p>
                <div class="space-y-4">
                    @foreach(['IP44', 'IP54', 'IP67'] as $ip)
                    <label class="flex items-center justify-between group cursor-pointer">
                        <span class="font-black text-xl text-slate-300 group-hover:text-bals-blue transition-colors">{{ $ip }}</span>
                        <input type="radio" name="ip" value="{{ $ip }}" class="w-6 h-6 accent-bals-blue">
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tableau des Prises --}}
    @include('partials.table-prises')
    {{-- SCRIPTS JAVASCRIPT --}}
@section('scripts')
    <script src="{{ asset('configurateur/js/configurateur.js') }}"></script>
@endsection

@endsection