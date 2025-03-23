<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * registrar usuario.
     */
    public function index()
    {
        try {
            $user = User::all();
            $result = $user->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                    'password' => $item->password,
                    'role' => $item->role,
                ];
            });
            return ApiResponse::success('Lista de usuarios registrados', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de usuarios registrados: ' .$e->getMessage(), 500);
        }
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|max:8|confirmed',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'Usuario registrado con éxito', 'user' => $user], 201);
    }

    //Inicio de Sesión
    public function login(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user = Auth::user();

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => $user
        ]);
    }

    //Obtener usuario autenticado
    public function userProfile(Request $request)
    {
        return response()->json(['user' => Auth::user()]);
    }

    /**
     * Mostrar un usuario en especifico.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $result = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'role' => $user->role,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
            return ApiResponse::success('Usuario obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Usuario no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener al usuario: ' .$e->getMessage(), 500);
        }
    }

    //Editar usuario.

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|max:8|confirmed',
            'role' => 'sometimes|string'
        ]);

        $user->update($request->only(['name', 'email', 'password', 'role']));
    }

    //Eliminar usuario
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado exitosamente']);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Usuario no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar al usuario: ' .$e->getMessage(), 500);
        }
    }

    //Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Sesión cerrada con éxito']);
    }
}
