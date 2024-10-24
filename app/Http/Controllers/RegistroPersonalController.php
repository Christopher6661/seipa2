<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_personal;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroPersonalController extends Controller
{
    /**
     * Lista personal
     */
    public function index()
    {
        try {
            $personal = registro_personal::all();
            $result = $personal->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombres' => $item->nombres,
                    'apellido_pa' => $item->apellido_pa,
                    'apellido_ma' => $item->apellido_ma,
                    'usuario' => $item->usuario,
                    'telefono_prin' => $item->telefono_prin,
                    'telefono_secun' => $item->telefono_secun,
                    'email' => $item->email,
                    'password' => $item->password,
                    'rol_id' => $item->rol->id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista del personal de registro', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista del personal: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crear personal
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombres' => 'required|string|max:40',
                'apellido_pa' => 'required|string|max:40',
                'apellido_ma' => 'required|string|max:40',
                'usuario' => 'required|string|max:30',
                'telefono_prin' => 'required|string|max:10',
                'telefono_secun' => 'required|string|max:10',
                'email' => 'required|string|max:40',
                'password' => 'required|string|max:8',
                'rol_id' => 'required|exists:roles,id'
            ]);
            $existePersonal = registro_personal::where($data)->exists();
            if ($existePersonal) {
                return ApiResponse::error('El personal ya esta registrado.', 422);
            }

            $personal = registro_personal::create($data);
            return ApiResponse::success('El personal fue creado exitosamente', 201, $personal);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el personal: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Mostrar un personal
     */
    public function show($id)
    {
        try {
            $personal = registro_personal::findOrFail($id);
            $result = [
                'id' => $personal->id,
                'nombres' => $personal->nombres,
                'apellido_pa' => $personal->apellido_pa,
                'apellido_ma' => $personal->apellido_ma,
                'usuario' => $personal->usuario,
                'telefono_prin' => $personal->telefono_prin,
                'telefono_secun' => $personal->telefono_secun,
                'email'=> $personal->email,
                'password' => $personal->password,
                'rol_id' => $personal->roles->id,
            ];
            return ApiResponse::success('Personal de registro obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Personal de registro no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener al personal de registro: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualizar personal.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nombres' => 'required|string|max:40',
                'apellido_pa' => 'required|string|max:40',
                'apellido_ma' => 'required|string|max:40',
                'usuario' => 'required|string|max:30',
                'telefono_prin' => 'required|string|max:10',
                'telefono_secun' => 'required|string|max:10',
                'email' => 'required|string|max:40',
                'password' => 'required|string|max:8',
                'rol_id' => 'required'
            ]);

            $existePersonal = registro_personal::where($data)->exists();
            if ($existePersonal) {
                return ApiResponse::error('El personal ya esta registrado.', 422);
            }

            $personal = registro_personal::findOrFail($id);
            $personal->update($data);
            return ApiResponse::success('El personal de registro se actualizo exitosamente', 200, $personal);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Personal no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el personal de registro: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Eliminar personal.
     */
    public function destroy($id)
    {
        try {
            $personal = registro_personal::findOrFail($id);
            $personal->delete();
            return ApiResponse::success('Personal de registro eliminado exitosamente', 200, $personal);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Personal no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar al personal de registro: ' .$e->getMessage(), 500);
        }
    }
}
