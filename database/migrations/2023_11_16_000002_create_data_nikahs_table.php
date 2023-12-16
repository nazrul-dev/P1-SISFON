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
        Schema::create('data_nikahs', function (Blueprint $table) {
            // MASTER


            $table->unsignedBigInteger('desa_id');
            $table->enum('diinput_dari', ['desa', 'kua'])->default('desa');
            $table->bigIncrements('id');
            $table->string('nomor_terakhir');
            $table->string('status_pemohon');
            $table->string('nomor_urut');
            $table->string('nomor_surat_keluar_s')->nullable();
            $table->string('nomor_surat_keluar_i')->nullable();
            $table->timestamp('tanggal_surat_keluar');
            $table->timestamp('tanggal_akad');
            $table->string('jam_akad');
            $table->string('status_tempat_akad');
            $table->string('alamat_tempat_akad');
            $table->string('saksi1');
            $table->string('saksi2')->nullable();
            $table->unsignedBigInteger('kua_pencatatan');
            $table->unsignedBigInteger('ttd_aparat');
            $table->timestamp('tanggal_diterima_kua');


            // SUAMI

            $table->string('nama');
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('pendidikan_terakhir');
            $table->string('nama_panggilan');
            $table->boolean('s_yatim');
            $table->boolean('s_piatu');
            $table->string('tempat_lahir');
            $table->timestamp('tanggal_lahir');
            $table->string('nik');
            $table->string('agama');
            $table->string('alamat')->nullable();
            $table->string('village_id')->nullable();
            $table->string('kecamatan_id')->nullable();
            $table->string('kabupaten_id')->nullable();
            $table->string('provinsi_id')->nullable();
            $table->string('status_perkawinan');
            $table->integer('istri_ke')->nullable();
            $table->string('nama_istri_terdahulu')->nullable();
            $table->string('nomor_handphone')->nullable();
            $table->string('status_warganegara')->default('WNI');
            $table->unsignedBigInteger('pekerjaan_id');

            // ISTRI

            $table->string('i_nama');
            $table->string('i_gelar_depan')->nullable();
            $table->string('i_gelar_belakang')->nullable();
            $table->string('i_pendidikan_terakhir');
            $table->string('i_nama_panggilan');
            $table->boolean('i_yatim');
            $table->boolean('i_piatu');
            $table->string('i_tempat_lahir');
            $table->string('i_nik');
            $table->string('i_agama');
            $table->string('i_alamat')->nullable();
            $table->string('i_village_id')->nullable();
            $table->string('i_kecamatan_id')->nullable();
            $table->string('i_kabupaten_id')->nullable();
            $table->string('i_provinsi_id')->nullable();
            $table->string('i_status_perkawinan');
            $table->integer('i_suami_ke')->nullable();
            $table->string('i_nomor_handphone')->nullable();
            $table->string('i_status_warganegara')->default('WNI');
            $table->date('i_tanggal_lahir');
            $table->unsignedBigInteger('i_pekerjaan_id');

            // ORTU SUAMI

            $table->string('sa_nama');
            $table->string('sa_status_warganegara')->nullable();
            $table->string('sa_binti')->nullable();
            $table->string('sa_tipe_binti')->nullable();
            $table->string('sa_tempat_lahir')->nullable();
            $table->date('sa_tanggal_lahir')->nullable();
            $table->string('sa_nik')->nullable();
            $table->string('sa_agama')->nullable();
            $table->string('sa_alamat')->nullable();
            $table->unsignedBigInteger('sa_pekerjaan_id')->nullable();

            // --

            $table->string('si_nama');
            $table->string('si_status_warganegara')->nullable();
            $table->string('si_binti')->nullable();
            $table->string('si_tipe_binti')->nullable();
            $table->string('si_tempat_lahir')->nullable();
            $table->date('si_tanggal_lahir')->nullable();
            $table->string('si_nik')->nullable();
            $table->string('si_agama')->nullable();
            $table->string('si_alamat')->nullable();
            $table->unsignedBigInteger('si_pekerjaan_id')->nullable();


            // ORTU ISTRI

            $table->string('ia_nama');
            $table->string('ia_status_warganegara')->nullable();
            $table->string('ia_binti')->nullable();
            $table->string('ia_tipe_binti')->nullable();
            $table->string('ia_tempat_lahir')->nullable();
            $table->date('ia_tanggal_lahir')->nullable();
            $table->string('ia_nik')->nullable();
            $table->string('ia_agama')->nullable();
            $table->string('ia_alamat')->nullable();
            $table->unsignedBigInteger('ia_pekerjaan_id')->nullable();
            // --
            $table->string('ii_nama');
            $table->string('ii_status_warganegara')->nullable();
            $table->string('ii_binti')->nullable();
            $table->string('ii_tipe_binti')->nullable();
            $table->string('ii_tempat_lahir')->nullable();
            $table->date('ii_tanggal_lahir')->nullable();
            $table->string('ii_nik')->nullable();
            $table->string('ii_agama')->nullable();
            $table->string('ii_alamat')->nullable();
            $table->unsignedBigInteger('ii_pekerjaan_id')->nullable();
            $table->unsignedBigInteger('n6_id')->nullable();
            $table->unsignedBigInteger('i_n6_id')->nullable();
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
        Schema::dropIfExists('data_nikahs');
    }
};
