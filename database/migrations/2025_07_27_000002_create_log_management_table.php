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
        Schema::create('log_management', function (Blueprint $table) {
            $table->id();
            $table->string('operation'); // 'cleanup', 'rotation', 'backup'
            $table->integer('files_processed');
            $table->integer('files_deleted');
            $table->integer('files_rotated');
            $table->bigInteger('space_freed_bytes')->default(0);
            $table->text('details')->nullable();
            $table->timestamp('executed_at');
            $table->string('executed_by')->default('system');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_management');
    }
}; 