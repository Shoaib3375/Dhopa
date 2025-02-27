<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::insert([
            [
                'name' => 'Basic Package',
                'price' => 30.00,
                'included_services' => json_encode(['Washing', 'Ironing']),
            ],
            [
                'name' => 'Premium Package',
                'price' => 50.00,
                'included_services' => json_encode(['Washing', 'Dry Cleaning', 'Ironing']),
            ],
        ]);
    }
}
