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
        Schema::table('service', function (Blueprint $table) {
            // Index untuk auto-complete query
            $table->index(['status', 'started_at'], 'idx_service_status_started');
            
            // Index untuk query lainnya
            $table->index('id_pengguna', 'idx_service_pengguna');
            $table->index('tanggal', 'idx_service_tanggal');
            $table->index('id_cabang', 'idx_service_cabang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service', function (Blueprint $table) {
            $table->dropIndex('idx_service_status_started');
            $table->dropIndex('idx_service_pengguna');
            $table->dropIndex('idx_service_tanggal');
            $table->dropIndex('idx_service_cabang');
        });
    }
}; 