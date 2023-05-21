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
        Schema::create('provider_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->string('slug')->unique()->nullable();
            $table->string('name')->index()->nullable();
            $table->boolean('active')->default(false);
            $table->string('input_format')->index()->nullable();
            $table->string('output_format')->index()->nullable();
            $table->timestamps();

            $table->foreign('provider_id', 'fk_provider_model')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_models');
    }
};
