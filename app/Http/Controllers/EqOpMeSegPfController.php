<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMeSegPf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMeSegPfController extends Controller
{
    /**
     * Despliega la lista de los equipos de operaciones para embarcaciones menores de seguridad.
     */
    public function index()
    {
        try {
            $EqOpMeSegPf = EqOpMeSegPf::all();
            $result = $EqOpMeSegPf->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->registroemb_me_pf->id,
                    'cuenta_eqseguridad' => $item->cuenta_eqseguridad ? 'Sí' : 'No',
                    'equipo_seguridad' => $item->equipo_seguridad,
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
                'emb_pertenece_id' => 'required|exists:registroemb_me_pf,id',
                'cuenta_eqseguridad' => 'required|boolean',
                'equipo_seguridad' => 'required|string|max:50',
                'eqseg_cant' => 'required|integer',
                'eqseg_tipo_id' => 'required|exists:tipo_equipo_seg,id',
            ]);
            $existeEqOpMeSegPF = EqOpMeSegPf::where($data)->exists();
            if ($existeEqOpMeSegPF) {
                return ApiResponse::error('El equipo de operaciones para embarcaciones menores de equipos de seguridad ya esta registrado.', 422);
            }

            $EqOpMeSegPf = EqOpMeSegPf::create($data);
            return ApiResponse::success('El equipo de operaciones para embarcaciones menores de equipos de seguridad fue creado exitosamente', 201, $EqOpMeSegPf);
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
            $EqOpMeSegPf = EqOpMeSegPf::findOrFail($id);
            $result = [
                'id' => $EqOpMeSegPf->id,
                'emb_pertenece_id' => $EqOpMeSegPf->registroemb_me_pf->id,
                'cuenta_eqseguridad' => $EqOpMeSegPf->cuenta_eqseguridad ? 'Sí' : 'No',
                'equipo_seguridad' => $EqOpMeSegPf->equipo_seguridad,
                'eqseg_cant' => $EqOpMeSegPf->eqseg_cant,
                'eqseg_tipo_id' => $EqOpMeSegPf->tipo_equipo_seg->id,
                'created_at' => $EqOpMeSegPf->created_at,
                'updated_at' => $EqOpMeSegPf->updated_at,
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
                'emb_pertenece_id' => 'required',
                'cuenta_eqseguridad' => 'required|boolean',
                'equipo_seguridad' => 'required|string|max:50',
                'eqseg_cant' => 'required|integer',
                'eqseg_tipo_id' => 'required',
            ]);

            $existeEqOpMeSegPF = EqOpMeSegPf::where($data)->exists();
            if ($existeEqOpMeSegPF) {
                return ApiResponse::error('El equipo de operaciones para embarcaciones menores de equipos de seguridad ya esta registrado.', 422);
            }

            $EqOpMeSegPf = EqOpMeSegPf::findOrFail($id);
            $EqOpMeSegPf->update($data);
            return ApiResponse::success('El equipo de operaciones para embarcaciones menores de equipos de seguridad se actualizo exitosamente', 200, $EqOpMeSegPf);
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
            $EqOpMeSegPf = EqOpMeSegPf::findOrFail($id);
            $EqOpMeSegPf->delete();
            return ApiResponse::success('Equipo de operaciones para embarcaciones menores de equipos de seguridad eliminado exitosamente', 200, $EqOpMeSegPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones para embarcaciones menores de equipos de seguridad no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de operaciones para embarcaciones menores de equipos de seguridad: ' .$e->getMessage(), 500);
        }
    }
}
