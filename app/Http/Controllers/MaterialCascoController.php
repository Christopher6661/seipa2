<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\material_casco;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MaterialCascoController extends Controller
{
    /**
     * Despliega la lista de los materiales de casco.
     */
    public function index()
    {
        try {
            $material_casco = material_casco::all();
            $result = $material_casco->map(function ($item) {
                return [
                    'id' => $item->id,
                    'material' => $item->material,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de materiales', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de materiales: ',$e->getMessage(), 500);
        }
    }

    /**
     * Crea un material para cascos.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'material' => 'required|string|max:50'
            ]);
            $existeMaterial = material_casco::where($data)->exists();
            if ($existeMaterial) {
                return ApiResponse::error('El material para cascos ya existe', 422);
            }

            $material_casco = material_casco::create($data);
            return ApiResponse::success('Material creado exitosamente', 201, $material_casco);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el material: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra el material para cascos.
     */
    public function show($id)
    {
        try {
            $material_casco = material_casco::findOrFail($id);
            $result = [
                'id' => $material_casco->id,
                'material' => $material_casco->material,
                'created_at' => $material_casco->created_at,
                'updated_at' => $material_casco->updated_at,
            ];
            return ApiResponse::success('Material obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Material para cascos no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el material: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza el material para cascos.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'material' => 'required|string|max:50'
            ]);

            $existeMaterial = material_casco::where($data)->exists();
            if ($existeMaterial) {
                return ApiResponse::error('El material ya existe', 422);
            }

            $material_casco = material_casco::findOrFail($id);
            $material_casco->update($data);
            return ApiResponse::success('Material actualizado exitosamente', 200, $material_casco);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Material no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el material para cascos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina el material para cascos.
     */
    public function destroy($id)
    {
        try {
            $material_casco = material_casco::findOrFail($id);
            $material_casco->delete();
            return ApiResponse::success('Material eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Material para cascos no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el material para cascos: ' .$e->getMessage(), 500);
        }
    }
}
