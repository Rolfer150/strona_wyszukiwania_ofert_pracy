<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Company;
use App\Models\Offer;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            //            ContractSeeder::class,
            //            EmploymentSeeder::class,
            //            WorkModeSeeder::class,
            RoleSeeder::class,
            SkillSeeder::class,
            UserSeeder::class
        ]);

        User::factory(80)->create()->each(function ($user) {
            $role = Arr::random(['employer', 'candidate']);
            $user->assignRole($role);
        });
        Offer::factory(1000)->create();
        Company::factory(100)->create();
        //        Skill::factory(200)->create();

        $categories = Category::all();
        $skills = Skill::all();
        Company::all()->each(function ($company) use ($categories) {
            $company->categories()->saveMany($categories->random(2));
        });
        User::all()->each(function ($user) use ($categories, $skills) {
            $user->categories()->saveMany($categories->random(2));
            $user->skills()->saveMany($skills->random(2));
        });
        Offer::all()->each(function ($offer) use ($skills) {
            $offer->skills()->saveMany($skills->random(2));
        });
    }
}
