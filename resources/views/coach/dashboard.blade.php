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
                @if($sessions->isEmpty())
                    <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <span class="text-4xl text-gray-300">📅</span>
                        <p class="mt-4 text-base font-medium text-gray-600">Tu vēl neesi izveidojis nevienu treniņu sesiju.</p>
                        <p class="text-xs text-gray-400 mt-1">Izmanto pogu augšā, lai pievienotu pirmo sesiju.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">Sporta veids</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">Tips</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">Datums & Laiks</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">Ilgums</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-700 uppercase tracking-wider">Max Vietas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($sessions as $session)
                                    <tr class="hover:bg-emerald-50/40 transition">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $session->Nosaukums }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $session->Tips === 'Individuālais' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                                {{ $session->Tips }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ date('d.m.Y', strtotime($session->Datums)) }} plkst. {{ date('H:i', strtotime($session->Laiks)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $session->Ilgums }} min</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $session->Max_dalībnieku_skaits }} vietas</td>
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