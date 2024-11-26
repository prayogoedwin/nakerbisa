<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('naker_pencari_keterampilan', function (Blueprint $table) {
            $table->id(); // id primary key
            $table->unsignedBigInteger('user_id'); // foreign key ke tabel users
            $table->string('lembaga_penyelenggara')->nullable(); // nama lembaga penyelenggara
            $table->text('alamat_penyelenggara')->nullable(); // alamat lembaga
            $table->year('lulus_tahun')->nullable(); // tahun lulus pelatihan
            $table->string('no_sertifikat')->nullable(); // nomor sertifikat pelatihan
            $table->string('lembaga_penguji')->nullable(); // lembaga penguji
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at untuk soft delete

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naker_pencari_keterampilan');
    }
};
