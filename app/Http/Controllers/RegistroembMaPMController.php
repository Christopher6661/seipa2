<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registroemb_ma_PM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroembMaPMController extends Controller
{
    /**
     * Despliega la lista de embarcaciones mayores del pescador moral.
     */
    public function index()
    {
        try {
            $embMayorPM = registroemb_ma_PM::all();
            $result = $embMayorPM->map(function ($item){
                return [
                    'id' => $item->id,
                    'nombre_emb_ma' => $item->nombre_emb_ma,
                    'captura_rnpa' => $item->captura_rnpa,
                    'matricula' => $item->matricula,
                    'puerto_base' => $item->puerto_base,
                    'año_construccion' => $item->año_construccion,
                    'tipo_cubierta_id' => $item->tipo_cubierta->id,
                    'material_casco_id' => $item->material_casco->id,
                    'tipo_actividad_pesca' => $item->tipo_actividad_pesca,
                    'cantidad_patrones' => $item->cantidad_patrones,
                    'cantidad_motoristas' => $item->cantidad_motoristas,
                    'cantidad_pescadores' => $item->cantidad_pescadores,
                    'cantidad_pesc_espe' => $item->cantidad_pesc_espe,
                    'cantidad_tripulacion' => $item->cantidad_tripulacion,
                    'costo_avituallamiento' => $item->costo_avituallamiento,
                    'medida_eslora_mts' => $item->medida_eslora_mts,
                    'medida_manga_mts' => $item->medida_manga_mts,
                    'medida_puntal_mts' => $item->medida_puntal_mts,
                    'medida_calado_mts' => $item->medida_calado_mts,
                    'medida_arquneto_mts' => $item->medida_arquneto_mts,
                    'capacidadbodega_mts' => $item->capacidadbodega_mts,
                    'capacidad_carga_ton' => $item->capacidad_carga_ton,
                    'capacidad_tanque_lts' => $item->capacidad_tanque_lts,
                    'certificado_seg_mar' => $item->certificado_seg_mar,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de las embarcaciones mayores del pescador moral', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de embarcaciones mayores' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea una embarcación mayor del pescador moral.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_emb_ma' => 'required|string|max:30',
                'captura_rnpa' => 'required|string|max:30',
                'matricula' => 'required|string|max:20',
                'puerto_base' => 'required|string|max:30',
                'año_construccion' => 'required|string|max:30',
                'tipo_cubierta_id' => 'required|exists:tipo_cubierta,id',
                'material_casco_id' => 'required|exists:material_casco,id',
                'tipo_actividad_pesca' => 'required|string|max:20',
                'cantidad_patrones' => 'required|integer',
                'cantidad_motoristas' => 'required|integer',
                'cant_pescadores' => 'required|integer',
                'cantidad_pesc_espe' => 'required|integer',
                'cantidad_tripulacion' => 'required|integer',
                'costo_avituallamiento' => 'required|float',
                'medida_eslora_mts' => 'required|float',
                'medida_manga_mts' => 'required|float',
                'medida_puntal_mts' => 'required|float',
                'medida_calado_mts' => 'required|float',
                'medida_arquneto_mts' => 'required|float',
                'capacidadbodega_mts' => 'required|float',
                'capacidad_carga_ton' => 'required|float',
                'capacidad_tanque_lts' => 'required|float',
                'certificado_seg_mar' => 'required|string|max:100'
            ]);


            $existeNombre = registroemb_ma_PM::where('nombre_emb_ma', $data['nombre_emb_ma'])->first();
            if ($existeNombre) {
                return ApiResponse::error('Este nombre ya esta registrado', 422);
            }
            $existeMatricula = registroemb_ma_PM::where('matricula', $data['matricula'])->first();
            if ($existeMatricula) {
                return ApiResponse::error('Esta matricula ya esta registrada', 422);
            }
            $existeMatricula = registroemb_ma_PM::where('captura_rnpa', $data['captura_rnpa'])->first();
            if ($existeMatricula) {
                return ApiResponse::error('Esta captura de RNPA ya esta registrada', 422);
            }

            $embMayorPM = registroemb_ma_PM::create($data);
            return ApiResponse::success('Embarcación mayor creada exitosamente', 201, $embMayorPM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la embarcación mayor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de una embarcación mayor del pescador moral.
     */
    public function show($id)
    {
        try {
            $embMayorPM = registroemb_ma_PM::findOrFail($id);
            $result = [
                    'id' => $embMayorPM->id,
                    'nombre_emb_ma' => $embMayorPM->nombre_emb_ma,
                    'captura_rnpa' => $embMayorPM->captura_rnpa,
                    'matricula' => $embMayorPM->matricula,
                    'puerto_base' => $embMayorPM->puerto_base,
                    'año_construccion' => $embMayorPM->año_construccion,
                    'tipo_cubierta_id' => $embMayorPM->tipo_cubierta->id,
                    'material_casco_id' => $embMayorPM->material_casco->id,
                    'tipo_actividad_pesca' => $embMayorPM->tipo_actividad_pesca,
                    'cantidad_patrones' => $embMayorPM->cantidad_patrones,
                    'cantidad_motoristas' => $embMayorPM->cantidad_motoristas,
                    'cantidad_pescadores' => $embMayorPM->cantidad_pescadores,
                    'cantidad_pesc_espe' => $embMayorPM->cantidad_pesc_espe,
                    'cantidad_tripulacion' => $embMayorPM->cantidad_tripulacion,
                    'costo_avituallamiento' => $embMayorPM->costo_avituallamiento,
                    'medida_eslora_mts' => $embMayorPM->medida_eslora_mts,
                    'medida_manga_mts' => $embMayorPM->medida_manga_mts,
                    'medida_puntal_mts' => $embMayorPM->medida_puntal_mts,
                    'medida_calado_mts' => $embMayorPM->medida_calado_mts,
                    'medida_arquneto_mts' => $embMayorPM->medida_arquneto_mts,
                    'capacidadbodega_mts' => $embMayorPM->capacidadbodega_mts,
                    'capacidad_carga_ton' => $embMayorPM->capacidad_carga_ton,
                    'capacidad_tanque_lts' => $embMayorPM->capacidad_tanque_lts,
                    'certificado_seg_mar' => $embMayorPM->certificado_seg_mar,
                    'created_at' => $embMayorPM->created_at,
                    'updated_at' => $embMayorPM->updated_at,
            ];
            return ApiResponse::success('Embarcación mayor obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación mayor no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la embarcación mayor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza una embarcación mayor del pescador moral.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre_emb_ma' => 'required|string|max:30',
                'captura_rnpa' => 'required|string|max:30',
                'matricula' => 'required|string|max:20',
                'puerto_base' => 'required|string|max:30',
                'año_construccion' => 'required|string|max:30',
                'tipo_cubierta_id' => 'required',
                'material_casco_id' => 'required',
                'tipo_actividad_pesca' => 'required|string|max:20',
                'cantidad_patrones' => 'required|integer',
                'cantidad_motoristas' => 'required|integer',
                'cant_pescadores' => 'required|integer',
                'cantidad_pesc_espe' => 'required|integer',
                'cantidad_tripulacion' => 'required|integer',
                'costo_avituallamiento' => 'required|float',
                'medida_eslora_mts' => 'required|float',
                'medida_manga_mts' => 'required|float',
                'medida_puntal_mts' => 'required|float',
                'medida_calado_mts' => 'required|float',
                'medida_arquneto_mts' => 'required|float',
                'capacidadbodega_mts' => 'required|float',
                'capacidad_carga_ton' => 'required|float',
                'capacidad_tanque_lts' => 'required|float',
                'certificado_seg_mar' => 'required|string|max:100'
            ]);

            /*$existeEmbMayorPM = registroemb_ma_PM::where('nombre_emb_ma', $request->nombre_emb_ma)
            ->orwhere('matricula', $request->matricula)
            ->orwhere('captura_rnpa', $request->captura_rnpa)
            ->first();
            if ($existeEmbMayorPM) {
                return ApiResponse::error('Esta embarcación mayor ya existe', 422);
            }*/

            $existeEmbMayorPM = registroemb_ma_PM::where(function($query) use ($request) {
                $query->where('nombre_emb_ma', $request->nombre_emb_ma)
                ->orWhere('matricula', $request->matricula)
                ->orWhere('captura_rnpa', $request->captura_rnpa);
            })
            ->where('id', '!=', $id) 
            ->first();

            if ($existeEmbMayorPM) {
                return ApiResponse::error('Este embarcación mayor ya existe', 422);
            }

            $embMayorPM = registroemb_ma_PM::findOrFail($id);
            $embMayorPM->update($request->all());
            return ApiResponse::success('Embarcación mayor actualizada exitosamente', 200, $embMayorPM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación mayor no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la embarcación mayor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina una embarcación mayor del pescador moral.
     */
    public function destroy($id)
    {
        try {
            $embMayorPM = registroemb_ma_PM::findOrFail($id);
            $embMayorPM->delete();
            return ApiResponse::success('Embarcación mayor eliminado exitosamente', 200, $embMayorPM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación mayor no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la embarcación mayor: ' .$e->getMessage(), 500);
        }
    }
}
