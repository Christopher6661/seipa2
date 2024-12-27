<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\especie;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EspecieController extends Controller
{
    /**
     * Despliega una lista de las especies de animales marinos
     */
    public function index()
    {
        try {
            $especies = especie::all();
            $result = $especies->map(function ($item){
                return [
                    'id' => $item->id,
                    'nombre_especie' => $item->nombre_especie,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de especies', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de especies: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea una nueva especie
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_especie' => 'required|string|max:40'
            ]);

            $especieExistente = especie::where('nombre_especie', $data['nombre_especie'])->first();

            if ($especieExistente) {
                return response()->json([
                    'message' => 'La especie ya existe.',
                    'data' => $especieExistente,
                    'especies_insertadas' => especie::all()
                ], 200);
            }

            $especie = especie::create($data);

            return response()->json([
                'message' => 'Especie creada exitosamente',
                'data' => $especie,
                'especies_insertadas' => especie::all()
            ], 201);
            
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la especie: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra una especie
     */
    public function show($id)
    {
        try {
            $especie = especie::findOrFail($id);
            $result = [
                'id' => $especie->id,
                'nombre_especie' => $especie->nombre_especie,
                'created_at' => $especie->created_at,
                'updated_at' => $especie->updated_at,
            ];
            return ApiResponse::success('Especie obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Especie no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la especie: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza una especie
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nombre_especie' => 'required|string|max:40'
            ]);

            $existeEspecie = especie::where($data)->exists();
            if ($existeEspecie) {
                return ApiResponse::error('La especie ya existe', 422);
            }

            $especie = especie::findOrFail($id);
            $especie->update($data);
            return ApiResponse::success('Especie actualizada exitosamente', 200, $especie);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Especie no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la especie: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina una especie
     */
    public function destroy($id)
    {
        try {
            $especie = especie::findOrFail($id);
            $especie->delete();
            return ApiResponse::success('Especie eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Especie no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la especie: ' .$e->getMessage(), 500);
        }
    }
}
