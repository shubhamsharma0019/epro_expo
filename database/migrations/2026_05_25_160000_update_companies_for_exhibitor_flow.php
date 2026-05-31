<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('companies')) {
            return;
        }

        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'status')) {
                $table->string('status')->default('approved')->change();
            }

            if (! Schema::hasColumn('companies', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            }

            if (! Schema::hasColumn('companies', 'name')) {
                $table->string('name')->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('companies', 'owner_name')) {
                $table->string('owner_name')->nullable()->after('name');
            }

            if (! Schema::hasColumn('companies', 'logo')) {
                $table->string('logo')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('companies', 'about')) {
                $table->text('about')->nullable()->after('website');
            }

            if (! Schema::hasColumn('companies', 'address')) {
                $table->text('address')->nullable()->after('about');
            }

            if (! Schema::hasColumn('companies', 'social_links')) {
                $table->json('social_links')->nullable()->after('address');
            }

            if (! Schema::hasColumn('companies', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('status');
            }

            if (! Schema::hasColumn('companies', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('submitted_at')->constrained('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('companies', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }

            if (! Schema::hasColumn('companies', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('approved_at');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('companies')) {
            return;
        }

        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'status')) {
                $table->string('status')->default('pending')->change();
            }

            foreach (['approved_by', 'user_id'] as $column) {
                if (Schema::hasColumn('companies', $column)) {
                    $table->dropConstrainedForeignId($column);
                }
            }

            foreach (['name', 'owner_name', 'logo', 'about', 'address', 'social_links', 'submitted_at', 'approved_at', 'rejection_reason'] as $column) {
                if (Schema::hasColumn('companies', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
