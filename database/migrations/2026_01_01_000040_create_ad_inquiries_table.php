<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('advertiser_name');
            $table->string('company_name')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('placement_spot')->default('header_banner'); // header_banner, in_lyrics, sidebar, footer
            $table->string('budget_range')->nullable();
            $table->string('banner_image')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('pending'); // pending, contacted, approved, declined
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_inquiries');
    }
};
