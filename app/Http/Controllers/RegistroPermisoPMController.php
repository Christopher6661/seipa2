<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_permiso_PM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroPermisoPMController extends Controller
{
    /**
     * Despliega la lista de los permisos del pescador moral.
     */
    public function index()
    {
        try {
            $permisoPM = registro_permiso_PM::all();
            $result = $permisoPM->map(function ($item) {
                return [
                    'id' => $item->id,
                    'folio_permiso' => $item->folio_permiso,
                    'pesqueria' => $item->pesqueria,
                    'vigencia_permiso_ini' => $item->vigencia_permiso_ini,
                    'vigencia_permiso_fin' => $item->vigencia_permiso_fin,
                    'RNPA' => $item->RNPA,
                    'tipo_permiso_id' => $item->permiso->nombre_permiso,
                    'tipo_emb' => $item->tipo_emb ? '1' : '0',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los permisos de pescador moral', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los permisos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un permiso para el pescador moral.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'folio_permiso' => 'required|string|max:12',
                'pesqueria' => 'required|string|max:40',
                'vigencia_permiso_ini' => 'required|date',
                'vigencia_permiso_fin' => 'required|date',
                'RNPA' => 'required|string|max:50',
                'tipo_permiso_id' => 'required|exists:tipo_permisos,id',
                'tipo_emb' => 'required|in:Mayor,Menor'
            ]);

            $existepermisoPM = registro_permiso_PM::where('folio_permiso', $data['folio_permiso'])->first();
            if ($existepermisoPM) {
                $errors = [];
                if ($existepermisoPM->folio_permiso === $data['folio_permiso']) {
                    $errors['folio_permiso'] = 'El folio para el permiso ya existe.';
                }
                return ApiResponse::error('El permiso ya existe', 422, $errors);
            }

            $permisoPM = registro_permiso_PM::create($data);
            return ApiResponse::success('Permiso creado exitosamente', 201, $permisoPM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el permiso para el pescador moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra un permiso del pescador moral.
     */
    public function show($id)
    {
        try {
            $permisoPM = registro_permiso_PM::findOrFail($id);
            $result = [
                'id' => $permisoPM->id,
                'folio_permiso' => $permisoPM->folio_permiso,
                'pesqueria' => $permisoPM->pesqueria,
                'vigencia_permiso_ini' => $permisoPM->vigencia_permiso_ini,
                'vigencia_permiso_fin' => $permisoPM->vigencia_permiso_fin,
                'RNPA' => $permisoPM->RNPA,
                'tipo_permiso_id' => $permisoPM->permiso->id,
                'tipo_emb' => $permisoPM->tipo_emb == 'Mayor' ? 'Mayor' : 'Menor',
                'created_at' => $permisoPM->created_at,
                'updated_at' => $permisoPM->updated_at,
            ];
            return ApiResponse::success('Permiso de pescador moral obtenido exitosamente', 200, $result); 
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el permiso: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza el permiso del pescador moral.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'folio_permiso' => 'required|string|max:12',
                'pesqueria' => 'required|string|max:40',
                'vigencia_permiso_ini' => 'required|date',
                'vigencia_permiso_fin' => 'required|date',
                'RNPA' => 'required|string|max:50',
                'tipo_permiso_id' => 'required',
                'tipo_emb' => 'required|in:Mayor,Menor'
            ]);

            $existepermisoPM = registro_permiso_PM::where('folio_permiso', $request->folio_permiso)
            ->where('id', '!=', $id)->first();
            if ($existepermisoPM) {
                return ApiResponse::error('EL folio de permiso ya esta en uso', 422);
            }

            $permisosPM = registro_permiso_PM::findOrFail($id);
            $permisosPM->update($request->all());
            return ApiResponse::success('Permiso actualizado exitosamente', 200, $permisosPM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el permiso: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina el permiso del pescador moral.
     */
    public function destroy($id)
    {
        try {
            $permisoPM = registro_permiso_PM::findOrFail($id);
            $permisoPM->delete();
            return ApiResponse::success('Permiso eliminado exitosamente', 200, $permisoPM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el permiso: ' .$e->getMessage(), 500);
        }
    }
}
