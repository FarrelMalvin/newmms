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
        // Index untuk tabel testimoni
        Schema::table('testimoni', function (Blueprint $table) {
            // Cek apakah index sudah ada sebelum membuat
            if (!$this->indexExists('testimoni', 'idx_testimoni_pengguna')) {
                $table->index('id_pengguna', 'idx_testimoni_pengguna');
            }
            if (!$this->indexExists('testimoni', 'idx_testimoni_service')) {
                $table->index('id_service', 'idx_testimoni_service');
            }
            if (!$this->indexExists('testimoni', 'idx_testimoni_menyoroti')) {
                $table->index('menyoroti', 'idx_testimoni_menyoroti');
            }
            if (!$this->indexExists('testimoni', 'idx_testimoni_created')) {
                $table->index('created_at', 'idx_testimoni_created');
            }
            if (!$this->indexExists('testimoni', 'idx_testimoni_pengguna_service')) {
                $table->index(['id_pengguna', 'id_service'], 'idx_testimoni_pengguna_service');
            }
        });

        // Index untuk tabel berita
        Schema::table('berita', function (Blueprint $table) {
            if (!$this->indexExists('berita', 'idx_berita_created')) {
                $table->index('created_at', 'idx_berita_created');
            }
        });

        // Index untuk tabel produk
        Schema::table('produk', function (Blueprint $table) {
            if (!$this->indexExists('produk', 'idx_produk_kategori')) {
                $table->index('kategori', 'idx_produk_kategori');
            }
        });

        // Index untuk tabel pengguna
        Schema::table('pengguna', function (Blueprint $table) {
            if (!$this->indexExists('pengguna', 'idx_pengguna_peran')) {
                $table->index('peran', 'idx_pengguna_peran');
            }
        });

        // Index untuk tabel pengguna_admin
        Schema::table('pengguna_admin', function (Blueprint $table) {
            if (!$this->indexExists('pengguna_admin', 'idx_pengguna_admin_cabang')) {
                $table->index('id_cabang', 'idx_pengguna_admin_cabang');
            }
        });

        // Index tambahan untuk tabel service (yang belum tercakup)
        Schema::table('service', function (Blueprint $table) {
            if (!$this->indexExists('service', 'idx_service_tanggal_cabang_status')) {
                $table->index(['tanggal', 'id_cabang', 'status'], 'idx_service_tanggal_cabang_status');
            }
            if (!$this->indexExists('service', 'idx_service_jadwal')) {
                $table->index('jadwal', 'idx_service_jadwal');
            }
            if (!$this->indexExists('service', 'idx_service_finished')) {
                $table->index('finished_at', 'idx_service_finished');
            }
            if (!$this->indexExists('service', 'idx_service_completion_notified')) {
                $table->index('completion_notified', 'idx_service_completion_notified');
            }
        });

        // Index untuk tabel type_service
        Schema::table('type_service', function (Blueprint $table) {
            if (!$this->indexExists('type_service', 'idx_type_service_nama')) {
                $table->index('nama_service', 'idx_type_service_nama');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop testimoni indexes
        Schema::table('testimoni', function (Blueprint $table) {
            $table->dropIndexIfExists('idx_testimoni_pengguna');
            $table->dropIndexIfExists('idx_testimoni_service');
            $table->dropIndexIfExists('idx_testimoni_menyoroti');
            $table->dropIndexIfExists('idx_testimoni_created');
            $table->dropIndexIfExists('idx_testimoni_pengguna_service');
        });

        // Drop berita indexes
        Schema::table('berita', function (Blueprint $table) {
            $table->dropIndexIfExists('idx_berita_created');
        });

        // Drop produk indexes
        Schema::table('produk', function (Blueprint $table) {
            $table->dropIndexIfExists('idx_produk_kategori');
        });

        // Drop pengguna indexes
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropIndexIfExists('idx_pengguna_peran');
        });

        // Drop pengguna_admin indexes
        Schema::table('pengguna_admin', function (Blueprint $table) {
            $table->dropIndexIfExists('idx_pengguna_admin_cabang');
        });

        // Drop service additional indexes
        Schema::table('service', function (Blueprint $table) {
            $table->dropIndexIfExists('idx_service_tanggal_cabang_status');
            $table->dropIndexIfExists('idx_service_jadwal');
            $table->dropIndexIfExists('idx_service_finished');
            $table->dropIndexIfExists('idx_service_completion_notified');
        });

        // Drop type_service indexes
        Schema::table('type_service', function (Blueprint $table) {
            $table->dropIndexIfExists('idx_type_service_nama');
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
}; 