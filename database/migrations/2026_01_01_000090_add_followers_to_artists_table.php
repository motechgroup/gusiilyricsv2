<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('artists', 'followers_count')) {
            Schema::table('artists', function (Blueprint $table) {
                $table->unsignedBigInteger('followers_count')->default(0)->after('is_featured');
            });
        }

        if (!Schema::hasTable('artist_followers')) {
            Schema::create('artist_followers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');
                $table->string('ip_address', 45);
                $table->string('visitor_token', 64)->nullable();
                $table->timestamps();

                $table->unique(['artist_id', 'ip_address']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('artist_followers');
        if (Schema::hasColumn('artists', 'followers_count')) {
            Schema::table('artists', function (Blueprint $table) {
                $table->dropColumn('followers_count');
            });
        }
    }
};
