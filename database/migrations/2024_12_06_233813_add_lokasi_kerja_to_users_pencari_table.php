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
            $table->enum('lokasi_kerja_saat_ini', ['0', '1'])->default('0')->comment('0: Rembang, 1: Luar Rembang')->nullable();
            $table->integer('lokasi_kerja_saat_ini_kec')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_pencari', function (Blueprint $table) {
            $table->dropColumn('lokasi_kerja_saat_ini');
            $table->dropColumn('lokasi_kerja_saat_ini_kec');
        });
    }
};
