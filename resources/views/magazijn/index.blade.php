<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Overzicht Magazijn Jamin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barcode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Verpakkingseenheid (kg)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aantal Aanwezig</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Allergenen Info</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Leverantie Info</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($producten as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->Barcode }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->Naam }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->VerpakkingsEenheid }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->AantalAanwezig ?? '0' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('magazijn.allergenen', $product->ProductId) }}" class="text-red-600 font-bold text-lg" title="Bekijk allergenen info">
                                        ❌
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('magazijn.levering', $product->ProductId) }}" class="text-blue-600 font-bold text-lg" title="Bekijk leverantie info">
                                        ❓
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>