<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'gender')) {
                $table->string('gender', 20)->nullable()->after('phone');
            }
            if (! Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('gender');
            }
        });

        Schema::table('visitor_tickets', function (Blueprint $table) {
            if (! Schema::hasColumn('visitor_tickets', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status');
            }
            if (! Schema::hasColumn('visitor_tickets', 'razorpay_order_id')) {
                $table->string('razorpay_order_id')->nullable()->after('payment_status');
            }
            if (! Schema::hasColumn('visitor_tickets', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id')->nullable()->after('razorpay_order_id');
            }
            if (! Schema::hasColumn('visitor_tickets', 'attendee_gender')) {
                $table->string('attendee_gender', 20)->nullable()->after('attendee_phone');
            }
            if (! Schema::hasColumn('visitor_tickets', 'attendee_city')) {
                $table->string('attendee_city')->nullable()->after('attendee_gender');
            }
        });
    }

    public function down(): void
    {
        Schema::table('visitor_tickets', function (Blueprint $table) {
            $columns = ['attendee_city', 'attendee_gender', 'razorpay_payment_id', 'razorpay_order_id', 'payment_status'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('visitor_tickets', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('users', function (Blueprint $table) {
            foreach (['city', 'gender'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
