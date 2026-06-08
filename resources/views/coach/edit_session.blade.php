<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rediģēt treniņa sesiju') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('coach.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition gap-1">
                    ← {{ __('Atpakaļ uz paneli') }}
                </a>
            </div>

            <div class="bg-white border border-gray-200 shadow-sm p-8 rounded-2xl">
                <form action="{{ route('sessions.update', $session->Sesijas_id) }}" method="POST" class="space-y-5 text-gray-900">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Sporta veids') }}</label>
                        <select name="Sporta_veida_id" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm rounded-xl" required>
                            <option value="">-- {{ __('Izvēlies sporta veidu') }} --</option>
                            @foreach($sports as $sport)
                                <option value="{{ $sport->Sporta_veida_id }}" {{ old('Sporta_veida_id', $session->Sporta_veida_id) == $sport->Sporta_veida_id ? 'selected' : '' }}>
                                    {{ $sport->Nosaukums ?? $sport->sporta_veids ?? $sport->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('Sporta_veida_id') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Treniņa tips') }}</label>
                        <select name="Tips" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm rounded-xl" required>
                            <option value="Individuālais" {{ old('Tips', $session->Tips) == 'Individuālais' || old('Tips', $session->Tips) == 'Individuāls' ? 'selected' : '' }}>{{ __('Individuālais treniņš') }}</option>
                            <option value="Grupu" {{ old('Tips', $session->Tips) == 'Grupu' ? 'selected' : '' }}>{{ __('Grupu treniņš') }}</option>
                        </select>
                        @error('Tips') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Datums') }}</label>
                            <input type="date" name="Datums" value="{{ old('Datums', $session->Datums) }}" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm rounded-xl" required>
                            @error('Datums') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Sākuma laiks') }}</label>
                            <input type="time" name="Laiks" value="{{ old('Laiks', date('H:i', strtotime($session->Laiks))) }}" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm rounded-xl" required>
                            @error('Laiks') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Ilgums (minūtēs)') }}</label>
                            <input type="number" name="Ilgums" value="{{ old('Ilgums', $session->Ilgums) }}" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm rounded-xl" required>
                            @error('Ilgums') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ __('Maksimālais dalībnieku skaits') }}</label>
                            <input type="number" name="Max_dalibnieku_skaits" value="{{ old('Max_dalibnieku_skaits', $session->Max_dalībnieku_skaits) }}" class="w-full border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm rounded-xl" required>
                            @error('Max_dalibnieku_skaits') <span class="text-xs text-rose-600 font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100 mt-6">
                        <a href="{{ route('coach.dashboard') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200 transition rounded-xl">
                            {{ __('Atcelt') }}
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 shadow-sm transition rounded-xl">
                            {{ __('Saglabāt izmaiņas') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>