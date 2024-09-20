<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\arte_pesca;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ArtePescaController extends Controller
{
    /**
     * Desplega la lista de artes de pesca.
     */
    public function index()
    {
        try {
            $artes_pesca = arte_pesca::all();
            $result = $artes_pesca->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre_artpesca' => $item->nombre_artpesca,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de artes de pesca', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los artes de pesca: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un arte de pesca.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_artpesca' => 'required|string|max:50'
            ]);
            $existeArtePesca = arte_pesca::where($data)->exists();
            if ($existeArtePesca) {
                return ApiResponse::error('Este arte de pesca ya existe', 422);
            }

            $arte_pesca = arte_pesca::create($data);
            return ApiResponse::success('Arte de pesca creado exitosamente', 201, $arte_pesca);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear arte de pesca: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra un arte de pesca.
     */
    public function show($id)
    {
        try {
            $arte_pesca = arte_pesca::findOrFail($id);
            $result = [
                'id' => $arte_pesca->id,
                'nombre_artpesca' => $arte_pesca->nombre_artpesca,
                'created_at' => $arte_pesca->created_at,
                'updated_at' => $arte_pesca->updated_at,
            ];
            return ApiResponse::success('Arte pesca obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el arte de pesca: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un arte de pesca.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nombre_artpesca' => 'required|string|max:50'
            ]);

            $existeArtePesca = arte_pesca::where($data)->exists();
            if ($existeArtePesca) {
                return ApiResponse::error('El arte de pesca ya existe', 422);
            }

            $arte_pesca = arte_pesca::findOrFail($id);
            $arte_pesca->update($data);
            return ApiResponse::success('Arte de pesca actualizado exitosamente', 200, $arte_pesca);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el arte de pesca: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un arte de pesca.
     */
    public function destroy($id)
    {
        try {
            $arte_pesca = arte_pesca::findOrFail($id);
            $arte_pesca->delete();
            return ApiResponse::success('Arte de pesca eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el arte de pesca: ' .$e->getMessage(), 500);
        }
    }
}
