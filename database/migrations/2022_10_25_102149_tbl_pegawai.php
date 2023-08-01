<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pegawai', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('nip',10);
            $table->String('nama',255);
            $table->String('email',100);
            $table->String('gd',5);
            $table->String('gb',5);
            $table->String('nohp',5);
            $table->String('image',100);
            $table->enum('status', ['ASN', 'NONASN'])->default('ASN');
            $table->String('kode_unitkerja',15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pegawai');
    }
}
