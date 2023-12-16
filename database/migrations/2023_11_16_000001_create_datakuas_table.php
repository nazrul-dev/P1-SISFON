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
        Schema::create('datakuas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('avatar')->nullable();
            $table->string('nama_kecamatan');
            $table->string('district_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('province_id')->nullable();
            $table->string('nama_kepala_kua');
            $table->string('alamat_kua')->nullable();
            $table->string('nip')->nullable();
            $table->boolean('di_luar_kabupaten')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datakuas');
    }
};
