<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_dattecprod_AF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroDattecprodAFController extends Controller
{
    /**
     * Despliega la lista de los datos tecnico-productivos del acuicultor fisico.
     */
    public function index()
    {
        try {
            $registroDatTecProdAF = registro_dattecprod_AF::all();
            $result = $registroDatTecProdAF->map(function ($item){
                return [
                    'id' => $item->id,
                    'area_total' => $item->area_total,
                    'area_total_actacu' => $item->area_total_actacu,
                    'uso_arearestante' => $item->uso_arearestante,
                    'modelo_extensivo' => $item->modelo_extensivo,
                    'modelo_intensivo' => $item->modelo_intensivo,
                    'modelo_semintensivo' => $item->modelo_semintensivo,
                    'modelo_otro' => $item->modelo_otro,
                    'especies_acuicolas' => $item->especies_acuicolas,
                    'pozo_profundo' => $item->pozo_profundo,
                    'presa' => $item->presa,
                    'laguna' => $item->laguna,
                    'mar' => $item->mar,
                    'pozo_cieloabierto' => $item->pozo_cieloabierto,
                    'rio_cuenca' => $item->rio_cuenca,
                    'arroyo_manantial' => $item->arroyo_manantial,
                    'otro' => $item->otro,
                    'especificar_otro' => $item->especificar_otro,
                    'forma_alimentacion' => $item->forma_alimentacion,
                    'aliment_agua_caudad' => $item->aliment_agua_caudad,
                    'desc_equip_acuicola' => $item->desc_equip_acuicola,
                    'tipo_asistenciatec' => $item->tipo_asistenciatec,
                    'organismo_laboratorio' => $item->organismo_laboratorio,
                    'hormonados_genetica' => $item->hormonados_genetica,
                    'medicam_quimicos' => $item->medicam_quimicos,
                    'aliment_balanceados' => $item->aliment_balanceados,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los datos tecnico-productivos del acuicultor fisicos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los datos tecnico-productivos del acuicultor fisicos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un registro de los datos tecnico-productivos del acuicultor fisico.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'area_total' => 'required|float',
                'area_total_actacu' => 'required|float',
                'uso_arearestante' => 'required|float',
                'modelo_extensivo' => 'required|boolean',
                'modelo_intensivo' => 'required|boolean',
                'modelo_semintensivo' => 'required|boolean',
                'modelo_otro' => 'required|boolean',
                'especies_acuicolas' => 'required|string|max:40',
                'pozo_profundo' => 'required|boolean',
                'presa' => 'required|boolean',
                'laguna' => 'required|boolean',
                'mar' => 'required|boolean',
                'pozo_cieloabierto' => 'required|boolean',
                'rio_cuenca' => 'required|boolean',
                'arroyo_manantial' => 'required|boolean',
                'otro' => 'required|boolean',
                'especificar_otro' => 'required|string|max:50',
                'forma_alimentacion' => 'required|string|max:7',
                'aliment_agua_caudad' => 'required|numeric|max:9999999999.99',
                'desc_equip_acuicola' => 'required|string|max:200',
                'tipo_asistenciatec' => 'required|string|max:24',
                'organismo_laboratorio' => 'required|boolean',
                'hormonados_genetica' => 'required|boolean',
                'medicam_quimicos' => 'required|boolean',
                'aliment_balanceados' => 'required|boolean',
            ]);

            $registroDatTecProdAF = registro_dattecprod_AF::create($data);
            return ApiResponse::success('Registro de datos tecnico-productivos creado exitosamente', 201, $registroDatTecProdAF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los datos tecnico-productivos del acuicultor fisico: ', 500);
        }
    }

    /**
     * Muestra los datos un registro tecnico-productivo del acuicultor fisico.
     */
    public function show($id)
    {
        try {
            $registroDatTecProdAF = registro_dattecprod_AF::findOrFail($id);
            $result = [
                'id' => $registroDatTecProdAF->id,
                'area_total' => $registroDatTecProdAF->area_total,
                'area_total_actacu' => $registroDatTecProdAF->area_total_actacu,
                'uso_arearestante' => $registroDatTecProdAF->uso_arearestante,
                'modelo_extensivo' => $registroDatTecProdAF->modelo_extensivo,
                'modelo_intensivo' => $registroDatTecProdAF->modelo_intensivo,
                'modelo_semintensivo' => $registroDatTecProdAF->modelo_semintensivo,
                'modelo_otro' => $registroDatTecProdAF->modelo_otro,
                'especies_acuicolas' => $registroDatTecProdAF->especies_acuicolas,
                'pozo_profundo' => $registroDatTecProdAF->pozo_profundo,
                'presa' => $registroDatTecProdAF->presa,
                'laguna' => $registroDatTecProdAF->laguna,
                'mar' => $registroDatTecProdAF->mar,
                'pozo_cieloabierto' => $registroDatTecProdAF->pozo_cieloabierto,
                'rio_cuenca' => $registroDatTecProdAF->rio_cuenca,
                'arroyo_manantial' => $registroDatTecProdAF->arroyo_manantial,
                'otro' => $registroDatTecProdAF->otro,
                'especificar_otro' => $registroDatTecProdAF->especificar_otro,
                'forma_alimentacion' => $registroDatTecProdAF->forma_alimentacion,
                'aliment_agua_caudad' => $registroDatTecProdAF->aliment_agua_caudad,
                'desc_equip_acuicola' => $registroDatTecProdAF->desc_equip_acuicola,
                'tipo_asistenciatec' => $registroDatTecProdAF->tipo_asistenciatec,
                'organismo_laboratorio' => $registroDatTecProdAF->organismo_laboratorio,
                'hormonados_genetica' => $registroDatTecProdAF->hormonados_genetica,
                'medicam_quimicos' => $registroDatTecProdAF->medicam_quimicos,
                'aliment_balanceados' => $registroDatTecProdAF->aliment_balanceados,
                'created_at' => $registroDatTecProdAF->created_at,
                'updated_at' => $registroDatTecProdAF->updated_at,
            ];
            return ApiResponse::success('Datos tecnico-productivos obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos tecnico-productivos no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos tecnico-productivos: ', 500);
        }
    }

    /**
     * Actualiza un registro de datos tecnico-productivos del acuicultor fisico.
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'area_total' => 'required|float',
                'area_total_actacu' => 'required|float',
                'uso_arearestante' => 'required|float',
                'modelo_extensivo' => 'required|boolean',
                'modelo_intensivo' => 'required|boolean',
                'modelo_semintensivo' => 'required|boolean',
                'modelo_otro' => 'required|boolean',
                'especies_acuicolas' => 'required|string|max:40',
                'pozo_profundo' => 'required|boolean',
                'presa' => 'required|boolean',
                'laguna' => 'required|boolean',
                'mar' => 'required|boolean',
                'pozo_cieloabierto' => 'required|boolean',
                'rio_cuenca' => 'required|boolean',
                'arroyo_manantial' => 'required|boolean',
                'otro' => 'required|boolean',
                'especificar_otro' => 'required|string|max:50',
                'forma_alimentacion' => 'required|string|max:7',
                'aliment_agua_caudad' => 'required|numeric|max:9999999999.99',
                'desc_equip_acuicola' => 'required|string|max:200',
                'tipo_asistenciatec' => 'required|string|max:24',
                'organismo_laboratorio' => 'required|boolean',
                'hormonados_genetica' => 'required|boolean',
                'medicam_quimicos' => 'required|boolean',
                'aliment_balanceados' => 'required|boolean',
            ]);

            $registroDatTecProdAF = registro_dattecprod_AF::findOrFail($id);
            $registroDatTecProdAF->update($data);
            return ApiResponse::success('Datos tecnico-productivos actualizados exitosamente', 200);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos tecnico-productivos no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar los datos tecnico-productivos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un registro de datos tecnico-productivos del acuicultor fisico.
     */
    public function destroy($id)
    {
        try {
            $registroDatTecProdAF = registro_dattecprod_AF::findOrFail($id);
            $registroDatTecProdAF->delete();
            return ApiResponse::success('Datos tecnico-productivos del acuicultor fisico eliminados exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos tecnico-productivos no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los datos tecnico-productivos del acuicultor fisico', 500);
        }
    }
}
