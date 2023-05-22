<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('library_files', function (Blueprint $table) {
            $table->boolean('lowercase')->default(false)->after('file_key');
            $table->boolean('stop_word')->default(false)->after('lowercase');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('library_files', function (Blueprint $table) {
            $table->dropColumn('lowercase');
            $table->dropColumn('stop_word');
        });
    }
};
