<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

//GESTÃO DE ARQUIVOS
Route::get('/arquivos', 'Archive\ArchiveController@index')->name('archives');
Route::post('/arquivos/novo', 'Archive\ArchiveController@create');
Route::get('/arquivos/all', 'Archive\ArchiveController@getFiles');
Route::delete('/arquivos/delete/{id}', 'Archive\ArchiveController@delete');
Route::get('/arquivos/download/{id}', 'Archive\ArchiveController@downloadFile');

//Extensões de arquivos permitidas
Route::post('/arquivos/extensao/create', 'Archive\ArchiveExtensionController@create');
Route::get('/arquivos/extensao/all', 'Archive\ArchiveExtensionController@getExtensions');
Route::delete('/arquivos/extensao/delete/{id}', 'Archive\ArchiveExtensionController@delete');


//GESTÃO DE HELP DESK
Route::get('/atendimento', 'HelpDesk\HelpDeskController@index')->name('helpdesks');
Route::get('/atendimento/novo', 'HelpDesk\HelpDeskController@new');
Route::post('/atendimento/novo/create', 'HelpDesk\HelpDeskController@create');
Route::post('/atendimento/novo/upload', 'HelpDesk\HelpDeskController@uploadFiles');
Route::post('/atendimento/novo/imagem/upload', 'HelpDesk\HelpDeskController@uploadImage');
Route::get('/atendimento/{id}', 'HelpDesk\HelpDeskController@view');
Route::post('/atendimento/prioridade', 'HelpDesk\HelpDeskController@changePriority');
Route::post('/atendimento/status', 'HelpDesk\HelpDeskController@changeStatus');
Route::get('/atendimento/download/{id}', 'HelpDesk\HelpDeskController@downloadFile');
Route::post('/atendimento/resposta/imagem/upload', 'HelpDesk\HelpDeskResponseController@uploadImage');
Route::post('/atendimento/resposta/upload', 'HelpDesk\HelpDeskResponseController@uploadFiles');
Route::post('/atendimento/resposta/create', 'HelpDesk\HelpDeskResponseController@create');
Route::get('/atendimento/respostas/{id}', 'HelpDesk\HelpDeskResponseController@getResponses');


//GESTÃO DE CATEGORIAS
Route::get('/categorias', function() {
    return view('categories');
})->middleware('auth')->name('categories');

//Categorias de Atendimento
Route::post('/categorias/helpdesk/create', 'HelpDesk\HelpDeskCategorieController@create');
Route::get('/categorias/helpdesk/all', 'HelpDesk\HelpDeskCategorieController@getCategories');
Route::delete('/categorias/helpdesk/delete/{id}', 'HelpDesk\HelpDeskCategorieController@delete');
Route::put('/categorias/helpdesk/update', 'HelpDesk\HelpDeskCategorieController@update');

//Categorias de Equipamento
Route::post('/categorias/equipamento/create', 'Equipment\EquipmentCategorieController@create');
Route::get('/categorias/equipamento/all', 'Equipment\EquipmentCategorieController@getCategories');
Route::delete('/categorias/equipamento/delete/{id}', 'Equipment\EquipmentCategorieController@delete');
Route::put('/categorias/equipamento/update', 'Equipment\EquipmentCategorieController@update');

//Categorias de arquivo
Route::post('/categorias/arquivo/create', 'Archive\ArchiveCategorieController@create');
Route::get('/categorias/arquivo/all', 'Archive\ArchiveCategorieController@getCategories');
Route::delete('/categorias/arquivo/delete/{id}', 'Archive\ArchiveCategorieController@delete');
Route::put('/categorias/arquivo/update', 'Archive\ArchiveCategorieController@update');

//Categorias de artigo
Route::post('/categorias/artigo/create', 'Article\ArticleCategorieController@create');
Route::get('/categorias/artigo/all', 'Article\ArticleCategorieController@getCategories');
Route::delete('/categorias/artigo/delete/{id}', 'Article\ArticleCategorieController@delete');
Route::put('/categorias/artigo/update', 'Article\ArticleCategorieController@update');

//GESTÃO DE SETORES
Route::get('/setores', 'Sector\SectorController@index')->name('sectors');
Route::get('/setores/all', 'Sector\SectorController@getSectors');
Route::post('/setores/create', 'Sector\SectorController@create');
Route::delete('/setores/delete/{id}', 'Sector\SectorController@delete');
Route::put('/setores/update', 'Sector\SectorController@update');

//GESTÃO DE EQUIPAMENTOS
Route::get('/equipamentos', 'Equipment\EquipmentController@index')->name('equipments');
Route::get('/equipamentos/all', 'Equipment\EquipmentController@getEquipments');
Route::post('/equipamentos/create', 'Equipment\EquipmentController@create');
Route::delete('/equipamentos/delete/{id}', 'Equipment\EquipmentController@delete');
Route::put('/equipamentos/update', 'Equipment\EquipmentController@update');

//GESTÃO DE COMPUTADORES
Route::get('/computadores', 'Computer\ComputerController@index')->name('computers');
Route::get('/computadores/novo', 'Computer\ComputerController@new');
Route::post('/computadores/novo/create', 'Computer\ComputerController@create');
Route::get('/computadores/all', 'Computer\ComputerController@getComputers');
Route::delete('/computadores/delete/{id}', 'Computer\ComputerController@delete');
Route::get('/computadores/atualizar/{id}', 'Computer\ComputerController@change');
Route::put('/computadores/atualizar/update', 'Computer\ComputerController@update');

//Sistemas operacionais
Route::post('/computadores/so/create', 'Computer\OperationalSystemController@create');
Route::get('/computadores/so/all', 'Computer\OperationalSystemController@getSOs');
Route::delete('/computadores/so/delete/{id}', 'Computer\OperationalSystemController@delete');
Route::put('/computadores/so/update', 'Computer\OperationalSystemController@update');

//GESTÃO DE SENHAS
Route::get('/senhas', 'Password\PasswordController@index')->name('passwords');
Route::post('/senhas/create', 'Password\PasswordController@create');
Route::get('/senhas/all', 'Password\PasswordController@getPasswords');
Route::delete('/senhas/delete/{id}', 'Password\PasswordController@delete');
Route::put('/senhas/update', 'Password\PasswordController@update');

//ROTAS DE AUTENTICAÇÃO
Auth::routes();