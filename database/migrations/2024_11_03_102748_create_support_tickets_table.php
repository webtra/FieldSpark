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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('ticket_number');
            $table->enum('category', [
                'Feature Request',
                'Technical Issue',
                'Billing/Payment',
                'Account Access',
                'Feedback',
                'Usability Issue',
                'Product Inquiry',
                'Security',
                'Upgrade/Downgrade Request',
                'General Inquiry'
            ])->default('Feature Request');
            $table->enum('urgency', [
                'Low',
                'Medium',
                'High',
                'Critical'
            ])->default('Medium');
            $table->text('subject');
            $table->text('message');
            $table->enum('status', [
                'Open', 
                'In Progress', 
                'Resolved', 
                'Closed'
            ])->default('Open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
