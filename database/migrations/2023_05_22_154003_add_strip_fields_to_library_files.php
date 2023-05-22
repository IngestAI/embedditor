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
            $table->boolean('strip_tag')->default(false)->after('file_key');
            $table->boolean('strip_punctuation')->default(false)->after('strip_tag');
            $table->boolean('strip_special_char')->default(false)->after('strip_punctuation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('library_files', function (Blueprint $table) {
            $table->dropColumn('strip_tag');
            $table->dropColumn('strip_punctuation');
            $table->dropColumn('strip_special_char');
        });
    }
};
