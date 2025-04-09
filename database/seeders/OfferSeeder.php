<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Enums\Contract;
use App\Enums\Employment;
use App\Enums\PaymentType;
use App\Enums\WorkMode;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employers = User::role('employer')->get();

        if ($employers->count() < 3) {
            $this->command->error('Potrzeba co najmniej 3 użytkowników z rolą employer.');
            return;
        }

        $categoryIT = Category::where('slug', 'it-rozwoj-oprogramowania')->first();
        $categoryFizyczna = Category::where('slug', 'praca-fizyczna')->first();
        $categoryObsluga = Category::where('slug', 'obsluga-klienta')->first();
        $categoryEnergetyka = Category::where('slug', 'energetyka')->first();

        if (!$categoryIT || !$categoryFizyczna || !$categoryObsluga || !$categoryEnergetyka) {
            $this->command->error('Brakuje jednej z wymaganych kategorii. Uruchom najpierw CategorySeeder.');
            return;
        }

        Offer::create([
            'name' => 'Programista',
            'slug' => Str::slug('Programista'),
            'image_path' => 'offer/python-programming-language.png',
            'description' => 'Ogłoszenie o naborze na stanowisko programisty Python projektującego aplikacje webowe w Django.',
            'tasks' => [
                'Programowanie aplikacji w frameworku webowym Django',
                'Wdrażanie nowych funkcjonalności'
            ],
            'expectancies' => [
                '5 lat doświadczenia w programowaniu w języku Python',
                'Umiejętność języka angielskiego (poziom B2)',
                'Umiejętność pisania czytelnej i jasnej dokumentacji'
            ],
            'additionals' => [
                'Obsługa oprogramowania Kubernetes'
            ],
            'assurances' => [
                'Stabilne, długoterminowe zatrudnienie',
                'Całe wyposażenie sprzętowe'
            ],
            'active' => true,
            'vacancy' => 1,
            'user_id' => 2,
            'payment' => PaymentType::MNETTO,
            'salary' => 20000,
            'category_id' => $categoryIT->id,
            'employment' => Employment::PELNY_ETAT,
            'contract' => Contract::UMOWA_O_PRACE,
            'work_mode' => WorkMode::PRACA_STACJONARNA
        ]);

        Offer::create([
            'name' => 'Magazynier',
            'slug' => Str::slug('Magazynier'),
            'image_path' => 'offer/magazynier.jpg',
            'description' => 'Praca fizyczna polegająca na kompletowaniu zamówień i obsłudze wózka widłowego.',
            'tasks' => ['Kompletowanie zamówień', 'Rozładunek i załadunek towarów'],
            'expectancies' => ['Uprawnienia UDT na wózki widłowe', 'Sprawność fizyczna'],
            'additionals' => ['Doświadczenie na magazynie'],
            'assurances' => ['Stała praca w systemie zmianowym', 'Odzież robocza i szkolenia BHP'],
            'active' => true,
            'vacancy' => 2,
            'user_id' => 3,
            'payment' => PaymentType::HBRUTTO,
            'salary' => 28,
            'category_id' => $categoryFizyczna->id,
            'employment' => Employment::PELNY_ETAT,
            'contract' => Contract::UMOWA_O_PRACE,
            'work_mode' => WorkMode::PRACA_STACJONARNA
        ]);

        Offer::create([
            'name' => 'Konsultant klienta',
            'slug' => Str::slug('Konsultant klienta'),
            'image_path' => 'offer/konsultant.jpg',
            'description' => 'Praca polegająca na telefonicznym kontakcie z klientem i obsłudze zapytań.',
            'tasks' => ['Obsługa zapytań telefonicznych', 'Aktualizacja danych klientów'],
            'expectancies' => ['Dobra dykcja', 'Podstawowa obsługa komputera'],
            'additionals' => ['Doświadczenie w call center'],
            'assurances' => ['Szkolenia wdrożeniowe', 'System premiowy'],
            'active' => true,
            'vacancy' => 3,
            'user_id' => 4,
            'payment' => PaymentType::MNETTO,
            'salary' => 4500,
            'category_id' => $categoryObsluga->id,
            'employment' => Employment::CZESC_ETATU,
            'contract' => Contract::UMOWA_ZLECENIE,
            'work_mode' => WorkMode::PRACA_HYBRYDOWA
        ]);

        Offer::create([
            'name' => 'Technik energetyk',
            'slug' => Str::slug('Technik energetyk'),
            'image_path' => 'offer/energetyk.jpg',
            'description' => 'Praca przy utrzymaniu infrastruktury energetycznej zakładu.',
            'tasks' => ['Monitorowanie instalacji elektrycznych', 'Usuwanie awarii energetycznych'],
            'expectancies' => ['Uprawnienia SEP do 1kV', 'Gotowość do pracy w terenie'],
            'additionals' => ['Doświadczenie w branży'],
            'assurances' => ['Auto służbowe', 'Dodatkowe ubezpieczenie NNW'],
            'active' => true,
            'vacancy' => 1,
            'user_id' => 2,
            'payment' => PaymentType::MBRUTTO,
            'salary' => 7200,
            'category_id' => $categoryEnergetyka->id,
            'employment' => Employment::PELNY_ETAT,
            'contract' => Contract::UMOWA_O_PRACE,
            'work_mode' => WorkMode::PRACA_MOBILNA
        ]);
    }
}
