<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMaRadComPf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMaRadComPfController extends Controller
{
    /**
     * Despliega la lista de los equipos de operaciones de radio-comunicación para embarcaciones mayores.
     */
    public function index()
    {
        try {
            $EqOpMaRadComPf = EqOpMaRadComPf::all();
            $result = $EqOpMaRadComPf->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->EmbarcacionPertenece->id,
                    'cuenta_eqradiocom' => $item->cuenta_eqradiocom ? 'Sí' : 'No',
                    'equipo_radiocomun' => $item->equipo_radiocomun,
                    'eqradiocom_tipo_id' => $item->TipoEquipoRadioComunicacion->tipo_radiocom,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de equipos de operaciones de radio-comunicación para embarcaciones mayores', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los equipos de operaciones de radio-comunicación para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un equipo de operaciones de radio-comunicación para embarcaciones mayores.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required|exists:registroemb_ma_pf,id',
                'cuenta_eqradiocom' => 'required|boolean',
                'equipo_radiocomun' => 'required|string|max:50',
                'eqradiocom_cant' => 'required|integer',
                'eqradiocom_tipo_id' => 'required|exists:tipo_equipo_radcom,id',
            ]);
            $existeEqOpMaRadComPf = EqOpMaRadComPf::where($data)->exists();
            if ($existeEqOpMaRadComPf) {
                return ApiResponse::error('El equipo de operaciones de radio-comunicación para embarcaciones mayores ya esta registrado.', 422);
            }

            $EqOpMaRadComPf = EqOpMaRadComPf::create($data);
            return ApiResponse::success('El equipo de operaciones de radio-comunicación para embarcaciones mayores fue creado exitosamente', 201, $EqOpMaRadComPf);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el equipo de operaciones de radio-comunicación para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }

    /**
     *  Muestra la información de un equipo de operaciones de radio-comunicación para embarcaciones mayores.
     */
    public function show($id)
    {
        try {
            $EqOpMaRadComPf = EqOpMaRadComPf::findOrFail($id);
            $result = [
                'id' => $EqOpMaRadComPf->id,
                'emb_pertenece_id' => $EqOpMaRadComPf->EmbarcacionPertenece->id,
                'cuenta_eqradiocom' => $EqOpMaRadComPf->cuenta_eqradiocom ? 'Sí' : 'No',
                'equipo_radiocomun' => $EqOpMaRadComPf->equipo_radiocomun,
                'eqradiocom_tipo_id' => $EqOpMaRadComPf->TipoEquipoRadioComunicacion->tipo_radiocom,
                'created_at' => $EqOpMaRadComPf->created_at,
                'updated_at' => $EqOpMaRadComPf->updated_at,
            ];
            return ApiResponse::success('Equipo de operaciones de radio-comunicación para embarcaciones mayores obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de radio-comunicación para embarcaciones mayores no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de operaciones de radio-comunicación para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un equipo de operaciones de radio-comunicación para embarcaciones mayores.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required',
                'cuenta_eqradiocom' => 'required|boolean',
                'equipo_radiocomun' => 'required|string|max:50',
                'eqradiocom_cant' => 'required|integer',
                'eqradiocom_tipo_id' => 'required',
            ]);

            $existeEqOpMaRadComPf = EqOpMaRadComPf::where($data)->exists();
            if ($existeEqOpMaRadComPf) {
                return ApiResponse::error('El equipo de operaciones de radio-comunicación para embarcaciones menores ya esta registrado.', 422);
            }

            $EqOpMaRadComPf = EqOpMaRadComPf::findOrFail($id);
            $EqOpMaRadComPf->update($data);
            return ApiResponse::success('El equipo de operaciones de radio-comunicación para embarcaciones mayores se actualizo exitosamente', 200, $EqOpMaRadComPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de radio-comunicación para embarcaciones mayores no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de operaciones de radio-comunicación para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operaciones de radio-comunicación para embarcaciones mayores.
     */
    public function destroy($id)
    {
        try {
            $EqOpMaRadComPf = EqOpMaRadComPf::findOrFail($id);
            $EqOpMaRadComPf->delete();
            return ApiResponse::success('Equipo de operaciones de radio-comunicación para embarcaciones mayores eliminado exitosamente', 200, $EqOpMaRadComPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de radio-comunicación para embarcaciones mayores no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de operaciones de radio-comunicación para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }
}
