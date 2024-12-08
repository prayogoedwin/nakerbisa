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
            $table->integer('status_saat_ini')->default(2)->change(); // Ubah default value
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_pencari', function (Blueprint $table) {
            $table->integer('status_saat_ini')->default(null)->change(); // Kembalikan default value ke null atau nilai sebelumnya
        });
    }
};
