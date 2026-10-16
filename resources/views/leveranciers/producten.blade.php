<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Geleverde producten
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">
                    Geleverde producten
                </h1>

                <div class="mb-6 space-y-1">
                    <p>
                        <strong>Naam leverancier:</strong>
                        {{ $leverancier->Naam }}
                    </p>

                    <p>
                        <strong>Contactpersoon:</strong>
                        {{ $leverancier->ContactPersoon }}
                    </p>

                    <p>
                        <strong>Leverancier nr:</strong>
                        {{ $leverancier->LeverancierNummer }}
                    </p>

                    <p>
                        <strong>Mobiel:</strong>
                        {{ $leverancier->Mobiel }}
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 border text-left">
                                    Naam product
                                </th>

                                <th class="px-4 py-3 border text-center">
                                    Aantal in Magazijn
                                </th>

                                <th class="px-4 py-3 border text-center">
                                    Verpakkingseenheid
                                </th>

                                <th class="px-4 py-3 border text-center">
                                    Laatste levering
                                </th>

                                <th class="px-4 py-3 border text-center">
                                    Nieuwe levering
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @if ($geenProducten)
                                <tr>
                                    <td colspan="5" class="px-4 py-6 border text-center font-semibold text-gray-700">
                                        Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin
                                    </td>
                                </tr>
                            @else
                                @foreach ($producten as $product)
                                    <tr>
                                        <td class="px-4 py-3 border">
                                            {{ $product->ProductNaam }}
                                        </td>

                                        <td class="px-4 py-3 border text-center">
                                            {{ $product->AantalAanwezig ?? 0 }}
                                        </td>

                                        <td class="px-4 py-3 border text-center">
                                            {{ $product->VerpakkingsEenheid }}
                                        </td>

                                        <td class="px-4 py-3 border text-center">
                                            {{ date('d-m-Y', strtotime($product->LaatsteLevering)) }}
                                        </td>

                                        <td class="px-4 py-3 border text-center">
                                            <a href="{{ route('leveranciers.levering', [
                                                'leverancierId' => $leverancier->LeverancierId,
                                                'productId' => $product->ProductId,
                                            ]) }}"
                                                class="text-green-600 text-2xl font-black hover:text-green-800"
                                                title="Nieuwe levering">
                                                +
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('leveranciers.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Terug
                    </a>

                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Home
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
