<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('music_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('song_id')->nullable()->constrained('songs')->onDelete('cascade');
            $table->foreignId('ad_inquiry_id')->nullable()->constrained('ad_inquiries')->onDelete('set null');
            $table->string('artist_name');
            $table->string('song_title');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('song_url')->nullable();
            $table->string('package_type')->default('Standard Listing');
            $table->string('status')->default('pending'); // pending, active, completed, paused, rejected
            $table->decimal('budget_amount', 10, 2)->default(0.00);
            $table->unsignedInteger('campaign_views')->default(0);
            $table->unsignedInteger('campaign_clicks')->default(0);
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->text('lyrics_text')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('songs', function (Blueprint $table) {
            $table->boolean('is_promoted')->default(false)->after('is_trending');
            $table->string('promoted_badge_text')->nullable()->after('is_promoted');
        });
    }

    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn(['is_promoted', 'promoted_badge_text']);
        });

        Schema::dropIfExists('music_promotions');
    }
};
