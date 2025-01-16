<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\datosgenerales_PM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DatosgeneralesPMController extends Controller
{
    /**
     * Despliega la lista de los datos generales de los pescadores morales.
     */
    public function index()
    {
        try {
            $datosgeneralesPM = datosgenerales_PM::all();
            $result = $datosgeneralesPM->map(function ($item){
                return [
                    'id' => $item->id,
                    'razon_social' => $item->razon_social,
                    'RFC' => $item->RFC,
                    'CURP' => $item->CURP,
                    'telefono' => $item->telefono,
                    'domicilio' => $item->domicilio,
                    'region_id' => $item->regiones->id,
                    'distrito_id' => $item->distritos->id,
                    'municipio_id' => $item->municipios->id,
                    'localidad_id' => $item->localidades->id,
                    'zona_pesca' => $item->zona_pesca,
                    'cuota_captura' => $item->cuota_captura,
                    'cant_artpesca' => $item->cant_artpesca,
                    'etnia_id' => $item->etnias->id,
                    'acta_constitutiva' => $item->acta_constitutiva,
                    'socios' => $item->socios,
                    'cuenta_permiso' => $item->cuenta_permiso ? '1' : '0',
                    'motivo_no_cuenta' => $item->motivo_no_cuenta,
                    'cuentaemb_ma' => $item->cuentaemb_ma ? '1' : '0',
                    'motivono_cuenta_embma' => $item->motivono_cuenta_embma,
                    'cant_emb_ma' => $item->cant_emb_ma,
                    'cant_motor_ma' => $item->cant_motor_ma,
                    'tipos_motores_ma' => $item->tipos_motores_ma,
                    'cuentaemb_me' => $item->cuentaemb_me ? '1' : '0',
                    'motivono_cuenta_embme' => $item->motivono_cuenta_embme,
                    'cant_emb_me' => $item->cant_emb_me,
                    'cant_motor_me' => $item->cant_motor_me,
                    'tipos_motores_me' => $item->tipos_motores_me,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los datos generales de los pescadores morales', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los datos generales de los pescadores morales: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Registra los datos generales de un pescador moral.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'razon_social' => 'required|string|max:250',
                'RFC' => 'required|string|max:12',
                'CURP' => 'required|string|max:18',
                'telefono' => 'required|string|max:10',
                'domicilio' => 'required|string|max:40',
                'region_id' => 'required|exists:regiones,id',
                'distrito_id' => 'required|exists:distritos,id',
                'municipio_id' => 'required|exists:municipios,id',
                'localidad_id' => 'required|exists:localidades,id',
                'zona_pesca' => 'required|string|max:30',
                'cuota_captura' => 'required|string|max:200',
                'cant_artpesca' => 'required|integer',
                'etnia_id' => 'required|exists:etnias,id',
                'acta_constitutiva' => 'required|string|max:255',
                'socios' => 'required|integer',
                'cuenta_permiso' => 'required|boolean',
                'motivo_no_cuenta' => 'required|string|max:255',
                'cuentaemb_ma' => 'required|boolean',
                'motivono_cuenta_embma' => 'nullable|string|max:255',
                'cant_emb_ma' => 'nullable|integer',
                'cant_motor_ma' => 'nullable|integer',
                'tipos_motores_ma' => 'nullable|string|max:50',
                'cuentaemb_me' => 'required|boolean',
                'motivono_cuenta_embme' => 'nullable|string|max:255',
                'cant_emb_me' => 'nullable|integer',
                'cant_motor_me' => 'nullable|integer',
                'tipos_motores_me' => 'nullable|string|max:100',
            ]);

            $existeDatosGeneralesPM = datosgenerales_PM::where('razon_social', $data['razon_social'])
                ->orwhere('RFC', $data['RFC'])
                ->orwhere('CURP', $data['CURP'])
                ->first();
            if ($existeDatosGeneralesPM) {
                $errors = [];
                if ($existeDatosGeneralesPM->razon_social == $data['razon_social']) {
                    $errors['razon_social'] = 'El nombre ya esta registrado';
                }
                if ($existeDatosGeneralesPM->RFC == $data['RFC']) {
                    $errors['RFC'] = 'El RFC ya esta registrado';
                }
                if ($existeDatosGeneralesPM->CURP == $data['CURP']) {
                    $errors['CURP'] = 'La Curp ya esta registrada';
                }
                return ApiResponse::error('Los datos del pescador moral ya estan registrados', 422, $errors);
            }

            $datosgeneralesPM = datosgenerales_PM::create($data);
            return ApiResponse::success('Los datos fueron registrados exitosamente', 201, $datosgeneralesPM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los datos generales del pescador moral: ', 500);
        }
    }

    /**
     * Muestra los datos generales de un pescador moral.
     */
    public function show($id)
    {
        try {
            $datosgeneralesPM = datosgenerales_PM::findOrFail($id);
            $result = [
                'id' => $datosgeneralesPM->id,
                    'razon_social' => $datosgeneralesPM->razon_social,
                    'RFC' => $datosgeneralesPM->RFC,
                    'CURP' => $datosgeneralesPM->CURP,
                    'telefono' => $datosgeneralesPM->telefono,
                    'domicilio' => $datosgeneralesPM->domicilio,
                    'region_id' => $datosgeneralesPM->regiones->id,
                    'distrito_id' => $datosgeneralesPM->distritos->id,
                    'municipio_id' => $datosgeneralesPM->municipios->id,
                    'localidad_id' => $datosgeneralesPM->localidades->id,
                    'zona_pesca' => $datosgeneralesPM->zona_pesca,
                    'cuota_captura' => $datosgeneralesPM->cuota_captura,
                    'cant_artpesca' => $datosgeneralesPM->cant_artpesca,
                    'etnia_id' => $datosgeneralesPM->etnias->id,
                    'acta_constitutiva' => $datosgeneralesPM->acta_constitutiva,
                    'socios' => $datosgeneralesPM->socios,
                    'cuenta_permiso' => $datosgeneralesPM->cuenta_permiso ? '1' : '0',
                    'motivo_no_cuenta' => $datosgeneralesPM->motivo_no_cuenta,
                    'cuentaemb_ma' => $datosgeneralesPM->cuentaemb_ma ? '1' : '0',
                    'motivono_cuenta_embma' => $datosgeneralesPM->motivono_cuenta_embma,
                    'cant_emb_ma' => $datosgeneralesPM->cant_emb_ma,
                    'cant_motor_ma' => $datosgeneralesPM->cant_motor_ma,
                    'tipos_motores_ma' => $datosgeneralesPM->tipos_motores_ma,
                    'cuentaemb_me' => $datosgeneralesPM->cuentaemb_me ? '1' : '0',
                    'motivono_cuenta_embme' => $datosgeneralesPM->motivono_cuenta_embme,
                    'cant_emb_me' => $datosgeneralesPM->cant_emb_me,
                    'cant_motor_me' => $datosgeneralesPM->cant_motor_me,
                    'tipos_motores_me' => $datosgeneralesPM->tipos_motores_me,
                    'created_at' => $datosgeneralesPM->created_at,
                    'updated_at' => $datosgeneralesPM->updated_at,
            ];
            return ApiResponse::success('Datos generales obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos generales del pescador moral: ', 500);
        }
    }

    /**
     * Actualiza los datos generales de un pescador moral.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'razon_social' => 'required|string|max:250',
                'RFC' => 'required|string|max:12',
                'CURP' => 'required|string|max:18',
                'telefono' => 'required|string|max:10',
                'domicilio' => 'required|string|max:40',
                'region_id' => 'required',
                'distrito_id' => 'required',
                'municipio_id' => 'required',
                'localidad_id' => 'required',
                'zona_pesca' => 'required|string|max:30',
                'cuota_captura' => 'required|string|max:200',
                'cant_artpesca' => 'required|integer',
                'etnia_id' => 'required',
                'acta_constitutiva' => 'required|string|max:255',
                'socios' => 'required|integer',
                'cuenta_permiso' => 'required|boolean',
                'motivo_no_cuenta' => 'required|string|max:255',
                'cuentaemb_ma' => 'required|boolean',
                'motivono_cuenta_embma' => 'nullable|string|max:255',
                'cant_emb_ma' => 'nullable|integer',
                'cant_motor_ma' => 'nullable|integer',
                'tipos_motores_ma' => 'nullable|string|max:50',
                'cuentaemb_me' => 'required|boolean',
                'motivono_cuenta_embme' => 'nullable|string|max:255',
                'cant_emb_me' => 'nullable|integer',
                'cant_motor_me' => 'nullable|integer',
                'tipos_motores_me' => 'nullable|string|max:100',
            ]);

            $existeDatosGeneralesPM = datosgenerales_PM::where('id', '!=', $id)
            ->where(function ($query) use ($data){
               $query->where('razon_social', $data['razon_social'])
               ->orwhere(function ($query) use ($data){
                   $query->where('RFC', $data['RFC'])
                   ->orwhere('CURP', $data['CURP']);
               });
            })
            ->first();

            if ($existeDatosGeneralesPM) {
                $errors = [];
                if ($existeDatosGeneralesPM->nombres === $data['razon_social']) {
                    $errors['razon_social'] = 'El nombre ya está registrado';
                }
                if ($existeDatosGeneralesPM->RFC === $data['RFC']) {
                    $errors['RFC'] = 'El RFC ya está registrado';
                }
                if ($existeDatosGeneralesPM->CURP === $data['CURP']) {
                    $errors['CURP'] = 'La CURP ya está registrada';
                }
                return ApiResponse::error('Estos datos ya estan registrados', 422, $errors);
            }

            $datosgeneralesPM = datosgenerales_PM::findOrFail($id);
            $datosgeneralesPM->update($data);
            return ApiResponse::success('Los datos generales se han actualizado exitosamente', 200);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar los datos generales: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina los datos generales de un pescador moral.
     */
    public function destroy($id)
    {
        try {
            $datosgeneralesPM = datosgenerales_PM::findOrFail($id);
            $datosgeneralesPM->delete();
            return ApiResponse::success('Datos generales del pescador moral eliminados exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los datos generales del pescador moral', 500);
        }
    }
}
