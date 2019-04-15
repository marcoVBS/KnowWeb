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

Route::get('/atendimento', 'HelpDesk\HelpDeskController@index')->name('helpdesk');


//Categorias
Route::get('/categorias', function() {
    return view('categories');
})->middleware('auth')->name('categories');

//Categorias de Atendimento
Route::post('/categorias/helpdesk/create', 'HelpDesk\HelpDeskCategorieController@create');
Route::get('/categorias/helpdesk/all', 'HelpDesk\HelpDeskCategorieController@getCategories');
Route::delete('/categorias/helpdesk/delete/{id}', 'HelpDesk\HelpDeskCategorieController@delete');
Route::put('/categorias/helpdesk/update/', 'HelpDesk\HelpDeskCategorieController@update');

Auth::routes();