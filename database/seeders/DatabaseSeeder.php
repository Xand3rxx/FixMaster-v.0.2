<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        // $this->call(RoleSeeder::class);
        // $this->call(PermissionSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(CSESeeder::class);
        // $this->call(ClientSeeder::class);
        // $this->call(EstateSeeder::class);

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CSESeeder::class,
            ClientSeeder::class,
            EstateSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
