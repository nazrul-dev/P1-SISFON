<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_n6', function (Blueprint $table) {
            // MASTER
            $table->bigIncrements('id');
            $table->unsignedBigInteger('desa_id');
            $table->enum('diinput_dari', ['desa', 'kua'])->default('desa');
            $table->string('n6_nomor_surat_keluar');
            $table->timestamp('tanggal_surat_keluar');
            $table->unsignedBigInteger('ttd_aparat_id');
            $table->string('n6_nama');
            $table->string('n6_jenis_kelamin')->default('L');
            $table->string('n6_gelar_belakang')->nullable();
            $table->string('n6_gelar_depan')->nullable();
            $table->string('n6_alamat_tempat_meninggal');
            $table->string('n6_pendidikan_terakhir');
            $table->string('n6_nama_panggilan');
            $table->string('n6_binti')->nullable();
            $table->string('n6_tipe_bin')->nullable();
            $table->string('n6_tempat_lahir');
            $table->string('n6_nik');
            $table->string('n6_agama');
            $table->string('n6_alamat')->nullable();
            $table->string('n6_village_id')->nullable();
            $table->string('n6_kecamatan_id')->nullable();
            $table->string('n6_kabupaten_id')->nullable();
            $table->string('n6_provinsi_id')->nullable();
            $table->string('n6_status_warganegara')->default('WNI');
            $table->unsignedBigInteger('n6_pekerjaan_id');
            $table->timestamp('n6_tanggal_meninggal');
            $table->timestamp('n6_tanggal_lahir');
            $table->timestamps();
            $table->integer('count_edit_first')->default(0);
            $table->boolean('status_edit')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_n6');
    }
};
