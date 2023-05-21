<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('providers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        DB::table('providers')->insert([
            [
                'slug' => 'openai',
                'name' => 'OpenAI',
                'active' => true,
            ],
        ]);
    }
}
