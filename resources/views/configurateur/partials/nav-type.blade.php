{{-- Navigation entre les types de coffrets --}}
{{-- Passer $activeType depuis la vue parent via @include(..., ['activeType' => 'chantier']) --}}
@php $activeType ??= ''; @endphp

<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
    <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Type de Coffret</p>
    <div class="flex flex-wrap gap-3" id="type-coffret-buttons">

        @if ($activeType === 'chantier')
            <span class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white cursor-default"
                  data-type="Coffret Chantier">Coffret Chantier</span>
        @else
            <a href="{{ route('configurateur.chantier') }}"
               class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
               data-type="Coffret Chantier">Coffret Chantier</a>
        @endif

        @if ($activeType === 'etage')
            <span class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white cursor-default"
                  data-type="Coffret d'Étage">Coffret d'Étage</span>
        @else
            <a href="{{ route('configurateur.etage') }}"
               class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
               data-type="Coffret d'Étage">Coffret d'Étage</a>
        @endif

        @if ($activeType === 'industrie')
            <span class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white cursor-default"
                  data-type="Coffret Industrie">Coffret Industrie</span>
        @else
            <a href="{{ route('configurateur.industrie') }}"
               class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
               data-type="Coffret Industrie">Coffret Industrie</a>
        @endif

        @if ($activeType === 'evenementiel')
            <span class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white cursor-default"
                  data-type="Coffret Événementiel">Coffret Événementiel</span>
        @else
            <a href="{{ route('configurateur.evenementiel') }}"
               class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
               data-type="Coffret Événementiel">Coffret Événementiel</a>
        @endif

        @if ($activeType === 'prise-industrielle')
            <span class="btn-type actif px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-bals-blue bg-bals-blue text-white cursor-default"
                  data-type="Prise industrielle">Prise industrielle</span>
        @else
            <a href="{{ route('configurateur.prise-industrielle') }}"
               class="btn-type px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all"
               data-type="Prise industrielle">Prise industrielle</a>
        @endif

    </div>
</div>
