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
        Schema::create('agrochemicals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('recommended_dosage', 8, 2)->nullable();
            $table->enum('category', [
                'Herbicide',
                'Pesticide',
                'Fungicide',
                'Fertilizer',
                'Growth Regulator'
            ]);
            $table->string('manufacturer')->nullable();
            $table->enum('application_method', ['Spray', 'Granular', 'Drip', 'Foliar'])->default('Spray');
            $table->enum('toxicity_level', ['Low', 'Medium', 'High'])->default('Medium');
            $table->boolean('restricted_use')->default(false);
            $table->string('recommended_application_frequency')->nullable();
            $table->integer('reentry_interval')->nullable();
            $table->integer('pre_harvest_interval')->nullable();
            $table->text('safety_precautions')->nullable();
            $table->string('mixing_compatibility')->nullable();
            $table->integer('mixing_order');
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agrochemicals');
    }
};
