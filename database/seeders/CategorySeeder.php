<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Praca fizyczna', 'slug' => 'praca-fizyczna'],
            ['name' => 'Mechanika', 'slug' => 'mechanika'],
            ['name' => 'Bankowość', 'slug' => 'bankowosc'],
            ['name' => 'Administracja baz danych', 'slug' => 'administracja-baz-danych'],
            ['name' => 'IT - Rozwój oprogramowania', 'slug' => 'it-rozwoj-oprogramowania'],
            ['name' => 'Obsługa klienta', 'slug' => 'obsluga-klienta'],
            ['name' => 'Opieka medyczna', 'slug' => 'opieka-medyczna'],
            ['name' => 'Energetyka', 'slug' => 'energetyka'],
            ['name' => 'Transport i logistyka', 'slug' => 'transport-logistyka'],
            ['name' => 'Gastronomia', 'slug' => 'gastronomia'],
            ['name' => 'Edukacja i szkolenia', 'slug' => 'edukacja-szkolenia'],
            ['name' => 'Budownictwo', 'slug' => 'budownictwo'],
            ['name' => 'Sprzedaż i marketing', 'slug' => 'sprzedaz-marketing'],
            ['name' => 'HR i rekrutacja', 'slug' => 'hr-rekrutacja'],
            ['name' => 'Prawo', 'slug' => 'prawo'],
            ['name' => 'Sztuka i design', 'slug' => 'sztuka-design'],
            ['name' => 'Rolnictwo i leśnictwo', 'slug' => 'rolnictwo-lesnictwo'],
            ['name' => 'Sport i rekreacja', 'slug' => 'sport-rekreacja'],
        ];

        foreach ($categories as $value) {
            Category::create($value);
        }
    }
}
