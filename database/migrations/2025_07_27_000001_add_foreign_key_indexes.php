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
        // Index untuk foreign key di tabel service
        Schema::table('service', function (Blueprint $table) {
            // id_tipe_service sudah ada foreign key, pastikan ada index
            if (!$this->indexExists('service', 'service_id_tipe_service_index') && !$this->indexExists('service', 'idx_service_tipe_service')) {
                $table->index('id_tipe_service', 'idx_service_tipe_service');
            }
        });

        // Index untuk foreign key di tabel testimoni
        Schema::table('testimoni', function (Blueprint $table) {
            // Pastikan foreign key constraints memiliki index yang optimal
            if (!$this->foreignKeyExists('testimoni', 'testimoni_id_pengguna_foreign')) {
                $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            }
            if (!$this->foreignKeyExists('testimoni', 'testimoni_id_service_foreign')) {
                $table->foreign('id_service')->references('id_service')->on('service')->onDelete('cascade');
            }
        });

        // Index untuk foreign key di tabel pengguna_admin
        Schema::table('pengguna_admin', function (Blueprint $table) {
            // Pastikan foreign key constraints memiliki index yang optimal
            if (!$this->foreignKeyExists('pengguna_admin', 'pengguna_admin_id_pengguna_foreign')) {
                $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            }
            if (!$this->foreignKeyExists('pengguna_admin', 'pengguna_admin_id_cabang_foreign')) {
                $table->foreign('id_cabang')->references('id_cabang')->on('cabang')->onDelete('cascade');
            }
        });

        // Index untuk foreign key di tabel service (cabang)
        Schema::table('service', function (Blueprint $table) {
            if (!$this->foreignKeyExists('service', 'service_id_cabang_foreign')) {
                $table->foreign('id_cabang')->references('id_cabang')->on('cabang')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints if they were added
        Schema::table('testimoni', function (Blueprint $table) {
            $table->dropForeignIfExists(['id_pengguna']);
            $table->dropForeignIfExists(['id_service']);
        });

        Schema::table('pengguna_admin', function (Blueprint $table) {
            $table->dropForeignIfExists(['id_pengguna']);
            $table->dropForeignIfExists(['id_cabang']);
        });

        Schema::table('service', function (Blueprint $table) {
            $table->dropForeignIfExists(['id_cabang']);
            $table->dropIndexIfExists('idx_service_tipe_service');
        });
    }

    /**
     * Check if index exists
     */
    private function indexExists($table, $indexName)
    {
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = '{$indexName}'");
        return count($indexes) > 0;
    }

    /**
     * Check if foreign key exists
     */
    private function foreignKeyExists($table, $constraintName)
    {
        $constraints = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = '{$table}' 
            AND CONSTRAINT_NAME = '{$constraintName}'
        ");
        return count($constraints) > 0;
    }
}; 