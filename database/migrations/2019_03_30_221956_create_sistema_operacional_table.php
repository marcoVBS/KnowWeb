<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemaOperacionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_sistema_operacional', function (Blueprint $table) {
            $table->increments('id_sistema_operacional');
            $table->string('nome', 80);
            $table->string('versao', 45);
            $table->string('arquiterura', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_sistema_operacional');
    }
}
