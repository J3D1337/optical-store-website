<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            ['name' => 'Rijeka', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Crikvenica', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
