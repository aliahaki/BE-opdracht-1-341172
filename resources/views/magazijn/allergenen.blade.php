<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Overzicht Allergenen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- VELDEN BOVEN DE TABEL -->
                <div class="mb-6 space-y-1">
                    <p><strong>Naam Product:</strong> {{ $product->Naam }}</p>
                    <p><strong>Barcode:</strong> {{ $product->Barcode }}</p>
                </div>

                @if(!$geenAllergenen)
                    <!-- SCENARIO 01: ALLERGENEN TABEL GESORTEERD OP NAAM OPLOPEND -->
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Omschrijving</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($allergenen as $allergeen)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $allergeen->Naam }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $allergeen->Omschrijving }}</td>
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
                                    In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken
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

                <div class="mt-4">
                    <a href="{{ route('magazijn.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Terug naar Magazijn
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>