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
        Schema::table('users_pencari', function (Blueprint $table) {
            //
            $table->integer('status_saat_ini')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_pencari', function (Blueprint $table) {
            //
            $table->enum('status_saat_ini', ['bekerja', 'belum_bekerja', 'tidak_bekerja'])->nullable()->change();
        });
    }
};
