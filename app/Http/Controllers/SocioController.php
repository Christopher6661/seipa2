<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\socio;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SocioController extends Controller
{
    /**
     * Despliega la lista de los socios de las coperativas morales.
     */
    public function index()
    {
        try {
            $sociosAM = socio::all();
            $result = $sociosAM->map(function ($item){
                return [
                    'id' => $item->id,
                    'colaborador_id' => $item->colaborador->razon_social,
                    'CURP' => $item->CURP,
                    'tipo' => $item->tipo ? '1' : '0',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los socios de las cooperativas morales', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los socios de las cooperativas morales: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Registra un socio de una coperativa moral.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'colaborador_id' => 'required|exists:datos_generales_am,id',
                'CURP' => 'required|string|max:18',
                'tipo' => 'required|boolean'
            ]);

            $existeSocioAM = socio::where('CURP', $data['CURP'])->first();
            if ($existeSocioAM) {
                $errors = [];
                if ($existeSocioAM->CURP == $data['CURP']) {
                    $errors['CURP'] = 'La CURP ya esta registrada';
                }
                return ApiResponse::error('Los datos del socio ya estan registrados', 422, $errors);
            }

            $sociosAM = socio::create($data);
            return ApiResponse::success('Socio registrado exitosamente', 201, $sociosAM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar al socio de la cooperativa moral: ', 500);
        }
    }

    /**
     * Muestra los datos del socio de una coperativa moral.
     */
    public function show($id)
    {
        try {
            $sociosAM = socio::findOrFail($id);
            $result = [
                'id' => $sociosAM->id,
                'colaborador_id' => $sociosAM->colaborador->id,
                'CURP' => $sociosAM->CURP,
                'tipo' => $sociosAM->tipo ? '1' : '0',
                'created_at' => $sociosAM->created_at,
                'updated_at' => $sociosAM->updated_at,
            ];
            return ApiResponse::success('Información del socio obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos del socio no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos del socio de la cooperativa moral: ', 500);
        }
    }

    /**
     * Actualiza los datos de un socio de una coperativa moral.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'colaborador_id' => 'required',
                'CURP' => 'required|string|max:18',
                'tipo' => 'required|boolean'
            ]);

            $existeSocioAM = socio::where('id', '!=', $id)
            ->where(function ($query) use ($data) {
                $query->where('CURP', $data['CURP']);
            })
            ->first();

            if ($existeSocioAM) {
                $errors = [];
                if ($existeSocioAM->CURP === $data['CURP']) {
                    $errors['CURP'] = 'La CURP ya está registrada';
                }
                return ApiResponse::error('Los datos del socio ya estan registrados', 422, $errors);
            }

            $sociosAM = socio::findOrFail($id);
            $sociosAM->update($data);
            return ApiResponse::success('Los datos del socio se han actualizado exitosamente', 200);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Socio no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar los datos del socio de la cooperativa moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un socio de una coperativa moral.
     */
    public function destroy($id)
    {
        try {
            $sociosAM = socio::findOrFail($id);
            $sociosAM->delete();
            return ApiResponse::success('Socio eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Socio no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar al socio de la cooperativa moral', 500);
        }
    }
}
