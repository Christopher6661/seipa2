<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMeSegPm;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMeSegPmController extends Controller
{
    /**
     * Despliega la lista de los equipos de operaciones para embarcaciones menores de seguridad.
     */
    public function index()
    {
        try {
            $EqOpMeSegPm = EqOpMeSegPm::all();
            $result = $EqOpMeSegPm->map(function ($item){
                return [
                    'id' => $item->id,
                    'userprofile_id' => $item->perfil_usuario->name,
                    'emb_pertenece_id' => $item->registroemb_me_pm->id,
                    'cuenta_eqseguridad' => $item->cuenta_eqseguridad ? 'Sí' : 'No',
                    'equipo_seguiridad' => $item->equipo_seguiridad,
                    'eqseg_cant' => $item->eqseg_cant,
                    'eqseg_tipo_id' => $item->tipo_equipo_seg->id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de equipos de operaciones para embarcaciones menores de equipos de seguridad', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de equipos de operaciones para embarcaciones menores de equipos de seguridad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un equipo de operaciones para embarcaciones menores de seguridad.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required|exists:users,id',
                'emb_pertenece_id' => 'required|exists:registroemb_me_pm,id',
                'cuenta_eqseguridad' => 'required|boolean',
                'equipo_seguiridad' => 'required|string|max:50',
                'eqseg_cant' => 'required|integer',
                'eqseg_tipo_id' => 'required|exists:tipo_equipo_seg,id',
            ]);
            $existeEqOpMeSegPm = EqOpMeSegPm::where($data)->exists();
            if ($existeEqOpMeSegPm) {
                return ApiResponse::error('El equipo de operaciones para embarcaciones menores de equipos de seguridad ya esta registrado.', 422);
            }

            $EqOpMeSegPm = EqOpMeSegPm::create($data);
            return ApiResponse::success('El equipo de operaciones para embarcaciones menores de equipos de seguridad fue creado exitosamente', 201, $EqOpMeSegPm);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el equipo de operaciones para embarcaciones menores de equipos de seguridad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de un equipo de operaciones para embarcaciones menores de seguridad.
     */
    public function show($id)
    {
        try {
            $EqOpMeSegPm = EqOpMeSegPm::findOrFail($id);
            $result = [
                'id' => $EqOpMeSegPm->id,
                'userprofile_id' => $EqOpMeSegPm->perfil_usuario->id,
                'emb_pertenece_id' => $EqOpMeSegPm->registroemb_me_pm->id,
                'cuenta_eqseguridad' => $EqOpMeSegPm->cuenta_eqseguridad ? 'Sí' : 'No',
                'equipo_seguiridad' => $EqOpMeSegPm->equipo_seguiridad,
                'eqseg_cant' => $EqOpMeSegPm->eqseg_cant,
                'eqseg_tipo_id' => $EqOpMeSegPm->tipo_equipo_seg->id,
                'created_at' => $EqOpMeSegPm->created_at,
                'updated_at' => $EqOpMeSegPm->updated_at,
            ];
            return ApiResponse::success('Equipo de operaciones para embarcaciones menores de equipos de seguridad obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones para embarcaciones menores de equipos de seguridad no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de operaciones para embarcaciones menores de equipos de seguridad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un equipo de operaciones para embarcaciones menores de seguridad.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required',
                'emb_pertenece_id' => 'required',
                'cuenta_eqseguridad' => 'required|boolean',
                'equipo_seguiridad' => 'required|string|max:50',
                'eqseg_cant' => 'required|integer',
                'eqseg_tipo_id' => 'required',
            ]);

            $existeEqOpMeSegPm = EqOpMeSegPm::where($data)->exists();
            if ($existeEqOpMeSegPm) {
                return ApiResponse::error('El equipo de operaciones para embarcaciones menores de equipos de seguridad ya esta registrado.', 422);
            }

            $EqOpMeSegPm = EqOpMeSegPm::findOrFail($id);
            $EqOpMeSegPm->update($data);
            return ApiResponse::success('El equipo de operaciones para embarcaciones menores de equipos de seguridad se actualizo exitosamente', 200, $EqOpMeSegPm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones para embarcaciones menores de equipos de seguridad no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de operaciones para embarcaciones menores de equipos de seguridad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operaciones para embarcaciones menores de seguridad.
     */
    public function destroy($id)
    {
        try {
            $EqOpMeSegPm = EqOpMeSegPm::findOrFail($id);
            $EqOpMeSegPm->delete();
            return ApiResponse::success('Equipo de operaciones para embarcaciones menores de equipos de seguridad eliminado exitosamente', 200, $EqOpMeSegPm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones para embarcaciones menores de equipos de seguridad no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de operaciones para embarcaciones menores de equipos de seguridad: ' .$e->getMessage(), 500);
        }
    }
}
