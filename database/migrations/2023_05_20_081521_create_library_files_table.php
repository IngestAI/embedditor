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
        Schema::create('library_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('library_id');
            $table->string('original_name');
            $table->string('filename');
            $table->string('file_key');
            $table->boolean('uploaded');
            $table->boolean('formatted');
            $table->boolean('embedded');
            $table->timestamps();


            $table->foreign('library_id', 'fk_library')
                ->references('id')
                ->on('libraries')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_files');
    }
};
