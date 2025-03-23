<?php

namespace Database\Factories;

use App\Enums\EducationalStage;
use App\Enums\SkillLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_name = fake()->firstName;
        $user_surname = fake()->lastName;
        $birth_date = date('Y-m-d', mt_rand(strtotime('1980-01-01'), strtotime('2005-12-31')));

        return [
            'email' => fake()->unique()->safeEmail,
            'name' => $user_name,
            'surname' => $user_surname,
            'slug' => Str::slug($user_name . '-' . $user_surname . '-' . random_int(1000, 9999)),
            'birth_date' => $birth_date,
            'phone_number' => fake()->phoneNumber,
            'education' => fake()->randomElement(EducationalStage::cases()),
            'school' => fake()->text(50),
            //            'short_description' => fake()->realText(128),
            'description' => fake()->realText(1024),
            'address' => [
                'city' => fake()->city,
                'street' => fake()->streetName,
                'home_nr' => fake()->buildingNumber,
                'zip_code' => fake()->postcode,
            ],
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
