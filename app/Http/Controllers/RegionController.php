<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\region;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegionController extends Controller
{
    /**
     * Despliega la lista de regiones.
     */
    public function index()
    {
        try {
            $regiones = region::all();
            $result = $regiones->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre_region' => $item->nombre_region,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at
                ];
            });
            return ApiResponse::success('Lista de regiones', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de regiones: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea una region.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_region' => 'required|string|max:40'
            ]);
            
            $existeRegion = region::where($data)->exists();
            if ($existeRegion) {
                return ApiResponse::error('Esta region ya existe', 422);
            }

            $region = region::create($data);
            return ApiResponse::success('Región creada exitosamente', 201, $region);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la región: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra una region .
     */
    public function show($id)
    {
        try {
            $region = region::findOrFail($id);
            $result = [
                'id' => $region->id,
                'nombre_region' => $region->nombre_region,
                'updated_at' => $region->updated_at,
            ];
            return ApiResponse::success('Región obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Región no encontrada', 404);
        } catch (Exception $e) {
            ApiResponse::error('Error al obtener la región: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza una region.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nombre_region' => 'required|string|max:40'
            ]);

            $existeRegion = region::where($data)->exists();
            if ($existeRegion) {
                return ApiResponse::error('La región ya existe', 422);
            }

            $region = region::findOrFail($id);
            $region->update($data);
            return ApiResponse::success('Región actualizada exitosamente', 200, $region);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Región no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la región: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina una region.
     */
    public function destroy($id)
    {
        try {
            $region = region::findOrFail($id);
            $region->delete();
            return ApiResponse::success('Región eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Región no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la región: ' .$e->getMessage(), 500);
        }
    }
}
