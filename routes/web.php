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


//GESTÃO DE HELP DESK
Route::get('/atendimento', 'HelpDesk\HelpDeskController@index')->name('helpdesk');
Route::post('/atendimento/create', 'HelpDesk\HelpDeskController@create');
Route::post('/atendimento/upload', 'HelpDesk\HelpDeskController@uploadFiles');
Route::post('/atendimento/imagem/upload', 'HelpDesk\HelpDeskController@uploadImage');


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

Auth::routes();