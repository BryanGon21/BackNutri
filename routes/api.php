<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('token', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('api.login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('users/change-password', [App\Http\Controllers\Api\AuthController::class, 'updatePassword']);
    Route::get('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::apiResources([
    ]);
});

// Route::apiResources([
//     'users' => App\Http\Controllers\UserController::class,
// ]);

Route::get('users/roles', [App\Http\Controllers\UserController::class, 'roles']);
Route::get('users/medicos', [App\Http\Controllers\UserController::class, 'medicos']);
Route::post('users/register', [App\Http\Controllers\UserController::class, 'register']);
Route::get('consultas/pacientes/{id}', [App\Http\Controllers\ConsultaController::class, 'consultas']);
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('users/habilitar/{id}', [App\Http\Controllers\UserController::class, 'habilitar']);
    Route::get('citas/medico', [App\Http\Controllers\CitaController::class, 'medico']);
    Route::post('citas/encurso', [App\Http\Controllers\CitaController::class, 'encurso']);
    Route::post('citas/terminar', [App\Http\Controllers\CitaController::class, 'terminar']);
    Route::get('pacientes/pdf/{id}', [App\Http\Controllers\PdfController::class, 'verPerfil']);

    Route::get('unidades/habilitar/{id}', [App\Http\Controllers\UnidadController::class, 'habilitar']);
    Route::get('unidades/habilitados', [App\Http\Controllers\UnidadController::class, 'habilitados']);
    
    Route::get('infoalimentos/habilitar/{id}', [App\Http\Controllers\InfoAlimentoController::class, 'habilitar']);
    Route::get('infoalimentos/habilitados', [App\Http\Controllers\InfoAlimentoController::class, 'habilitados']);
    
    Route::get('tipocomidas/habilitar/{id}', [App\Http\Controllers\TipoComidaController::class, 'habilitar']);
    Route::get('tipocomidas/habilitados', [App\Http\Controllers\TipoComidaController::class, 'habilitados']);
    
    Route::get('mediciones/paciente/{id}', [App\Http\Controllers\InfoMedicaController::class, 'verProgreso']);

    Route::apiResources([
        'users' => App\Http\Controllers\UserController::class,
        'pacientes' => App\Http\Controllers\PacienteController::class,
        'citas' => App\Http\Controllers\CitaController::class,
        'consultas' => App\Http\Controllers\ConsultaController::class,
        'mediciones' => App\Http\Controllers\InfoMedicaController::class,
        'resultados' => App\Http\Controllers\ResultadoController::class,
        'unidades' => App\Http\Controllers\UnidadController::class,
        'infoalimentos' => App\Http\Controllers\InfoAlimentoController::class,
        'plandietas' => App\Http\Controllers\PlanDietaController::class,
        'comidas' => App\Http\Controllers\ComidaController::class,
        'recetas' => App\Http\Controllers\RecetaController::class,
        'tipocomidas' => App\Http\Controllers\TipoComidaController::class,
    ]);
});

// Route::get('pacientes_informacion', [App\Http\Controllers\PacienteController::class, 'mostrarInfo']);

Route::post('/excel', [App\Http\Controllers\ExcelController::class, 'import'])->name('import.excel');

// Route::get('mostrarReporte', [App\Http\Controllers\PdfController::class, 'generateReport']);