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

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CSESeeder::class,
            ClientSeeder::class,
            EstateSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            StateSeeder::class,
            LgaSeeder::class,
            ServiceRequestSeeder::class,
            ServiceRequestStatusSeeder::class,
            CountrySeeder::class,
            PaymentModeSeeder::class,
            PaymentDisbursedSeeder::class,
            ToolInventorySeeder::class,
            TaxSeeder::class,
            TaxHistorySeeder::class,
            QASeeder::class,
            DiscountSeeder::class,
            TechnicianSeeder::class,
            PriceSeeder::class,
            PriceHistorySeeder::class,
            BankSeeder::class,
        ]);
    }
}
