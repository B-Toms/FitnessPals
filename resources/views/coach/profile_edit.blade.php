<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm p-6 border border-gray-100">
                
                <h2 class="text-xl font-bold text-gray-800 mb-1">{{ __('Rediģēt mana profila informāciju') }}</h2>
                <p class="text-sm text-gray-500 mb-6">{{ __('Šeit norādītā informācija un sertifikāti būs redzami klientiem tavā publiskajā profilā.') }}</p>
                <hr class="mb-6 border-gray-100">

                @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('coach.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="Kvalifikācija" class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __('Mana kvalifikācija un pieredze') }}
                        </label>
                        <textarea 
                            class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 shadow-sm" 
                            id="Kvalifikācija" 
                            name="Kvalifikācija" 
                            rows="4" 
                            required>{{ old('Kvalifikācija', $coachData->Kvalifikācija ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="Sertifikācijas_dati" class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __('Iegūtie sertifikāti') }}
                        </label>
                        <textarea 
                            class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 shadow-sm" 
                            id="Sertifikācijas_dati" 
                            name="Sertifikācijas_dati" 
                            rows="4" 
                            required>{{ old('Sertifikācijas_dati', $coachData->Sertifikācijas_dati ?? '') }}</textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-sm transition ease-in-out duration-150 text-sm">
                            {{ __('Saglabāt izmaiņas') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>