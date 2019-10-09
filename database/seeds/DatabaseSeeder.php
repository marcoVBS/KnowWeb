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
            'status' => 1,
            'setor_id' => 1,
        ]);
        
        DB::table('tb_permissao')->insert(['nome' => 'manage-permissions']);
        DB::table('tb_permissao')->insert(['nome' => 'set-user-permissions']);
        DB::table('tb_permissao')->insert(['nome' => 'list-users']);
        DB::table('tb_permissao')->insert(['nome' => 'create-user']);
        DB::table('tb_permissao')->insert(['nome' => 'disable-user']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-user']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-sectors']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-helpdesk']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-file']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-equipment']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-article']);
        DB::table('tb_permissao')->insert(['nome' => 'list-passwords']);
        DB::table('tb_permissao')->insert(['nome' => 'view-password']);
        DB::table('tb_permissao')->insert(['nome' => 'create-password']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-password']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-password']);
        DB::table('tb_permissao')->insert(['nome' => 'list-equipments']);
        DB::table('tb_permissao')->insert(['nome' => 'view-equipment']);
        DB::table('tb_permissao')->insert(['nome' => 'create-equipment']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-equipment']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-equipment']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-file-extensions']);
        DB::table('tb_permissao')->insert(['nome' => 'list-files']);
        DB::table('tb_permissao')->insert(['nome' => 'upload-files']);
        DB::table('tb_permissao')->insert(['nome' => 'download-files']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-file']);
        DB::table('tb_permissao')->insert(['nome' => 'list-computers']);
        DB::table('tb_permissao')->insert(['nome' => 'view-computer']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-operational-systems']);
        DB::table('tb_permissao')->insert(['nome' => 'create-computer']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-computer']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-computer']);
        DB::table('tb_permissao')->insert(['nome' => 'create-article']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-article']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-article']);
    }
}
