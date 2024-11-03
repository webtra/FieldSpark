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
        Schema::create('agrochemical_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id');
            $table->foreignId('agrochemical_id');
            $table->date('planned_application_date');

            $table->date('application_date')->nullable();
            $table->time('application_time')->nullable();
            $table->decimal('tractor_hours_start', 8, 1)->nullable();
            $table->decimal('tractor_hours_end', 8, 1)->nullable();
            $table->integer('tank_number')->nullable();
            $table->integer('liters_sprayed')->nullable();
            $table->string('operator_name')->nullable();
            
            $table->boolean('application_sheet_generated')->default(false);
            $table->string('application_sheet_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agrochemical_programs');
    }
};
