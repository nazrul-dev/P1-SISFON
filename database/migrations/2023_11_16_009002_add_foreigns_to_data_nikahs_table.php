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
        Schema::table('data_nikahs', function (Blueprint $table) {
            $table
                ->foreign('kua_pencatatan')
                ->references('id')
                ->on('datakuas')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('kua_lainnya')
                ->references('id')
                ->on('jabatans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('pencetak_id')
                ->references('id')
                ->on('users')
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
        Schema::table('data_nikahs', function (Blueprint $table) {
            $table->dropForeign(['kua_pencatatan']);
            $table->dropForeign(['kua_lainnya']);
            $table->dropForeign(['pencetak_id']);
            $table->dropForeign(['desa_id']);
        });
    }
};
