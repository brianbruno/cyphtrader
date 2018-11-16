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


Route::name('plataforma.')->group(function () {
    Route::get('/', function () {
        return view('platform.index');
    })->name('dashboard')->middleware('auth');;
});
Route::prefix('niquelino')->group(function () {

    Route::prefix('charts')->group(function () {


        Route::get('/getLucroPorDia', function(){
            $niquelinoController = app()->make('\App\Http\Controllers\Niquelino\NiquelinoController');
            return $niquelinoController ->getLucroPorDia();
        })->middleware('auth')->name('niquelino.charts.lucropordia');

        Route::get('/getLucroHoje', function(){
            $niquelinoController = app()->make('\App\Http\Controllers\Niquelino\NiquelinoController');
            return $niquelinoController ->getLucroHoje();
        })->middleware('auth')->name('niquelino.charts.lucrohoje');

        Route::get('/getLucroHojeMini', function(){
            $niquelinoController = app()->make('\App\Http\Controllers\Niquelino\NiquelinoController');
            return $niquelinoController ->getLucroHojeMini();
        })->middleware('auth')->name('niquelino.charts.lucrohojemini');

    });

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
