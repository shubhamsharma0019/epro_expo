<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booth_documents', function (Blueprint $table) {
            if (! Schema::hasColumn('booth_documents', 'document_type')) {
                $table->string('document_type')->nullable()->after('title');
            }
            if (! Schema::hasColumn('booth_documents', 'description')) {
                $table->text('description')->nullable()->after('file_size');
            }
            if (! Schema::hasColumn('booth_documents', 'status')) {
                $table->string('status')->default('active')->after('visibility');
            }
        });

        Schema::table('booth_catalogues', function (Blueprint $table) {
            if (! Schema::hasColumn('booth_catalogues', 'description')) {
                $table->text('description')->nullable()->after('category');
            }
            if (! Schema::hasColumn('booth_catalogues', 'status')) {
                $table->string('status')->default('active')->after('visibility');
            }
        });

        Schema::table('booth_media', function (Blueprint $table) {
            if (! Schema::hasColumn('booth_media', 'video_url')) {
                $table->string('video_url')->nullable()->after('file_path');
            }
            if (! Schema::hasColumn('booth_media', 'description')) {
                $table->text('description')->nullable()->after('thumbnail');
            }
            if (! Schema::hasColumn('booth_media', 'status')) {
                $table->string('status')->default('active')->after('sort_order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('booth_media', function (Blueprint $table) {
            foreach (['video_url', 'description', 'status'] as $column) {
                if (Schema::hasColumn('booth_media', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('booth_catalogues', function (Blueprint $table) {
            foreach (['description', 'status'] as $column) {
                if (Schema::hasColumn('booth_catalogues', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('booth_documents', function (Blueprint $table) {
            foreach (['document_type', 'description', 'status'] as $column) {
                if (Schema::hasColumn('booth_documents', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
