<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_af;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroAfController extends Controller
{
    /**
     * Desplegar lista de acuacultores fisicos.
     */
    public function index()
    {
        try {
            $af = registro_af::all();
            $result = $af->map(function ($item) {
                return [
                    'id' => $item->id,
                    'oficregis_id' => $item->oficinas->id,
                    'nombres' => $item->nombres,
                    'apellido_pa' => $item->apellido_pa,
                    'apellido_ma' => $item->apellido_ma,
                    'usuario' => $item->usuario,
                    'password' => $item->password,
                    'email' => $item->email,
                    'tipo_actividad' => $item->tipo_actividad ? 'Pescador' : 'Acuicultor',
                    'tipo_persona' => $item->tipo_persona ? 'Fisica' : 'Moral',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de acuacultores fisicos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de acuacultores fisicos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crear acuacultor fisico.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'oficregis_id' => 'required|exists:oficinas,id',
                'nombres' => 'required|string|max:40',
                'apellido_pa' => 'required|string|max:40',
                'apellido_ma' => 'required|string|max:40',
                'usuario' => 'required|string|max:30',
                'password' => 'required|string|max:8',
                'email' => 'required|string|max:40',
                'tipo_actividad' => 'required|boolean',
                'tipo_persona' => 'required|boolean'
            ]);
            $existeAF = registro_af::where($data)->exists();
            if ($existeAF) {
                return ApiResponse::error('El acuicultor fisico ya esta registrado.', 422);
            }

            $af = registro_af::create($data);
            return ApiResponse::success('El acuicultor fisico fue creado existosamente', 201, $af);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear al acuicultor fisico: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Mostrar un acuacultor fisico.
     */
    public function show($id)
    {
        try {
            $af = registro_af::findOrFail($id);
            $result = [
                'id' => $af->id,
                'oficregis_id' => $af->oficinas->id,
                'nombres' => $af->nombres,
                'apellido_pa' => $af->apellido_pa,
                'apellido_ma' => $af->apellido_ma,
                'usuario' => $af->usuario,
                'password' => $af->password,
                'email' => $af->email,
                'tipo_actividad' => $af->tipo_actividad ? 'Pescador' : 'Acuicultor',
                'tipo_persona' => $af->tipo_persona ? 'Fisica' : 'Moral',
                'created_at' => $af->created_at,
                'updated_at' => $af->updated_at,
            ];
            return ApiResponse::success('Acuicultor fisico obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Acuicultor fisico no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener al acuicultor fisico: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualizar acuacultor fisico.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
            'oficregis_id' => 'required',
            'nombres' => 'required|string|max:40',
            'apellido_pa' => 'required|string|max:40',
            'apellido_ma' => 'required|string|max:40',
            'usuario' => 'required|string|max:30',
            'password' => 'required|string|max:8',
            'email' => 'required|string|max:40',
            'tipo_actividad' => 'required|boolean',
            'tipo_persona' => 'required|boolean'
            ]);

            $existeAF = registro_af::where($data)->exists();
            if ($existeAF) {
                return ApiResponse::error('El acuicultor fisico ya esta registrado.', 422);
            }

            $af = registro_af::findOrFail($id);
            $af->update($data);
            return ApiResponse::success('El acuicultor fisico se actualizo exitosamente', 200, $af);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Acuicultor fisico no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar al acuicultor fisico: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Eliminar acuacultor fisico.
     */
    public function destroy($id)
    {
        try {
            $af = registro_af::findOrFail($id);
            $af->delete();
            return ApiResponse::success('Acuicultor fisico eliminado exitosamente', 200, $af);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Acuicultor fisico no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar al acuicultor fisico: ' .$e->getMessage(), 500);
        }
    }
}
