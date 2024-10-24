<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMeManejoPf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMeManejoPfController extends Controller
{
    /**
     * Despliega la lista de equipos de operaciones de equipos de manejo para embarcaciones menores.
     */
    public function index()
    {
        try {
            $EqOpMeManejoPf = EqOpMeManejoPf::all();
            $result = $EqOpMeManejoPf->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->registroemb_me_pf->id,
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
                'emb_pertenece_id' => 'required|exists:registroemb_me_pf,id',
                'cuenta_eqmanejo' => 'required|boolean',
                'equipo_manejo' => 'required|string|max:50',
                'eqmanejo_cant' => 'required|integer',
                'eqmanejo_tipo_id' => 'required|exists:tipo_equipo_manejo',
            ]);
            $existeEqOpMeManejoPf = EqOpMeManejoPf::where($data)->exists();
            if ($existeEqOpMeManejoPf) {
                return ApiResponse::error('El equipo de operaciones de manejo para embarcaciones menores ya esta registrado.', 422);
            }

            $EqOpMeManejoPf = EqOpMeManejoPf::create($data);
            return ApiResponse::success('El equipo de operaciones de manejo para embarcaciones menores fue creado exitosamente', 201, $EqOpMeManejoPf);
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
            $EqOpMeManejoPf = EqOpMeManejoPf::findOrFail($id);
            $result = [
                'id' => $EqOpMeManejoPf->id,
                'emb_pertenece_id' => $EqOpMeManejoPf->registroemb_me_pf->id,
                'cuenta_eqmanejo' => $EqOpMeManejoPf->cuenta_eqmanejo ? 'Sí' : 'No',
                'equipo_manejo' => $EqOpMeManejoPf->equipo_manejo,
                'eqmanejo_tipo_id' => $EqOpMeManejoPf->tipo_equipo_manejo->id,
                'created_at' => $EqOpMeManejoPf->created_at,
                'updated_at' => $EqOpMeManejoPf->updated_at,
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

            $existeEqOpMeManejoPf = EqOpMeManejoPf::where($data)->exists();
            if ($existeEqOpMeManejoPf) {
                return ApiResponse::error('El equipo de operaciones de manejo para embarcaciones menores ya esta registrado.', 422);
            }

            $EqOpMeManejoPf = EqOpMeManejoPf::findOrFail($id);
            $EqOpMeManejoPf->update($data);
            return ApiResponse::success('El equipo de operaciones de manejo para embarcaciones menores se actualizo exitosamente', 200, $EqOpMeManejoPf);
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
            $EqOpMeManejoPf = EqOpMeManejoPf::findOrFail($id);
            $EqOpMeManejoPf->delete();
            return ApiResponse::success('Equipo de operaciones de manejo para embarcaciones menores eliminado exitosamente', 200, $EqOpMeManejoPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de manejo para embarcaciones menores no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de operaciones de manejo para embarcaciones menores : ' .$e->getMessage(), 500);
        }
    }
}
