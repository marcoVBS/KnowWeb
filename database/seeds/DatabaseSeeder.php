<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    
        DB::table('tb_setor')->insert([
            'nome' => 'admin'
        ]);
       
        DB::table('tb_usuario')->insert([
            'nome' => 'admin',
            'email' => 'admin@gmail.com',
            'telefone' => '(55) 99999-9999',
            'cpf' => '999.999.999-99',
            'password' => Hash::make('admin123'),
            'tipo_usuario' => 'Administrador',
            'setor_id' => 1,
        ]);
    }
}
