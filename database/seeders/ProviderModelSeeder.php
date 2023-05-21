<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = DB::table('providers')->pluck('id', 'slug')->toArray();

        $openaiProvider = $providers['openai'] ?? null;

        DB::table('provider_models')->insert([
            [
                'provider_id' => $openaiProvider,
                'slug' => 'gpt-3.5-turbo',
                'name' => 'GPT-3.5 Turbo',
                'active' => true,
                'input_format' => 'text',
                'output_format' => 'text',
            ],
            [
                'provider_id' => $openaiProvider,
                'slug' => 'openai',
                'name' => 'GPT-4',
                'active' => true,
                'input_format' => 'text',
                'output_format' => 'text',
            ],
            [
                'provider_id' => $openaiProvider,
                'slug' => 'text-davinci-003',
                'name' => 'Text Davinci 003',
                'active' => true,
                'input_format' => 'text',
                'output_format' => 'text',
            ],
            [
                'provider_id' => $openaiProvider,
                'slug' => 'text-davinci-002',
                'name' => 'Text Davinci 002',
                'active' => true,
                'input_format' => 'text',
                'output_format' => 'text',
            ],
            [
                'provider_id' => $openaiProvider,
                'slug' => 'text-curie-001',
                'name' => 'Text Curie 001',
                'active' => true,
                'input_format' => 'text',
                'output_format' => 'text',
            ],
            [
                'provider_id' => $openaiProvider,
                'slug' => 'text-babbage-001',
                'name' => 'Text Babbage 001',
                'active' => true,
                'input_format' => 'text',
                'output_format' => 'text',
            ],
            [
                'provider_id' => $openaiProvider,
                'slug' => 'text-ada-001',
                'name' => 'Text Ada 001',
                'active' => true,
                'input_format' => 'text',
                'output_format' => 'text',
            ],
        ]);
    }
}
