<div class="mt-4">
    <h4 class="text-md font-medium">Pytania rekrutacyjne</h4>

    <!-- Przycisk do generowania -->
    <button wire:click="generateQuestions"
            wire:loading.attr="disabled"
            class="bg-blue-500 text-white px-4 py-2 rounded mt-2">
        <span wire:loading.remove>Generuj pytania</span>
        <span wire:loading>Generowanie...</span>
    </button>

    <!-- Lista pytań -->
    @if(count($generatedQuestions) > 0)
        <ul class="mt-3 list-disc list-inside">
            @foreach($generatedQuestions as $question)
                <li class="text-gray-700 dark:text-gray-300">{{ $question }}</li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500 mt-2">Brak wygenerowanych pytań.</p>
    @endif
</div>
