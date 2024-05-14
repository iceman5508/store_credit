<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plan = Package::create([
            'name' => 'Monthly Plan',
            'price' => '9.99'
        ]);
        $plan = Package::create([
            'name' => 'Annual Plan',
            'price' => '59.99'
        ]);
       
    }
}
