@extends('layouts.app')

@section('subtitle', 'Prises Industrielles BALS')

@section('content')
    @include('partials.form-contact')

    {{-- PRODUIT SELECTION --}}
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <div class="bg-bals-blue text-white px-6 py-2 font-black italic uppercase text-sm">Produit</div>
        <div class="p-4 grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach(['Socle Saillie', 'Socle Tableau Droit', 'Prolongateur', 'Fiche'] as $prod)
            <label class="cursor-pointer group">
                <input type="radio" name="produit" value="{{ $prod }}" class="peer sr-only">
                <div class="h-full border-2 border-slate-100 rounded-xl p-4 text-center peer-checked:border-bals-blue peer-checked:bg-blue-50 transition-all">
                    <div class="w-12 h-12 bg-slate-100 rounded-lg mx-auto mb-2 group-hover:scale-110 transition-transform flex items-center justify-center">
                        <span class="text-[10px] font-black text-slate-400">IMG</span>
                    </div>
                    <span class="text-[10px] font-black uppercase leading-tight">{{ $prod }}</span>
                </div>
            </label>
            @endforeach
        </div>
    </div>

    {{-- TENSION (Grid Couleurs) --}}
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <div class="bg-bals-blue text-white px-6 py-2 font-black italic uppercase text-sm italic">Tension</div>
        <div class="p-4 space-y-4">
            {{-- BT Section --}}
            <div class="grid grid-cols-2 md:grid-cols-7 gap-2">
                @php
                    $bt = [
                        ['v' => '110V', 'c' => 'bg-yellow-400', 'hz' => '50-60Hz'],
                        ['v' => '230V', 'c' => 'bg-blue-500', 'hz' => '50-60Hz'],
                        ['v' => '400V', 'c' => 'bg-red-500', 'hz' => '50-60Hz'],
                        ['v' => '>50V', 'c' => 'bg-green-600', 'hz' => '100-300Hz'],
                        ['v' => '440V', 'c' => 'bg-red-700', 'hz' => '60Hz'],
                    ];
                @endphp
                @foreach($bt as $item)
                <label class="cursor-pointer">
                    <input type="radio" name="tension" value="{{ $item['v'] }}" class="peer sr-only">
                    <div class="border border-slate-200 rounded overflow-hidden peer-checked:ring-2 peer-checked:ring-bals-blue">
                        <div class="{{ $item['c'] }} h-4"></div>
                        <div class="p-2 text-center">
                            <div class="font-black text-xs">{{ $item['v'] }}</div>
                            <div class="text-[8px] text-slate-400">{{ $item['hz'] }}</div>
                        </div>
                    </div>
                </label>
                @endforeach
                {{-- Tension Libre --}}
                <label class="col-span-2 border-2 border-dashed border-slate-200 rounded flex items-center justify-center p-2 cursor-pointer peer-checked:bg-slate-50">
                     <input type="radio" name="tension" value="Libre" class="mr-2">
                     <span class="text-[10px] font-black uppercase">Tension libre</span>
                </label>
            </div>
        </div>
    </div>

    {{-- INTENSITÉ & POLARITÉ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="bg-bals-blue text-white px-6 py-2 font-black italic uppercase text-sm">Intensité</div>
            <div class="p-4 grid grid-cols-4 gap-2">
                @foreach(['16A', '32A', '63A', '125A'] as $amp)
                <label class="flex flex-col items-center gap-2 p-2 border border-slate-100 rounded">
                    <input type="radio" name="amp" value="{{ $amp }}">
                    <span class="text-xs font-bold">{{ $amp }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="bg-bals-blue text-white px-6 py-2 font-black italic uppercase text-sm">Polarité</div>
            <div class="p-4 grid grid-cols-3 gap-2">
                @foreach(['2P', '2P+T', '3P', '3P+T', '3P+N+T'] as $pol)
                <label class="flex items-center gap-2 text-[10px] font-bold">
                    <input type="radio" name="pol" value="{{ $pol }}"> {{ $pol }}
                </label>
                @endforeach
            </div>
        </div>
    </div>
    {{-- SCRIPTS JAVASCRIPT --}}
@section('scripts')
    <script src="{{ asset('configurateur/js/configurateur.js') }}"></script>
@endsection

@endsection