<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\TipoEqManejo;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoEqManejoController extends Controller
{
    /**
     * Despliega la lista de los tipos de equipos de manejo.
     */
    public function index()
    {
        try {
            $TiposEqManejo = TipoEqManejo::all();
            $result = $TiposEqManejo->map(function ($item){
                return [
                    'id' => $item->id,
                    'tipo_eqmanejo' => $item->tipo_eqmanejo,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de tipos de equipos de manejo', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los tipos de equipos de manejo: '.$e->getMessage(), 500);
        }
    }

    /**
     * Crea un nuevo tipo de equipo de manejo.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'tipo_eqmanejo' => 'required|string|max:50'
            ]);
            $existeTEqManejo = TipoEqManejo::where($data)->exists();
            if ($existeTEqManejo) {
                return ApiResponse::error('Este tipo de equipo de manejo ya existe', 422);
            }

            $TiposEqManejo = TipoEqManejo::create($data);
            return ApiResponse::success('Tipo de sistema de conservación creado exitosamente', 201, $TiposEqManejo);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el tipo de equipo de manejo: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de un tipo de equipo de manejo.
     */
    public function show($id)
    {
        try {
            $TiposEqManejo = TipoEqManejo::findOrFail($id);
            $result = [
                'id' => $TiposEqManejo->id,
                'tipo_eqmanejo' => $TiposEqManejo->tipo_eqmanejo,
                'created_at' => $TiposEqManejo->created_at,
                'updated_at' => $TiposEqManejo->updated_at,
            ];
            return ApiResponse::success('Tipo de equipo de manejo obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de equipo de manejo no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el tipo de equipo de manejo: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un tipo de equipo de manejo.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'tipo_eqmanejo' => 'required|string|max:50'
            ]);

            $existeTEqManejo = TipoEqManejo::where($data)->exists();
            if ($existeTEqManejo) {
                return ApiResponse::error('Este tipo de equipo de manejo ya existe', 422);
            }

            $TiposEqManejo = TipoEqManejo::findOrFail($id);
            $TiposEqManejo->update($data);
            return ApiResponse::success('Tipo de equipo de manejo actualizado exitosamente', 200, $TiposEqManejo);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de equipo de manejo no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el tipo de equipo de manejo: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un tipo de equipo de manejo.
     */
    public function destroy($id)
    {
        try {
            $TiposEqManejo = TipoEqManejo::findOrFail($id);
            $TiposEqManejo->delete();
            return ApiResponse::success('Tipo de equipo de operación eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de equipo de manejo no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el tipo de equipo de manejo: ' .$e->getMessage(), 500);
        }
    }
}
