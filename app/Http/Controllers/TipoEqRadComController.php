<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\TipoEqRadCom;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoEqRadComController extends Controller
{
    /**
     * Despliega la lista de los tipos de  equipos de radio-comunicación.
     */
    public function index()
    {
        try {
            $TipoEqRadCom = TipoEqRadCom::all();
            $result = $TipoEqRadCom->map(function ($item){
                return [
                    'id' => $item->id,
                    'tipo_radiocom' => $item->tipo_radiocom,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de tipos de equipos de radio-comunicación', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los tipos de equipos de radio-comunicación: '.$e->getMessage(), 500);
        }
    }

    /**
     * Crea un tipo de equipo de radio-comunicación.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'tipo_radiocom' => 'required|string|max:50'
            ]);
            $existeTipoEqRadCom = TipoEqRadCom::where($data)->exists();
            if ($existeTipoEqRadCom) {
                return ApiResponse::error('Este tipo de equipo de radio-comunicación ya existe', 422);
            }

            $TipoEqRadCom = TipoEqRadCom::create($data);
            return ApiResponse::success('Tipo de equipo de radio-comunicación creado exitosamente', 201, $TipoEqRadCom);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el tipo de equipo de radio-comunicación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de un tipo de equipo de radio-comunicación.
     */
    public function show($id)
    {
        try {
            $TipoEqRadCom = TipoEqRadCom::findOrFail($id);
            $result = [
                'id' => $TipoEqRadCom->id,
                'tipo_radiocom' => $TipoEqRadCom->tipo_radiocom,
                'created_at' => $TipoEqRadCom->created_at,
                'updated_at' => $TipoEqRadCom->updated_at,
            ];
            return ApiResponse::success('Tipo de equipo de radio-comunicación obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de equipo de radio-comunicación no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el tipo de equipo de radio-comunicación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un tipo de equipo de radio-comunicación.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'tipo_radiocom' => 'required|string|max:50'
            ]);

            $existeTipoEqRadCom = TipoEqRadCom::where($data)->exists();
            if ($existeTipoEqRadCom) {
                return ApiResponse::error('Este tipo de equipo de radio-comunicación ya existe', 422);
            }

            $TipoEqRadCom = TipoEqRadCom::findOrFail($id);
            $TipoEqRadCom->update($data);
            return ApiResponse::success('Tipo de equipo de radio-comunicación actualizado exitosamente', 200, $TipoEqRadCom);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de equipo de radio-comunicación no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el tipo de equipo de radio-comunicación: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un tipo de equipo de radio-comunicación.
     */
    public function destroy($id)
    {
        try {
            $TipoEqRadCom = TipoEqRadCom::findOrFail($id);
            $TipoEqRadCom->delete();
            return ApiResponse::success('Tipo de equipo de radio-comunicación eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de equipo de radio-comunicación no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el tipo de equipo de radio-comunicación: ' .$e->getMessage(), 500);
        }
    }
}
