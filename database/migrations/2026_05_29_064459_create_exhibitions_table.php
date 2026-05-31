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
        if (Schema::hasTable('exhibitions')) {
            Schema::table('exhibitions', function (Blueprint $table) {
                if (!Schema::hasColumn('exhibitions', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('exhibitions', 'venue')) {
                    $table->string('venue')->nullable();
                }
                if (!Schema::hasColumn('exhibitions', 'banner_url')) {
                    $table->string('banner_url')->nullable();
                }
                if (!Schema::hasColumn('exhibitions', 'companies_count')) {
                    $table->integer('companies_count')->default(0);
                }
            });
        } else {
            Schema::create('exhibitions', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->date('start_date');
                $table->date('end_date');
                $table->string('venue');
                $table->text('description');
                $table->integer('companies_count')->default(0);
                $table->string('banner_url')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('exhibitions')) {
            Schema::table('exhibitions', function (Blueprint $table) {
                $columns = [];
                if (Schema::hasColumn('exhibitions', 'name')) $columns[] = 'name';
                if (Schema::hasColumn('exhibitions', 'venue')) $columns[] = 'venue';
                if (Schema::hasColumn('exhibitions', 'banner_url')) $columns[] = 'banner_url';
                if (Schema::hasColumn('exhibitions', 'companies_count')) $columns[] = 'companies_count';
                
                if (count($columns) > 0) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
