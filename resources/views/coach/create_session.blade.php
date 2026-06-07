<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Izveidot jaunu treniņu sesiju') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-100 overflow-hidden shadow-sm sm:rounded-xl p-8">
                
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-900">Sesijas detaļas</h3>
                    <p class="text-sm text-gray-500 mt-1">Aizpildi laukus, lai klients varētu pieteikties treniņam.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded text-sm">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('coach.sessions.store') }}" method="POST" class="space-y-5 text-gray-900">
                    @csrf

                    <div>
                        <label for="Sporta_veida_id" class="block text-sm font-semibold text-gray-700">Sporta veids</label>
                        <select name="Sporta_veida_id" id="Sporta_veida_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition" required>
                            <option value="">-- Izvēlies sporta veidu --</option>
                            @foreach($sportTypes as $type)
                                <option value="{{ $type->Sporta_veida_id }}">{{ $type->Nosaukums }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="Tips" class="block text-sm font-semibold text-gray-700">Treniņa tips</label>
                        <select name="Tips" id="Tips" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition" required>
                            <option value="Individuālais">Individuālais treniņš</option>
                            <option value="Grupu">Grupu treniņš</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="Datums" class="block text-sm font-semibold text-gray-700">Datums</label>
                            <input type="date" name="Datums" id="Datums" min="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition" required>
                        </div>

                        <div>
                            <label for="Laiks" class="block text-sm font-semibold text-gray-700">Sākuma laiks</label>
                            <input type="time" name="Laiks" id="Laiks" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="Ilgums" class="block text-sm font-semibold text-gray-700">Ilgums (minūtēs)</label>
                            <input type="number" name="Ilgums" id="Ilgums" min="15" value="60" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition" required>
                        </div>

                        <div>
                            <label for="Max_dalībnieku_skaits" class="block text-sm font-semibold text-gray-700">Maksimālais dalībnieku skaits</label>
                            <input type="number" name="Max_dalībnieku_skaits" id="Max_dalībnieku_skaits" min="1" value="10" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition" required>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100 mt-6">
                        <a href="{{ route('coach.dashboard') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition text-sm">
                            Atcelt
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition text-sm shadow-sm">
                            Saglabāt sesiju
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tipsSelect = document.getElementById('Tips');
            const maxVietasInput = document.getElementById('Max_dalībnieku_skaits');

            function toggleMaxVietas() {
                if (tipsSelect.value === 'Individuālais') {
                    maxVietasInput.value = 1;
                    maxVietasInput.readOnly = true;
                    maxVietasInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                } else {
                    if (maxVietasInput.value == 1) {
                        maxVietasInput.value = 10; // Atgriežam noklusēto grupas vērtību
                    }
                    maxVietasInput.readOnly = false;
                    maxVietasInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                }
            }

            // Palaid pārbaudi gan uzreiz ielādējot lapu, gan mainot izvēli
            tipsSelect.addEventListener('change', toggleMaxVietas);
            toggleMaxVietas();
        });
    </script>
</x-app-layout>