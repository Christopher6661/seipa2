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
                'razon_social' => 'required|string|max:250',
                'RFC' => 'required|string|max:12',
                'CURP' => 'required|string|max:18',
                'usuario' => 'required|string|max:30',
                'password' => 'required|string|max:8',
                'email' => 'required|string|max:40',
                'tipo_actividad' => 'required|boolean',
                'tipo_persona' => 'required|boolean'
            ]);

            $existeRFC = registro_am::where('RFC', $data['RFC'])->exists();
            $existeCURP = registro_am::where('CURP', $data['CURP'])->exists();
            $existeRazonsocial = registro_am::where('razon_social', $data['razon_social'])->exists();
            $existeEmail = registro_am::where('email', $data['email'])->exists();
            $exisUsuario = registro_am::where('usuario', $data['usuario'])->exists();
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
                'tipo_actividad' => $am->tipo_actividad ? '1' : '0',
                'tipo_persona' => $am->tipo_persona ? '1' : '0',
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
                'razon_social' => 'required|string|max:250',
                'RFC' => 'required|string|max:12',
                'CURP' => 'required|string|max:18',
                'usuario' => 'required|string|max:30',
                'password' => 'required|string|max:8',
                'email' => 'required|string|max:40',
                'tipo_actividad' => 'required|boolean',
                'tipo_persona' => 'required|boolean'
            ]);

            $usuarioExiste = registro_am::where('usuario', $data['usuario'])->where('id', '!=', $id)->exists();
            $emailExiste = registro_am::where('email', $data['email'])->where('id', '!=', $id)->exists();
            $existeCURP = registro_am::where('CURP', $data['CURP'])->where('id', '!=', $id)->exists();
            $existeRazonsocial = registro_am::where('razon_social', $data['razon_social'])->where('id', '!=', $id)->exists();
            $existeRFC = registro_am::where('RFC', $data['RFC'])->where('id', '!=', $id)->exists();

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
