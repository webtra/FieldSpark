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
        Schema::create('agrochemical_program_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')
                ->references('id')
                ->on('agrochemical_programs')
                ->onDelete('cascade');
            $table->date('application_date')->nullable();
            $table->time('time')->nullable();
            $table->float('tractor_start_hours')->nullable();
            $table->float('tractor_end_hours')->nullable();
            $table->integer('tank_number')->nullable();
            $table->float('liters_applied')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agrochemical_program_applications');
    }
};
