<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\MotorMenor_PF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MotorMenorPFController extends Controller
{
    /**
     * Despliega la lista de los motores para emb menores del PF.
     */
    public function index()
    {
        try {
            $motorMenor_PF = MotorMenor_PF::all();
            $result = $motorMenor_PF->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->registroemb_me_pf->nombre_emb,
                    'marca_motor' => $item->marca_motor,
                    'modelo_motor' => $item->modelo_motor,
                    'potencia' => $item->potencia,
                    'num_serie' => $item->num_serie,
                    'tiempo' => $item->tiempo,
                    'tipo_combustible' => $item->tipo_combustible,
                    'fuera_borda' => $item->fuera_borda ? 'Sí' : 'No',
                    'vida_util_anio' => $item->vida_util_anio,
                    'doc_propiedad' => $item->doc_propiedad,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los motores para embarcaciones menores del PF', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de motores para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un motor para emb menor.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required|exists:registroemb_me_pf,id',
                'marca_motor' => 'required|string|max:30',
                'modelo_motor' => 'required|string|max:30',
                'potencia' => 'required|string|max:20',
                'num_serie' => 'required|string|max:10',
                'tiempo' => 'required|string|max:13',
                'tipo_combustible' => 'required|in:Magna, Premium, Diesel',
                'fuera_borda' => 'required|boolean',
                'vida_util_anio' => 'required|string|max:10',
                'doc_propiedad' => 'required|string|max:255'
            ]);

            $existeMotorMePF = MotorMenor_PF::where('num_serie', $data['num_serie'])->first();
            if ($existeMotorMePF) {
                $errors = [];
                if ($existeMotorMePF->num_serie === $data['num_serie']) {
                    $errors['num_serie'] = 'Este número de serie ya esta registrado';
                }
                return ApiResponse::error('Este motor para embarcaciones menores ya existe', 422, $errors);
            }

            $motorMenor_PF = MotorMenor_PF::create($data);
            return ApiResponse::success('Motor para embarcaciones menores creado exitosamente', 201, $motorMenor_PF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el motor para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra un motor menor.
     */
    public function show($id)
    {
        try {
            $motorMenor_PF = MotorMenor_PF::findOrFail($id);
            $result = [
                'id' => $motorMenor_PF->id,
                'emb_pertenece_id' => $motorMenor_PF->registroemb_me_pf->nombre_emb,
                'marca_motor' => $motorMenor_PF->marca_motor,
                'modelo_motor' => $motorMenor_PF->modelo_motor,
                'potencia' => $motorMenor_PF->potencia,
                'num_serie' => $motorMenor_PF->num_serie,
                'tiempo' => $motorMenor_PF->tiempo,
                'tipo_combustible' => $motorMenor_PF->tipo_combustible,
                'fuera_borda' => $motorMenor_PF->fuera_borda ? 'Sí' : 'No',
                'vida_util_anio' => $motorMenor_PF->vida_util_anio,
                'doc_propiedad' => $motorMenor_PF->doc_propiedad,
                'created_at' => $motorMenor_PF->created_at,
                'updated_at' => $motorMenor_PF->updated_at,
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
                'tipo_combustible' => 'required|in:Magna, Premium, Diesel',
                'fuera_borda' => 'required|boolean',
                'vida_util_anio' => 'required|string|max:10',
                'doc_propiedad' => 'required|string|max:255'
            ]);

            $existeMotorMePF = MotorMenor_PF::where('num_serie', $request->num_serie)->first();
            if ($existeMotorMePF) {
                return ApiResponse::error('Este motor para embarcaciones menores ya existe', 422);
            }

            $motorMenor_PF = MotorMenor_PF::findOrFail($id);
            $motorMenor_PF->update($request->all());
            return ApiResponse::success('Motor actualizado exitosamente', 200, $motorMenor_PF);
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
            $motorMenor_PF = MotorMenor_PF::findOrFail($id);
            $motorMenor_PF->delete();
            return ApiResponse::success('Motor para embarcaciones menores eliminado exitosamente', 200, $motorMenor_PF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Motor no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el motor: ' .$e->getMessage(), 500);
        }
    }
}
