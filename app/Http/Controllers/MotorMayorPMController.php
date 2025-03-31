<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\MotorMayor_PM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MotorMayorPMController extends Controller
{
    /**
     * Despliega la lista de los motores para embarcaciones mayores.
     */
    public function index()
    {
        try {
            $motorMayorPM = MotorMayor_PM::all();
            $result = $motorMayorPM->map(function ($item){
                return [
                    'id' => $item->id,
                    'userprofile_id' => $item->perfil_usuario->name,
                    'emb_pertenece_id' => $item->embarcacionpertenece->nombre_emb_ma,
                    'marca_motor' => $item->marca_motor,
                    'modelo_motor' => $item->modelo_motor,
                    'potencia' => $item->potencia,
                    'num_serie' => $item->num_serie,
                    'tiempo' => $item->tiempo,
                    'tipo_combustible' => $item->tipo_combustible,
                    'fuera_borda' => ($item->fuera_borda == '1') ? '1' : '0',
                    'vida_util_anio' => $item->vida_util_anio,
                    'doc_propiedad' => $item->doc_propiedad,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los motores para embarcaciones mayores de pescador moral', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de motores para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un motor para emb mayor.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required|exists:users,id',
                'emb_pertenece_id' => 'required|exists:registroemb_ma_pm,id',
                'marca_motor' => 'required|string|max:30',
                'modelo_motor' => 'required|string|max:30',
                'potencia' => 'required|string|max:20',
                'num_serie' => 'required|string|max:10',
                'tiempo' => 'required|string|max:13',
                'tipo_combustible' => 'required|in:Magna,Premium,Diesel',
                'fuera_borda' => 'required|boolean',
                'vida_util_anio' => 'required|string|max:20',
                'doc_propiedad' => 'required|string|max:255'
            ]);

            $existeMotorMayorPM = MotorMayor_PM::where('num_serie', $data['num_serie'])->first();
            if ($existeMotorMayorPM) {
                $errors = [];
                if ($existeMotorMayorPM->num_serie === $data['num_serie']) {
                    $errors['num_serie'] = 'Este número de serie ya esta registrado';
                }
                return ApiResponse::error('Este motor para embarcaciones mayores ya existe', 422, $errors);
            }

            $motorMayorPM = MotorMayor_PM::create($data);
            return ApiResponse::success('Motor para embarcaciones mayores creado exitosamente', 201, $motorMayorPM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el motor para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra un motor para emb mayor.
     */
    public function show($id)
    {
        try {
            $motorMayorPM = MotorMayor_PM::findOrFail($id);
            $result = [
                'id' => $motorMayorPM->id,
                'userprofile_id' => $motorMayorPM->perfil_usuario->id,
                'emb_pertenece_id' => $motorMayorPM->embarcacionpertenece->id,
                'marca_motor' => $motorMayorPM->marca_motor,
                'modelo_motor' => $motorMayorPM->modelo_motor,
                'potencia' => $motorMayorPM->potencia,
                'num_serie' => $motorMayorPM->num_serie,
                'tiempo' => $motorMayorPM->tiempo,
                'tipo_combustible' => $motorMayorPM->tipo_combustible,
                'fuera_borda' => ($motorMayorPM->fuera_borda == '1') ? '1' : '0',
                'vida_util_anio' => $motorMayorPM->vida_util_anio,
                'doc_propiedad' => $motorMayorPM->doc_propiedad,
                'created_at' => $motorMayorPM->created_at,
                'updated_at' => $motorMayorPM->updated_at,
            ];
            return ApiResponse::success('Motor obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Motor no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el motor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza el motor para emb mayores.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'userprofile_id' => 'required',
                'emb_pertenece_id' => 'required',
                'marca_motor' => 'required|string|max:30',
                'modelo_motor' => 'required|string|max:30',
                'potencia' => 'required|string|max:20',
                'num_serie' => 'required|string|max:10',
                'tiempo' => 'required|string|max:13',
                'tipo_combustible' => 'required|in:Magna,Premium,Diesel',
                'fuera_borda' => 'required|boolean',
                'vida_util_anio' => 'required|string|max:10',
                'doc_propiedad' => 'required|string|max:255'
            ]);

            $existeMotorMayorPM = MotorMayor_PM::where('num_serie', $request->num_serie)
            ->where('id', '!=', $id)->first();
            if ($existeMotorMayorPM) {
                return ApiResponse::error('Este motor para embarcaciones menores ya existe', 422);
            }

            $motorMayorPM = MotorMayor_PM::findOrFail($id);
            $motorMayorPM->update($request->all());
            return ApiResponse::success('Motor actualizado exitosamente', 200, $motorMayorPM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Motor no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el motor para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }    

    /**
     * Elimina un motor para emb mayores.
     */
    public function destroy($id)
    {
        try {
            $motorMayorPM = MotorMayor_PM::findOrFail($id);
            $motorMayorPM->delete();
            return ApiResponse::success('Motor eliminado exitosamente', 200, $motorMayorPM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Motor no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el motor para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }
}
