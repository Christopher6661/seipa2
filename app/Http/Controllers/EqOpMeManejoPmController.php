<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMeManejoPm;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMeManejoPmController extends Controller
{
    /**
     * Despliega la lista de equipos de operaciones de equipos de manejo para embarcaciones menores.
     */
    public function index()
    {
        try {
            $EqOpMeManejoPm = EqOpMeManejoPm::all();
            $result = $EqOpMeManejoPm->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->registroemb_me_pm->id,
                    'cuenta_eqmanejo' => $item->cuenta_eqmanejo ? 'Sí' : 'No',
                    'equipo_manejo' => $item->equipo_manejo,
                    'eqmanejo_tipo_id' => $item->tipo_equipo_manejo->id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de equipos de operaciones de manejo para embarcaciones menores', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los equipos de operaciones de manejo para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un equipo de operaciones de equipos de manejo para embarcaciones menores.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required|exists:registroemb_me_pm,id',
                'cuenta_eqmanejo' => 'required|boolean',
                'equipo_manejo' => 'required|string|max:50',
                'eqmanejo_cant' => 'required|integer',
                'eqmanejo_tipo_id' => 'required|exists:tipo_equipo_manejo',
            ]);
            $existeEqOpMeManejoPm = EqOpMeManejoPm::where($data)->exists();
            if ($existeEqOpMeManejoPm) {
                return ApiResponse::error('El equipo de operaciones de manejo para embarcaciones menores ya esta registrado.', 422);
            }

            $EqOpMeManejoPm = EqOpMeManejoPm::create($data);
            return ApiResponse::success('El equipo de operaciones de manejo para embarcaciones menores fue creado exitosamente', 201, $EqOpMeManejoPm);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el equipo de operaciones de manejo para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra la información de un equipo de operaciones de equipos de manejo para embarcaciones menores.
     */
    public function show($id)
    {
        try {
            $EqOpMeManejoPm = EqOpMeManejoPm::findOrFail($id);
            $result = [
                'id' => $EqOpMeManejoPm->id,
                'emb_pertenece_id' => $EqOpMeManejoPm->registroemb_me_pm->id,
                'cuenta_eqmanejo' => $EqOpMeManejoPm->cuenta_eqmanejo ? 'Sí' : 'No',
                'equipo_manejo' => $EqOpMeManejoPm->equipo_manejo,
                'eqmanejo_tipo_id' => $EqOpMeManejoPm->tipo_equipo_manejo->id,
                'created_at' => $EqOpMeManejoPm->created_at,
                'updated_at' => $EqOpMeManejoPm->updated_at,
            ];
            return ApiResponse::success('Equipo de operaciones de manejo para embarcaciones menores obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de manejo para embarcaciones menores no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de operaciones de manejo para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un equipo de operaciones de equipos de manejo para embarcaciones menores.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required',
                'cuenta_eqmanejo' => 'required|boolean',
                'equipo_manejo' => 'required|string|max:50',
                'eqmanejo_cant' => 'required|integer',
                'eqmanejo_tipo_id' => 'required',
            ]);

            $existeEqOpMeManejoPm = EqOpMeManejoPm::where($data)->exists();
            if ($existeEqOpMeManejoPm) {
                return ApiResponse::error('El equipo de operaciones de manejo para embarcaciones menores ya esta registrado.', 422);
            }

            $EqOpMeManejoPm = EqOpMeManejoPm::findOrFail($id);
            $EqOpMeManejoPm->update($data);
            return ApiResponse::success('El equipo de operaciones de manejo para embarcaciones menores se actualizo exitosamente', 200, $EqOpMeManejoPm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de manejo para embarcaciones menores no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de operaciones de manejo para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operaciones de equipos de manejo para embarcaciones menores.
     */
    public function destroy($id)
    {
        try {
            $EqOpMeManejoPm = EqOpMeManejoPm::findOrFail($id);
            $EqOpMeManejoPm->delete();
            return ApiResponse::success('Equipo de operaciones de manejo para embarcaciones menores eliminado exitosamente', 200, $EqOpMeManejoPm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de manejo para embarcaciones menores no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de operaciones de manejo para embarcaciones menores : ' .$e->getMessage(), 500);
        }
    }
}
