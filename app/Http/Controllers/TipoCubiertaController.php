<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\tipo_cubierta;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoCubiertaController extends Controller
{
    /**
     * Despliega la lista de los tipos de cubiertas.
     */
    public function index()
    {
        try {
            $tipo_cubierta = tipo_cubierta::all();
            $result = $tipo_cubierta->map(function ($item) {
                return [
                'id' => $item->id,
                'nombre_cubierta' => $item->nombre_cubierta,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de cubiertas', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los tipos de cubiertas: '.$e->getMessage(), 500);
        }
    }

    /**
     * Crear tipo de cubierta.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_cubierta' => 'required|string|max:50'
            ]);
            $existeTCubierta = tipo_cubierta::where($data)->exists();
            if ($existeTCubierta) {
                return ApiResponse::error('Este tipo de cubierta ya existe', 422);
            }

            $tipo_cubierta = tipo_cubierta::create($data);
            return ApiResponse::success('Tipo de cubierta creada exitosamente', 201, $tipo_cubierta);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el tipo de cubierta: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra un tipo de cubierta.
     */
    public function show($id)
    {
        try {
            $tipo_cubierta = tipo_cubierta::findOrFail($id);
            $result = [
                'id' => $tipo_cubierta->id,
                'nombre_cubierta' => $tipo_cubierta->nombre_cubierta,
                'created_at' => $tipo_cubierta->created_at,
                'updated_at' => $tipo_cubierta->updated_at,
            ];
            return ApiResponse::success('Cubierta obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de cubierta no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el tipo de cubierta: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un tipo de cubierta.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nombre_cubierta' => 'required|string|max:50'
            ]);

            $existeTCubierta = tipo_cubierta::where($data)->exists();
            if ($existeTCubierta) {
                return ApiResponse::error('Este tipo de cubierta ya existe', 422);
            }

            $tipo_cubierta = tipo_cubierta::findOrFail($id);
            $tipo_cubierta->update($data);
            return ApiResponse::success('Cubierta actualizada exitosamente', 200, $tipo_cubierta);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de cubierta no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el tipo de cubierta: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un tipo de cubierta.
     */
    public function destroy($id)
    {
        try {
            $tipo_cubierta = tipo_cubierta::findOrFail($id);
            $tipo_cubierta->delete();
            return ApiResponse::success('Cubierta eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de cubierta no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la cubierta: ' .$e->getMessage(), 500);
        }
    }
}
