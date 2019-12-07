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
        
        DB::table('tb_permissao')->insert(['nome' => 'manage-permissions', 'descricao' => 'Gerenciar permissões', 'grupo' => 'Usuários']);
        DB::table('tb_permissao')->insert(['nome' => 'set-user-permissions', 'descricao' => 'Permissões de usuários', 'grupo' => 'Usuários']);
        DB::table('tb_permissao')->insert(['nome' => 'list-users', 'descricao' => 'Listar', 'grupo' => 'Usuários']);
        DB::table('tb_permissao')->insert(['nome' => 'create-user', 'descricao' => 'Cadastrar', 'grupo' => 'Usuários']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-user', 'descricao' => 'Editar', 'grupo' => 'Usuários']);
        DB::table('tb_permissao')->insert(['nome' => 'disable-user', 'descricao' => 'Desabilitar', 'grupo' => 'Usuários']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-sectors', 'descricao' => 'Gerenciar', 'grupo' => 'Setores']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-helpdesk', 'descricao' => 'Gerenciar de atendimento', 'grupo' => 'Categorias']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-file', 'descricao' => 'Gerenciar de arquivo', 'grupo' => 'Categorias']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-equipment', 'descricao' => 'Gerenciar de equipamento', 'grupo' => 'Categorias']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-categorie-article', 'descricao' => 'Gerenciar de artigo', 'grupo' => 'Categorias']);
        DB::table('tb_permissao')->insert(['nome' => 'list-passwords', 'descricao' => 'Listar', 'grupo' => 'Senhas']);
        DB::table('tb_permissao')->insert(['nome' => 'view-password', 'descricao' => 'Visualizar', 'grupo' => 'Senhas']);
        DB::table('tb_permissao')->insert(['nome' => 'create-password', 'descricao' => 'Cadastrar', 'grupo' => 'Senhas']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-password', 'descricao' => 'Editar', 'grupo' => 'Senhas']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-password', 'descricao' => 'Deletar', 'grupo' => 'Senhas']);
        DB::table('tb_permissao')->insert(['nome' => 'list-equipments', 'descricao' => 'Listar', 'grupo' => 'Equipamentos']);
        DB::table('tb_permissao')->insert(['nome' => 'view-equipment', 'descricao' => 'Visualizar', 'grupo' => 'Equipamentos']);
        DB::table('tb_permissao')->insert(['nome' => 'create-equipment', 'descricao' => 'Cadastrar', 'grupo' => 'Equipamentos']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-equipment', 'descricao' => 'Editar', 'grupo' => 'Equipamentos']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-equipment', 'descricao' => 'Deletar', 'grupo' => 'Equipamentos']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-file-extensions', 'descricao' => 'Gerenciar extensões', 'grupo' => 'Arquivos']);
        DB::table('tb_permissao')->insert(['nome' => 'list-files', 'descricao' => 'Listar', 'grupo' => 'Arquivos']);
        DB::table('tb_permissao')->insert(['nome' => 'upload-files', 'descricao' => 'Upload', 'grupo' => 'Arquivos']);
        DB::table('tb_permissao')->insert(['nome' => 'download-files', 'descricao' => 'Download', 'grupo' => 'Arquivos']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-file', 'descricao' => 'Deletar', 'grupo' => 'Arquivos']);
        DB::table('tb_permissao')->insert(['nome' => 'list-computers', 'descricao' => 'Listar', 'grupo' => 'Computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'view-computer', 'descricao' => 'Visualizar', 'grupo' => 'Computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'manage-operational-systems', 'descricao' => 'Sistemas operacionais', 'grupo' => 'Computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'create-computer', 'descricao' => 'Cadastrar', 'grupo' => 'Computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-computer', 'descricao' => 'Editar', 'grupo' => 'Computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-computer', 'descricao' => 'Deletar', 'grupo' => 'Computadores']);
        DB::table('tb_permissao')->insert(['nome' => 'create-article', 'descricao' => 'Cadastrar', 'grupo' => 'Artigos']);
        DB::table('tb_permissao')->insert(['nome' => 'edit-article', 'descricao' => 'Editar', 'grupo' => 'Artigos']);
        DB::table('tb_permissao')->insert(['nome' => 'delete-article', 'descricao' => 'Deletar', 'grupo' => 'Artigos']);
    }
}
