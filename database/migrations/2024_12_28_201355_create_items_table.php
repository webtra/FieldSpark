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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->string('name');
            $table->enum('unit', ['g', 'kg', 'ml', 'l'])->nullable();
            $table->text('description')->nullable();
            $table->decimal('recommended_dosage', 8, 2)->nullable();
            $table->enum('category', [
                'Herbicide',
                'Pesticide',
                'Fungicide',
                'Fertilizer',
                'Growth Regulator'
            ])->nullable();
            $table->enum('application_method', ['Spray', 'Granular', 'Drip', 'Foliar'])->default('Spray')->nullable();
            $table->enum('toxicity_level', ['Low', 'Medium', 'High'])->default('Medium')->nullable();
            $table->boolean('restricted_use')->default(false)->nullable();
            $table->string('recommended_application_frequency')->nullable();
            $table->integer('reentry_interval')->nullable();
            $table->integer('pre_harvest_interval')->nullable();
            $table->text('safety_precautions')->nullable();
            $table->string('mixing_compatibility')->nullable();
            $table->integer('mixing_order')->nullable();
            $table->enum('mixing_category', [
                'Water',
                'Water Quality Regulators',
                'Water-Soluble Packets',
                'Dry Formulations',
                'Suspension Concentrates',
                'Emulsifiable Concentrates',
                'Adhesives',
                'Water-Soluble Liquids',
                'Foliar Feedings'
            ])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
