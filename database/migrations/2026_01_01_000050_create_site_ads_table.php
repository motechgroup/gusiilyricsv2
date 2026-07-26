<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('placement_spot'); // header_top, lyrics_above, lyrics_below, sidebar, footer
            $table->string('type')->default('image'); // image, script
            $table->string('image_path')->nullable();
            $table->string('target_url')->nullable();
            $table->text('code_script')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('impressions_count')->default(0);
            $table->unsignedBigInteger('clicks_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_ads');
    }
};
