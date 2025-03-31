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
                    'userprofile_id' => $item->perfil_usuario->name,
                    'area_total' => $item->area_total,
                    'area_total_actacu' => $item->area_total_actacu,
                    'uso_arearestante' => $item->uso_arearestante,
                    'modelo_extensivo' => $item->modelo_extensivo ? '1' : '0',
                    'modelo_intensivo' => $item->modelo_intensivo ? '1' : '0',
                    'modelo_semintensivo' => $item->modelo_semintensivo ? '1' : '0',
                    'modelo_otro' => $item->modelo_otro,
                    'especies_acuicolas' => $item->especies_acuicolas,
                    'pozo_profundo' => $item->pozo_profundo ? '1' : '0',
                    'presa' => $item->presa ? '1' : '0',
                    'laguna' => $item->laguna ? '1' : '0',
                    'mar' => $item->mar ? '1' : '0',
                    'pozo_cieloabierto' => $item->pozo_cieloabierto ? '1' : '0',
                    'rio_cuenca' => $item->rio_cuenca ? '1' : '0',
                    'arroyo_manantial' => $item->arroyo_manantial ? '1' : '0',
                    'otro' => $item->otro ? '1' : '0',
                    'especificar_otro' => $item->especificar_otro,
                    'forma_alimentacion' => $item->forma_alimentacion === 'Bombeo' ? 'Bombeo' : 'Pozo',
                    'aliment_agua_caudad' => $item->aliment_agua_caudad,
                    'desc_equip_acuicola' => $item->desc_equip_acuicola,
                    'tipo_asistenciatec' => $item->tipo_asistenciatec === 'Asesor pagado' ? 'Asesor pagado' : 'Otorgado por institucion',
                    'organismo_laboratorio' => $item->organismo_laboratorio ? '1' : '0',
                    'hormonados_genetica' => $item->hormonados_genetica ? '1' : '0',
                    'medicam_quimicos' => $item->medicam_quimicos ? '1' : '0',
                    'aliment_balanceados' => $item->aliment_balanceados ? '1' : '0',
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
                'userprofile_id' => 'required|exists:users,id',
                'area_total' => 'required|numeric',
                'area_total_actacu' => 'required|numeric',
                'uso_arearestante' => 'required|numeric',
                'modelo_extensivo' => 'required|boolean',
                'modelo_intensivo' => 'required|boolean',
                'modelo_semintensivo' => 'required|boolean',
                'modelo_otro' => 'string|max:50|nullable',
                'especies_acuicolas' => 'required|string|max:40',
                'pozo_profundo' => 'required|boolean',
                'presa' => 'required|boolean',
                'laguna' => 'required|boolean',
                'mar' => 'required|boolean',
                'pozo_cieloabierto' => 'required|boolean',
                'rio_cuenca' => 'required|boolean',
                'arroyo_manantial' => 'required|boolean',
                'otro' => 'nullable|string|max:40',
                'especificar_otro' => 'string|max:50|nullable',
                'forma_alimentacion' => 'required|in:Bombeo,Pozo',
                'aliment_agua_caudad' => 'required|numeric|max:9999999999.99',
                'desc_equip_acuicola' => 'required|string|max:200',
                'tipo_asistenciatec' => 'required|in:Asesor pagado,Otorgado por institucion',
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
                'userprofile_id' => $registroDatTecProdAM->perfil_usuario->id,
                'area_total' => $registroDatTecProdAM->area_total,
                'area_total_actacu' => $registroDatTecProdAM->area_total_actacu,
                'uso_arearestante' => $registroDatTecProdAM->uso_arearestante,
                'modelo_extensivo' => $registroDatTecProdAM->modelo_extensivo ? '1' : '0',
                'modelo_intensivo' => $registroDatTecProdAM->modelo_intensivo ? '1' : '0',
                'modelo_semintensivo' => $registroDatTecProdAM->modelo_semintensivo ? '1' : '0',
                'modelo_otro' => $registroDatTecProdAM->modelo_otro,
                'especies_acuicolas' => $registroDatTecProdAM->especies_acuicolas,
                'pozo_profundo' => $registroDatTecProdAM->pozo_profundo ? '1' : '0',
                'presa' => $registroDatTecProdAM->presa ? '1' : '0',
                'laguna' => $registroDatTecProdAM->laguna ? '1' : '0',
                'mar' => $registroDatTecProdAM->mar ? '1' : '0',
                'pozo_cieloabierto' => $registroDatTecProdAM->pozo_cieloabierto ? '1' : '0',
                'rio_cuenca' => $registroDatTecProdAM->rio_cuenca ? '1' : '0',
                'arroyo_manantial' => $registroDatTecProdAM->arroyo_manantial ? '1' : '0',
                'otro' => $registroDatTecProdAM->otro ? '1' : '0',
                'especificar_otro' => $registroDatTecProdAM->especificar_otro,
                'forma_alimentacion' => $registroDatTecProdAM->forma_alimentacion === 'Bombeo' ? 'Bombeo' : 'Pozo',
                'aliment_agua_caudad' => $registroDatTecProdAM->aliment_agua_caudad,
                'desc_equip_acuicola' => $registroDatTecProdAM->desc_equip_acuicola,
                'tipo_asistenciatec' => $registroDatTecProdAM->tipo_asistenciatec === 'Asesor pagado' ? 'Asesor pagado' : 'Otorgado por institucion',
                'organismo_laboratorio' => $registroDatTecProdAM->organismo_laboratorio ? '1' : '0',
                'hormonados_genetica' => $registroDatTecProdAM->hormonados_genetica ? '1' : '0',
                'medicam_quimicos' => $registroDatTecProdAM->medicam_quimicos ? '1' : '0',
                'aliment_balanceados' => $registroDatTecProdAM->aliment_balanceados ? '1' : '0',
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
                'userprofile_id' => 'required',
                'area_total' => 'required|numeric',
                'area_total_actacu' => 'required|numeric',
                'uso_arearestante' => 'required|numeric',
                'modelo_extensivo' => 'required|boolean',
                'modelo_intensivo' => 'required|boolean',
                'modelo_semintensivo' => 'required|boolean',
                'modelo_otro' => 'string|max:50|nullable',
                'especies_acuicolas' => 'required|string|max:40',
                'pozo_profundo' => 'required|boolean',
                'presa' => 'required|boolean',
                'laguna' => 'required|boolean',
                'mar' => 'required|boolean',
                'pozo_cieloabierto' => 'required|boolean',
                'rio_cuenca' => 'required|boolean',
                'arroyo_manantial' => 'required|boolean',
                'otro' => 'required|string|max:40|nullable',
                'especificar_otro' => 'string|max:50|nullable',
                'forma_alimentacion' => 'required|in:Bombeo,Pozo',
                'aliment_agua_caudad' => 'required|numeric|max:9999999999.99',
                'desc_equip_acuicola' => 'required|string|max:200',
                'tipo_asistenciatec' => 'required|in:Asesor pagado,Otorgado por institucion',
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
