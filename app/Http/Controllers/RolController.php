<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\rol;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RolController extends Controller
{
    /**
     * Mostrar roles
     */
    public function index()
    {
        try{
            $roles = rol::all();
            $result = $roles->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tipo_rol' => $item->tipo_rol,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de roles', 200, $result);
        } catch (Exception $e){
            return ApiResponse::error('Error al obtener la lista de roles: '.$e->getMessage(), 500);
        }
    }

    /**
     * crear un rol
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'tipo_rol' => 'required|string|max:50'
            ]);
            $existeRol = rol::where($data)->exists();
            if ($existeRol) {
                return ApiResponse::error('El rol ya existe', 422);
            }

            $Rol = rol::create($data);
            return ApiResponse::success('Rol creado exitosamente', 201, $Rol);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: '. $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el rol: '. $e->getMessage(), 500);
        }
    }

    /**
     * mostrar rol
     */
    public function show($id)
    {
        try {
            $rol = rol::findOrFail($id);
            $result = [
                'id' => $rol->id,
                'tipo_rol' => $rol->created_at,
                'updated_at' => $rol->updated_at,
            ];
            return ApiResponse::success('Rol obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Rol no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el rol: ' .$e->getMessage(), 500);
        }
    }

    /**
     * actualizar rol
     */
    public function update(Request $request, $id)
    {
        try {

            $data = $request->validate([
                'tipo_rol' => 'required|string|max:50'
            ]);

            $existeRol = rol::where($data)->exists();
            if ($existeRol) {
                return ApiResponse::error('El rol ya existe', 422);
            }

            $rol = rol::findOrFail($id);
            $rol->update($data);
            return ApiResponse::success('Rol actualizado exitosamente', 200, $rol);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Rol no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualiar el rol: ' .$e->getMessage(), 500);
        }
    }

    /**
     * borrar rol
     */
    public function destroy($id)
    {
        try {
            $rol = rol::findOrFail($id);
            $rol->delete();
            return ApiResponse::success('Rol eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Rol no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el rol: ' .$e->getMessage(), 500);
        }
    }
}
