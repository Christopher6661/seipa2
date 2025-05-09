<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registroemb_ma_PF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroembMaPFController extends Controller
{
    /**
     * Despliega la lista de embarcaciones mayores del pescador fisico.
     */
    public function index()
    {
        try {
            $embMayorPF = registroemb_ma_PF::all();
            $result = $embMayorPF->map(function ($item){
                return [
                    'id' => $item->id,
                    'userprofile_id' => $item->perfil_usuario->name,
                    'nombre_emb_ma' => $item->nombre_emb_ma,
                    'captura_rnpa' => $item->captura_rnpa,
                    'matricula' => $item->matricula,
                    'puerto_base' => $item->puerto_base,
                    'año_construccion' => $item->año_construccion,
                    'tipo_cubierta_id' => $item->tipocubierta->nombre_cubierta,
                    'material_casco_id' => $item->materialcasco->material,
                    'tipo_actividad_pesca' => $item->tipo_actividad_pesca,
                    'cantidad_patrones' => $item->cantidad_patrones,
                    'cantidad_motoristas' => $item->cantidad_motoristas,
                    'cant_pescadores' => $item->cant_pescadores,
                    'cantpesc_especializados' => $item->cantpesc_especializados,
                    'cant_tripulacion' => $item->cant_tripulacion,
                    'costo_avituallamiento' => $item->costo_avituallamiento,
                    'medida_eslora' => $item->medida_eslora,
                    'medida_manga' => $item->medida_manga,
                    'medida_puntal' => $item->medida_puntal,
                    'medida_decalado' => $item->medida_decalado,
                    'medida_arqueo_neto' => $item->medida_arqueo_neto,
                    'capacidad_bodega' => $item->capacidad_bodega,
                    'capacidad_carga' => $item->capacidad_carga,
                    'capacidad_tanque' => $item->capacidad_tanque,
                    'certificado_seguridad' => $item->certificado_seguridad,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de las embarcaciones mayores del pescador fisico', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de embarcaciones mayores' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea una embarcación mayor.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required|exists:users,id',
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
                'cantpesc_especializados' => 'required|integer',
                'cant_tripulacion' => 'required|integer',
                'costo_avituallamiento' => 'required|numeric',
                'medida_eslora' => 'required|numeric',
                'medida_manga' => 'required|numeric',
                'medida_puntal' => 'required|numeric',
                'medida_decalado' => 'required|numeric',
                'medida_arqueo_neto' => 'required|numeric',
                'capacidad_bodega' => 'required|numeric',
                'capacidad_carga' => 'required|numeric',
                'capacidad_tanque' => 'required|numeric',
                'certificado_seguridad' => 'required|string|max:100'
            ]);

            $existeNombre = registroemb_ma_PF::where('nombre_emb_ma', $data['nombre_emb_ma'])->first();
            if ($existeNombre) {
                return ApiResponse::error('Este nombre ya esta registrado', 422);
            }
            $existeMatricula = registroemb_ma_PF::where('matricula', $data['matricula'])->first();
            if ($existeMatricula) {
                return ApiResponse::error('Esta matricula ya esta registrada', 422);
            }
            $existeMatricula = registroemb_ma_PF::where('captura_rnpa', $data['captura_rnpa'])->first();
            if ($existeMatricula) {
                return ApiResponse::error('Esta captura de RNPA ya esta registrada', 422);
            }

            $embMayorPF = registroemb_ma_PF::create($data);
            return ApiResponse::success('Embarcación mayor creada exitosamente', 201, $embMayorPF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la embarcación mayor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de una embarcación mayor.
     */
    public function show($id)
    {
        try {
            $embMayorPF = registroemb_ma_PF::findOrFail($id);
            $result = [
                'id' => $embMayorPF->id,
                'userprofile_id' => $embMayorPF->perfil_usuario->id,
                'nombre_emb_ma' => $embMayorPF->nombre_emb_ma,
                'captura_rnpa' => $embMayorPF->captura_rnpa,
                'matricula' => $embMayorPF->matricula,
                'puerto_base' => $embMayorPF->puerto_base,
                'año_construccion' => $embMayorPF->año_construccion,
                'tipo_cubierta_id' => $embMayorPF->tipocubierta->id,
                'material_casco_id' => $embMayorPF->materialcasco->id,
                'tipo_actividad_pesca' => $embMayorPF->tipo_actividad_pesca,
                'cantidad_patrones' => $embMayorPF->cantidad_patrones,
                'cantidad_motoristas' => $embMayorPF->cantidad_motoristas,
                'cant_pescadores' => $embMayorPF->cant_pescadores,
                'cantpesc_especializados' => $embMayorPF->cantpesc_especializados,
                'cant_tripulacion' => $embMayorPF->cant_tripulacion,
                'costo_avituallamiento' => $embMayorPF->costo_avituallamiento,
                'medida_eslora' => $embMayorPF->medida_eslora,
                'medida_manga' => $embMayorPF->medida_manga,
                'medida_puntal' => $embMayorPF->medida_puntal,
                'medida_decalado' => $embMayorPF->medida_decalado,
                'medida_arqueo_neto' => $embMayorPF->medida_arqueo_neto,
                'capacidad_bodega' => $embMayorPF->capacidad_bodega,
                'capacidad_carga' => $embMayorPF->capacidad_carga,
                'capacidad_tanque' => $embMayorPF->capacidad_tanque,
                'certificado_seguridad' => $embMayorPF->certificado_seguridad,
                'created_at' => $embMayorPF->created_at,
                'updated_at' => $embMayorPF->updated_at,
            ];
            return ApiResponse::success('Embarcación mayor obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación mayor no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la embarcación mayor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza una embarcación mayor.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'userprofile_id' => 'required',
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
                'cantpesc_especializados' => 'required|integer',
                'cant_tripulacion' => 'required|integer',
                'costo_avituallamiento' => 'required|numeric',
                'medida_eslora' => 'required|numeric',
                'medida_manga' => 'required|numeric',
                'medida_puntal' => 'required|numeric',
                'medida_decalado' => 'required|numeric',
                'medida_arqueo_neto' => 'required|numeric',
                'capacidad_bodega' => 'required|numeric',
                'capacidad_carga' => 'required|numeric',
                'capacidad_tanque' => 'required|numeric',
                'certificado_seguridad' => 'required|string|max:100'
            ]);

            /*$existeEmbMayorPF = registroemb_ma_PF::where('nombre_emb_ma', $request->nombre_emb_ma)
            ->orwhere('matricula', $request->matricula)
            ->orwhere('captura_rnpa', $request->captura_rnpa)
            ->first();
            if ($existeEmbMayorPF) {
                return ApiResponse::error('Esta embarcación mayor ya existe', 422);
            }*/

            $nombreEmbMaExists = registroemb_ma_PF::where('nombre_emb_ma', $request->nombre_emb_ma)
            ->where('id', '!=', $id)->first();
            if ($nombreEmbMaExists) {
                return ApiResponse::error('EL nombre ya esta en uso', 422);
            }
        
            $matriculaExists = registroemb_ma_PF::where('matricula', $request->matricula)
            ->where('id', '!=', $id)->first();
            if ($matriculaExists) {
                return ApiResponse::error('La matricula ya esta en uso', 422);
            }
        
            $capturaRnpaExists = registroemb_ma_PF::where('captura_rnpa', $request->captura_rnpa)
            ->where('id', '!=', $id)->first();
            if ($capturaRnpaExists) {
                return ApiResponse::error('El RNPA  ya esta en uso', 422);
            }
        
            $embMayorPF = registroemb_ma_PF::findOrFail($id);
            $embMayorPF->update($request->all());
            return ApiResponse::success('Embarcación mayor actualizada exitosamente', 200, $embMayorPF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación mayor no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la embarcación mayor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina una embarcación mayor.
     */
    public function destroy($id)
    {
        try {
            $embMayorPF = registroemb_ma_PF::findOrFail($id);
            $embMayorPF->delete();
            return ApiResponse::success('Embarcación mayor eliminado exitosamente', 200, $embMayorPF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación mayor no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la embarcación mayor: ' .$e->getMessage(), 500);
        }
    }
}
