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
        Schema::create('naker_pencari_pengalaman', function (Blueprint $table) {
            $table->id(); // id primary key
            $table->unsignedBigInteger('user_id'); // foreign key ke tabel users
            $table->string('nama_perusahaan')->nullable(); // nama perusahaan
            $table->text('alamat_perusahaan')->nullable(); // alamat perusahaan
            $table->year('mulai_tahun'); // tahun mulai bekerja
            $table->year('berhenti_tahun')->nullable(); // tahun berhenti bekerja
            $table->string('jabatan')->nullable(); // jabatan di perusahaan
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
        Schema::dropIfExists('naker_pencari_pengalaman');
    }
};
