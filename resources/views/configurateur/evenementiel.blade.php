@extends('layouts.app')

@section('page_title', 'Demande de Devis')
@section('subtitle', 'Coffret Événementiel BALS')

@section('content')
    @include('partials.form-contact')

    {{-- Navigation entre types de coffrets --}}
    @include('configurateur.partials.nav-type')

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
        <div class="bg-bals-blue text-white px-6 py-3 font-black italic uppercase tracking-widest text-center">
            Caractéristiques Techniques
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="grid grid-cols-1 gap-2">
                <p class="text-[10px] font-black uppercase text-slate-400 mb-2">Montage & Matériaux</p>
                @foreach(['Fixe', 'Mobile', 'Mobile sur pied', 'Caoutchouc', 'Métallique (fixe)', 'Plastique', 'Gamme EVOBOX (mobile)', 'Flight-cases (mobile)'] as $opt)
                <label class="flex items-center gap-3 px-3 py-2 border border-slate-50 rounded group cursor-pointer hover:bg-slate-50">
                    <input type="checkbox" name="tech[]" value="{{ $opt }}" class="accent-bals-blue">
                    <span class="text-sm font-bold text-slate-600 italic">{{ $opt }}</span>
                </label>
                @endforeach
            </div>
            
            <div class="bg-slate-50 rounded-xl p-6 flex flex-col justify-center">
                <p class="text-center font-black italic text-slate-400 mb-4 uppercase">Indice de protection</p>
                <div class="flex flex-col gap-4">
                    @foreach(['IP44', 'IP54', 'IP67'] as $ip)
                        <label class="flex items-center gap-4 bg-white p-4 rounded-lg shadow-sm border border-slate-100">
                            <input type="radio" name="ip" value="{{ $ip }}" class="w-5 h-5 accent-bals-blue">
                            <span class="font-black text-2xl text-slate-700">{{ $ip }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('partials.table-prises')
    {{-- SCRIPTS JAVASCRIPT --}}
@section('scripts')
    <script src="{{ asset('configurateur/js/configurateur.js') }}"></script>
@endsection

@endsection