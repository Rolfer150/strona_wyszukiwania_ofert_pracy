<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Offer;
use Illuminate\Support\Facades\Http;

class QuestionGenerator extends Component
{
    public Offer $offer;
    public array $generatedQuestions = [];

    /**
     * Ustawienie oferty (dostarczonej jako parametr do komponentu)
     *
     * @param Offer $offer
     */
    public function mount(Offer $offer): void
    {
        $this->offer = $offer;
    }

    /**
     * Generuje pytania rekrutacyjne dla danej oferty przy użyciu FastAPI
     *
     * @return void
     */
    public function generateQuestions(): void
    {
        try {
            $response = Http::post("http://host.docker.internal:8000/generate_questions_ml", [
                'name' => $this->offer->name,
                'description' => $this->offer->description ?? '',
                'tasks' => array_map('strval', is_array($this->offer->tasks) ? $this->offer->tasks : []),
                'expectancies' => array_map('strval', is_array($this->offer->expectancies) ? $this->offer->expectancies : []),
                'category' => $this->offer->category->slug ?? '',
            ]);


            $this->generatedQuestions = $response->json()['questions'] ?? ['Brak odpowiedzi z serwera'];
        } catch (\Exception $e) {
            $this->generatedQuestions = ['Błąd połączenia z API: ' . $e->getMessage()];
        }
    }

    /**
     * Widok komponentu Livewire
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.question-generator');
    }
}
