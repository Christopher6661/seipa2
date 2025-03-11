<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\MotorMenor_PM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MotorMenorPMController extends Controller
{
    /**
     * Despliega la lista de los motores para emb menores del PM.
     */
    public function index()
    {
        try {
            $motorMenor_PM = MotorMenor_PM::all();
            $result = $motorMenor_PM->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->EmbarcacionPertenece->nombre_emb,
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
            return ApiResponse::success('Lista de los motores para embarcaciones menores del PM', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de motores para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un motor para emb menor.
     */
    public function store(Request $request)
    {
        try{
          $data = $request->validate([
            'emb_pertenece_id' => 'required|exists:registroemb_me_pm,id',
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

          $existeMotorMePM = MotorMenor_PM::where('num_serie', $data['num_serie'])->first();
          if ($existeMotorMePM) {
              $errors = [];
              if ($existeMotorMePM->num_serie === $data['num_serie']) {
                  $errors['num_serie'] = 'Este número de serie ya esta registrado';
              }
              return ApiResponse::error('Este motor para embarcaciones menores ya existe', 422, $errors);
          }

          $motorMenor_PM = MotorMenor_PM::create($data);
          return ApiResponse::success('Motor para embarcaciones menores creado exitosamente', 201, $motorMenor_PM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el motor para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     *  Muestra un motor menor.
     */
    public function show($id)
    {
        try {
            $motorMenor_PM = MotorMenor_PM::findOrFail($id);
            $result = [
                'id' => $motorMenor_PM->id,
                'emb_pertenece_id' => $motorMenor_PM->EmbarcacionPertenece->id,
                'marca_motor' => $motorMenor_PM->marca_motor,
                'modelo_motor' => $motorMenor_PM->modelo_motor,
                'potencia' => $motorMenor_PM->potencia,
                'num_serie' => $motorMenor_PM->num_serie,
                'tiempo' => $motorMenor_PM->tiempo,
                'tipo_combustible' => $motorMenor_PM->tipo_combustible,
                'fuera_borda' => ($motorMenor_PM->fuera_borda == '1') ? '1' : '0',
                'vida_util_anio' => $motorMenor_PM->vida_util_anio,
                'doc_propiedad' => $motorMenor_PM->doc_propiedad,
                'created_at' => $motorMenor_PM->created_at,
                'updated_at' => $motorMenor_PM->updated_at,
            ];
            return ApiResponse::success('Motor obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Motor no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el motor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un motor menor.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'emb_pertenece_id' => 'required',
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

            $existeMotorMePM = MotorMenor_PM::where('num_serie', $request->num_serie)->first();
            if ($existeMotorMePM) {
                return ApiResponse::error('Este motor para embarcaciones menores ya existe', 422);
            }

            $motorMenor_PM = MotorMenor_PM::findOrFail($id);
            $motorMenor_PM->update($request->all());
            return ApiResponse::success('Motor actualizado exitosamente', 200, $motorMenor_PM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Motor no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el motor: ' .$e->getMessage(), 500);
        } 
    }

    /**
     * Elimina un motor menor.
     */
    public function destroy($id)
    {
        try {
            $motorMenor_PM = MotorMenor_PM::findOrFail($id);
            $motorMenor_PM->delete();
            return ApiResponse::success('Motor para embarcaciones menores eliminado exitosamente', 200, $motorMenor_PM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Motor no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el motor: ' .$e->getMessage(), 500);
        }
    }
}
