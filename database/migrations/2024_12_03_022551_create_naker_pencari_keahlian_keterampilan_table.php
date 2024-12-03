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
        Schema::create('naker_pencari_keahlian_keterampilan', function (Blueprint $table) {
            $table->id(); // Kolom id otomatis dibuat sebagai primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Kolom user_id yang merujuk ke tabel users
            $table->string('keahlian'); // Kolom untuk menyimpan keahlian
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->softDeletes(); // Kolom deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naker_pencari_keahlian_keterampilan');
    }
};
