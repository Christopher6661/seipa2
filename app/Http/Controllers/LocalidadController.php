<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\localidad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LocalidadController extends Controller
{
    /**
     * Despliega la lista de localidades.
     */
    public function index()
    {
        try {
            $localidades = localidad::all();
            $result = $localidades->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre_localidad' => $item->nombre_localidad,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de localidades', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de las localidades: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea localidad.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_localidad' => 'required|string|max:40'
            ]);
            $existeLocalidad = localidad::where($data)->exists();
            if ($existeLocalidad) {
                return ApiResponse::error('La localidad ya existe', 422);
            }

            $localidad = localidad::create($data);
            return ApiResponse::success('Localidad creada exitosamente', 201, $localidad);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la localidad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra localidad.
     */
    public function show($id)
    {
        try {
            $localidad = localidad::findOrFail($id);
            $result = [
                'id' => $localidad->id,
                'nombre_localidad' => $localidad->nombre_localidad,
                'created_at' => $localidad->created_at,
                'updated_at' => $localidad->updated_at,
            ];
            return ApiResponse::success('Localidad obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Localidad no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la localidad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza localidad.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nombre_localidad' => 'required|string|max:40'
            ]);

            $existeLocalidad = localidad::where($data)->exists();
            if ($existeLocalidad) {
                return ApiResponse::error('La localidad ya existe', 422);
            }

            $localidad = localidad::findOrFail($id);
            $localidad->update($data);
            return ApiResponse::success('Localidad actualizada exitosamente', 200, $localidad);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Localidad no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la localidad: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina localidad.
     */
    public function destroy($id)
    {
        try {
            $localidad = localidad::findOrFail($id);
            $localidad->delete();
            return ApiResponse::success('Localidad eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Localidad no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la localidad: ' .$e->getMessage(), 500);
        }
    }
}
