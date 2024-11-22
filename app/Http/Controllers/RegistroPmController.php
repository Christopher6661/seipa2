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
                'oficregis_id' => $item->oficinas->nombre_oficina,
                'razon_social' => $item->razon_social,
                'RFC' => $item->RFC,
                'CURP' => $item->CURP,
                'usuario' => $item->usuario,
                'password' => $item->password,
                'email' => $item->email,
                'tipo_actividad' => $item->tipo_actividad ? '1' : '0',
                'tipo_persona' => $item->tipo_persona ? '1' : '0',
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
                'email' => 'required|string|email|max:40', 
                'tipo_actividad' => 'required|boolean',
                'tipo_persona' => 'required|boolean'
            ]);
    
            $existeRFC = registro_pm::where('RFC', $data['RFC'])->exists();
            $existeCURP = registro_pm::where('CURP', $data['CURP'])->exists();
            $existeRazonsocial = registro_pm::where('razon_social', $data['razon_social'])->exists();
            $existeEmail = registro_pm::where('email', $data['email'])->exists();
            $exisUsuario = registro_pm::where('usuario', $data['usuario'])->exists();
            if ($existeRFC && $existeCURP && $existeRazonsocial && $existeEmail && $exisUsuario) {
                    return ApiResponse::error('El  RFC, CURP, Razon social, Email y el nombre de usuario ya están en uso.', 422);
            } elseif ($existeRFC) {
                    return ApiResponse::error('El RFC ya está en uso.', 422);
            } elseif ($existeCURP) {
                    return ApiResponse::error('El CURP ya está registrado.', 422);

            } elseif ($existeRazonsocial) {
                return ApiResponse::error('La razón social ya está registrada.', 422);
                
            } elseif ($existeEmail) {
                return ApiResponse::error('El correo electrónico ya en uso.', 422);
            } elseif ($exisUsuario) {
                return ApiResponse::error('El nombre de usuario ya está en uso.', 422);
            }
    
            $pm = registro_pm::create($data);
            return ApiResponse::success('El pescador moral fue creado exitosamente', 201, $pm);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el pescador moral: ' . $e->getMessage(), 500);
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
                'tipo_actividad' => $pm->tipo_actividad ? '1' : '0',
                'tipo_persona' => $pm->tipo_persona ? '1' : '0',
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
                'email' => 'required|email|max:40',
                'tipo_actividad' => 'required|boolean',
                'tipo_persona' => 'required|boolean'
            ]);
    
            $usuarioExiste = registro_pm::where('usuario', $data['usuario'])->where('id', '!=', $id)->exists();
            $emailExiste = registro_pm::where('email', $data['email'])->where('id', '!=', $id)->exists();
            $existeCURP = registro_pm::where('CURP', $data['CURP'])->where('id', '!=', $id)->exists();
            $existeRazonsocial = registro_pm::where('razon_social', $data['razon_social'])->where('id', '!=', $id)->exists();
            $existeRFC = registro_pm::where('RFC', $data['RFC'])->where('id', '!=', $id)->exists();

            if ($usuarioExiste && $emailExiste) {
                return ApiResponse::error('El nombre de usuario y el correo electrónico ya están en uso.', 422);
            } elseif ($usuarioExiste) {
                return ApiResponse::error('El nombre de usuario ya está en uso.', 422);
            } elseif ($emailExiste) {
                return ApiResponse::error('El correo electrónico ya está en uso.', 422);
            } elseif ($existeCURP) {
                return ApiResponse::error('El CURP ya está registrado.', 422);
            } elseif ($existeRazonsocial) {
                return ApiResponse::error('La razón social ya está registrada.', 422);
            }
            elseif ($existeRFC) {
                return ApiResponse::error('El RFC ya está registrado.', 422);
            }
    
            $pm = registro_pm::findOrFail($id);
            $pm->update($data);
            return ApiResponse::success('El pescador moral se actualizó exitosamente', 200, $pm);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Pescador moral no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el pescador moral: ' . $e->getMessage(), 500);
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
