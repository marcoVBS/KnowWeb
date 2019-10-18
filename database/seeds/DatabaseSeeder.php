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
        
        DB::table('tb_permissao')->insert(['nome' => 'manage-permissions', 'descricao' => 'Gerenciar permissões']);
        DB::table('tb_permissao')->insert(['nome' => 'set-user-permissions', 'descricao' => 'Setar permissões de usuário']);
        DB::table('tb_permissao')->insert(['nome' => 'list-users', 'descricao' => 'Listar usuários']);
        DB::table('tb_permissao')->insert(['nome' => 'create-user', 'descricao' => 'Criar usuários']);
        DB::table('tb_permissao')->insert(['nome' => 'disable-user', 'descricao' => 'Desabilitar usuários']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-user', 'descricao' => 'Editar usuários']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-sectors', 'descricao' => 'Gerenciar setores']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-helpdesk', 'descricao' => 'Gerenciar categorias de atendimento']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-file', 'descricao' => 'Gerenciar categoria de arquivo']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-equipment', 'descricao' => 'Gerenciar categorias de equipamento']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-article', 'descricao' => 'Gerenciar categorias de artigo']);
        DB::table('tb_permissao')->insert(['nome' => 'list-passwords', 'descricao' => 'Listar senhas']);
        DB::table('tb_permissao')->insert(['nome' => 'view-password', 'descricao' => 'Visualizar senhas']);
        DB::table('tb_permissao')->insert(['nome' => 'create-password', 'descricao' => 'Criar senhas']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-password', 'descricao' => 'Editar senhas']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-password', 'descricao' => 'Deletar senhas']);
        DB::table('tb_permissao')->insert(['nome' => 'list-equipments', 'descricao' => 'Listar equipamentos']);
        DB::table('tb_permissao')->insert(['nome' => 'view-equipment', 'descricao' => 'Visualizar equipamentos']);
        DB::table('tb_permissao')->insert(['nome' => 'create-equipment', 'descricao' => 'Criar equipamentos']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-equipment', 'descricao' => 'Editar equipamentos']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-equipment', 'descricao' => 'Deletar equipamentos']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-file-extensions', 'descricao' => 'Gerenciar extensões de arquivo']);
        DB::table('tb_permissao')->insert(['nome' => 'list-files', 'descricao' => 'Listar arquivos']);
        DB::table('tb_permissao')->insert(['nome' => 'upload-files', 'descricao' => 'Upload de arquivos']);
        DB::table('tb_permissao')->insert(['nome' => 'download-files', 'descricao' => 'Download de arquivos']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-file', 'descricao' => 'Deletar arquivos']);
        DB::table('tb_permissao')->insert(['nome' => 'list-computers', 'descricao' => 'Listar computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'view-computer', 'descricao' => 'Visualizar computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-operational-systems', 'descricao' => 'Gerenciar sistemas operacionais']);
        DB::table('tb_permissao')->insert(['nome' => 'create-computer', 'descricao' => 'Criar computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-computer', 'descricao' => 'Editar computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-computer', 'descricao' => 'Deletar computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'create-article', 'descricao' => 'Criar artigos']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-article', 'descricao' => 'Editar artigos']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-article', 'descricao' => 'Deletar artigos']);
    }
}
