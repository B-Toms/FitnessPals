<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manas rezervācijas') }}
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
                <div class="border-b border-gray-100 pb-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-900">{{ __('Tavi pieteiktie treniņi') }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ __('Šeit tu vari pārskatīt savu treniņu grafiku un atteikties, ja plāni mainījušies.') }}</p>
                </div>

                @if($bookings->isEmpty())
                    <div class="text-center py-12 bg-gray-50 border-2 border-dashed border-gray-200 ">
                        <p class="text-base font-medium text-gray-600">{{ __('Tu vēl neesi pieteicies nevienam treniņam.') }}</p>
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
                                    <th class="px-6 py-3 text-right font-semibold text-gray-700 uppercase tracking-wider">{{ __('Darbības') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($bookings as $booking)
                                    <tr class="hover:bg-emerald-50/40 transition">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $booking->sporta_veids ?? __('Treniņš') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium  {{ ($booking->Tips === 'Individuālais' || $booking->Tips === 'Individuāls') ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                                {{ __($booking->Tips ?? 'Grupu') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ date('d.m.Y', strtotime($booking->Datums)) }} {{ __('plkst.') }} {{ date('H:i', strtotime($booking->Laiks)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ $booking->Ilgums }} min
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('client.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlies atcelt šo rezervāciju?');" class="inline-block m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 uppercase tracking-wider cursor-pointer transition bg-transparent border-0 p-0">
                                                    {{ __('Atteikties') }}
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