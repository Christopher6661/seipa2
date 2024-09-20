<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\municipio;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MunicipioController extends Controller
{
    /**
     * Desplegar la lista de los municipios.
     */
    public function index()
    {
        try {
            $municipios = municipio::all();
            $result = $municipios->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre_municipio' => $item->nombre_municipio,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de municipios', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de municipios: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crear un municipio.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_municipio' => 'required|string|max:40'
            ]);
            $existeMunicipio = municipio::where($data)->exists();
            if ($existeMunicipio) {
                return ApiResponse::error('El municipio ya existe', 422);
            }

            $municipio = municipio::create($data);
            return ApiResponse::success('Municipio creado exitosamente', 201, $municipio);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el municipio: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Mostrar un municipio.
     */
    public function show($id)
    {
        try {
            $municipio = municipio::findOrFail($id);
            $result = [
                'id' => $municipio->id,
                'nombre_municipio' => $municipio->nombre_municipio,
                'updated_at' => $municipio->updated_at,
            ];
            return ApiResponse::success('Municipio obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Municipio no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el municipio: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualizar municipio.
     */
    public function update(Request $request, $id)
    {
        try {

            $data = $request->validate([
                'nombre_municipio' => 'required|string|max:40'
            ]);

            $existeMunicipio = municipio::where($data)->exists();
            if ($existeMunicipio) {
                return ApiResponse::error('El municipio ya existe', 422);
            }

            $municipio = municipio::findOrFail($id);
            $municipio->update($data);
            return ApiResponse::success('Municipio actualizado exitosamente', 200, $municipio);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Municipio no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el municipio: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Eliminar municipio.
     */
    public function destroy($id)
    {
        try {
            $municipio = municipio::findOrFail($id);
            $municipio->delete();
            return ApiResponse::success('Municipio eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Municipio no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el municipio: ' .$e->getMessage(), 500);
        }
    }
}
