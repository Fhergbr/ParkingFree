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

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/','HomeController@index')->name('home');
Route::get('/control','HomeController@control')->name('control');
Route::post('/addPark','HomeController@addPark')->name('addPark');
Route::post('/addVacancy','HomeController@addVacancy')->name('addVacancy');
Route::post('/editPost/{id}','HomeController@edit')->name('editPost');
Route::get('/deletePost/{id}','HomeController@delete')->name('deletePost');
Route::get('/loadOutput/{board}','HomeController@loadOutput')->name('loadOutput');
Route::post('/priceForHour','HomeController@priceForHour')->name('priceForHour');
Route::post('/imprimir','HomeController@imprimir')->name('imprimir');
