<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_equipamento', function (Blueprint $table) {
            $table->increments('id_equipamento');
            $table->string('descricao', 70);
            $table->text('caracteristicas', 500);
            $table->integer('categoria_equipamento_id')->unsigned();
            $table->foreign('categoria_equipamento_id')->references('id_categoria_equipamento')->on('tb_categoria_equipamento')
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
        Schema::dropIfExists('tb_equipamento');
    }
}
