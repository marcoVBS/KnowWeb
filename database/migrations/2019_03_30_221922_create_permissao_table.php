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
        Schema::table('tb_permissao', function (Blueprint $table) {
            //
        });

        
        Schema::dropIfExists('tb_usuario_permissao');
        Schema::create('tb_usuario_permissao', function (Blueprint $table) {
            
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
