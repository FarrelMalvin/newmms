<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Berita
        if (!Schema::hasTable('berita')) {
            Schema::create('berita', function (Blueprint $table)
             {
                $table->integer('id_berita')->primary()->autoIncrement();
                $table->string('judul_berita', 255);
                $table->text('deskripsi');
                $table->string('foto', 255)->nullable();
              
            });
        }
        // Testimoni
        if (!Schema::hasTable('testimoni')) {
            Schema::create('testimoni', function (Blueprint $table) {
                $table->integer('id_testimoni')->primary()->autoIncrement();
                $table->unsignedBigInteger('id_pengguna');
                $table->integer('id_service');
                $table->text('isi_testimoni');
                $table->string('menyoroti', 5)->default('false');
                $table->integer('rating_bintang');
                $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
                $table->foreign('id_service')->references('id_service')->on('service')->onDelete('cascade');
                // Constraint CHECK akan ditambah setelah create
            });
            DB::statement('ALTER TABLE testimoni ADD CONSTRAINT rating_bintang_check CHECK (rating_bintang >= 1 AND rating_bintang <= 5)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimoni');
        Schema::dropIfExists('berita');
    }
};