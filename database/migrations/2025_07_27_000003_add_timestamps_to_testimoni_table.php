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
        Schema::table('testimoni', function (Blueprint $table) {
            // Tambah timestamps jika belum ada
            if (!Schema::hasColumn('testimoni', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimoni', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}; 