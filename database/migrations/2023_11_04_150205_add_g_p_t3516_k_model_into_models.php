<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $openaiProvider = DB::table('providers')
            ->where('slug', 'openai')
            ->pluck('id')
            ->first();

        DB::table('provider_models')->insert([
            [
                'provider_id' => $openaiProvider,
                'slug' => 'gpt-3.5-turbo-16k',
                'name' => 'GPT-3.5 16K',
                'active' => true,
                'input_format' => 'text',
                'output_format' => 'text',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('provider_models')
            ->where('slug', 'gpt-3.5-turbo-16k')
            ->delete();
    }
};
