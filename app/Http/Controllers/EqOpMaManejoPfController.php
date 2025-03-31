<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMaManejoPf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMaManejoPfController extends Controller
{
    /**
     * Despliega la lista de equipos de operaciones de equipos de manejo para embarcaciones mayores.
     */
    public function index()
    {
        try {
            $EqOpMaManejoPf = EqOpMaManejoPf::all();
            $result = $EqOpMaManejoPf->map(function ($item){
                return [
                    'id' => $item->id,
                    'userprofile_id' => $item->perfil_usuario->name,
                    'emb_pertenece_id' => $item->EmbarcacionPertenece->id,
                    'cuenta_eqmanejo' => $item->cuenta_eqmanejo ? 'Sí' : 'No',
                    'equipo_manejo' => $item->equipo_manejo,
                    'eqmanejo_cant' => $item->eqmanejo_cant,
                    'eqmanejo_tipo_id' => $item->TipoEquipoManejo->tipo_eqmanejo,
                    'emb_pertenece_id' => $item->registroemb_ma_pf->nombre_emb_ma,
                    'cuenta_eqmanejo' => $item->cuenta_eqmanejo ? 'Sí' : 'No',
                    'equipo_manejo' => $item->equipo_manejo,
                    'eqmanejo_tipo_id' => $item->tipoeqmanejo->tipo_eqmanejo,
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
                'userprofile_id' => 'required|exists:users,id',
                'emb_pertenece_id' => 'required|exists:registroemb_ma_pf,id',
                'cuenta_eqmanejo' => 'required|boolean',
                'equipo_manejo' => 'required|string|max:50',
                'eqmanejo_cant' => 'required|integer',
                'eqmanejo_tipo_id' => 'required|exists:tipo_equipo_manejo,id',
            ]);

            $existeEqOpMaManejoPf = EqOpMaManejoPf::where('emb_pertenece_id', $data['emb_pertenece_id'])
                ->where('cuenta_eqmanejo', $data['cuenta_eqmanejo'])
                ->where('equipo_manejo', $data['equipo_manejo'])
                ->where('eqmanejo_tipo_id', $data['eqmanejo_tipo_id'])
                ->exists();

            if ($existeEqOpMaManejoPf) {
                return ApiResponse::error('El equipo de operaciones de manejo para embarcaciones mayores ya está registrado.', 422);
            }

            $EqOpMaManejoPf = EqOpMaManejoPf::create($data);
            return ApiResponse::success('El equipo de operaciones de manejo para embarcaciones mayores fue creado exitosamente', 201, $EqOpMaManejoPf);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el equipo de operaciones de manejo para embarcaciones mayores: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Muestra la información de un equipo de operaciones de equipos de manejo para embarcaciones mayores.
     */
    public function show($id)
    {
        try {
            $EqOpMaManejoPf = EqOpMaManejoPf::findOrFail($id);
            $result = [
                'id' => $EqOpMaManejoPf->id,
                'userprofile_id' => $EqOpMaManejoPf->perfil_usuario->id,
                'emb_pertenece_id' => $EqOpMaManejoPf->EmbarcacionPertenece->id,
                'cuenta_eqmanejo' => $EqOpMaManejoPf->cuenta_eqmanejo ? 'Sí' : 'No',
                'equipo_manejo' => $EqOpMaManejoPf->equipo_manejo,
                'eqmanejo_tipo_id' => $EqOpMaManejoPf->TipoEquipoManejo->id,
                'emb_pertenece_id' => $EqOpMaManejoPf->registroemb_ma_pf->nombre_emb_ma,
                'cuenta_eqmanejo' => $EqOpMaManejoPf->cuenta_eqmanejo ? 'Sí' : 'No',
                'equipo_manejo' => $EqOpMaManejoPf->equipo_manejo,
                'eqmanejo_tipo_id' => $EqOpMaManejoPf->tipoeqmanejo->tipo_eqmanejo,
                'created_at' => $EqOpMaManejoPf->created_at,
                'updated_at' => $EqOpMaManejoPf->updated_at,
            ];
            return ApiResponse::success('Detalles del equipo de operaciones de manejo para embarcaciones mayores', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones no encontrado.', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de operaciones de manejo para embarcaciones mayores: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un equipo de operaciones de equipos de manejo para embarcaciones mayores.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required',
                'emb_pertenece_id' => 'required|exists:registroemb_ma_pf,id',
                'cuenta_eqmanejo' => 'required|boolean',
                'equipo_manejo' => 'required|string|max:50',
                'eqmanejo_cant' => 'required|integer',
                'eqmanejo_tipo_id' => 'required|exists:tipo_equipo_manejo,id',
            ]);

            $EqOpMaManejoPf = EqOpMaManejoPf::findOrFail($id);
            $EqOpMaManejoPf->update($data);

            return ApiResponse::success('El equipo de operaciones de manejo para embarcaciones mayores fue actualizado exitosamente', 200, $EqOpMaManejoPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones no encontrado.', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de operaciones de manejo para embarcaciones mayores: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operaciones de equipos de manejo para embarcaciones mayores.
     */
    public function destroy($id)
{
    try {
        $EqOpMaManejoPf = EqOpMaManejoPf::findOrFail($id);
        $EqOpMaManejoPf->delete();

        return ApiResponse::success('El equipo de operaciones de manejo para embarcaciones mayores fue eliminado exitosamente', 200);
    } catch (ModelNotFoundException $e) {
        return ApiResponse::error('Equipo de operaciones no encontrado.', 404);
    } catch (Exception $e) {
        return ApiResponse::error('Error al eliminar el equipo de operaciones de manejo para embarcaciones mayores: ' . $e->getMessage(), 500);
    }
}
}
