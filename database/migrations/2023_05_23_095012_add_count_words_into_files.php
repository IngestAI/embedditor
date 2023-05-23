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
            $table->unsignedBigInteger('total_words')->default(0)->after('chunked_list');
            $table->unsignedBigInteger('total_embedded_words')->default(0)->after('chunked_list');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('library_files', function (Blueprint $table) {
            $table->dropColumn('total_words');
            $table->dropColumn('total_embedded_words');
        });
    }
};
