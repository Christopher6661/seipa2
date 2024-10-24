<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMaManejoPm;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMaManejoPmController extends Controller
{
    /**
     * Despliega la lista de equipos de operaciones de equipos de manejo para embarcaciones mayores.
     */
    public function index()
    {
        try {
            $EqOpMaManejoPm = EqOpMaManejoPm::all();
            $result = $EqOpMaManejoPm->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->registroemb_ma_pm->id,
                    'cuenta_eqmanejo' => $item->cuenta_eqmanejo ? 'Sí' : 'No',
                    'equipo_manejo' => $item->equipo_manejo,
                    'eqmanejo_tipo_id' => $item->tipo_equipo_manejo->id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de equipos de operaciones de manejo para embarcaciones mayores', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los equipos de operaciones de manejo para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un equipo de operaciones de equipos de manejo para embarcaciones mayores.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required|exists:registroemb_ma_pm,id',
                'cuenta_eqmanejo' => 'required|boolean',
                'equipo_manejo' => 'required|string|max:50',
                'eqmanejo_cant' => 'required|integer',
                'eqmanejo_tipo_id' => 'required|exists:tipo_equipo_manejo',
            ]);
            $existeEqOpMaManejoPm = EqOpMaManejoPm::where($data)->exists();
            if ($existeEqOpMaManejoPm) {
                return ApiResponse::error('El equipo de operaciones de manejo para embarcaciones mayores ya esta registrado.', 422);
            }

            $EqOpMaManejoPm = EqOpMaManejoPm::create($data);
            return ApiResponse::success('El equipo de operaciones de manejo para embarcaciones mayores fue creado exitosamente', 201, $EqOpMaManejoPm);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el equipo de operaciones de manejo para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra la información de un equipo de operaciones de equipos de manejo para embarcaciones mayores.
     */
    public function show($id)
    {
        try {
            $EqOpMaManejoPm = EqOpMaManejoPm::findOrFail($id);
            $result = [
                'id' => $EqOpMaManejoPm->id,
                'emb_pertenece_id' => $EqOpMaManejoPm->registroemb_ma_pm->id,
                'cuenta_eqmanejo' => $EqOpMaManejoPm->cuenta_eqmanejo ? 'Sí' : 'No',
                'equipo_manejo' => $EqOpMaManejoPm->equipo_manejo,
                'eqmanejo_tipo_id' => $EqOpMaManejoPm->tipo_equipo_manejo->id,
                'created_at' => $EqOpMaManejoPm->created_at,
                'updated_at' => $EqOpMaManejoPm->updated_at,
            ];
            return ApiResponse::success('Equipo de operaciones de manejo para embarcaciones mayores obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de manejo para embarcaciones mayores no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de operaciones de manejo para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un equipo de operaciones de equipos de manejo para embarcaciones mayores.
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

            $existeEqOpMaManejoPm = EqOpMaManejoPm::where($data)->exists();
            if ($existeEqOpMaManejoPm) {
                return ApiResponse::error('El equipo de operaciones de manejo para embarcaciones mayores ya esta registrado.', 422);
            }

            $EqOpMaManejoPm = EqOpMaManejoPm::findOrFail($id);
            $EqOpMaManejoPm->update($data);
            return ApiResponse::success('El equipo de operaciones de manejo para embarcaciones mayores se actualizo exitosamente', 200, $EqOpMaManejoPm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de manejo para embarcaciones mayores no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de operaciones de manejo para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operaciones de equipos de manejo para embarcaciones mayores.
     */
    public function destroy($id)
    {
        try {
            $EqOpMaManejoPm = EqOpMaManejoPm::findOrFail($id);
            $EqOpMaManejoPm->delete();
            return ApiResponse::success('Equipo de operaciones de manejo para embarcaciones mayores eliminado exitosamente', 200, $EqOpMaManejoPm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de manejo para embarcaciones mayores no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de operaciones de manejo para embarcaciones mayores: ' .$e->getMessage(), 500);
        } 
    }
}
