<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('KES');
            $table->string('gateway', 30)->default('mpesa'); // mpesa, stripe, manual
            $table->string('transaction_reference')->nullable()->index();
            $table->string('status', 20)->default('completed'); // completed, pending, refunded
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
