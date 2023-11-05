<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            ['country' => 'PL', 'perdiem_amount' => 10],
            ['country' => 'DE', 'perdiem_amount' => 50],
            ['country' => 'GB', 'perdiem_amount' => 75]
        ]);
    }
}
