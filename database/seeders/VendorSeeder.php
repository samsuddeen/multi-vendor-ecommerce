<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::insert([
            'name' => 'vendor',
            'email' => 'vendor@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
    }
}
