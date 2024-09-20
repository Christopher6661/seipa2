<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\etnia;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EtniaController extends Controller
{
    /**
     * Despliega la lista de etnias.
     */
    public function index()
    {
        try {
            $etnias = etnia::all();
            $result = $etnias->map(function ($item) {
                return [
                    'id' => $item->id, 
                    'nombre_etnia' => $item->nombre_etnia,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de etnias', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de etnias: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea una etnia.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_etnia' => 'required|string|max:50'
            ]);
            $existeEtnia = etnia::where($data)->exists();
            if ($existeEtnia) {
                return ApiResponse::error('Esta etnia ya existe', 422);
            }

            $etnia = etnia::create($data);
            return ApiResponse::success('Etnia creada exitosamente', 201, $etnia);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la etnia: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra una etnia.
     */
    public function show($id)
    {
        try {
            $etnia = etnia::findOrFail($id);
            $result = [
                'id' => $etnia->id,
                'nombre_etnia' => $etnia->nombre_etnia,
                'created_at' => $etnia->created_at,
                'updated_at' => $etnia->updated_at,
            ];
            return ApiResponse::success('Etnia obtenda exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Etnia no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la etnia: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza una etnia.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nombre_etnia' => 'required|string|max:50'
            ]);

            $existeEtnia = etnia::where($data)->exists();
            if ($existeEtnia) {
                return ApiResponse::error('La etnia ya existe', 422);
            }

            $etnia = etnia::findOrFail($id);
            $etnia->update($data);
            return ApiResponse::success('Etnia actualizada exitosamente', 200, $etnia);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Etnia no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la etnia: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina una etnia.
     */
    public function destroy($id)
    {
        try {
            $etnia = etnia::findOrFail($id);
            $etnia->delete();
            return ApiResponse::success('Etnia eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Etnia no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la etnia: ' .$e->getMessage(), 500);
        }
    }
}
