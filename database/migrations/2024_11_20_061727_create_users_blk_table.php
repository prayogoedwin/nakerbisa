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
        Schema::create('users_blk', function (Blueprint $table) {
            $table->bigIncrements('id'); // Kolom id, primary key
            $table->unsignedBigInteger('user_id'); // Foreign key ke tabel users
            $table->string('name', 255)->nullable();
            $table->unsignedSmallInteger('id_provinsi'); // tidak auto_increment
            $table->unsignedSmallInteger('id_kota'); // tidak auto_increment
            $table->unsignedMediumInteger('id_kecamatan'); // tidak auto_increment
            $table->char('id_desa', 10);
            $table->string('alamat', 200)->nullable();
            $table->string('kodepos', 5)->nullable();
            $table->string('telpon', 13)->nullable();
            $table->string('pic', 255)->nullable();
            $table->string('jabatan', 50)->nullable();
            $table->string('website', 100)->nullable();
            $table->tinyInteger('status_id')->default(1); // int 1 dengan default 1
            $table->string('foto', 255)->nullable();
            $table->integer('posted_by', false, true)->length(11);
            $table->timestamps(); // Untuk created_at dan updated_at
            $table->softDeletes();

            // Relasi foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_blk');
    }
};
