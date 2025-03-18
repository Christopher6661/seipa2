<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMaSisConPm;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMaSisConPmController extends Controller
{
    /**
     * Despliega la lista de los equipos de operacion mayores de sistema de conservación del pescador moral.
     */
    public function index()
    {
        try {
            $EqOpMaSisConPm = EqOpMaSisConPm::all();
            $result = $EqOpMaSisConPm->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->EmbarcacionPertenece->nombre_emb_ma,
                    'cuenta_siscon' => $item->cuenta_siscon ? 'Sí' : 'No',
                    'sistema_conserva' => $item->sistema_conserva,
                    'siscon_cant' => $item->siscon_cant,
                    'siscon_tipo_id' => $item->TipoSistemaConservacion->tipo_siscon,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de equipos de operaciones para embarcaciones mayores de sistemas de conservación', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los equipos de operación de embarcaciones mayores de sistemas de conservación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un equipo de operacion mayor de sistema de conservación del pescador moral.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required|exists:registroemb_ma_pm,id',
                'cuenta_siscon' => 'required|boolean',
                'sistema_conserva' => 'required|string|max:50',
                'siscon_cant' => 'required|integer',
                'siscon_tipo_id' => 'required|exists:tipo_sistconservacion,id',
            ]);
            $existeEqOpMaSisConPm = EqOpMaSisConPm::where($data)->exists();
            if ($existeEqOpMaSisConPm) {
                return ApiResponse::error('El equipo de operacion para embarcaciones mayores de sistema de conservación ya esta registrado.', 422);
            }

            $EqOpMaSisConPm = EqOpMaSisConPm::create($data);
            return ApiResponse::success('El equipo de operacion para embarcaciones mayores de sistema de conservación fue creado exitosamente', 201, $EqOpMaSisConPm);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el equipo de operacion para embarcaciones mayores de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de un equipo de operacion mayor de sistema de conservación del pescador moral.
     */
    public function show($id)
    {
        try {
            $EqOpMaSisConPm = EqOpMaSisConPm::findOrFail($id);
            $result = [
                'id' => $EqOpMaSisConPm->id,
                'emb_pertenece_id' => $EqOpMaSisConPm->registroemb_ma_pm->id,
                'cuenta_siscon' => $EqOpMaSisConPm->cuenta_siscon ? 'Sí' : 'No',
                'sistema_conserva' => $EqOpMaSisConPm->sistema_conserva,
                'siscon_cant' => $EqOpMaSisConPm->siscon_cant,
                'siscon_tipo_id' => $EqOpMaSisConPm->tipo_sistconservacion->id,
                'created_at' => $EqOpMaSisConPm->created_at,
                'updated_at' => $EqOpMaSisConPm->updated_at,
            ];
            return ApiResponse::success('Equipo de operacion para embarcaciones mayores de sistema de conservación obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operacion para embarcaciones mayores de sistema de conservación no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de operacion para embarcaciones mayores de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un equipo de operacion mayor de sistema de conservación del pescador moral.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required',
                'cuenta_siscon' => 'required|boolean',
                'sistema_conserva' => 'required|string|max:50',
                'siscon_cant' => 'required|integer',
                'siscon_tipo_id' => 'required',
            ]);

            $existeEqOpMaSisConPm = EqOpMaSisConPm::where($data)->exists();
            if ($existeEqOpMaSisConPm) {
                return ApiResponse::error('El equipo de operacion para embarcaciones mayores de sistema de conservación ya esta registrado.', 422);
            }

            $EqOpMaSisConPm = EqOpMaSisConPm::findOrFail($id);
            $EqOpMaSisConPm->update($data);
            return ApiResponse::success('El equipo de operacion para embarcaciones mayores de sistema de conservación se actualizo exitosamente', 200, $EqOpMaSisConPm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operacion para embarcaciones mayores de sistema de conservación no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de operacion para embarcaciones mayores de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operacion mayor de sistema de conservación del pescador moral.
     */
    public function destroy($id)
    {
        try {
            $EqOpMaSisConPm = EqOpMaSisConPm::findOrFail($id);
            $EqOpMaSisConPm->delete();
            return ApiResponse::success('Equipo de operacion para embarcaciones mayores de sistema de conservación eliminado exitosamente', 200, $EqOpMaSisConPm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operacion para embarcaciones mayores de sistema de conservación no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de operacion para embarcaciones mayores de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }
}
