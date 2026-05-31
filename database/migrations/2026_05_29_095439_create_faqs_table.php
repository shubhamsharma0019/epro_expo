<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_id')->constrained('exhibitions')->onDelete('cascade');
            $table->string('question');
            $table->text('answer');
            $table->string('icon')->default('ph-question'); // e.g. 'ph-wifi-high', 'ph-download-simple'
            $table->string('category')->default('support'); // e.g. 'guide', 'support'
            $table->timestamps();
        });

        // Insert initial FAQs for seeded exhibitions
        $faqs = [
            [
                'exhibition_id' => 1,
                'question' => 'Download Event Guide',
                'answer' => 'Get the complete schedule, floor map, list of speakers, and details of all 120+ exhibitors in PDF format.',
                'icon' => 'ph-download-simple',
                'category' => 'guide',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exhibition_id' => 1,
                'question' => 'Wi-Fi Information',
                'answer' => 'Connect to the SSID "JioWorld_Free" or "EproExpo_WiFi" and use the access code "EXPO2026" for high-speed internet.',
                'icon' => 'ph-wifi-high',
                'category' => 'support',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exhibition_id' => 1,
                'question' => 'Help Desk & Support',
                'answer' => 'The general support help desk is located in the Main Entrance Lobby and open from 08:30 AM to 06:30 PM (IST).',
                'icon' => 'ph-question',
                'category' => 'support',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exhibition_id' => 1,
                'question' => 'Frequently Asked Questions (FAQs)',
                'answer' => 'Find quick answers regarding badge printing, locker room facility, food courts, parking validation, and nearby transport.',
                'icon' => 'ph-info',
                'category' => 'guide',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('faqs')->insert($faqs);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
