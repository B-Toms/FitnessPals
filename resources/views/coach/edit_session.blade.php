<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rediģēt treniņa sesiju') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('coach.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition gap-1">
                    ← Atpakaļ uz paneli
                </a>
            </div>

            <div class="bg-white border border-gray-200 shadow-sm p-6">
                <form action="{{ route('sessions.update', $session->Sesijas_id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
    <label class="block text-sm font-bold text-gray-700 mb-1">Sporta veids</label>
    <select name="Sporta_veida_id" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
        <option value="">-- Izvēlies sporta veidu --</option>
        @foreach($sports as $sport)
            <option value="{{ $sport->Sporta_veida_id }}" {{ old('Sporta_veida_id', $session->Sporta_veida_id) == $sport->Sporta_veida_id ? 'selected' : '' }}>
                {{ $sport->Nosaukums ?? $sport->sporta_veids ?? $sport->SportaVeids ?? $sport->name ?? 'Sporta veids #'.$sport->Sporta_veida_id }}
            </option>
        @endforeach
    </select>
    @error('Sporta_veida_id') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
</div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tips</label>
                        <select name="Tips" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            <option value="Individuāls" {{ old('Tips', $session->Tips) == 'Individuāls' ? 'selected' : '' }}>Individuāls</option>
                            <option value="Grupu" {{ old('Tips', $session->Tips) == 'Grupu' ? 'selected' : '' }}>Grupu</option>
                        </select>
                        @error('Tips') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Datums</label>
                        <input type="date" name="Datums" value="{{ old('Datums', $session->Datums) }}" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        @error('Datums') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Laiks</label>
                        <input type="text" name="Laiks" value="{{ old('Laiks', $session->Laiks) }}" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        @error('Laiks') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Ilgums (minūtēs)</label>
                        <input type="number" name="Ilgums" value="{{ old('Ilgums', $session->Ilgums) }}" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        @error('Ilgums') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Maksimālais vietu skaits</label>
                        <input type="number" name="Max_dalibnieku_skaits" value="{{ old('Max_dalibnieku_skaits', $session->Max_dalībnieku_skaits) }}" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        @error('Max_dalibnieku_skaits') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('coach.dashboard') }}" class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-bold hover:bg-gray-200 transition">
                            Atcelt
                        </a>
                        <button type="submit" class="px-5 py-2 bg-emerald-600 text-white text-sm font-bold hover:bg-emerald-700 shadow-sm transition">
                            Saglabāt izmaiņas
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>