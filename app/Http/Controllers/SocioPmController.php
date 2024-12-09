<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\socio_pm;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SocioPmController extends Controller
{
    /**
     * Despliega la lista de los socios de las coperativas morales.
     */
    public function index()
    {
        try {
            $socio_pm = socio_pm::all();
            $result = $socio_pm->map(function ($item){
                return [
                    'id' => $item->id,
                    'pescadormoral_id' => $item->colaborador->razon_social,
                    'CURP' => $item->CURP,
                    'tipo' => $item->tipo ? '1' : '0',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los socios de la cooperativa del pescador moral', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los socios de la cooperativa del pescador moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Registra un socio de una coperativa moral.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'pescadormoral_id' => 'required|exists:datos_generales_pm,id',
                'CURP' => 'required|string|max:18',
                'tipo' => 'required|boolean'
            ]);

            $existeSocioPM = socio_pm::where('CURP', $data['CURP'])->first();
            if ($existeSocioPM) {
                $errors = [];
                if ($existeSocioPM->CURP == $data['CURP']) {
                    $errors['CURP'] = 'La CURP ya esta registrada';
                }
                return ApiResponse::error('Los datos del socio ya estan registrados', 422, $errors);
            }

            $socioPM = socio_pm::create($data);
            return ApiResponse::success('Socio registrado exitosamente', 201, $socioPM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar al socio de la coperativa del pescador moral: ', 500);
        }
    }

    /**
     * Muestra los datos del socio de una coperativa moral.
     */
    public function show($id)
    {
        try {
            $socioPM = socio_pm::findOrFail($id);
            $result = [
                'id' => $socioPM->id,
                'pescadormoral_id' => $socioPM->colaborador->id,
                'CURP' => $socioPM->CURP,
                'tipo' => $socioPM->tipo ? '1' : '0',
                'created_at' => $socioPM->created_at,
                'updated_at' => $socioPM->updated_at,
            ];
            return ApiResponse::success('Información del socio obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos del socio no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos del socio de la cooperativa del pescador moral: ', 500);
        }
    }

    /**
     * Actualiza los datos de un socio de una coperativa moral.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'pescadormoral_id' => 'required',
                'CURP' => 'required|string|max:18',
                'tipo' => 'required|boolean'
            ]);

            $existeSocioPM = socio_pm::where('id', '!=', $id)
            ->where(function ($query) use ($data) {
                $query->where('CURP', $data['CURP']);
            })
            ->first();

            if ($existeSocioPM) {
                $errors = [];
                if ($existeSocioPM->CURP === $data['CURP']) {
                    $errors['CURP'] = 'La CURP ya está registrada';
                }
                return ApiResponse::error('Los datos del socio ya estan registrados', 422, $errors);
            }

            $sociosPM = socio_pm::findOrFail($id);
            $sociosPM->update($data);
            return ApiResponse::success('Los datos del socio se han actualizado exitosamente', 200);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Socio no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar los datos del socio de la cooperativa del pescador moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un socio de una coperativa moral.
     */
    public function destroy($id)
    {
        try {
            $socioPM = socio_pm::findOrFail($id);
            $socioPM->delete();
            return ApiResponse::success('Socio eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Socio no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar al socio de la cooperativa del pescador moral', 500);
        }
    }
}
