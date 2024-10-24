<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\TipoEqSeg;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoEqSegController extends Controller
{
    /**
     * Despliega la lista de los tipos de equipos de seguridad.
     */
    public function index()
    {
        try {
            $TipoEqSeg = TipoEqSeg::all();
            $result = $TipoEqSeg->map(function ($item){
                return [
                    'id' => $item->id,
                    'tipo_eqseguridad' => $item->tipo_eqseguridad,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de tipos de equipos de seguridad', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los tipos de equipos de seguridad: '.$e->getMessage(), 500);
        }
    }

    /**
     * Crea un nuevo tipo de equipo de seguridad.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'tipo_eqseguridad' => 'required|string|max:50'
            ]);
            $existeTEqSeg = TipoEqSeg::where($data)->exists();
            if ($existeTEqSeg) {
                return ApiResponse::error('Este tipo de equipo de seguridad ya existe', 422);
            }

            $TipoEqSeg = TipoEqSeg::create($data);
            return ApiResponse::success('Tipo de equipo de seguridad creado exitosamente', 201, $TipoEqSeg);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el tipo de equipo de seguridad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de un tipo de equipo de seguridad.
     */
    public function show($id)
    {
        try {
            $TipoEqSeg = TipoEqSeg::findOrFail($id);
            $result = [
                'id' => $TipoEqSeg->id,
                'tipo_eqseguridad' => $TipoEqSeg->tipo_eqseguridad,
                'created_at' => $TipoEqSeg->created_at,
                'updated_at' => $TipoEqSeg->updated_at,
            ];
            return ApiResponse::success('Tipo de equipo de seguridad obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de equipo de seguridad no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el tipo de equipo de seguridad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un tipo de equipo de seguridad.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'tipo_eqseguridad' => 'required|string|max:50'
            ]);

            $existeTEqSeg = TipoEqSeg::where($data)->exists();
            if ($existeTEqSeg) {
                return ApiResponse::error('Este tipo de equipo de comunicación ya existe', 422);
            }
            $TipoEqSeg = TipoEqSeg::findOrFail($id);
            $TipoEqSeg->update($data);
            return ApiResponse::success('Tipo de equipo de seguridad actualizado exitosamente', 200, $TipoEqSeg);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de equipo de seguridad no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el tipo de equipo de seguridad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un tipo de equipo de seguridad.
     */
    public function destroy($id)
    {
        try {
            $TipoEqSeg = TipoEqSeg::findOrFail($id);
            $TipoEqSeg->delete();
            return ApiResponse::success('Tipo de equipo de seguridad eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de equipo de seguridad no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el tipo de equipo de seguridad: ' .$e->getMessage(), 500);
        }
    }
}
