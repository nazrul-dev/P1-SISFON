<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aparatur_desas', function (Blueprint $table) {
            $table
                ->foreign('jabatan_id')
                ->references('id')
                ->on('jabatans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('desa_id')
                ->references('id')
                ->on('desas')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aparatur_desas', function (Blueprint $table) {
            $table->dropForeign(['jabatan_id']);
            $table->dropForeign(['desa_id']);
        });
    }
};
