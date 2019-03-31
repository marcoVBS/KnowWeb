<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSenhaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_senha', function (Blueprint $table) {
            $table->increments('id_senha');
            $table->string('descricao', 70);
            $table->string('login', 50);
            $table->string('senha', 60);
            $table->text('observacoes', 300)->nullable();
            $table->integer('equipamento_id')->unsigned()->nullable();
            $table->foreign('equipamento_id')->references('id_equipamento')->on('tb_equipamento')
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
        Schema::dropIfExists('tb_senha');
    }
}
