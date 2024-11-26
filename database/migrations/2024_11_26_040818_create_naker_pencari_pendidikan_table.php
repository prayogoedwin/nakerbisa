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
        Schema::create('naker_pencari_pendidikan', function (Blueprint $table) {
            $table->id(); // id primary key
            $table->unsignedBigInteger('user_id'); // foreign key ke tabel users
            $table->unsignedBigInteger('pendidikan_id'); // pendidikan_id
            $table->unsignedBigInteger('jurusan_id')->nullable(); // jurusan_id
            $table->string('nama_sekolah')->nullable(); // nama sekolah
            $table->text('alamat_sekolah')->nullable(); // alamat sekolah
            $table->year('lulus')->nullable(); // tahun lulus
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
        Schema::dropIfExists('naker_pencari_pendidikan');
    }
};
