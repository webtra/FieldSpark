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
            $table->string('prime_name');
            $table->string('variety_number')->nullable()->unique();
            $table->string('country')->nullable();
            $table->text('color_of_berry_skin')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->text('species')->nullable();
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
