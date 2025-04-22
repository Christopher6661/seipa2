<?php

use App\Http\Controllers\ArtePescaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DatosgeneralesAFController;
use App\Http\Controllers\DatosgeneralesAMController;
use App\Http\Controllers\DatosgeneralesPFController;
use App\Http\Controllers\DatosgeneralesPMController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\EqOpMaManejoPfController;
use App\Http\Controllers\EqOpMaManejoPmController;
use App\Http\Controllers\EqOpMaRadComPfController;
use App\Http\Controllers\EqOpMaRadComPmController;
use App\Http\Controllers\EqOpMaSegPfController;
use App\Http\Controllers\EqOpMaSegPmController;
use App\Http\Controllers\EqOpMaSisConPfController;
use App\Http\Controllers\EqOpMaSisConPmController;
use App\Http\Controllers\EqOpMeManejoPfController;
use App\Http\Controllers\EqOpMeManejoPmController;
use App\Http\Controllers\EqOpMeRadComPfController;
use App\Http\Controllers\EqOpMeRadComPmController;
use App\Http\Controllers\EqOpMeSegPfController;
use App\Http\Controllers\EqOpMeSegPmController;
use App\Http\Controllers\EqOpMeSisConPfController;
use App\Http\Controllers\EqOpMeSisConPmController;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\EtniaController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\MaterialCascoController;
use App\Http\Controllers\MotorMayorPFController;
use App\Http\Controllers\MotorMayorPMController;
use App\Http\Controllers\MotorMenorPFController;
use App\Http\Controllers\MotorMenorPMController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RegistroAdminprodAFController;
use App\Http\Controllers\RegistroAdminprodAMController;
use App\Http\Controllers\RegistroArtepescaPFController;
use App\Http\Controllers\RegistroArtepescaPMController;
use App\Http\Controllers\RegistroDattececonAFController;
use App\Http\Controllers\RegistroDattececonAMController;
use App\Http\Controllers\RegistroDattecprodAFController;
use App\Http\Controllers\RegistroDattecprodAMController;
use App\Http\Controllers\RegistroembMaPFController;
use App\Http\Controllers\RegistroembMaPMController;
use App\Http\Controllers\RegistroembMePFController;
use App\Http\Controllers\RegistroembMePMController;
use App\Http\Controllers\RegistroPermisoPFController;
use App\Http\Controllers\RegistroPermisoPMController;
use App\Http\Controllers\RegistroPersonalController;
use App\Http\Controllers\RegistroTipoinfraestAFController;
use App\Http\Controllers\RegistroTipoinfraestAMController;
use App\Http\Controllers\RegistroUbifisicaAFController;
use App\Http\Controllers\RegistroUbifisicaAMController;
use App\Http\Controllers\ReporteacuiCsopcsController;
use App\Http\Controllers\ReportepescaArriboController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\SocioPmController;
use App\Http\Controllers\TipoCubiertaController;
use App\Http\Controllers\TipoEqManejoController;
use App\Http\Controllers\TipoEqRadComController;
use App\Http\Controllers\TipoEqSegController;
use App\Http\Controllers\TipoPermisoController;
use App\Http\Controllers\TipoSisConController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Rutas protegidas según el rol del usuario
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'userProfile']);
    Route::put('/user/{id}', [AuthController::class, 'update'])->middleware('role:admin');
    Route::delete('/user/{id}', [AuthController::class, 'destroy'])->middleware('role:admin');
    
    //
    Route::apiResource('reportepesca_arribo', ReportepescaArriboController::class);
    Route::apiResource('reporteacui_csopcs', ReporteacuiCsopcsController::class);
});

Route::middleware(['auth:api', 'role:personal,admin'])->group(function () {
    Route::get('/usuarios', [AuthController::class, 'index']);
});

//ruta de las tablas
Route::apiResource('roles', RolController::class);
Route::apiResource('oficinas', OficinaController::class);
Route::apiResource('registro_personal', RegistroPersonalController::class);
Route::apiResource('regiones', RegionController::class);
Route::apiResource('distritos', DistritoController::class);
Route::apiResource('municipios', MunicipioController::class);
Route::apiResource('localidades', LocalidadController::class);
Route::apiResource('etnias', EtniaController::class);
Route::apiResource('tipo_permisos', TipoPermisoController::class);
Route::apiResource('tipo_cubierta', TipoCubiertaController::class);
Route::apiResource('material_casco', MaterialCascoController::class);
Route::apiResource('arte_pesca', ArtePescaController::class);
Route::apiResource('tipo_sistconservacion', TipoSisConController::class);
Route::apiResource('tipo_equipo_radcom', TipoEqRadComController::class);
Route::apiResource('tipo_equipo_seg', TipoEqSegController::class);
Route::apiResource('tipo_equipo_manejo', TipoEqManejoController::class);
Route::apiResource('especies', EspecieController::class);
Route::apiResource('datos_generales_pf', DatosgeneralesPFController::class);
Route::apiResource('registro_permisos_pf', RegistroPermisoPFController::class);
Route::apiResource('registroemb_me_pf', RegistroembMePFController::class);
Route::apiResource('registroemb_ma_pf', RegistroembMaPFController::class);
Route::apiResource('motormenor_pf', MotorMenorPFController::class);
Route::apiResource('motormayor_pf', MotorMayorPFController::class);
Route::apiResource('registro_artepesca_pf', RegistroArtepescaPFController::class);
Route::apiResource('eqop_me_siscon_pf', EqOpMeSisConPfController::class);
Route::apiResource('eqop_me_eqradcom_pf', EqOpMeRadComPfController::class);
Route::apiResource('eqop_me_eqseg_pf', EqOpMeSegPfController::class);
Route::apiResource('eqop_me_eqmanejo_pf', EqOpMeManejoPfController::class);
Route::apiResource('eqop_ma_siscon_pf', EqOpMaSisConPfController::class);
Route::apiResource('eqop_ma_eqradcom_pf', EqOpMaRadComPfController::class);
Route::apiResource('eqop_ma_eqseg_pf', EqOpMaSegPfController::class);
Route::apiResource('eqop_ma_eqmanejo_pf', EqOpMaManejoPfController::class);
Route::apiResource('datos_generales_pm', DatosgeneralesPMController::class);
Route::apiResource('registro_permisos_pm', RegistroPermisoPMController::class);
Route::apiResource('registroemb_me_pm', RegistroembMePMController::class);
Route::apiResource('registroemb_ma_pm', RegistroembMaPMController::class);
Route::apiResource('motormenor_pm', MotorMenorPMController::class);
Route::apiResource('motormayor_pm', MotorMayorPMController::class);
Route::apiResource('registro_artepesca_pm', RegistroArtepescaPMController::class);
Route::apiResource('eqop_me_siscon_pm', EqOpMeSisConPmController::class);
Route::apiResource('eqop_me_eqradcom_pm', EqOpMeRadComPmController::class);
Route::apiResource('eqop_me_eqseg_pm', EqOpMeSegPmController::class);
Route::apiResource('eqop_me_eqmanejo_pm', EqOpMeManejoPmController::class);
Route::apiResource('eqop_ma_siscon_pm', EqOpMaSisConPmController::class);
Route::apiResource('eqop_ma_eqradcom_pm', EqOpMaRadComPmController::class);
Route::apiResource('eqop_ma_eqseg_pm', EqOpMaSegPmController::class);
Route::apiResource('eqop_ma_eqmanejo_pm', EqOpMaManejoPmController::class);
Route::apiResource('datos_generales_af', DatosgeneralesAFController::class);
Route::apiResource('registro_ubfisica_af', RegistroUbifisicaAFController::class);
Route::apiResource('registro_adminprod_af', RegistroAdminprodAFController::class);
Route::apiResource('registro_dattecprod_af', RegistroDattecprodAFController::class);
Route::apiResource('registro_tipoinfraest_af', RegistroTipoinfraestAFController::class);
Route::apiResource('registro_dattececon_af', RegistroDattececonAFController::class);
Route::apiResource('datos_generales_am', DatosgeneralesAMController::class);
Route::apiResource('socios', SocioController::class);
Route::apiResource('registro_ubfisica_am', RegistroUbifisicaAMController::class);
Route::apiResource('registro_adminprod_am', RegistroAdminprodAMController::class);
Route::apiResource('registro_dattecprod_am', RegistroDattecprodAMController::class);
Route::apiResource('registro_tipoinfraest_am', RegistroTipoinfraestAMController::class);
Route::apiResource('registro_dattececon_am', RegistroDattececonAMController::class);
Route::apiResource('socios_pm', SocioPmController::class);
