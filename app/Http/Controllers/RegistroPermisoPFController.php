<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_permiso_PF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroPermisoPFController extends Controller
{
    /**
     * Despliega la lista de los permisos.
     */
    public function index()
    {
        try {
            $permisosPF = registro_permiso_PF::all();
            $result = $permisosPF->map(function ($item) {
                return [
                    'id' => $item->id,
                    'userprofile_id' => $item->perfil_usuario->name,
                    'folio_permiso' => $item->folio_permiso,
                    'pesqueria' => $item->pesqueria,
                    'vigencia_permiso_ini' => $item->vigencia_permiso_ini,
                    'vigencia_permiso_fin' => $item->vigencia_permiso_fin,
                    'RNPA' => $item->RNPA,
                    'tipo_permiso_id' => $item->permiso->nombre_permiso,
                    'tipo_embarcacion' => $item->tipo_embarcacion ? 'Mayor' : 'Menor',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los permisos de pescador fisico', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los permisos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un permiso.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required|exists:users,id',
                'folio_permiso' => 'required|string|max:12',
                'pesqueria' => 'required|string|max:40',
                'vigencia_permiso_ini' => 'required|date',
                'vigencia_permiso_fin' => 'required|date',
                'RNPA' => 'required|string|max:50',
                'tipo_permiso_id' => 'required|exists:tipo_permisos,id',
                'tipo_embarcacion' => 'required|in:Mayor,Menor'
            ]);

            $existeFolio = registro_permiso_PF::where('folio_permiso', $data['folio_permiso'])->first();
            if ($existeFolio) {
                return ApiResponse::error('El folio de permiso ya está en uso.', 422);
            }
           
            $permisosPF = registro_permiso_PF::create($data);
            return ApiResponse::success('Permiso creado exitosamente', 201, $permisosPF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el permiso para el pescador físico: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Muestra un permiso.
     */
    public function show($id)
    {
        try {
            $permisosPF = registro_permiso_PF::findOrFail($id);
            $result = [
                'id' => $permisosPF->id,
                'userprofile_id' => $permisosPF->perfil_usuario->id,
                'folio_permiso' => $permisosPF->folio_permiso,
                'pesqueria' => $permisosPF->pesqueria,
                'vigencia_permiso_ini' => $permisosPF->vigencia_permiso_ini,
                'vigencia_permiso_fin' => $permisosPF->vigencia_permiso_fin,
                'RNPA' => $permisosPF->RNPA,
                'tipo_permiso_id' => $permisosPF->permiso->id,
                'tipo_embarcacion' => $permisosPF->tipo_embarcacion == 'Mayor' ? 'Mayor' : 'Menor',
                'created_at' => $permisosPF->created_at,
                'updated_at' => $permisosPF->updated_at,
            ];

            return ApiResponse::success('Permiso de pescador fisico obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el permiso: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un permiso.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'userprofile_id' => 'required',
                'folio_permiso' => 'required|string|max:12',
                'pesqueria' => 'required|string|max:40',
                'vigencia_permiso_ini' => 'required|date',
                'vigencia_permiso_fin' => 'required|date',
                'RNPA' => 'required|string|max:50',
                'tipo_permiso_id' => 'required',
                'tipo_embarcacion' => 'required|in:Mayor,Menor'
            ]);

            /*$existepermisoPF = registro_permiso_PF::where('folio_permiso', $request->folio_permiso)->first();
            if ($existepermisoPF) {
                return ApiResponse::error('Este permiso para pescador fisico ya existe', 422);
            } */

            $existepermisoPF = registro_permiso_PF::where('folio_permiso', $request->folio_permiso)
            ->where('id', '!=', $id)->first();
            if ($existepermisoPF) {
                return ApiResponse::error('EL folio de permiso ya esta en uso', 422);
            }

            $permisosPF = registro_permiso_PF::findOrFail($id);
            $permisosPF->update($request->all());
            return ApiResponse::success('Permiso actualizado exitosamente', 200, $permisosPF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el permiso: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina el permiso.
     */
    public function destroy($id)
    {
        try {
            $permisosPF = registro_permiso_PF::findOrFail($id);
            $permisosPF->delete();
            return ApiResponse::success('Permiso eliminado exitosamente', 200, $permisosPF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el permiso: ' .$e->getMessage(), 500);
        }
    }
}
