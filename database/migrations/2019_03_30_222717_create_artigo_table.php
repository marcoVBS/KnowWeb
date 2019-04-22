<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtigoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_artigo', function (Blueprint $table) {
            $table->increments('id_artigo');
            $table->string('titulo', 100);
            $table->text('descricao')->nullable();
            $table->integer('categoria_artigo_id')->unsigned();
            $table->foreign('categoria_artigo_id')->references('id_categoria_artigo')->on('tb_categoria_artigo')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->text('conteudo');
            $table->integer('usuario_autor_id')->unsigned();
            $table->foreign('usuario_autor_id')->references('id_usuario')->on('tb_usuario')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('usuario_atualizador_id')->unsigned()->nullable();
            $table->foreign('usuario_atualizador_id')->references('id_usuario')->on('tb_usuario')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::dropIfExists('tb_artigo_senha');
        Schema::create('tb_artigo_senha', function (Blueprint $table) {
            $table->increments('id_artigo_senha');
            $table->integer('artigo_id')->unsigned();
            $table->foreign('artigo_id')->references('id_artigo')->on('tb_artigo')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('senha_id')->unsigned();
            $table->foreign('senha_id')->references('id_senha')->on('tb_senha')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::dropIfExists('tb_artigo_equipamento');
        Schema::create('tb_artigo_equipamento', function (Blueprint $table) {
            $table->increments('id_artigo_equipamento');
            $table->integer('artigo_id')->unsigned();
            $table->foreign('artigo_id')->references('id_artigo')->on('tb_artigo')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('equipamento_id')->unsigned();
            $table->foreign('equipamento_id')->references('id_equipamento')->on('tb_equipamento')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::dropIfExists('tb_artigo_atendimento');
        Schema::create('tb_artigo_atendimento', function (Blueprint $table) {
            $table->increments('id_artigo_atendimento');
            $table->integer('artigo_id')->unsigned();
            $table->foreign('artigo_id')->references('id_artigo')->on('tb_artigo')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('atendimento_id')->unsigned();
            $table->foreign('atendimento_id')->references('id_atendimento')->on('tb_atendimento')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::dropIfExists('tb_artigo_computador');
        Schema::create('tb_artigo_computador', function (Blueprint $table) {
            $table->increments('id_artigo_computador');
            $table->integer('artigo_id')->unsigned();
            $table->foreign('artigo_id')->references('id_artigo')->on('tb_artigo')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('computador_id')->unsigned();
            $table->foreign('computador_id')->references('id_computador')->on('tb_computador')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::dropIfExists('tb_artigo_arquivo');
        Schema::create('tb_artigo_arquivo', function (Blueprint $table) {
            $table->increments('id_artigo_arquivo');
            $table->integer('artigo_id')->unsigned();
            $table->foreign('artigo_id')->references('id_artigo')->on('tb_artigo')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('arquivo_id')->unsigned();
            $table->foreign('arquivo_id')->references('id_arquivo')->on('tb_arquivo')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::dropIfExists('tb_artigo_tag');
        Schema::create('tb_artigo_tag', function (Blueprint $table) {
            $table->increments('id_artigo_tag');
            $table->integer('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id_tag')->on('tb_tag')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('tb_artigo_senha');    
       Schema::dropIfExists('tb_artigo_equipamento');    
       Schema::dropIfExists('tb_artigo_atendimento');    
       Schema::dropIfExists('tb_artigo_computador');    
       Schema::dropIfExists('tb_artigo_arquivo'); 
       Schema::dropIfExists('tb_artigo_tag');   
       Schema::dropIfExists('tb_artigo');    
    }
}
