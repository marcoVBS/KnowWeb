<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_usuario', function (Blueprint $table) {
            $table->Increments('id_usuario');
            $table->string('nome', 80);
            $table->string('email', 80)->unique();
            $table->string('telefone', 30);
            $table->string('cpf', 20);
            $table->string('foto', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('tipo_usuario', 45);
            $table->integer('status');
            $table->integer('setor_id')->unsigned();
            $table->foreign('setor_id')->references('id_setor')->on('tb_setor')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('tb_usuario');
    }
}
