<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;

/**
 * Rota da página principal (https://cw-test-alessandro-marvao.herokuapp.com/)
 * 
 * @return: void
 */
Route::get('', function () {
    return view('default');
});

/**
 * Rota de acesso a todos os elementos do RSS. O retorno é um arquivo em formato JSON.
 * 
 * @return: void
 */
Route::get('/rss', 'RSSController@index');

/**
 * Rota de acesso aos elementos do RSS, de acordo com a pesquisa por categoria. O retorno é um arquivo em formato JSON.
 * 
 * @return: void
 */
Route::get('/tag/{tag}', 'RSSController@show');
