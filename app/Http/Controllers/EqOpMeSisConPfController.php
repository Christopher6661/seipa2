<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EqOpMeSisConPf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EqOpMeSisConPfController extends Controller
{
    /**
     * Despliega la lista de los equipos de operacion menores de sistema de conservación del pescador fisico.
     */
    public function index()
    {
        try {
            $EqOpMeSisConPf = EqOpMeSisConPf::all();
            $result = $EqOpMeSisConPf->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->registroemb_me_pf->id,
                    'cuenta_siscon' => $item->cuenta_siscon ? 'Sí' : 'No',
                    'sistema_conserva' => $item->sistema_conserva,
                    'siscon_cant' => $item->siscon_cant,
                    'siscon_tipo_id' => $item->tipo_sistconservacion->id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de equipos de operaciones para embarcaciones menores de sistemas de conservación', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los equipos de operación de embarcaciones menores de sistemas de conservación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un equipo de operacion menor de sistema de conservación del pescador fisico.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required|exists:registroemb_me_pf,id',
                'cuenta_siscon' => 'required|boolean',
                'sistema_conserva' => 'required|string|max:50',
                'siscon_cant' => 'required|integer',
                'siscon_tipo_id' => 'required|exists:tipo_sistconservacion,id',
            ]);
            $existeEqOpMeSisConPF = EqOpMeSisConPf::where($data)->exists();
            if ($existeEqOpMeSisConPF) {
                return ApiResponse::error('El equipo de operacion para embarcaciones menores de sistema de conservación ya esta registrado.', 422);
            }

            $EqOpMeSisConPf = EqOpMeSisConPf::create($data);
            return ApiResponse::success('El equipo de operacion para embarcaciones menores de sistema de conservación fue creado exitosamente', 201, $EqOpMeSisConPf);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el equipo de operacion para embarcaciones menores de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra información de un equipo de operacion menor de sistema de conservación del pescador fisico.
     */
    public function show($id)
    {
        try {
            $EqOpMeSisConPf = EqOpMeSisConPf::findOrFail($id);
            $result = [
                'id' => $EqOpMeSisConPf->id,
                'emb_pertenece_id' => $EqOpMeSisConPf->registroemb_me_pf->id,
                'cuenta_siscon' => $EqOpMeSisConPf->cuenta_siscon ? 'Sí' : 'No',
                'sistema_conserva' => $EqOpMeSisConPf->sistema_conserva,
                'siscon_cant' => $EqOpMeSisConPf->siscon_cant,
                'siscon_tipo_id' => $EqOpMeSisConPf->tipo_sistconservacion->id,
                'created_at' => $EqOpMeSisConPf->created_at,
                'updated_at' => $EqOpMeSisConPf->updated_at,
            ];
            return ApiResponse::success('Equipo de operacion para embarcaciones menores de sistema de conservación obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operacion para embarcaciones menores de sistema de conservación no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de operacion para embarcaciones menores de sistema de conservación : ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un equipo de operacion menor de sistema de conservación del pescador fisico.
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

            $existeEqOpMeSisConPF = EqOpMeSisConPf::where($data)->exists();
            if ($existeEqOpMeSisConPF) {
                return ApiResponse::error('El equipo de operacion para embarcaciones menores de sistema de conservación ya esta registrado.', 422);
            }

            $EqOpMeSisConPf = EqOpMeSisConPf::findOrFail($id);
            $EqOpMeSisConPf->update($data);
            return ApiResponse::success('El equipo de operacion para embarcaciones menores de sistema de conservación se actualizo exitosamente', 200, $EqOpMeSisConPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operacion para embarcaciones menores de sistema de conservación no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de operacion para embarcaciones menores de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operacion menor de sistema de conservación del pescador fisico.
     */
    public function destroy($id)
    {
        try {
            $EqOpMeSisConPf = EqOpMeSisConPf::findOrFail($id);
            $EqOpMeSisConPf->delete();
            return ApiResponse::success('Equipo de operacion para embarcaciones menores de sistema de conservación eliminado exitosamente', 200, $EqOpMeSisConPf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de operacion para embarcaciones menores de sistema de conservación no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de operacion para embarcaciones menores de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }
}
