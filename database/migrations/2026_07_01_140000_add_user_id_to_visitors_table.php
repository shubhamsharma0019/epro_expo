<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('visitors')) {
            return;
        }

        Schema::table('visitors', function (Blueprint $table) {
            if (! Schema::hasColumn('visitors', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('exhibition_id')->constrained('users')->nullOnDelete();
                $table->index('user_id');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('visitors')) {
            return;
        }

        Schema::table('visitors', function (Blueprint $table) {
            if (Schema::hasColumn('visitors', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
