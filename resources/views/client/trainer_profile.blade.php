<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trenera Profils') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 font-semibold text-sm rounded-2xl shadow-sm flex items-center gap-2">
                    ✅ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 font-semibold text-sm rounded-2xl shadow-sm flex items-center gap-2">
            ⚠️ {{ session('error') }}
        </div>
    @endif

            <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition gap-1">
                ← Atpakaļ uz treneru sarakstu
            </a>
            </div>

            <div class="bg-white  border border-gray-200 shadow-sm p-6 mb-8 flex flex-col md:flex-row gap-6 items-center md:items-start">
                <div class="w-32 h-32 bg-slate-100  border border-gray-200 flex items-center justify-center text-4xl shadow-inner shrink-0">
                    💪
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-2xl font-extrabold text-gray-900 mb-2">{{ $trainer->Vārds }} {{ $trainer->Uzvārds }}</h1>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider  border border-emerald-200 inline-block mb-4">
                        Sertificēts Treneris
                    </span>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ $trainer->Bio ?? 'Šis treneris vēl nav pievienojis savu aprakstu.' }}
                    </p>
                </div>
            </div>

            <div class="bg-white  border border-gray-200 shadow-sm p-6 mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900 mb-1">📅 Pieteikties treniņam</h3>
                        <p class="text-xs text-gray-500">Izvēlies datumu, lai apskatītu pieejamos laikus.</p>
                    </div>
                    
                    <span class="text-sm font-extrabold text-slate-700 bg-slate-100 border border-slate-200 px-4 py-2 uppercase tracking-wider">
                        {{ \Carbon\Carbon::now()->locale('lv')->isoFormat('MMMM YYYY') }}
                    </span>
                </div>

                <div class="flex flex-wrap gap-6 mb-8 p-4 bg-slate-50 border border-gray-200 text-xs font-bold text-slate-700 shadow-sm items-center">
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 border shadow-sm block shrink-0" style="background-color: #d1fae5; border-color: #a7f3d0;"></span>
                        <span>Pieejami treniņi</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-5 h-5 border shadow-sm block shrink-0" style="background-color: #ffe4e6; border-color: #fecdd3;"></span>
                    <span>Nav brīvu vietu (Pilns)</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-5 h-5  border shadow-sm block shrink-0" style="background-color: #f8fafc; border-color: #f1f5f9;"></span>
                    <span>Nav plānotu nodarbību</span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 0.75rem;" class="mb-6">
                    @php
                        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
                        $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
                    @endphp

                    @for ($i = 0; $i < $daysInMonth; $i++)
                        @php
                            $currentDate = $startOfMonth->copy()->addDays($i);
                            $currentDateStr = $currentDate->format('Y-m-d');
                            $day = $currentDate->format('d');
                            $dayName = $currentDate->locale('lv')->minDayName;

                            // Atlasām visas šī konkrētā datuma sesijas
                            $dateSessions = $sessions->where('Datums', $currentDateStr);
                            $hasSession = $dateSessions->isNotEmpty();
                            
                            // Nosakām, vai šajā dienā ir kaut viena brīva vieta
                            $hasFreeSeats = $dateSessions->sum('Max_dalībnieku_skaits') > 0;
                            
                            // Pārbaudām, vai diena nav pagātnē
                            $isPast = $currentDate->isBefore(\Carbon\Carbon::today());
                        @endphp

                        <div class="flex flex-col items-center justify-center p-1 bg-slate-50  border border-gray-100">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">
                                {{ $dayName }}
                            </span>
                            
                            @if($hasSession && !$isPast)
                                @if($hasFreeSeats)
                                    <button type="button" onclick="showSlots('{{ $currentDateStr }}')" 
                                        id="btn-{{ $day }}"
                                        onmouseover="this.style.backgroundColor='#a7f3d0'; this.style.borderColor='#34d399';" 
                                        onmouseout="this.style.backgroundColor='#d1fae5'; this.style.borderColor='#a7f3d0';"
                                        style="width: 100%; min-height: 48px; background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; border-radius: 0.75rem; font-weight: 800; font-size: 1rem; transition: all 0.2s ease; cursor: pointer;" 
                                        class="shadow-sm flex items-center justify-center active:scale-95">
                                        {{ $day }}
                                    </button>
                                @else
                                    <button type="button" onclick="showSlots('{{ $currentDateStr }}')" 
                                        id="btn-{{ $day }}"
                                        onmouseover="this.style.backgroundColor='#fecdd3'; this.style.borderColor='#f43f5e';" 
                                        onmouseout="this.style.backgroundColor='#ffe4e6'; this.style.borderColor='#fecdd3';"
                                        style="width: 100%; min-height: 48px; background-color: #ffe4e6; color: #9f1239; border: 1px solid #fecdd3; border-radius: 0.75rem; font-weight: 800; font-size: 1rem; transition: all 0.2s ease; cursor: pointer;" 
                                        class="shadow-sm flex items-center justify-center active:scale-95">
                                        {{ $day }}
                                    </button>
                                @endif
                            @else
                                <button type="button" disabled 
                                    style="width: 100%; min-height: 48px; background-color: #f8fafc; color: #cbd5e1; border: 1px solid #f1f5f9; border-radius: 0.75rem; font-weight: 600; font-size: 1rem; cursor: not-allowed;" 
                                    class="flex items-center justify-center">
                                    {{ $day }}
                                </button>
                            @endif
                        </div>
                    @endfor
                </div>

                <div id="time-slots-container" class="hidden border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Pieejamie laika logi:</h4>
                    <div id="slots-list" class="space-y-3">
                        </div>
                </div>

            </div>

        </div>
    </div>

    <script>    
        const sessions = JSON.parse('{!! json_encode($sessions) !!}');

        function showSlots(date) {
            const container = document.getElementById('time-slots-container');
            const list = document.getElementById('slots-list');
            
            list.innerHTML = '';
            const activeSessions = sessions.filter(s => s.Datums === date);
            
            if(activeSessions.length > 0) {
                container.classList.remove('hidden');
                
                activeSessions.forEach(s => {
                    const hasSeats = s.Max_dalībnieku_skaits > 0;
                    
                    list.innerHTML += `
                        <div class="flex justify-between items-center p-4 bg-slate-50  border border-gray-200 text-sm shadow-sm">
                            <div class="flex items-center">
                                <span class="px-3 py-1 bg-emerald-600 text-white font-bold  text-xs shrink-0" style="margin-right: 1.5rem;">
                                    ${s.Laiks.substring(0,5)}
                                </span>
                                <div>
                                    <span class="font-bold text-gray-800 block">${s.SportaVeids}</span>
                                    <span class="text-xs ${hasSeats ? 'text-gray-500' : 'text-rose-600 font-bold'}">
                                        ${hasSeats ? `Brīvas vietas: ${s.Max_dalībnieku_skaits}` : 'Nav brīvu vietu!'}
                                    </span>
                                </div>
                            </div>
                            
                            <form action="/book-session/${s.Sesijas_id}" method="POST" class="m-0">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" 
                                    ${hasSeats ? '' : 'disabled'} 
                                    class="px-5 py-2 ${hasSeats ? 'bg-emerald-600 hover:bg-emerald-700 cursor-pointer' : 'bg-gray-300 cursor-not-allowed'} text-white text-xs font-bold uppercase tracking-wider shadow-sm transition transform ${hasSeats ? 'active:scale-95' : ''}">
                                    ${hasSeats ? 'Book Now' : 'Pilns'}
                                </button>
                            </form>
                        </div>
                    `;
                });
            } else {
                container.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>