<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArquivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_arquivo', function (Blueprint $table) {
            $table->increments('id_arquivo');
            $table->string('caminho', 100);
            $table->string('tamanho', 20);
            $table->string('nome', 50);
            $table->integer('extensao_arquivo_id')->unsigned();
            $table->foreign('extensao_arquivo_id')->references('id_extensao_arquivo')->on('tb_extensao_arquivo')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('categoria_arquivo_id')->unsigned();
            $table->foreign('categoria_arquivo_id')->references('id_categoria_arquivo')->on('tb_categoria_arquivo')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('usuario_id')->unsigned();
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
        Schema::dropIfExists('tb_arquivo');
    }
}
