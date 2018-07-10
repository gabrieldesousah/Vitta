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


Route::get('/triagem', function () {
    return view('triagem');
});


/**************************************************
BI
**************************************************/
Route::get('/bi', 'BiController@index');
Route::get('/dados', 'BiController@index');

Route::get('/triagem/filtro', 'BiController@triagem');
Route::get('/triagem/{today?}/{unidade?}/{servico?}', 'BiController@triagem');


Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::get('/airtable', 'AirtableController@index');

Route::get('/produtos', 'ProdutosController@index');
Route::get('/produto/{id}', 'ProdutosController@show');
Route::get('/trocar/{id}', 'ProdutosController@trocar');

Route::get('/vittalecas/oquesao', 'VittalecasController@oquesao');
Route::get('/vittalecas/regulamento', 'VittalecasController@regulamento');

Route::get('/equipe/{detalhes?}', 'UsersController@index');
Route::get('/equipe/{id}', 'UsersController@show');


Route::get('/email/send', 'EmailController@ship');
Route::get('/email/mass', 'EmailController@mass');



Route::get('orcamento', 'OrcamentoController@create');
Route::post('orcamento', 'OrcamentoController@store');

Route::get('/exames', 'ExamesController@create');
Route::post('/exames', 'ExamesController@store');
Route::get('/exame/{id}', 'ExamesController@edit');
Route::post('/exame/{id}', 'ExamesController@update');
Route::get('/exame/{exame}/destroy', 'ExamesController@destroy');


//Users
Route::get('/users', 'UsersController@index');
Route::get('/user/{id}', 'UsersController@show');
Route::get('/users/search', 'UsersController@search');
Route::get('/editprofile/{user?}', 'UsersController@edit');
Route::get('/editpass/{user?}', 'UsersController@editpass');
Route::post('/updateprofile/{user?}', 'UsersController@updateProfile');
Route::post('/updatepass/{user?}', 'UsersController@updatePass');

Route::prefix('dadosdiarios')->group( function(){
    Route::get('/backoffice', 'DadosDiariosController@backoffice');
    Route::get('/recepcao', 'DadosDiariosController@recepcao');
    Route::get('/enfermagem', 'DadosDiariosController@enfermagem');
    Route::get('/laboratorio', 'DadosDiariosController@laboratorio');
    Route::get('/callcenter', 'DadosDiariosController@callcenter');
});

Route::prefix('gentegestao')->group( function(){
    Route::get('/colaboradores', 'GenteGestaoController@colaboradores');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**************************************************
Pacientes
**************************************************/
Route::get('/listapacientes', 'PacientesController@lista');

Route::get('/pacientes', 'PacientesController@create');
Route::get('/pacientes/{paciente}', 'PacientesController@show_paciente');
Route::post('/pacientes/{paciente}/edit', 'PacientesController@update');
Route::get('/pacientes/create', 'PacientesController@create');
Route::post('/pacientes/store', 'PacientesController@store');

Route::group(['prefix' => 'resultados'], function(){
    Route::get('/', 'PacientesController@index');
    Route::post('/auth', 'PacientesController@auth');
    Route::get('/file/{ped}', 'PacientesController@show_file');
    Route::get('/get/{paciente}', 'PacientesController@show');
});

Route::prefix('buscarresultados')->group( function(){
	Route::get('/', 'ResultadosController@index');
	Route::get('hermespardini/auth', 'ResultadosController@HermesPardiniAuth');
	Route::get('hermespardini/getpatients', 'ResultadosController@getPatients');
	Route::post('hermespardini/getpatients', 'ResultadosController@getPatients');
	Route::get('hermespardini/get', 'ResultadosController@HermesPardiniGet');
	Route::get('hermespardini/get/{name}', 'ResultadosController@HermesPardiniGet');
	Route::get('hermespardini/get/{DATI}/{DATF}', 'ResultadosController@HermesPardiniGet');
});


//Falcão
Route::group(['prefix' => 'falcao'], function(){
    Route::get('abordagens', 'AbordagensController@index');
    Route::post('abordagens/store', 'AbordagensController@store');
    Route::get('abordagens/store', 'AbordagensController@index');
    Route::get('dados', 'AbordagensController@dados');
    Route::get('exportar', 'AbordagensController@exportar');
});

Route::get('/os', 'ordens_servicoController@index');
Route::post('/os', 'ordens_servicoController@index');