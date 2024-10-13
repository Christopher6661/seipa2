<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_adminprod_AM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroAdminprodAMController extends Controller
{
    /**
     *  Despliega la lista de los registros de administracion de producción.
     */
    public function index()
    {
        try {
            $registroAdminProdAM = registro_adminprod_AM::all();
            $result = $registroAdminProdAM->map(function ($item){
                return [
                    'id' => $item->id,
                    'num_familias' => $item->num_familias,
                    'num_mujeres' => $item->num_mujeres,
                    'num_hombres' => $item->num_hombres,
                    'total_integrantes' => $item->total_integrantes,
                    'tipo_tenencia_ua' => $item->tipo_tenencia_ua,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los registros de administración de producción', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los registros de administración de produccón: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un registro de administración de producción.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'num_familias' => 'required|integer',
                'num_mujeres' => 'required|integer',
                'num_hombres' => 'required|integer',
                'total_integrantes' => 'required|integer',
                'tipo_tenencia_ua' => 'required|string|max:200',
            ]);

            $registroAdminProdAM = registro_adminprod_AM::create($data);
            return ApiResponse::success('Registro de administración de producción creado exitosamente', 201, $registroAdminProdAM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el registro de administracón de la produccón: ', 500);
        }
    }

    /**
     * Muestra un registro de administración de producción.
     */
    public function show($id)
    {
        try {
            $registroAdminProdAM = registro_adminprod_AM::findOrFail($id);
            $result = [
                'id' => $registroAdminProdAM->id,
                'num_familias' => $registroAdminProdAM->num_familias,
                'num_mujeres' => $registroAdminProdAM->num_mujeres,
                'num_hombres' => $registroAdminProdAM->num_hombres,
                'total_integrantes' => $registroAdminProdAM->total_integrantes,
                'tipo_tenencia_ua' => $registroAdminProdAM->tipo_tenencia_ua,
                'created_at' => $registroAdminProdAM->created_at,
                'updated_at' => $registroAdminProdAM->updated_at,
            ];
            return ApiResponse::success('Registro de administración de producción obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Registro de administración de producción no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el registro de administración de producción: ', 500);
        }
    }

    /**
     * Actualiza un registro de administración de producción.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'num_familias' => 'required|integer',
                'num_mujeres' => 'required|integer',
                'num_hombres' => 'required|integer',
                'total_integrantes' => 'required|integer',
                'tipo_tenencia_ua' => 'required|string|max:200',
            ]);

            $registroAdminProdAM = registro_adminprod_AM::findOrFail($id);
            $registroAdminProdAM->update($data);
            return ApiResponse::success('El registro de administración de producción se actualizo correctamente', 200);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Registro de administración de producción no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el registro de administración de producción: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un registro de administración de producción.
     */
    public function destroy($id)
    {
        try {
            $registroAdminProdAM = registro_adminprod_AM::findOrFail($id);
            $registroAdminProdAM->delete();
            return ApiResponse::success('Registro de la administración de producción eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Registro de administración de producción no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el registro de la administración de producción ', 500);
        }
    }
}
