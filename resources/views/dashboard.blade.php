<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Atrodi savu treneri') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">
                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
                            Meklēt pēc sporta veida
                        </label>
                        <select name="sport_type" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium text-gray-700 focus:border-emerald-500 focus:ring-emerald-500 transition shadow-inner">
                            <option value="">Visi sporta veidi</option>
                            @foreach($sportTypes as $type)
                                <option value="{{ $type->Sporta_veida_id }}" {{ request('sport_type') == $type->Sporta_veida_id ? 'selected' : '' }}>
                                {{ $type->Nosaukums }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-auto">
                        <button type="submit" class="w-full px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm uppercase tracking-wider rounded-xl shadow-sm transition active:scale-95 cursor-pointer">
                            Filtrēt
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($trainers as $trainer)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col justify-between">
                        <div>
                            <div class="w-16 h-16 bg-slate-100 rounded-xl border border-gray-200 flex items-center justify-center text-2xl mb-4">
                                💪
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">
                                {{ $trainer->Vārds }} {{ $trainer->Uzvārds }}
                            </h4>
                            <p class="text-gray-600 text-xs mt-2">
                                {{ $trainer->Bio ?? 'Sveiki! Esmu profesionāls sporta treneris.' }}
                            </p>
                        </div>
                        <div class="mt-6">
                            <button class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs uppercase tracking-wider shadow-sm transition">
                                Skatīt profilu
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>