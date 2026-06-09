<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trenera vadības panelis') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 shadow-sm text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border border-gray-100 overflow-hidden shadow-sm p-8 ">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-100 pb-6 mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ __('Tavas plānotās treniņu sesijas') }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ __('Pārvaldi un veido jaunus treniņus saviem klientiem') }}</p>
                    </div>
                    
                    <a href="{{ route('coach.sessions.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-5 py-2.5 bg-emerald-600 border border-transparent font-semibold text-sm text-white tracking-wide hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm ">
                        {{ __('+ Izveidot jaunu sesiju') }}
                    </a>
                </div>

                @if($sessions->isEmpty())
                    <div class="text-center py-12 bg-gray-50 border-2 border-dashed border-gray-200 ">
                        <p class="text-base font-medium text-gray-600">{{ __('Tu vēl neesi izveidojis nevienu treniņu sesiju.') }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ __('Izmanto pogu augšā, lai pievienotu pirmo sesiju.') }}</p>
                    </div>
                @else
                    <div class="w-full max-w-full bg-white border border-gray-200 shadow-sm overflow-x-auto ">
                        <table class="w-full min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">{{ __('Sporta veids') }}</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">{{ __('Tips') }}</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">{{ __('Datums & Laiks') }}</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">{{ __('Ilgums') }}</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">{{ __('Max Vietas') }}</th>
                                    <th class="px-6 py-3 text-right font-semibold text-gray-700 uppercase tracking-wider">{{ __('Darbības') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($sessions as $session)
                                    <tr class="hover:bg-emerald-50/40 transition">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $session->Nosaukums ?? $session->Sporta_veids ?? $session->SportaVeids }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium  {{ ($session->Tips === 'Individuālais' || $session->Tips === 'Individuāls') ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                                {{ __($session->Tips) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ date('d.m.Y', strtotime($session->Datums)) }} {{ __('plkst.') }} {{ date('H:i', strtotime($session->Laiks)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $session->Ilgums }} min</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ $session->Max_dalībnieku_skaits ?? $session->Max_vietas }} {{ __('vietas') }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('sessions.edit', $session->Sesijas_id) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 uppercase tracking-wider transition mr-4 inline-block">
                                                {{ __('Labot') }}
                                            </a>
                                            <form action="{{ route('sessions.destroy', $session->Sesijas_id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlies dzēst šo sesiju un visas tās rezervācijas?');" class="inline-block m-0">                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 uppercase tracking-wider cursor-pointer transition bg-transparent border-0 p-0">
                                                    {{ __('Dzēst') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>