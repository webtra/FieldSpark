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
        Schema::create('varieties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->foreignId('type_id')->references('id')->on('types');
            $table->string('name');
            $table->string('yield_potential')->nullable();
            $table->integer('water_requirements')->nullable();
            $table->string('soil_type')->nullable();
            $table->integer('plant_spacing')->nullable();
            $table->integer('row_spacing')->nullable();
            $table->string('root_depth')->nullable();
            $table->enum('growth_season', ['spring', 'summer', 'autumn', 'winter'])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('varieties');
    }
};
