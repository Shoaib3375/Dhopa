<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            ['name' => 'Washing', 'price_per_kg' => 5.00, 'price_per_piece' => null],
            ['name' => 'Dry Cleaning', 'price_per_kg' => 10.00, 'price_per_piece' => null],
            ['name' => 'Ironing', 'price_per_kg' => null, 'price_per_piece' => 2.00],
        ]);
    }
}
