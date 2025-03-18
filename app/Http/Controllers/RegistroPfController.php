<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_pf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroPfController extends Controller
{
    /**
     * Mostrar liste de pescadores fisicos.
     */
    public function index()
    {
        try {
            $pf = registro_pf::all();
            $result = $pf->map(function ($item) {
                return [
                    'id' => $item->id,
                    'oficregis_id' => $item->oficinas->nombre_oficina,
                    'nombres' => $item->nombres,
                    'apellido_pa' => $item->apellido_pa,
                    'apellido_ma' => $item->apellido_ma,
                    'usuario' => $item->usuario,
                    'password' => $item->password,
                    'email' => $item->email,
                    'tipo_actividad' => $item->tipo_actividad ? '1' : '0',
                    'tipo_persona' => $item->tipo_persona ? '1' : '0',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de pescadores fisicos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de pescadores fisicos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crear pescador fisico.
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
                'email' => 'required|string|email|max:40', 
                'tipo_actividad' => 'required|boolean',
                'tipo_persona' => 'required|boolean'
            ]);
    
            $usuarioExiste = registro_pf::where('usuario', $data['usuario'])->exists();
            $emailExiste = registro_pf::where('email', $data['email'])->exists();
    
            if ($usuarioExiste && $emailExiste) {
                return ApiResponse::error('El nombre de usuario y el correo electrónico ya están en uso.', 422);
            } elseif ($usuarioExiste) {
                return ApiResponse::error('El nombre de usuario ya está en uso.', 422);
            } elseif ($emailExiste) {
                return ApiResponse::error('El correo electrónico ya está en uso.', 422);
            }
    
            $pf = registro_pf::create($data);
            return ApiResponse::success('El pescador físico fue creado exitosamente', 201, $pf);
            
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el pescador físico: ' .$e->getMessage(), 500);
        }
    }
    

    /**
     * Mostrar un Pescador fisico.
     */
    public function show($id)
    {
        try {
            $pf = registro_pf::findOrFail($id);
            $result = [
                'id' => $pf->id,
                'oficregis_id' => $pf->oficinas->id,
                'nombres' => $pf->nombres,
                'apellido_pa' => $pf->apellido_pa,
                'apellido_ma' => $pf->apellido_ma,
                'usuario' => $pf->usuario,
                'password' => $pf->password,
                'email' => $pf->email,
                'tipo_actividad' => $pf->tipo_actividad ? 'Pescador' : 'Acuicultor',
                'tipo_persona' => $pf->tipo_persona ? 'Fisica' : 'Moral',
                'created_at' => $pf->created_at,
                'updated_at' => $pf->updated_at,
            ];


            return ApiResponse::success('Pescador fisico obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Pescador fisico no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener al pescador fisico: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualizar pescador fisico.
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
            
            $usuarioExiste = registro_pf::where('usuario', $data['usuario'])->where('id', '!=', $id)->exists();
            $emailExiste = registro_pf::where('email', $data['email'])->where('id', '!=', $id)->exists();
    
            if ($usuarioExiste && $emailExiste) {
                return ApiResponse::error('El nombre de usuario y el correo electrónico ya están en uso.', 422);
            } elseif ($usuarioExiste) {
                return ApiResponse::error('El nombre de usuario ya está en uso.', 422);
            } elseif ($emailExiste) {
                return ApiResponse::error('El correo electrónico ya está en uso.', 422);
            }
    
            $pf = registro_pf::findOrFail($id);
            $pf->update($data);
            return ApiResponse::success('El pescador fisico se actualizo exitosamente', 200, $pf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Pescador fisico no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el pescador fisico: ' . $e->getMessage(), 500);
        }
    }
    

    /**
     * Eliminar pescador fisico.
     */
    public function destroy($id)
    {
        try {
            $pf = registro_pf::findOrFail($id);
            $pf->delete();
            return ApiResponse::success('Pescador fisico eliminado exitosamente', 200, $pf);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Pescador fisico no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar al pescador fisico: ' .$e->getMessage(), 500);
        }
    }
}
