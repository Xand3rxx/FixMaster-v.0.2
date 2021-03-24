<?php

namespace Database\Seeders;

use App\Models\Town;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Town::truncate();
        // Using Eloquent ORM, this updates created at and updated at
        Town::create(['name' => Str::random(10)]);
        // Using Fluent Query Builder this doesn't update created_at and updated_at
        DB::table('towns')->insert(['name' => Str::random(10)]);
    }
}
