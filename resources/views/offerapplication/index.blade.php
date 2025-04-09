<x-app-layout>
    <div class="p-3">
        <h3 class="text-2xl font-semibold mb-4">Lista Twoich aplikacji</h3>

        <div class="grid grid-cols-2 gap-4">
            @foreach($applies as $apply)
                <div class="p-4 border rounded-lg shadow-md">
                    {{-- Komponent Livewire do generowania materiałów pomocniczych --}}
                    @livewire('offer-application-list', ['apply' => $apply], key($apply->id))
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
