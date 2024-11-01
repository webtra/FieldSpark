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
        Schema::create('cultivars', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name', 100)->index();
            $table->enum('growth_season', ['spring', 'summer', 'autumn', 'winter']);
            $table->integer('maturity_days')->nullable();
            $table->decimal('yield_potential', 10, 2)->nullable();
            $table->integer('water_requirements')->nullable();
            $table->string('soil_type', 100)->nullable();
            $table->decimal('plant_spacing', 5, 2)->nullable();
            $table->integer('root_depth')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultivars');
    }
};
