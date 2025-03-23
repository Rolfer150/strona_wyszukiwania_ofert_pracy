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
        $user = User::first();
        $itCategory = Category::where('slug', 'it-rozwoj-oprogramowania')->first();
        $gastronomy = Category::where('slug', 'gastronomia')->first();
        $transport = Category::where('slug', 'transport-logistyka')->first();
        $education = Category::where('slug', 'edukacja-szkolenia')->first();

        if (!$user || !$itCategory || !$gastronomy || !$transport || !$education) {
            $this->command->error('Brakuje użytkownika lub kategorii. Najpierw uruchom UserSeeder i CategorySeeder.');
            return;
        }

        Offer::create([
            'name' => 'Programista',
            'slug' => Str::slug('Programista'),
            // 'image_path' => 'offer/python-programming-language.png',
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
            'user_id' => $user->id,
            'payment' => PaymentType::MNETTO,
            'salary' => 20000,
            'category_id' => $itCategory->id,
            'employment' => Employment::PELNY_ETAT,
            'contract' => Contract::UMOWA_O_PRACE,
            'work_mode' => WorkMode::PRACA_STACJONARNA
        ]);

        Offer::create([
            'name' => 'Kucharz',
            'slug' => Str::slug('Kucharz'),
            // 'image_path' => 'offer/kucharz.png',
            'description' => 'Poszukujemy doświadczonego kucharza do restauracji z kuchnią polską.',
            'tasks' => [
                'Przygotowywanie dań według receptur',
                'Zachowanie higieny i czystości na stanowisku pracy'
            ],
            'expectancies' => [
                'Min. 2 lata doświadczenia w gastronomii',
                'Zaangażowanie i punktualność'
            ],
            'additionals' => [
                'Kurs HACCP'
            ],
            'assurances' => [
                'Elastyczny grafik',
                'Posiłki pracownicze'
            ],
            'active' => true,
            'vacancy' => 2,
            'user_id' => $user->id,
            'payment' => PaymentType::HNETTO,
            'salary' => 25,
            'category_id' => $gastronomy->id,
            'employment' => Employment::PELNY_ETAT,
            'contract' => Contract::UMOWA_O_PRACE,
            'work_mode' => WorkMode::PRACA_STACJONARNA
        ]);

        Offer::create([
            'name' => 'Kierowca C+E',
            'slug' => Str::slug('Kierowca C+E'),
            'image_path' => 'offer/kierowca.png',
            'description' => 'Firma transportowa poszukuje kierowcy C+E na trasach międzynarodowych.',
            'tasks' => [
                'Transport towarów po UE',
                'Prowadzenie dokumentacji przewozowej'
            ],
            'expectancies' => [
                'Prawo jazdy kat. C+E',
                'Karta kierowcy, kurs na przewóz rzeczy'
            ],
            'additionals' => [
                'Doświadczenie min. 1 rok w zawodzie'
            ],
            'assurances' => [
                'System pracy 3/1 lub 4/1',
                'Nowoczesna flota'
            ],
            'active' => true,
            'vacancy' => 1,
            'user_id' => $user->id,
            'payment' => PaymentType::MNETTO,
            'salary' => 8500,
            'category_id' => $transport->id,
            'employment' => Employment::PELNY_ETAT,
            'contract' => Contract::UMOWA_O_PRACE,
            'work_mode' => WorkMode::PRACA_MOBILNA
        ]);

        Offer::create([
            'name' => 'Nauczyciel matematyki',
            'slug' => Str::slug('Nauczyciel matematyki'),
            // 'image_path' => 'offer/nauczyciel.png',
            'description' => 'Szkoła podstawowa zatrudni nauczyciela matematyki.',
            'tasks' => [
                'Prowadzenie zajęć edukacyjnych',
                'Przygotowanie materiałów i sprawdzianów'
            ],
            'expectancies' => [
                'Wykształcenie kierunkowe',
                'Umiejętność pracy z dziećmi'
            ],
            'additionals' => [
                'Doświadczenie w nauczaniu zdalnym'
            ],
            'assurances' => [
                'Stabilne zatrudnienie',
                'Dodatki motywacyjne'
            ],
            'active' => true,
            'vacancy' => 1,
            'user_id' => $user->id,
            'payment' => PaymentType::MNETTO,
            'salary' => 4800,
            'category_id' => $education->id,
            'employment' => Employment::PELNY_ETAT,
            'contract' => Contract::UMOWA_O_PRACE,
            'work_mode' => WorkMode::PRACA_STACJONARNA
        ]);
    }
}
