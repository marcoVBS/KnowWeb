<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArquivoArtigoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_arquivo_artigo', function (Blueprint $table) {
            $table->increments('id_arquivo_artigo');
            $table->string('nome', 45);
            $table->string('caminho', 100);
            $table->integer('artigo_id')->unsigned();
            $table->foreign('artigo_id')->references('id_artigo')->on('tb_artigo')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_arquivo_artigo');   
    }
}
