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

/*GAME*/

	//CARTONES
	Route::post('/GenerateNumbers', 'CartonController@GenerateNumbers')->name('GenerateNumbers');	
	Route::post('/searchCarton', 'CartonController@searchCarton')->name('searchCarton');
	Route::post('/GenerarCartones', 'CartonController@GenerarCartones')->name('GenerarCartones');
	Route::get('/GenerarSerie/{id?}', 'CartonController@GenerarSerie')->name('GenerarSerie');
	Route::post('/GenerateSeries', 'CartonController@GenerateSeries')->name('GenerateSeries');

	//SORTEOS
	Route::get('/SimulateGame', 'SorteoController@SimulateGame')->name('SimulateGame');
	Route::get('/ViewCartones/{id?}', 'SorteoController@ViewCartones')->name('ViewCartones');
	Route::get('/ViewSeries/{id?}', 'SorteoController@ViewSeries')->name('ViewSeries');
	Route::post('/PlayGame', 'SorteoController@PlayGame')->name('PlayGame');
	Route::get('/checkLinea/{id?}', 'SorteoController@checkLinea')->name('checkLinea');
	Route::get('/checkCarton/{id?}', 'SorteoController@checkCarton')->name('checkCarton');
	Route::post('/NumerosJugado', 'SorteoController@NumerosJugado')->name('NumerosJugado');
	Route::post('/searchSorteo', 'SorteoController@searchSorteo')->name('searchSorteo');

	//ADMIN - SORTEOS

	Route::group(['prefix' => 'admin/'], function () {
        Route::get('sorteolist', 'SorteoController@sorteolist')->name('sorteolist.index');
        Route::get('sorteoedit/{id?}', 'SorteoController@sorteoedit')->name('sorteoedit.edit');
        Route::get('sorteodelete/{id?}', 'SorteoController@sorteodelete')->name('sorteodelete.delete');
    });

/*END GAME*/


Route::get('/GenerarCarton', 'CartonController@GenerarCarton')->name('GenerarCarton');
Route::get('/bingo', 'CartonController@bingo')->name('bingo');
