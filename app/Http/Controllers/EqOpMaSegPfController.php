<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMaSegPf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMaSegPfController extends Controller
{
    /**
     * Despliega la lista de los equipos de operaciones para embarcaciones mayores de seguridad.
     */
    public function index()
    {
        try {
            $EqOpMaSegPf = EqOpMaSegPf::all();
            $result = $EqOpMaSegPf->map(function ($item){
                return [
                    'id' => $item->id,
                    'userprofile_id' => $item->perfil_usuario->name,
                    'emb_pertenece_id' => $item->EmbarcacionPertenece->id,
                    'cuenta_eqseguridad' => $item->cuenta_eqseguridad ? 'Sí' : 'No',
                    'equipo_seguiridad' => $item->equipo_seguiridad,
                    'eqseg_cant' => $item->eqseg_cant,
                    'eqseg_tipo_id' => $item->TipoEquipoSeguridad->id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de equipos de operaciones para embarcaciones mayores de equipos de seguridad', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de equipos de operaciones para embarcaciones mayores de equipos de seguridad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un equipo de operaciones para embarcaciones mayores de seguridad.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required|exists:users,id',
                'emb_pertenece_id' => 'required|exists:registroemb_ma_pf,id',
                'cuenta_eqseguridad' => 'required|boolean',
                'equipo_seguiridad' => 'required|string|max:50',
                'eqseg_cant' => 'required|integer',
                'eqseg_tipo_id' => 'required|exists:tipo_equipo_seg,id',
            ]);
            $existeEqOpMaSegPF = EqOpMaSegPf::where($data)->exists();
            if ($existeEqOpMaSegPF) {
                return ApiResponse::error('El equipo de operaciones para embarcaciones mayores de equipos de seguridad ya esta registrado.', 422);
            }

            $EqOpMaSegPf = EqOpMaSegPf::create($data);
            return ApiResponse::success('El equipo de operaciones para embarcaciones mayores de equipos de seguridad fue creado exitosamente', 201, $EqOpMaSegPf);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el equipo de operaciones para embarcaciones mayores de equipos de seguridad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de un equipo de operaciones para embarcaciones mayores de seguridad.
     */
    public function show($id)
    {
        try {
            $EqOpMaSegPf = EqOpMaSegPf::findOrFail($id);
            $result = [
                'id' => $EqOpMaSegPf->id,
                'userprofile_id' => $EqOpMaSegPf->perfil_usuario->id,
                'emb_pertenece_id' => $EqOpMaSegPf->EmbarcacionPertenece->id,
                'cuenta_eqseguridad' => $EqOpMaSegPf->cuenta_eqseguridad ? 'Sí' : 'No',
                'equipo_seguiridad' => $EqOpMaSegPf->equipo_seguiridad,
                'eqseg_cant' => $EqOpMaSegPf->eqseg_cant,
                'eqseg_tipo_id' => $EqOpMaSegPf->TipoEquipoSeguridad->id,
                'created_at' => $EqOpMaSegPf->created_at,
                'updated_at' => $EqOpMaSegPf->updated_at,
            ];
            return ApiResponse::success('Equipo de operaciones para embarcaciones mayores de equipos de seguridad obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones para embarcaciones mayores de equipos de seguridad no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de operaciones para embarcaciones mayores de equipos de seguridad: ' .$e->getMessage(), 500);
        } 
    }

    /**
     * Actualiza un equipo de operaciones para embarcaciones mayores de seguridad.
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

            $existeEqOpMaSegPF = EqOpMaSegPf::where($data)->exists();
            if ($existeEqOpMaSegPF) {
                return ApiResponse::error('El equipo de operaciones para embarcaciones mayores de equipos de seguridad ya esta registrado.', 422);
            }

            $EqOpMaSegPf = EqOpMaSegPf::findOrFail($id);
            $EqOpMaSegPf->update($data);
            return ApiResponse::success('El equipo de operaciones para embarcaciones mayores de equipos de seguridad se actualizo exitosamente', 200, $EqOpMaSegPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones para embarcaciones mayores de equipos de seguridad no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de operaciones para embarcaciones mayores de equipos de seguridad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operaciones para embarcaciones mayores de seguridad.
     */
    public function destroy($id)
    {
        try {
            $EqOpMaSegPf = EqOpMaSegPf::findOrFail($id);
            $EqOpMaSegPf->delete();
            return ApiResponse::success('Equipo de operaciones para embarcaciones mayores de equipos de seguridad eliminado exitosamente', 200, $EqOpMaSegPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones para embarcaciones mayores de equipos de seguridad no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de operaciones para embarcaciones mayores de equipos de seguridad: ' .$e->getMessage(), 500);
        }
    }
}
