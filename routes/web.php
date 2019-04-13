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
    })->name('dashboard')->middleware('auth');

    Route::middleware(['auth'])->group(function () {

        Route::namespace('Administrativo')->group(function () {

            Route::prefix('administrativo')->group(function () {
                Route::get('', 'AdminController@index')->name('administrativo');
                Route::get('adicionar-usuario', 'AdminController@adicionarUsuario')->name('adicionar-usuario');
                Route::post('salvar-usuario', 'AdminController@salvarUsuario')->name('usuario-salvar');
            });
        });

    });


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
