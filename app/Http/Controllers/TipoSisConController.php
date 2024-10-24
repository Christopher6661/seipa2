<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\TipoSisCon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoSisConController extends Controller
{
    /**
     * Despliega la lista de los tipos de sistemas de conservacion.
     */
    public function index()
    {
        try {
            $TiposSisCon = TipoSisCon::all();
            $result = $TiposSisCon->map(function ($item){
                return [
                    'id' => $item->id,
                    'tipos_siscon' => $item->tipo_siscon,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de tipos de sistemas de conservación', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los tipos de sistemas de conservación: '.$e->getMessage(), 500);
        }
    }

    /**
     * Crea un nuevo tipo de sistema de conservacion.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'tipo_siscon' => 'required|string|max:50'
            ]);
            $existeTSisCon = TipoSisCon::where($data)->exists();
            if ($existeTSisCon) {
                return ApiResponse::error('Este tipo de sistema de conservación ya existe', 422);
            }

            $TiposSisCon = TipoSisCon::create($data);
            return ApiResponse::success('Tipo de sistema de conservación creado exitosamente', 201, $TiposSisCon);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el tipo de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de un tipo de sistema de conservacion.
     */
    public function show($id)
    {
        try {
            $TiposSisCon = TipoSisCon::findOrFail($id);
            $result = [
                'id' => $TiposSisCon->id,
                'tipos_siscon' => $TiposSisCon->tipo_siscon,
                'created_at' => $TiposSisCon->created_at,
                'updated_at' => $TiposSisCon->updated_at,
            ];
            return ApiResponse::success('Tipo de sistema de conservación obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de sistema de conservación no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el tipo de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un tipo de sistema de conservacion.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'tipo_siscon' => 'required|string|max:50'
            ]);

            $existeTSisCon = TipoSisCon::where($data)->exists();
            if ($existeTSisCon) {
                return ApiResponse::error('Este tipo de sistema de conservación ya existe', 422);
            }

            $TiposSisCon = TipoSisCon::findOrFail($id);
            $TiposSisCon->update($data);
            return ApiResponse::success('Tipo de sistema de conservación actualizado exitosamente', 200, $TiposSisCon);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de sistema de conservación no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el tipo de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un tipo de sistema de conservacion.
     */
    public function destroy($id)
    {
        try {
            $TiposSisCon = TipoSisCon::findOrFail($id);
            $TiposSisCon->delete();
            return ApiResponse::success('Tipo de sistema de conservación eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de sistema de conservación no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el tipo de sistema de conservación: ' .$e->getMessage(), 500);
        }
    }
}
