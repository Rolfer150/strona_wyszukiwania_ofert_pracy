<div class="mt-4">
    <h4 class="text-md font-medium">Generator pytań</h4>

    <button wire:click="generateQuestions"
            wire:loading.attr="disabled"
            class="bg-blue-500 text-white px-4 py-2 rounded mt-2">
        <span wire:loading.remove>Generuj pytania</span>
        <span wire:loading>Generowanie...</span>
    </button>

    @if(!empty($generatedQuestions))
        <ul class="mt-3 list-disc list-inside">
            @foreach($generatedQuestions as $question)
                <li>{{ is_array($question) ? json_encode($question) : $question }}</li>
            @endforeach
        </ul>
    @endif
</div>

