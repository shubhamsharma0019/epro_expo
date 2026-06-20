<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('admin_roles')) {
            Schema::create('admin_roles', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->boolean('is_system')->default(false);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('admin_permissions')) {
            Schema::create('admin_permissions', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('slug')->unique();
                $table->string('module')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('admin_role_permissions')) {
            Schema::create('admin_role_permissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admin_role_id')->constrained('admin_roles')->cascadeOnDelete();
                $table->foreignId('admin_permission_id')->constrained('admin_permissions')->cascadeOnDelete();
                $table->timestamps();
                $table->unique(['admin_role_id', 'admin_permission_id'], 'admin_role_permission_unique');
            });
        }

        if (! Schema::hasTable('admin_role_assignments')) {
            Schema::create('admin_role_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
                $table->foreignId('admin_role_id')->constrained('admin_roles')->cascadeOnDelete();
                $table->foreignId('assigned_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamp('assigned_at')->nullable();
                $table->timestamps();
                $table->unique(['admin_id', 'admin_role_id'], 'admin_role_assignment_unique');
            });
        }

        if (! Schema::hasTable('company_kyc_verifications')) {
            Schema::create('company_kyc_verifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->constrained()->cascadeOnDelete();
                $table->string('gst_number')->nullable();
                $table->string('pan_number')->nullable();
                $table->string('cin_number')->nullable();
                $table->string('registration_certificate_path')->nullable();
                $table->string('tax_certificate_path')->nullable();
                $table->string('id_proof_path')->nullable();
                $table->string('status')->default('pending');
                $table->unsignedTinyInteger('risk_score')->default(0);
                $table->json('risk_flags')->nullable();
                $table->text('review_notes')->nullable();
                $table->foreignId('reviewed_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamp('reviewed_at')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('admin_notifications')) {
            Schema::create('admin_notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->string('type')->default('system');
                $table->string('title');
                $table->text('message');
                $table->string('channel')->default('in_app');
                $table->string('priority')->default('normal');
                $table->json('meta')->nullable();
                $table->string('status')->default('unread');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('cms_pages')) {
            Schema::create('cms_pages', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('page_type')->default('page');
                $table->longText('content')->nullable();
                $table->json('sections')->nullable();
                $table->json('seo')->nullable();
                $table->string('status')->default('draft');
                $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('support_tickets')) {
            Schema::create('support_tickets', function (Blueprint $table) {
                $table->id();
                $table->string('ticket_number')->unique();
                $table->string('requester_type')->default('company');
                $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('name');
                $table->string('email');
                $table->string('subject');
                $table->text('message');
                $table->string('category')->default('general');
                $table->string('priority')->default('normal');
                $table->string('status')->default('open');
                $table->foreignId('assigned_to')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamp('resolved_at')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('support_ticket_messages')) {
            Schema::create('support_ticket_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('support_ticket_id')->constrained('support_tickets')->cascadeOnDelete();
                $table->string('sender_type')->default('admin');
                $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->text('message');
                $table->json('attachments')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('admin_activity_logs')) {
            Schema::create('admin_activity_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->string('action');
                $table->string('subject_type')->nullable();
                $table->unsignedBigInteger('subject_id')->nullable();
                $table->string('module')->nullable();
                $table->json('changes')->nullable();
                $table->json('meta')->nullable();
                $table->ipAddress('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('admin_settings')) {
            Schema::create('admin_settings', function (Blueprint $table) {
                $table->id();
                $table->string('group')->default('general');
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('value_type')->default('string');
                $table->text('description')->nullable();
                $table->boolean('is_public')->default(false);
                $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('admin_system_settings')) {
            Schema::create('admin_system_settings', function (Blueprint $table) {
                $table->id();
                $table->string('category')->default('platform');
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('value_type')->default('string');
                $table->boolean('is_encrypted')->default(false);
                $table->text('description')->nullable();
                $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('payment_refunds')) {
            Schema::create('payment_refunds', function (Blueprint $table) {
                $table->id();
                $table->string('refund_type')->default('ticket');
                $table->foreignId('booth_booking_id')->nullable()->constrained('booth_bookings')->nullOnDelete();
                $table->foreignId('visitor_ticket_id')->nullable()->constrained('visitor_tickets')->nullOnDelete();
                $table->decimal('amount', 12, 2)->default(0);
                $table->string('currency', 10)->default('INR');
                $table->string('status')->default('requested');
                $table->string('reason')->nullable();
                $table->text('notes')->nullable();
                $table->foreignId('processed_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamp('processed_at')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('visitor_checkins')) {
            Schema::create('visitor_checkins', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('visitor_ticket_id')->nullable()->constrained('visitor_tickets')->nullOnDelete();
                $table->foreignId('company_event_id')->nullable()->constrained('company_events')->nullOnDelete();
                $table->foreignId('exhibition_id')->nullable()->constrained('exhibitions')->nullOnDelete();
                $table->string('entry_gate')->nullable();
                $table->string('checkin_type')->default('qr');
                $table->string('status')->default('checked_in');
                $table->foreignId('verified_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamp('checked_in_at')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('admin_leads')) {
            Schema::create('admin_leads', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('enquiry_id')->nullable()->constrained('enquiries')->nullOnDelete();
                $table->foreignId('visitor_meeting_booking_id')->nullable()->constrained('visitor_meeting_bookings')->nullOnDelete();
                $table->string('lead_source')->default('enquiry');
                $table->string('lead_status')->default('new');
                $table->unsignedTinyInteger('lead_score')->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('admin_flow_diagrams')) {
            Schema::create('admin_flow_diagrams', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->longText('diagram_content')->nullable();
                $table->string('diagram_type')->default('process');
                $table->string('status')->default('draft');
                $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_flow_diagrams');
        Schema::dropIfExists('admin_leads');
        Schema::dropIfExists('visitor_checkins');
        Schema::dropIfExists('payment_refunds');
        Schema::dropIfExists('admin_system_settings');
        Schema::dropIfExists('admin_settings');
        Schema::dropIfExists('admin_activity_logs');
        Schema::dropIfExists('support_ticket_messages');
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('cms_pages');
        Schema::dropIfExists('admin_notifications');
        Schema::dropIfExists('company_kyc_verifications');
        Schema::dropIfExists('admin_role_assignments');
        Schema::dropIfExists('admin_role_permissions');
        Schema::dropIfExists('admin_permissions');
        Schema::dropIfExists('admin_roles');
    }
};
