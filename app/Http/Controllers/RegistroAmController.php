<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_am;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroAmController extends Controller
{
    /**
     * Desplegar lista acuacultores morales.
     */
    public function index()
    {
        try {
            $am = registro_am::all();
            $result = $am->map(function ($item) {
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
            return ApiResponse::success('Lista de acuicultores morales', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de acuicultores morales: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crear acuacultor mora.
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
            $existeAM = registro_am::where($data)->exists();
            if ($existeAM) {
                return ApiResponse::error('El acuicultor moral ya esta registrado.', 422);
            }

            $am = registro_am::create($data);
            return ApiResponse::success('El acuicultor moral fue creado exitosamente', 201, $am);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear al acuicultor moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Mostrar un acuacultor moral.
     */
    public function show($id)
    {
        try {
            $am = registro_am::findOrFail($id);
            $result = [
                'id' => $am->id,
                'oficregis_id' => $am->oficinas->id,
                'razon_social' => $am->razon_social,
                'RFC' => $am->RFC,
                'CURP' => $am->CURP,
                'usuario' => $am->usuario,
                'password' => $am->password,
                'email' => $am->email,
                'tipo_actividad' => $am->tipo_actividad ? 'Pescador' : 'Acuicultor',
                'tipo_persona' => $am->tipo_persona ? 'Fisica' : 'Moral',
                'created_at' => $am->created_at,
                'updated_at' => $am->updated_at,
            ];
            return ApiResponse::success('Acuicultor moral obtenudo existosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Acuicultor moral no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener al acuicultor moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualizar acuacultor moral.
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

            $existeAM = registro_am::where($data)->exists();
            if ($existeAM) {
                return ApiResponse::error('El acuicultor moral ya esta registrado.', 422);
            }

            $am = registro_am::findOrFail($id);
            $am->update($data);
            return ApiResponse::success('El acuicultor moral se actualizo exitosamente', 200, $am);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Acuicultor moral no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar al acuicultor moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Borrar acuacultor morales.
     */
    public function destroy($id)
    {
        try {
            $am = registro_am::findOrFail($id);
            $am->delete();
            return ApiResponse::success('Acuicultor moral eliminado exitosamente', 200, $am);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Acuicultor moral no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar al acuicultor moral: ' .$e->getMessage(), 500);
        }
    }
}
