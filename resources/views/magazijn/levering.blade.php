<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Levering Informatie
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(!$geenVoorraad && $leveringsInfo->count() > 0)
                    <!-- VELDEN BOVEN DE TABEL (Scenario 01) -->
                    <div class="mb-6 space-y-1">
                        <p><strong>Naam leverancier:</strong> {{ $leveringsInfo->first()->LeverancierNaam }}</p>
                        <p><strong>Contactpersoon leverancier:</strong> {{ $leveringsInfo->first()->ContactPersoon }}</p>
                        <p><strong>Leveranciernummer:</strong> {{ $leveringsInfo->first()->LeverancierNummer }}</p>
                        <p><strong>Mobiel:</strong> {{ $leveringsInfo->first()->Mobiel }}</p>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naam product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum laatste levering</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aantal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Eerstvolgende levering</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($leveringsInfo as $info)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->Naam }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ date('d-m-Y', strtotime($info->DatumLevering)) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $info->Aantal }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $info->DatumEerstVolgendeLevering ? date('d-m-Y', strtotime($info->DatumEerstVolgendeLevering)) : 'N.v.t.' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <!-- SCENARIO 02: EXACTE TEKST IN DE TABEL & 4 SECONDEN REDIRECT -->
                    <table class="min-w-full divide-y divide-gray-200 border mb-4">
                        <tbody class="bg-white">
                            <tr>
                                <td class="px-6 py-4 text-center text-red-600 font-semibold">
                                    Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is: 30-04-2023
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <script>
                        setTimeout(function() {
                            window.location.href = "{{ route('magazijn.index') }}";
                        }, 4000);
                    </script>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>