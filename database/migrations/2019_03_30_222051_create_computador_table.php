<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComputadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_computador', function (Blueprint $table) {
            $table->increments('id_computador');
            $table->string('placa_mae', 50);
            $table->string('processador', 50);
            $table->string('memoria_ram', 50);
            $table->string('unidade_armazenamento', 50);
            $table->string('mac_ethernet', 45)->nullable();
            $table->string('mac_wireless', 45)->nullable();
            $table->string('senha_usuario_adm', 60)->nullable();
            $table->string('nome_computador', 50)->nullable();
            $table->string('identificador_computador', 50)->nullable();
            $table->text('programas_especificos', 400)->nullable();
            $table->integer('sistema_operacional_id')->unsigned();
            $table->foreign('sistema_operacional_id')->references('id_sistema_operacional')->on('tb_sistema_operacional')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('setor_id')->unsigned()->nullable();
            $table->foreign('setor_id')->references('id_setor')->on('tb_setor')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('usuario_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->references('id_usuario')->on('tb_usuario')
                ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tb_computador');
    }
}
