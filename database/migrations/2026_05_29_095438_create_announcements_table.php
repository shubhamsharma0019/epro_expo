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
 
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_id')->constrained('exhibitions')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('type')->default('general'); // e.g. 'new', 'general', 'alert'
            $table->string('author_name')->nullable();
            $table->string('author_avatar')->nullable();
            $table->timestamps();
        });
 
        // Insert initial announcements for seeded exhibitions
        $announcements = [
            [
                'exhibition_id' => 1,
                'title' => 'Keynote Presentation by Sam Altman',
                'content' => 'Don\'t miss the Keynote speech on "The Future of Artificial General Intelligence" by Sam Altman on May 16 at 10:00 AM on the Main Stage!',
                'type' => 'new',
                'author_name' => 'Organizing Committee',
                'author_avatar' => 'https://i.pravatar.cc/150?u=sam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exhibition_id' => 1,
                'title' => 'Innovation Pavilion Now Open',
                'content' => 'Visit the Innovation Pavilion to explore 100+ new product listings and live robotics showcases from global manufacturers.',
                'type' => 'general',
                'author_name' => 'Event Admin',
                'author_avatar' => 'https://i.pravatar.cc/150?u=admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exhibition_id' => 1,
                'title' => 'Complimentary Lunch Coupons Available',
                'content' => 'Premium and Business Pass holders can collect their complimentary lunch coupons from the registration desk in Hall 1.',
                'type' => 'general',
                'author_name' => 'Registration Support',
                'author_avatar' => 'https://i.pravatar.cc/150?u=support',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Exhibition 2
            [
                'exhibition_id' => 2,
                'title' => 'AI Expo Bengaluru Opening Ceremony',
                'content' => 'Welcome to the Future of AI Expo! The opening ceremony starts at 09:30 AM in the Main Lobby.',
                'type' => 'new',
                'author_name' => 'Organizing Committee',
                'author_avatar' => 'https://i.pravatar.cc/150?u=expo',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
 
        DB::table('announcements')->insert($announcements);
 
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
