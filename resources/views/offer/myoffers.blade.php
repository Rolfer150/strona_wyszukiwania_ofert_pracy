<x-app-layout>
    <div class="p-3">
        <h3 class="text-2xl font-semibold mb-4">Lista Twoich ogłoszeń o pracę</h3>

        <a href="{{ route('offer.create') }}"
        class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">
            Dodaj Ofertę
        </a>

        <div class="grid grid-cols-2 gap-4">
            @foreach($myOffers as $offer)
                <div class="p-4 border rounded-lg shadow-md">
                    <x-offer-item :offer="$offer"></x-offer-item>

                    {{-- Komponent Livewire do generowania pytań --}}
                    @livewire('question-generator', ['offer' => $offer], key($offer->id))
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
