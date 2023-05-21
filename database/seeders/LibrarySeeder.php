<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('libraries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        DB::table('libraries')->insert([
            'name' => 'Default library',
            'temperature' => 0.5,
            'chunk_size' => 1500,
        ]);
    }
}
