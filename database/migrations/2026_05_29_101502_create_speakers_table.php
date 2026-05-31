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

        Schema::create('speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_id')->constrained('exhibitions')->onDelete('cascade');
            $table->string('name');
            $table->string('title');
            $table->string('company');
            $table->text('bio')->nullable();
            $table->string('avatar_url')->nullable();
            $table->timestamps();
        });

        // Insert initial speakers for Exhibition 1
        $speakers = [
            [
                'exhibition_id' => 1,
                'name' => 'Dr. Alan Stone',
                'title' => 'Director of AI Research',
                'company' => 'FutureLabs',
                'bio' => 'A pioneer in deep reinforcement learning and autonomous robotics. He has published 50+ research papers and leads the robotic intelligence team at FutureLabs.',
                'avatar_url' => 'https://randomuser.me/api/portraits/men/82.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'Elena Rodriguez',
                'title' => 'Cloud Solutions Architect',
                'company' => 'CloudSphere Tech',
                'bio' => ' Elena specializes in highly secure cloud networks and zero-downtime microservices migrations. She has assisted over 50 enterprise clients in automating their infrastructure.',
                'avatar_url' => 'https://randomuser.me/api/portraits/women/68.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'David Chen',
                'title' => 'VP of Sales & Engineering',
                'company' => 'DataMind Analytics',
                'bio' => 'David designs distributed storage engines capable of sub-millisecond query execution. He has over 15 years of database engineering experience.',
                'avatar_url' => 'https://randomuser.me/api/portraits/men/62.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'name' => 'Rahul Sharma',
                'title' => 'Lead Product Manager',
                'company' => 'TechNext Solutions',
                'bio' => 'Rahul oversees the development of RPA software and workflow cognitive managers designed to automate document ingestion and high-volume billing operations.',
                'avatar_url' => 'https://randomuser.me/api/portraits/men/32.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('speakers')->insert($speakers);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};
