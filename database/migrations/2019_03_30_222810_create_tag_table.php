<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_tag', function (Blueprint $table) {
            //
        });

        Schema::dropIfExists('tb_artigo_tag');
        Schema::create('tb_artigo_tag', function (Blueprint $table) {
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('tb_artigo_tag');  
       Schema::dropIfExists('tb_tag');  
    }
}
