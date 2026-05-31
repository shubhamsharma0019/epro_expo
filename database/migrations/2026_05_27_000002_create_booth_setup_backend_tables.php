<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booth_bookings', function (Blueprint $table) {
            if (! Schema::hasColumn('booth_bookings', 'booth_setup_status')) {
                $table->string('booth_setup_status')->default('draft')->after('booking_status');
            }
        });

        Schema::table('booth_profiles', function (Blueprint $table) {
            foreach ([
                'company_logo' => fn () => $table->string('company_logo')->nullable(),
                'company_name' => fn () => $table->string('company_name')->nullable(),
                'contact_person' => fn () => $table->string('contact_person')->nullable(),
                'industry' => fn () => $table->string('industry')->nullable(),
                'email' => fn () => $table->string('email')->nullable(),
                'phone' => fn () => $table->string('phone')->nullable(),
                'tagline' => fn () => $table->string('tagline')->nullable(),
                'website' => fn () => $table->string('website')->nullable(),
                'about_company' => fn () => $table->longText('about_company')->nullable(),
                'address' => fn () => $table->string('address')->nullable(),
                'city' => fn () => $table->string('city')->nullable(),
                'state' => fn () => $table->string('state')->nullable(),
                'zip_code' => fn () => $table->string('zip_code')->nullable(),
                'country' => fn () => $table->string('country')->nullable(),
                'linkedin_url' => fn () => $table->string('linkedin_url')->nullable(),
                'twitter_url' => fn () => $table->string('twitter_url')->nullable(),
                'facebook_url' => fn () => $table->string('facebook_url')->nullable(),
                'youtube_url' => fn () => $table->string('youtube_url')->nullable(),
                'created_by' => fn () => $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(),
                'deleted_at' => fn () => $table->softDeletes(),
            ] as $column => $callback) {
                if (! Schema::hasColumn('booth_profiles', $column)) {
                    $callback();
                }
            }
        });

        if (! Schema::hasTable('booth_brandings')) {
            Schema::create('booth_brandings', function (Blueprint $table) {
                $this->baseOwnedTable($table);
                $table->string('booth_banner')->nullable();
                $table->string('primary_color')->nullable();
                $table->string('secondary_color')->nullable();
                $table->string('welcome_heading')->nullable();
                $table->string('theme_template')->nullable();
                $table->string('booth_background')->nullable();
                $table->string('cta_button_text')->nullable();
                $table->string('cta_button_link')->nullable();
                $table->softDeletes();
                $table->unique('booth_booking_id');
            });
        }

        if (! Schema::hasTable('booth_products')) {
            Schema::create('booth_products', function (Blueprint $table) {
                $this->baseOwnedTable($table);
                $table->string('product_image')->nullable();
                $table->string('name');
                $table->string('category')->nullable();
                $table->text('short_description')->nullable();
                $table->longText('detailed_description')->nullable();
                $table->string('status')->default('draft');
                $table->unsignedInteger('views')->default(0);
                $table->integer('sort_order')->default(0);
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable('booth_documents')) {
            Schema::create('booth_documents', function (Blueprint $table) {
                $this->baseOwnedTable($table);
                $table->string('title');
                $table->string('file_path');
                $table->string('file_type')->nullable();
                $table->string('visibility')->default('public');
                $table->unsignedBigInteger('file_size')->nullable();
                $table->unsignedInteger('downloads')->default(0);
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable('booth_catalogues')) {
            Schema::create('booth_catalogues', function (Blueprint $table) {
                $this->baseOwnedTable($table);
                $table->string('title');
                $table->string('cover_image')->nullable();
                $table->string('file_path');
                $table->string('category')->nullable();
                $table->unsignedInteger('pages')->nullable();
                $table->unsignedBigInteger('file_size')->nullable();
                $table->string('visibility')->default('public');
                $table->unsignedInteger('downloads')->default(0);
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable('booth_media')) {
            Schema::create('booth_media', function (Blueprint $table) {
                $this->baseOwnedTable($table);
                $table->string('title');
                $table->string('type')->default('image');
                $table->string('file_path');
                $table->string('thumbnail')->nullable();
                $table->unsignedBigInteger('file_size')->nullable();
                $table->unsignedInteger('views')->default(0);
                $table->integer('sort_order')->default(0);
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable('booth_team_members')) {
            Schema::create('booth_team_members', function (Blueprint $table) {
                $this->baseOwnedTable($table);
                $table->string('photo')->nullable();
                $table->string('name');
                $table->string('designation');
                $table->json('expertise_tags')->nullable();
                $table->string('email');
                $table->string('phone')->nullable();
                $table->date('availability_start_date')->nullable();
                $table->date('availability_end_date')->nullable();
                $table->time('availability_start_time')->nullable();
                $table->time('availability_end_time')->nullable();
                $table->string('status')->default('active');
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable('booth_meeting_availabilities')) {
            Schema::create('booth_meeting_availabilities', function (Blueprint $table) {
                $this->baseOwnedTable($table);
                $table->date('available_start_date');
                $table->date('available_end_date');
                $table->json('available_weekdays');
                $table->time('daily_start_time');
                $table->time('daily_end_time');
                $table->json('meeting_types');
                $table->unsignedInteger('slot_duration');
                $table->unsignedInteger('buffer_time')->nullable();
                $table->foreignId('assigned_team_member_id')->nullable()->constrained('booth_team_members')->nullOnDelete();
                $table->string('timezone')->nullable();
                $table->softDeletes();
                $table->unique('booth_booking_id');
            });
        }

        if (! Schema::hasTable('booth_meeting_slots')) {
            Schema::create('booth_meeting_slots', function (Blueprint $table) {
                $this->baseOwnedTable($table);
                $table->foreignId('team_member_id')->nullable()->constrained('booth_team_members')->nullOnDelete();
                $table->date('date');
                $table->time('start_time');
                $table->time('end_time');
                $table->string('meeting_type');
                $table->string('status')->default('available');
            });
        }

        if (! Schema::hasTable('booth_sessions')) {
            Schema::create('booth_sessions', function (Blueprint $table) {
                $this->baseOwnedTable($table);
                $table->foreignId('team_member_id')->nullable()->constrained('booth_team_members')->nullOnDelete();
                $table->string('title');
                $table->longText('description')->nullable();
                $table->date('session_date');
                $table->time('start_time');
                $table->time('end_time');
                $table->string('type')->default('live_demo');
                $table->unsignedInteger('attendee_limit')->nullable();
                $table->string('status')->default('upcoming');
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable('booth_setup_steps')) {
            Schema::create('booth_setup_steps', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->constrained()->cascadeOnDelete();
                $table->foreignId('booth_booking_id')->constrained()->cascadeOnDelete();
                $table->string('step_key');
                $table->string('step_name');
                $table->string('status')->default('pending');
                $table->timestamp('completed_at')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();
                $table->unique(['booth_booking_id', 'step_key']);
            });
        }

        if (! Schema::hasTable('booth_publish_requests')) {
            Schema::create('booth_publish_requests', function (Blueprint $table) {
                $this->baseOwnedTable($table);
                $table->string('status')->default('pending');
                $table->timestamp('submitted_at')->nullable();
                $table->foreignId('reviewed_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamp('reviewed_at')->nullable();
                $table->text('rejection_reason')->nullable();
                $table->softDeletes();
                $table->unique('booth_booking_id');
            });
        }

        if (! Schema::hasTable('booth_analytics')) {
            Schema::create('booth_analytics', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->constrained()->cascadeOnDelete();
                $table->foreignId('booth_booking_id')->constrained()->cascadeOnDelete();
                $table->unsignedInteger('booth_views')->default(0);
                $table->unsignedInteger('product_views')->default(0);
                $table->unsignedInteger('brochure_downloads')->default(0);
                $table->unsignedInteger('meeting_requests')->default(0);
                $table->unsignedInteger('enquiries')->default(0);
                $table->unsignedInteger('session_attendees')->default(0);
                $table->json('lead_sources')->nullable();
                $table->json('traffic_trend')->nullable();
                $table->json('recent_activities')->nullable();
                $table->timestamps();
                $table->unique('booth_booking_id');
            });
        }
    }

    public function down(): void
    {
        foreach ([
            'booth_analytics',
            'booth_publish_requests',
            'booth_setup_steps',
            'booth_sessions',
            'booth_meeting_slots',
            'booth_meeting_availabilities',
            'booth_team_members',
            'booth_media',
            'booth_catalogues',
            'booth_documents',
            'booth_products',
            'booth_brandings',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }

    private function baseOwnedTable(Blueprint $table): void
    {
        $table->id();
        $table->foreignId('company_id')->constrained()->cascadeOnDelete();
        $table->foreignId('booth_booking_id')->constrained()->cascadeOnDelete();
        $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamps();
    }
};
