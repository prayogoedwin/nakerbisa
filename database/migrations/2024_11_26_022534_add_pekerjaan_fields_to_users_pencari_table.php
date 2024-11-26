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
            $table->unsignedInteger('sektor_pekerjaan_saat_ini')->nullable()->after('status_saat_ini');
            $table->integer('jam_kerja')->nullable()->after('sektor_pekerjaan_saat_ini');
            $table->decimal('gaji', 10, 2)->nullable()->after('jam_kerja');

            $table->foreign('sektor_pekerjaan_saat_ini')
                ->references('id')
                ->on('naker_sektor')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_pencari', function (Blueprint $table) {
            //
            $table->dropForeign(['sektor_pekerjaan_saat_ini']);
            $table->dropColumn(['sektor_pekerjaan_saat_ini', 'jam_kerja', 'gaji']);
        });
    }
};
