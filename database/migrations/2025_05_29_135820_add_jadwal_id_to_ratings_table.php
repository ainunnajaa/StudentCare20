<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('ratings', function (Blueprint $table) {
        $table->unsignedBigInteger('jadwal_id')->nullable()->after('id'); // langkah 1: hanya kolom
    });

    // langkah 2: isi data lama dulu via seeder atau query manual (lihat penjelasan di bawah)

    Schema::table('ratings', function (Blueprint $table) {
        $table->foreign('jadwal_id')->references('id')->on('jadwals')->onDelete('cascade'); // langkah 3: tambah FK
    });
}


};
