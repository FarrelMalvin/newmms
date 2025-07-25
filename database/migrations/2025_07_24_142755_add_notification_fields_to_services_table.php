<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('service', function (Blueprint $table) {
            $table->boolean('completion_notified')->default(false)->after('finished_at');
            $table->timestamp('notification_sent_at')->nullable()->after('completion_notified');
            $table->boolean('testimonial_eligible')->default(false)->after('notification_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('service', function (Blueprint $table) {
            $table->dropColumn(['completion_notified', 'notification_sent_at', 'testimonial_eligible']);
        });
    }
};