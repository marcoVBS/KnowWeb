<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_permissao', function (Blueprint $table) {
            $table->increments('id_permissao');
            $table->string('nome', 45);
            $table->string('descricao', 100)->nullable();
        });

        
        Schema::dropIfExists('tb_usuario_permissao');
        Schema::create('tb_usuario_permissao', function (Blueprint $table) {
            $table->increments('id_usuario_permissao');
            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id_usuario')->on('tb_usuario')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('permissao_id')->unsigned();
            $table->foreign('permissao_id')->references('id_permissao')->on('tb_permissao')
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
        Schema::dropIfExists('tb_usuario_permissao');
        Schema::dropIfExists('tb_permissao');
    }
}
