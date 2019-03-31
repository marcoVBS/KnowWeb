<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespostaAtendimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_resposta_atendimento', function (Blueprint $table) {
            $table->increments('id_resposta_atendimento');
            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id_usuario')->on('tb_usuario')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('atendimento_id')->unsigned();
            $table->foreign('atendimento_id')->references('id_atendimento')->on('tb_atendimento')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->text('resposta', 500);
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
        Schema::dropIfExists('tb_resposta_atendimento');
    }
}
