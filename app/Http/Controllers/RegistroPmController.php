<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_pm;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroPmController extends Controller
{
    /**
     * Mostrar lista de pescadores morales.
     */
    public function index() 
    {
        try {
            $pm = registro_pm::all();
            $result = $pm->map(function ($item) {
              return [
                'id' => $item->id,
                'oficregis_id' => $item->oficinas->id,
                'razon_social' => $item->razon_social,
                'RFC' => $item->RFC,
                'CURP' => $item->CURP,
                'usuario' => $item->usuario,
                'password' => $item->password,
                'email' => $item->email,
                'tipo_actividad' => $item->tipo_actividad ? 'Pescador' : 'Acuicultor',
                'tipo_persona' => $item->tipo_persona ? 'Fisica' : 'Moral',
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
              ];
            });
            return ApiResponse::success('Lista de pescadores morales', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de pescadores morales: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crear pescador moral.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'oficregis_id' => 'required|exists:oficinas,id',
                'razon_social' => 'required|string|max:40',
                'RFC' => 'required|string|max:12',
                'CURP' => 'required|string|max:18',
                'usuario' => 'required|string|max:30',
                'password' => 'required|string|max:8',
                'email' => 'required|string|max:40',
                'tipo_actividad' => 'required|boolean',
                'tipo_persona' => 'required|boolean'
            ]);
            $existePM = registro_pm::where($data)->exists();
            if ($existePM) {
                return ApiResponse::error('El pescador moral ya esta registrado.', 422);
            }

            $pm = registro_pm::create($data);
            return ApiResponse::success('El pescador moral fue creado exitosamente', 201, $pm);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el pescador moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra un pescador moral.
     */
    public function show($id)
    {
        try {
            $pm = registro_pm::findOrFail($id);
            $result = [
                'id' => $pm->id,
                'oficregis_id' => $pm->oficinas->id,
                'razon_social' => $pm->razon_social,
                'RFC' => $pm->RFC,
                'CURP' => $pm->CURP,
                'usuario' => $pm->usuario,
                'password' => $pm->password,
                'email' => $pm->email,
                'tipo_actividad' => $pm->tipo_actividad ? 'Pescador' : 'Acuicultor',
                'tipo_persona' => $pm->tipo_persona ? 'Fisica' : 'Moral',
                'created_at' => $pm->created_at,
                'updated_at' => $pm->updated_at,
            ];
            return ApiResponse::success('Pescador moral obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Pescador moral no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener al pescador moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza pescador moral.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'oficregis_id' => 'required',
                'razon_social' => 'required|string|max:40',
                'RFC' => 'required|string|max:12',
                'CURP' => 'required|string|max:18',
                'usuario' => 'required|string|max:30',
                'password' => 'required|string|max:8',
                'email' => 'required|string|max:40',
                'tipo_actividad' => 'required|boolean',
                'tipo_persona' => 'required|boolean'
            ]);

            $existePM = registro_pm::where($data)->exists();
            if ($existePM) {
                return ApiResponse::error('El pescador moral ya esta registrado.', 422);
            }

            $pm = registro_pm::findOrFail($id);
            $pm->update($data);
            return ApiResponse::success('El pescador moral se actualizo exitosamente', 200, $pm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Pescador moral no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el pescador moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina pescador moral.
     */
    public function destroy($id)
    {
        try {
            $pm = registro_pm::findOrFail($id);
            $pm->delete();
            return ApiResponse::success('Pescador moral eliminado exitosamente', 200, $pm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Pescador moral no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar al pescador moral: ' .$e->getMessage(), 500);
        }
    }
}
