<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\tipo_permiso;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoPermisoController extends Controller
{
    /**
     * Despliega la lista de los tipos de permisos.
     */
    public function index()
    {
        try {
            $tipo_permisos = tipo_permiso::all();
            $result = $tipo_permisos->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre_permiso' => $item->nombre_permiso,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de permisos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de permisos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un tipo de permiso.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_permiso' => 'required|string|max:50'
            ]);
            $existeTPermiso = tipo_permiso::where($data)->exists();
            if ($existeTPermiso) {
                return ApiResponse::error('El tipo de permiso ya existe', 422);
            }

            $tipo_permiso = tipo_permiso::create($data);
            return ApiResponse::success('Tipo de permiso creado exitosamente', 201, $tipo_permiso);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el tipo de permiso: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra el tipo de permiso.
     */
    public function show($id)
    {
        try {
            $tipo_permiso = tipo_permiso::findOrFail($id);
            $result = [
                'id' => $tipo_permiso->id,
                'nombre_permiso' => $tipo_permiso->nombre_permiso,
                'created_at' => $tipo_permiso->created_at,
                'updated_at' => $tipo_permiso->updated_at,
            ];
            return ApiResponse::success('Tipo de permiso obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de permiso no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el tipo de permiso: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un tipo de permiso.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nombre_permiso' => 'required|string|max:50'
            ]);

            $existeTPermiso = tipo_permiso::where($data)->exists();
            if ($existeTPermiso) {
                return ApiResponse::error('El tipo de permiso ya existe', 422);
            }

            $tipo_permiso = tipo_permiso::findOrFail($id);
            $tipo_permiso->update($data);
            return ApiResponse::success('Tipo de permiso actualizado exitosamente', 200, $tipo_permiso);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de permiso no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el tipo de permiso: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina el tipo de permiso.
     */
    public function destroy($id)
    {
        try {
            $tipo_permiso = tipo_permiso::findOrFail($id);
            $tipo_permiso->delete();
            return ApiResponse::success('Tipo de permiso eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de permiso no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el tipo de permiso: ' .$e->getMessage(), 500);
        }
    }
}
