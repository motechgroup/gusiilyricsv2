<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('artists', 'genre_id')) {
            Schema::table('artists', function (Blueprint $table) {
                $table->foreignId('genre_id')->nullable()->constrained('genres')->nullOnDelete()->after('slug');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('artists', 'genre_id')) {
            Schema::table('artists', function (Blueprint $table) {
                $table->dropForeign(['genre_id']);
                $table->dropColumn('genre_id');
            });
        }
    }
};
