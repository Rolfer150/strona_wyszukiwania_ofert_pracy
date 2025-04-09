<?php

namespace App\Livewire;

use App\Models\OfferApplication;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;

class OfferApplicationList extends Component
{
    use WithFileUploads;

    public $apply;
    public $cvFile;
    public array $materials = [];

    public function generateMaterials()
    {
        if (!$this->apply->offer) {
            $this->materials = ['Brak powiązanej oferty.'];
            return;
        }

        try {
            $response = Http::timeout(60)
                ->attach(
                    'cv_file',
                    file_get_contents($this->cvFile->getRealPath()),
                    $this->cvFile->getClientOriginalName()
                )
                ->asMultipart()
                ->post("http://host.docker.internal:8000/generate_materials_cv", [
                    'offer_title' => $this->apply->offer->name,
                    'tasks' => implode(', ', (array)$this->apply->offer->tasks),
                    'expectancies' => implode(', ', (array)$this->apply->offer->expectancies),
                ]);


            $this->materials = $response->json()['materials'] ?? ['Brak odpowiedzi z serwera'];
        } catch (\Exception $e) {
            $this->materials = ['Błąd połączenia z API: ' . $e->getMessage()];
        }
    }
}
