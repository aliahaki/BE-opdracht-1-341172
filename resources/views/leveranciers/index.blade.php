<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Overzicht Leveranciers
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-6">
                    Overzicht Leveranciers
                </h1>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 border text-left">
                                    Naam
                                </th>

                                <th class="px-4 py-3 border text-left">
                                    Contactpersoon
                                </th>

                                <th class="px-4 py-3 border text-left">
                                    Leveranciernummer
                                </th>

                                <th class="px-4 py-3 border text-left">
                                    Mobiel
                                </th>

                                <th class="px-4 py-3 border text-center">
                                    Aantal verschillende producten
                                </th>

                                <th class="px-4 py-3 border text-center">
                                    Toon producten
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($leveranciers as $leverancier)
                                <tr>
                                    <td class="px-4 py-3 border">
                                        {{ $leverancier->Naam }}
                                    </td>

                                    <td class="px-4 py-3 border">
                                        {{ $leverancier->ContactPersoon }}
                                    </td>

                                    <td class="px-4 py-3 border">
                                        {{ $leverancier->LeverancierNummer }}
                                    </td>

                                    <td class="px-4 py-3 border">
                                        {{ $leverancier->Mobiel }}
                                    </td>

                                    <td class="px-4 py-3 border text-center">
                                        {{ $leverancier->AantalVerschillendeProducten }}
                                    </td>

                                    <td class="px-4 py-3 border text-center">
                                        <a href="{{ route('leveranciers.producten', $leverancier->LeverancierId) }}"
                                            class="text-2xl hover:opacity-70" title="Toon producten">
                                            📦
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
