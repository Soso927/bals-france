<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
    <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Type de Coffret</p>
    <div class="flex flex-wrap gap-3" id="type-coffret-buttons">
        <a href="{{ url('/configurateur/chantier') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all">
            Coffret Chantier
        </a>

        <a href="{{ url('/configurateur/etage') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all">
            Coffret d'Étage
        </a>

        <a href="{{ url('/configurateur/coffret-industrie') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all">
            Coffret Industrie
        </a>

        <a href="{{ url('/configurateur/coffret-evenementiel') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all">
            Coffret Événementiel
        </a>

        <a href="{{ url('/configurateur/prise-industrielle') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-bals-blue hover:text-bals-blue transition-all">
            Prise industrielle
        </a>
    </div>
</div>
