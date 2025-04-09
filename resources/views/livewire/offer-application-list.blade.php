<div class="mt-4">
    <h4 class="text-md font-medium">Materiały pomocnicze</h4>

    <label for="cvFile" class="block text-sm mt-2">Wyślij plik CV (PDF/TXT)</label>
    <input type="file" id="cvFile" wire:model="cvFile" class="mt-1 mb-2">

    <button wire:click="generateMaterials"
            wire:loading.attr="disabled"
            class="bg-blue-500 text-white px-4 py-2 rounded">
        <span wire:loading.remove>Generuj materiały</span>
        <span wire:loading>Generowanie...</span>
    </button>

    @if($materials)
        <ul class="mt-3 list-disc list-inside">
            @foreach($materials as $material)
                <li class="text-gray-700 dark:text-gray-300">{{ is_array($material) ? json_encode($material) : $material }}</li>
            @endforeach
        </ul>
    @endif
</div>
