<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\oficina;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OficinaController extends Controller
{
    /**
     * Mostrar oficinas
     */
    public function index()
    {
        try {
            $oficinas = oficina::all();
            $result = $oficinas->map(function ($item) {
              return [
                'id' => $item->id,
                'nombre_oficina' => $item->nombre_oficina,
                'ubicacion' => $item->ubicacion,
                'telefono' => $item->telefono,
                'email' => $item->email,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
              ]; 
            });
            return ApiResponse::success('Lista de oficinas', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de oficinas: ' .$e->getMessage(), 500 );
        }
    }

    /**
     * Crear una oficina
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre_oficina' => 'required|string|max:50',
                'ubicacion' => 'required|string|max:50',
                'telefono' => 'required|string|max:10',
                'email' => 'required|string|max:40'
            ]);
            
            $existeOficina = oficina::where(function ($query) use ($data) {
                $query->where('nombre_oficina', $data['nombre_oficina'])
                ->orWhere('telefono', $data['telefono'])
                ->orWhere('email', $data['email']);
            })->first();

            if ($existeOficina) {
                $errors = [];
                if ($existeOficina->telefono === $data['telefono']) {
                    $errors['telefonlo'] = 'el número de telefono ya esta registrado.';
                }
                if ($existeOficina->email === $data['email']) {
                    $errors['email'] = 'El correo electrónico ya esta registrado.';
                }
                return ApiResponse::error('La oficina ya existe', 422, $errors);
            }
            $oficina = oficina::create($data);
            return ApiResponse::success('Oficina creada exitosamente', 201, $oficina);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422);
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la oficina: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Mostrar una oficina
     */
    public function show($id)
    {
        try {
            $oficina = oficina::findOrFail($id);
            $result = [
                'id' => $oficina->id,
                'nombre_oficina' => $oficina->nombre_oficina,
                'ubicacion' => $oficina->ubicacion,
                'telefono' => $oficina->telefono,
                'email' => $oficina->email,
                'created_at' => $oficina->created_at,
                'updated_at' => $oficina->updated_at,
            ];
            return ApiResponse::success('Oficina obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Oficina no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la oficina: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualizar oficina
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'nombre_oficina' => 'required|string|max:50',
                'ubicacion' => 'required|string|max:100',
                'telefono' => 'required|string|max:10',
                'email' => 'required|string|max:40'
            ]);

            $existeOficina = oficina::where(function ($query) use ($data, $id) {
                $query->where('nombre_oficina', $data['nombre_oficina'])
                ->orWhere('telefono', $data['telefono'])
                ->orWhere('email', $data['email']);
            })->where('id', '!=', $id)->first();

            if ($existeOficina) {
                $errors = [];
                if ($existeOficina->telefono === $request->telefono) {
                    $errors['telefono'] = 'El número de telefono ya esta registrado.';
                }
                if ($existeOficina->email === $request->email) {
                    $errors['email'] = 'El correo electrónico ya esta registrado.';
                }
                return ApiResponse::error('La oficina ya existe', 422, $errors);
            }
            $oficina = oficina::findOrFail($id);
            $oficina->update($data);

            return ApiResponse::success('Oficina actualizada exitosamente', 200, $oficina);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Oficina no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la oficina: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Borrar Oficina
     */
    public function destroy($id)
    {
        try {
            $oficina = oficina::findOrFail($id);
            $oficina->delete();
            return ApiResponse::success('Oficina eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Oficina no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la oficina: ' .$e->getMessage(), 500);
        }
    }
}
