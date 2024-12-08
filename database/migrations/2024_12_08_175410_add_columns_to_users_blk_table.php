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
        Schema::table('users_blk', function (Blueprint $table) {
            $table->string('no_izin_pendirian')->nullable(); // No. Izin Pendirian
            $table->date('waktu_pendirian')->nullable(); // Waktu Pendirian
            $table->string('nomor_vin')->nullable(); // Nomor VIN
            $table->string('nomor_induk_berusaha')->nullable(); // Nomor Induk Berusaha (NIB)
            $table->string('nomor_akreditasi_lembaga')->nullable(); // Nomor Akreditasi Lembaga
            $table->date('berlaku_sampai')->nullable(); // Berlaku Sampai
            $table->string('jenis_pelatihan')->nullable(); // Jenis Pelatihan
            $table->integer('kapasitas_peserta_per_pelatihan')->nullable(); // Kapasitas Peserta Per Pelatihan
            $table->integer('jumlah_lulusan_sampai_sekarang')->nullable(); // Jumlah Lulusan Sampai Sekarang
            $table->integer('jumlah_peserta_lulus_uji_kompetensi')->nullable(); // Jumlah Peserta Lulus Uji Kompetensi
            $table->integer('jumlah_instruktur')->nullable(); // Jumlah Instruktur
            $table->integer('jumlah_instruktur_bersertifikat_kompetensi')->nullable(); // Jumlah Instruktur Bersertifikat Kompetensi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_blk', function (Blueprint $table) {
            $table->dropColumn([
                'no_izin_pendirian',
                'waktu_pendirian',
                'nomor_vin',
                'nomor_induk_berusaha',
                'nomor_akreditasi_lembaga',
                'berlaku_sampai',
                'jenis_pelatihan',
                'kapasitas_peserta_per_pelatihan',
                'jumlah_lulusan_sampai_sekarang',
                'jumlah_peserta_lulus_uji_kompetensi',
                'jumlah_instruktur',
                'jumlah_instruktur_bersertifikat_kompetensi',
            ]);
        });
    }
};
