<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trenera vadības panelis') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded shadow-sm text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border border-gray-100 overflow-hidden shadow-sm sm:rounded-xl p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-100 pb-6 mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Tavas plānotās treniņu sesijas</h3>
                        <p class="text-sm text-gray-500 mt-1">Pārvaldi un veido jaunus treniņus saviem klientiem</p>
                    </div>
                    
                    <a href="{{ route('coach.sessions.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-5 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                        + Izveidot jaunu sesiju
                    </a>
                </div>

                <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                    <span class="text-4xl text-gray-300">📅</span>
                    <p class="mt-4 text-base font-medium text-gray-600">Šeit drīz parādīsies saraksts ar taviem izveidotajiem treniņiem.</p>
                    <p class="text-xs text-gray-400 mt-1">Izmanto pogu augšā, lai pievienotu pirmo sesiju.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>