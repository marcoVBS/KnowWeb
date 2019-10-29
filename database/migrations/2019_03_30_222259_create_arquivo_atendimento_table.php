<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArquivoAtendimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_arquivo_atendimento', function (Blueprint $table) {
            $table->increments('id_arquivo_atendimento');
            $table->integer('atendimento_id')->unsigned();
            $table->foreign('atendimento_id')->references('id_atendimento')->on('tb_atendimento')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('resposta_atendimento_id')->unsigned()->nullable();
            $table->foreign('resposta_atendimento_id')->references('id_resposta_atendimento')->on('tb_resposta_atendimento')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('nome', 150);
            $table->string('caminho', 300);
            $table->string('tipo', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_arquivo_atendimento');
    }
}
