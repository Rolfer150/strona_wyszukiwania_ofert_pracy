<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        $candidate = Role::create(['name' => 'candidate']);
        $employer = Role::create(['name' => 'employer']);

        $apply_offer = Permission::create(['name' => 'apply offer']);
        $create_offer = Permission::create(['name' => 'create offer']);

        $apply_offer->assignRole($candidate);
        $create_offer->assignRole($employer);
        // $candidate->givePermissionTo($apply_offer);
        // $employer->givePermissionTo($create_offer);
    }
}
