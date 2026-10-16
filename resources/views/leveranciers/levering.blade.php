<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Levering product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">

                <h1 class="text-2xl font-bold mb-8">
                    Levering product
                </h1>

                {{-- Product- en leveranciergegevens --}}
                <div class="mb-8 space-y-3">

                    <div class="grid grid-cols-[170px_1fr]">
                        <strong>Product:</strong>
                        <span>{{ $levering->ProductNaam }}</span>
                    </div>

                    <div class="grid grid-cols-[170px_1fr]">
                        <strong>Leverancier:</strong>
                        <span>{{ $levering->LeverancierNaam }}</span>
                    </div>

                    <div class="grid grid-cols-[170px_1fr]">
                        <strong>Contactpersoon:</strong>
                        <span>{{ $levering->ContactPersoon }}</span>
                    </div>

                    <div class="grid grid-cols-[170px_1fr]">
                        <strong>Mobiel:</strong>
                        <span>{{ $levering->Mobiel }}</span>
                    </div>

                </div>


                {{-- Melding unhappy scenario --}}
                @if ($melding)
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ $melding }}
                    </div>
                @endif


                <form method="POST"
                    action="{{ route('leveranciers.levering.opslaan', [
                        'leverancierId' => $levering->LeverancierId,
                        'productId' => $levering->ProductId,
                    ]) }}">
                    @csrf


                    {{-- Aantal producteenheden --}}
                    <div class="grid grid-cols-[260px_1fr] items-center gap-4 mb-5">

                        <label for="aantal" class="font-semibold">
                            Aantal producteenheden
                        </label>

                        <div>
                            <input type="number" id="aantal" name="aantal" min="1"
                                value="{{ old('aantal') }}" class="w-full border-gray-300 rounded-md shadow-sm">

                            @error('aantal')
                                <p class="text-red-600 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>


                    {{-- Datum eerstvolgende levering --}}
                    <div class="grid grid-cols-[260px_1fr] items-center gap-4 mb-8">

                        <label for="datum_eerstvolgende_levering" class="font-semibold">
                            Datum eerstvolgende levering
                        </label>

                        <div>
                            <input type="date" id="datum_eerstvolgende_levering" name="datum_eerstvolgende_levering"
                                value="{{ old('datum_eerstvolgende_levering') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm">

                            @error('datum_eerstvolgende_levering')
                                <p class="text-red-600 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>


                    {{-- Knoppen --}}
                    <div class="flex justify-between items-center">

                        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Sla op
                        </button>


                        <div class="flex gap-4">

                            <a href="{{ route('leveranciers.producten', $levering->LeverancierId) }}"
                                class="px-5 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                Terug
                            </a>

                            <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                Home
                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
