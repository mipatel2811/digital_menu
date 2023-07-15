<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Role::truncate();

        Role::create([
            'role_name' => 'user',
            'role' => 0,
        ]);

        Role::create([
            'role_name' => 'super_admin',
            'role' => 1,
        ]);

        Role::create([
            'role_name' => 'admin',
            'role' => 2,
        ]);

        Role::create([
            'role_name' => 'owner',
            'role' => 3,
        ]);
        
    }
}
