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
        Schema::table('tb_artigo', function (Blueprint $table) {
            //
        });

        Schema::dropIfExists('tb_artigo_senha');
        Schema::create('tb_artigo_senha', function (Blueprint $table) {
            
        });

        Schema::dropIfExists('tb_artigo_equipamento');
        Schema::create('tb_artigo_equipamento', function (Blueprint $table) {
            
        });

        Schema::dropIfExists('tb_artigo_atendimento');
        Schema::create('tb_artigo_atendimento', function (Blueprint $table) {
            
        });

        Schema::dropIfExists('tb_artigo_computador');
        Schema::create('tb_artigo_computador', function (Blueprint $table) {
            
        });

        Schema::dropIfExists('tb_artigo_arquivo');
        Schema::create('tb_artigo_arquivo', function (Blueprint $table) {
            
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
       Schema::dropIfExists('tb_artigo');    
    }
}
