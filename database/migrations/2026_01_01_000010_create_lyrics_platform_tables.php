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
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('location')->default('Kisii, Kenya');
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();
            $table->integer('release_year')->nullable();
            $table->timestamps();
        });

        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('album_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('genre_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('lyrics_raw');
            $table->text('english_translation')->nullable();
            $table->text('swahili_translation')->nullable();
            $table->string('spotify_url')->nullable();
            $table->string('apple_music_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('audio_url')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('likes_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->timestamps();
        });

        Schema::create('corrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('song_id')->constrained()->onDelete('cascade');
            $table->string('visitor_name')->nullable();
            $table->string('visitor_email')->nullable();
            $table->string('correction_type')->default('spelling'); // spelling, missing_lines, translation, other
            $table->text('details');
            $table->string('status')->default('pending'); // pending, reviewed, rejected
            $table->timestamps();
        });

        Schema::create('lyric_requests', function (Blueprint $table) {
            $table->id();
            $table->string('song_title');
            $table->string('artist_name');
            $table->string('visitor_email')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, fulfilled, rejected
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('lyric_requests');
        Schema::dropIfExists('corrections');
        Schema::dropIfExists('songs');
        Schema::dropIfExists('albums');
        Schema::dropIfExists('artists');
        Schema::dropIfExists('genres');
    }
};
