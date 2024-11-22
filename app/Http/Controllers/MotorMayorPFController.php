<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\MotorMayor_PF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MotorMayorPFController extends Controller
{
    /**
     * Despliega la lista de los motores para embarcaciones mayores.
     */
    public function index()
    {
        try {
            $motorMayorPF = MotorMayor_PF::all();
            $result = $motorMayorPF->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->EmbarcacionPertenece->nombre_emb_ma,
                    'marca_motor' => $item->marca_motor,
                    'modelo_motor' => $item->modelo_motor,
                    'potencia' => $item->potencia,
                    'num_serie' => $item->num_serie,
                    'tiempo' => $item->tiempo,
                    'tipo_combustible' =>  $item->tipo_combustible == 'Magna' ? 'Magna' :
                    ($item->tipo_combustible == 'Premium' ? 'Premium' : 'Diesel'),
                    'fuera_borda' => $item->fuera_borda ? '1' : '0',
                    'vida_util_anio' => $item->vida_util_anio,
                    'doc_propiedad' => $item->doc_propiedad,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los motores para embarcaciones mayores de pescador fisico', 200, $result);
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
                'emb_pertenece_id' => 'required|exists:registroemb_ma_pf,id',
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

            $existeMotorMayorPF = MotorMayor_PF::where('num_serie', $data['num_serie'])->first();
            if ($existeMotorMayorPF) {
                return ApiResponse::error('Este número de serie ya esta registrado', 422);
            }

            $motorMayorPF = MotorMayor_PF::create($data);
            return ApiResponse::success('Motor para embarcaciones mayores creado exitosamente', 201, $motorMayorPF);
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
            $motorMayorPF = MotorMayor_PF::findOrFail($id);
            $result = [
                'id' => $motorMayorPF->id,
                'emb_pertenece_id' => $motorMayorPF->EmbarcacionPertenece->id,
                'marca_motor' => $motorMayorPF->marca_motor,
                'modelo_motor' => $motorMayorPF->modelo_motor,
                'potencia' => $motorMayorPF->potencia,
                'num_serie' => $motorMayorPF->num_serie,
                'tiempo' => $motorMayorPF->tiempo,
                'tipo_combustible' => $motorMayorPF->tipo_combustible,
                'fuera_borda' => $motorMayorPF->fuera_borda ? '1' : '0',
                'vida_util_anio' => $motorMayorPF->vida_util_anio,
                'doc_propiedad' => $motorMayorPF->doc_propiedad,
                'created_at' => $motorMayorPF->created_at,
                'updated_at' => $motorMayorPF->updated_at,
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
           
            $existeMotorMayorPF = MotorMayor_PF::where('num_serie', $request->num_serie)
            ->where('id', '!=', $id)->first();
            if ($existeMotorMayorPF) {
                return ApiResponse::error('Este motor para embarcaciones menores ya existe', 422);
            }

            $motorMayorPF = MotorMayor_PF::findOrFail($id);
            $motorMayorPF->update($request->all());
            return ApiResponse::success('Motor actualizado exitosamente', 200, $motorMayorPF);
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
            $motorMayorPF = MotorMayor_PF::findOrFail($id);
            $motorMayorPF->delete();
            return ApiResponse::success('Motor eliminado exitosamente', 200, $motorMayorPF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Motor no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el motor para embarcaciones mayores: ' .$e->getMessage(), 500);
        }
    }
}
