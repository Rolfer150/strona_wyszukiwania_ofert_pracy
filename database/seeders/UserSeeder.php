<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::factory()->create([
            'email' => 'admin@test.pl',
            'name' => 'Admin',
            'surname' => 'Admiński',
            'slug' => Str::slug('Admin-Admiński-' . rand(1000, 9999)),
            'password' => bcrypt('test1234')
        ]);
        $admin->assignRole('admin');

        // Pracodawcy
        foreach (range(1, 3) as $i) {
            $employer = User::factory()->create([
                'email' => "employer$i@test.pl",
                'name' => "Pracodawca$i",
                'surname' => "Firma$i",
                'slug' => Str::slug("Pracodawca$i-Firma$i-" . rand(1000, 9999)),
                'password' => bcrypt('test1234')
            ]);
            $employer->assignRole('employer');
        }

        // Kandydaci
        foreach (range(1, 5) as $i) {
            $candidate = User::factory()->create([
                'email' => "candidate$i@test.pl",
                'name' => "Kandydat$i",
                'surname' => "Nowak$i",
                'slug' => Str::slug("Kandydat$i-Nowak$i-" . rand(1000, 9999)),
                'password' => bcrypt('test1234')
            ]);
            $candidate->assignRole('candidate');
        }
    }
}
