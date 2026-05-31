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

        Schema::create('agenda_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_id')->constrained('exhibitions')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('speaker_name');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('hall_name');
            $table->timestamps();
        });

        // Insert initial sessions for Exhibition 1 (Global Tech Summit 2024)
        $sessions = [
            [
                'exhibition_id' => 1,
                'title' => 'Opening Keynote: Future of GenAI & Robotics',
                'description' => 'Dr. Alan Stone discusses the convergence of deep generative models with physical automation.',
                'speaker_name' => 'Dr. Alan Stone',
                'start_time' => '10:00 AM',
                'end_time' => '11:00 AM',
                'hall_name' => 'Keynote Hall A',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'title' => 'Secure Enterprise Cloud & Serverless Infrastructure',
                'description' => 'Best practices for provisioning private VPC networks and managing auto-scaled serverless nodes.',
                'speaker_name' => 'Elena Rodriguez',
                'start_time' => '11:30 AM',
                'end_time' => '12:30 PM',
                'hall_name' => 'Seminar Room 1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'title' => 'B2B Matchmaking & Networking Lunch',
                'description' => 'Open networking session for corporate sponsors and registered VIP pass attendees.',
                'speaker_name' => 'Organizing Committee',
                'start_time' => '12:30 PM',
                'end_time' => '02:00 PM',
                'hall_name' => 'Main Executive Lounge',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'title' => 'Distributed Datasets and Sub-Second Queries',
                'description' => 'Technical deep-dive on scaling database index fields and caches for high-concurrency requests.',
                'speaker_name' => 'David Chen',
                'start_time' => '02:00 PM',
                'end_time' => '03:00 PM',
                'hall_name' => 'Seminar Room 2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exhibition_id' => 1,
                'title' => 'RPA Automation and Cognitive Workflow Orchestration',
                'description' => 'How to automate repetitive document extraction and invoice routing using cognitive automation software.',
                'speaker_name' => 'Rahul Sharma',
                'start_time' => '03:30 PM',
                'end_time' => '04:30 PM',
                'hall_name' => 'Keynote Hall A',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('agenda_sessions')->insert($sessions);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_sessions');
    }
};
