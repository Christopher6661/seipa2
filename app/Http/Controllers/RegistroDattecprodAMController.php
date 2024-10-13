<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_dattecprod_AM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroDattecprodAMController extends Controller
{
    /**
     * Despliega la lista de los datos tecnico-productivos del acuicultor moral.
     */
    public function index()
    {
        try {
            $registroDatTecProdAM = registro_dattecprod_AM::all();
            $result = $registroDatTecProdAM->map(function ($item){
                return [
                    'id' => $item->id,
                    'area_total' => $item->area_total,
                    'area_total_actacu' => $item->area_total_actacu,
                    'uso_arearestante' => $item->uso_arearestante,
                    'modelo_extensivo' => $item->modelo_extensivo ? 'Sí' : 'No',
                    'modelo_intensivo' => $item->modelo_intensivo ? 'Sí' : 'No',
                    'modelo_semintensivo' => $item->modelo_semintensivo ? 'Sí' : 'No',
                    'modelo_otro' => $item->modelo_otro ? 'Sí' : 'No',
                    'especies_acuicolas' => $item->especies_acuicolas,
                    'pozo_profundo' => $item->pozo_profundo ? 'Sí' : 'No',
                    'presa' => $item->presa ? 'Sí' : 'No',
                    'laguna' => $item->laguna ? 'Sí' : 'No',
                    'mar' => $item->mar ? 'Sí' : 'No',
                    'pozo_cieloabierto' => $item->pozo_cieloabierto ? 'Sí' : 'No',
                    'rio_cuenca' => $item->rio_cuenca ? 'Sí' : 'No',
                    'arroyo_manantial' => $item->arroyo_manantial ? 'Sí' : 'No',
                    'otro' => $item->otro ? 'Sí' : 'No',
                    'especificar_otro' => $item->especificar_otro,
                    'forma_alimentacion' => $item->forma_alimentacion,
                    'aliment_agua_caudad' => $item->aliment_agua_caudad,
                    'desc_equip_acuicola' => $item->desc_equip_acuicola,
                    'tipo_asistenciatec' => $item->tipo_asistenciatec,
                    'organismo_laboratorio' => $item->organismo_laboratorio ? 'Sí' : 'No',
                    'hormonados_genetica' => $item->hormonados_genetica ? 'Sí' : 'No',
                    'medicam_quimicos' => $item->medicam_quimicos ? 'Sí' : 'No',
                    'aliment_balanceados' => $item->aliment_balanceados ? 'Sí' : 'No',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los datos tecnico-productivos de los acuicultores morales', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los datos tecnico-productivos de los acuicultores fisicos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un registro de los datos tecnico-productivos del acuicultor moral.
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

            $registroDatTecProdAM = registro_dattecprod_AM::create($data);
            return ApiResponse::success('Registro de datos tecnico-productivos creado exitosamente', 201, $registroDatTecProdAM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los datos tecnico-productivos del acuicultor moral: ', 500);
        }
    }

    /**
     * Muestra los datos un registro tecnico-productivo del acuicultor moral.
     */
    public function show($id)
    {
        try {
            $registroDatTecProdAM = registro_dattecprod_AM::findOrFail($id);
            $result = [
                'id' => $registroDatTecProdAM->id,
                'area_total' => $registroDatTecProdAM->area_total,
                'area_total_actacu' => $registroDatTecProdAM->area_total_actacu,
                'uso_arearestante' => $registroDatTecProdAM->uso_arearestante,
                'modelo_extensivo' => $registroDatTecProdAM->modelo_extensivo ? 'Sí' : 'No',
                'modelo_intensivo' => $registroDatTecProdAM->modelo_intensivo ? 'Sí' : 'No',
                'modelo_semintensivo' => $registroDatTecProdAM->modelo_semintensivo ? 'Sí' : 'No',
                'modelo_otro' => $registroDatTecProdAM->modelo_otro ? 'Sí' : 'No',
                'especies_acuicolas' => $registroDatTecProdAM->especies_acuicolas,
                'pozo_profundo' => $registroDatTecProdAM->pozo_profundo ? 'Sí' : 'No',
                'presa' => $registroDatTecProdAM->presa ? 'Sí' : 'No',
                'laguna' => $registroDatTecProdAM->laguna ? 'Sí' : 'No',
                'mar' => $registroDatTecProdAM->mar ? 'Sí' : 'No',
                'pozo_cieloabierto' => $registroDatTecProdAM->pozo_cieloabierto ? 'Sí' : 'No',
                'rio_cuenca' => $registroDatTecProdAM->rio_cuenca ? 'Sí' : 'No',
                'arroyo_manantial' => $registroDatTecProdAM->arroyo_manantial ? 'Sí' : 'No',
                'otro' => $registroDatTecProdAM->otro ? 'Sí' : 'No',
                'especificar_otro' => $registroDatTecProdAM->especificar_otro,
                'forma_alimentacion' => $registroDatTecProdAM->forma_alimentacion,
                'aliment_agua_caudad' => $registroDatTecProdAM->aliment_agua_caudad,
                'desc_equip_acuicola' => $registroDatTecProdAM->desc_equip_acuicola,
                'tipo_asistenciatec' => $registroDatTecProdAM->tipo_asistenciatec,
                'organismo_laboratorio' => $registroDatTecProdAM->organismo_laboratorio ? 'Sí' : 'No',
                'hormonados_genetica' => $registroDatTecProdAM->hormonados_genetica ? 'Sí' : 'No',
                'medicam_quimicos' => $registroDatTecProdAM->medicam_quimicos ? 'Sí' : 'No',
                'aliment_balanceados' => $registroDatTecProdAM->aliment_balanceados ? 'Sí' : 'No',
                'created_at' => $registroDatTecProdAM->created_at,
                'updated_at' => $registroDatTecProdAM->updated_atM
            ];
            return ApiResponse::success('Datos tecnico-productivos obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos tecnico-productivos no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos tecnico-productivos: ', 500);
        }
    }

    /**
     * Actualiza un registro de datos tecnico-productivos del acuicultor moral.
     */
    public function update(Request $request, $id)
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

            $registroDatTecProdAM = registro_dattecprod_AM::findOrFail($id);
            $registroDatTecProdAM->update($data);
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
     * Elimina un registro de datos tecnico-productivos del acuicultor moral.
     */
    public function destroy($id)
    {
        try {
            $registroDatTecProdAM = registro_dattecprod_AM::findOrFail($id);
            $registroDatTecProdAM->delete();
            return ApiResponse::success('Datos tecnico-productivos del acuicultor moral eliminados exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos tecnico-productivos no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los datos tecnico-productivos del acuicultor moral', 500);
        }
    }
}
