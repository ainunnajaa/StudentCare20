<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBiodataToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable();
            $table->string('jurusan')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nip')->nullable();        
            $table->string('whatsapp')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan',])->nullable();   
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'jurusan', 'tanggal_lahir', 'nip', 'whatsapp','jenis_kelamin']);
        });
    }
}
