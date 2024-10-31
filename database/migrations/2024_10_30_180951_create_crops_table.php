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
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cultivar_id')->constrained('cultivars');
            $table->string('block_number');
            $table->date('planting_date');
            $table->date('harvest_date')->nullable();
            $table->string('location');
            $table->enum('status', ['planted', 'growing', 'harvested', 'failed']);
            $table->integer('size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crops');
    }
};
