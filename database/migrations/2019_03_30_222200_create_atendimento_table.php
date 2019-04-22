<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtendimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_atendimento', function (Blueprint $table) {
            $table->increments('id_atendimento');
            $table->string('titulo', 80);
            $table->text('descricao');
            $table->string('prioridade', 45)->nullable();
            $table->string('status', 45);
            $table->integer('categoria_atendimento_id')->unsigned();
            $table->foreign('categoria_atendimento_id')->references('id_categoria_atendimento')->on('tb_categoria_atendimento')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('setor_id')->unsigned()->nullable();
            $table->foreign('setor_id')->references('id_setor')->on('tb_setor')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('usuario_solicitante_id')->unsigned();
            $table->foreign('usuario_solicitante_id')->references('id_usuario')->on('tb_usuario')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('atendente_responsavel_id')->unsigned()->nullable();
            $table->foreign('atendente_responsavel_id')->references('id_usuario')->on('tb_usuario')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('atendente_encaminhado_id')->unsigned()->nullable();
            $table->foreign('atendente_encaminhado_id')->references('id_usuario')->on('tb_usuario')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->timestamp('time_finalizado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('tb_atendimento');
    }
}
