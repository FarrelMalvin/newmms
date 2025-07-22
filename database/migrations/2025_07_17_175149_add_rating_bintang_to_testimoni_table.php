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
        // Berita
        if (!Schema::hasTable('berita')) {
            Schema::create('berita', function (Blueprint $table) {
<<<<<<< HEAD
                $table->id('id_berita');
=======
                $table->integer('id_berita')->primary()->autoIncrement();
>>>>>>> 885471175fa0715ebbfa0816a9c109590157b94f
                $table->string('judul_berita', 255);
                $table->text('deskripsi');
                $table->string('foto', 255)->nullable();
                // Jika ingin relasi ke user, bisa tambahkan kolom id_pengguna dan foreign key
                // $table->integer('id_pengguna')->nullable();
                // $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('set null');
            });
        }
        // Testimoni
        if (!Schema::hasTable('testimoni')) {
            Schema::create('testimoni', function (Blueprint $table) {
<<<<<<< HEAD
                $table->id('id_testimoni');
                $table->unsignedBigInteger('id_pengguna');
                $table->unsignedBigInteger('id_service');
=======
                $table->integer('id_testimoni')->primary()->autoIncrement();
                $table->unsignedBigInteger('id_pengguna');
                $table->integer('id_service');
>>>>>>> 885471175fa0715ebbfa0816a9c109590157b94f
                $table->text('isi_testimoni');
                $table->string('menyoroti', 5)->default('false');
                $table->integer('rating_bintang');
                $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
                $table->foreign('id_service')->references('id_service')->on('service')->onDelete('cascade');
                // Constraint CHECK akan ditambah setelah create
            });
<<<<<<< HEAD
            // SQLite doesn't support CHECK constraints, so we'll handle validation in the model
=======
            \DB::statement('ALTER TABLE testimoni ADD CONSTRAINT rating_bintang_check CHECK (rating_bintang >= 1 AND rating_bintang <= 5)');
>>>>>>> 885471175fa0715ebbfa0816a9c109590157b94f
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