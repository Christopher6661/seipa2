<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\distrito;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DistritoController extends Controller
{
    /**
     * Desplegar la lista de los distritos
     */
    public function index()
    {
        try {
            $distritos = distrito::all();
            $result = $distritos->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre_distrito' => $item->nombre_distrito,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de distritos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de distritos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crear un distrito.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_distrito' => 'required|string|max:40'
            ]);
            $existeDistrito = distrito::where($data)->exists();
            if ($existeDistrito) {
                return ApiResponse::error('El distrito ya existe', 422);
            }

            $distrito = distrito::create($data);
            return ApiResponse::success('Distrito creado exitosamente', 201, $distrito);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el distrito: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Mostrar un distrito.
     */
    public function show($id)
    {
        try {
            $distrito = distrito::findOrFail($id);
            $result = [
                'id' => $distrito->id,
                'nombre_distrito' => $distrito->nombre_distrito,
                'updated_at' => $distrito->updated_at,
            ];
            return ApiResponse::success('Distrito obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Distrito no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el distrito: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualizar un distrito.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nombre_distrito' => 'required|string|max:40'
            ]);

            $existeDistrito = distrito::where($data)->exists();
            if ($existeDistrito) {
                return ApiResponse::error('El distrito ya existe', 422);
            }
            
            $distrito = distrito::findOrFail($id);
            $distrito->update($data);
            return ApiResponse::success('Distrito actualizado exitosamente', 200, $distrito);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Distrito no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el distrito: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Eliminar un distrito.
     */
    public function destroy($id)
    {
        try {
            $distrito = distrito::findOrFail($id);
            $distrito->delete();
            return ApiResponse::success('Distrito eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Distrito no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el distrito: ' .$e->getMessage(), 500);
        }
    }
}
