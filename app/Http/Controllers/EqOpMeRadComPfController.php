<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMeRadComPf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMeRadComPfController extends Controller
{
    /**
     * Despliega la lista de los equipos de operaciones de radio-comunicación para embarcaciones menores.
     */
    public function index()
    {
        try {
            $EqOpMeRadComPf = EqOpMeRadComPf::all();
            $result = $EqOpMeRadComPf->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->registroemb_me_pf->id,
                    'cuenta_eqradiocom' => $item->cuenta_eqradiocom ? 'Sí' : 'No',
                    'equipo_radiocomun' => $item->equipo_radiocomun,
                    'eqradiocom_tipo_id' => $item->tipo_equipo_radcom->id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de equipos de operaciones de radio-comunicación para embarcaciones menores', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los equipos de operaciones de radio-comunicación para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un equipo de operaciones de radio-comunicación para embarcaciones menores.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required|exists:registroemb_me_pf,id',
                'cuenta_eqradiocom' => 'required|boolean',
                'equipo_radiocomun' => 'required|string|max:50',
                'eqradiocom_cant' => 'required|integer',
                'eqradiocom_tipo_id' => 'required|exists:tipo_equipo_radcom,id',
            ]);
            $existeEqOpMeRadComPf = EqOpMeRadComPf::where($data)->exists();
            if ($existeEqOpMeRadComPf) {
                return ApiResponse::error('El equipo de operaciones de radio-comunicación para embarcaciones menores ya esta registrado.', 422);
            }

            $EqOpMeRadComPf = EqOpMeRadComPf::create($data);
            return ApiResponse::success('El equipo de operaciones de radio-comunicación para embarcaciones menores fue creado exitosamente', 201, $EqOpMeRadComPf);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el equipo de operaciones de radio-comunicación para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra la información de un equipo de operaciones de radio-comunicación para embarcaciones menores.
     */
    public function show($id)
    {
        try {
            $EqOpMeRadComPf = EqOpMeRadComPf::findOrFail($id);
            $result = [
                'id' => $EqOpMeRadComPf->id,
                'emb_pertenece_id' => $EqOpMeRadComPf->registroemb_me_pf->id,
                'cuenta_eqradiocom' => $EqOpMeRadComPf->cuenta_eqradiocom ? 'Sí' : 'No',
                'equipo_radiocomun' => $EqOpMeRadComPf->equipo_radiocomun,
                'eqradiocom_tipo_id' => $EqOpMeRadComPf->tipo_equipo_radcom->id,
                'created_at' => $EqOpMeRadComPf->created_at,
                'updated_at' => $EqOpMeRadComPf->updated_at,
            ];
            return ApiResponse::success('Equipo de operaciones de radio-comunicación para embarcaciones menores obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de radio-comunicación para embarcaciones menores no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de operaciones de radio-comunicación para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un equipo de operaciones de radio-comunicación para embarcaciones menores.
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

            $existeEqOpMeRadComPf = EqOpMeRadComPf::where($data)->exists();
            if ($existeEqOpMeRadComPf) {
                return ApiResponse::error('El equipo de operaciones de radio-comunicación para embarcaciones menores ya esta registrado.', 422);
            }

            $EqOpMeRadComPf = EqOpMeRadComPf::findOrFail($id);
            $EqOpMeRadComPf->update($data);
            return ApiResponse::success('El equipo de operaciones de radio-comunicación para embarcaciones menores se actualizo exitosamente', 200, $EqOpMeRadComPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de radio-comunicación para embarcaciones menores no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de operaciones de radio-comunicación para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operaciones de radio-comunicación para embarcaciones menores.
     */
    public function destroy($id)
    {
        try {
            $EqOpMeRadComPf = EqOpMeRadComPf::findOrFail($id);
            $EqOpMeRadComPf->delete();
            return ApiResponse::success('Equipo de operaciones de radio-comunicación para embarcaciones menores eliminado exitosamente', 200, $EqOpMeRadComPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operaciones de radio-comunicación para embarcaciones menores no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de operaciones de radio-comunicación para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }
}
