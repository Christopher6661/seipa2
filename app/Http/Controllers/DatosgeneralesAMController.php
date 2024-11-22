<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\datosgenerales_AM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DatosgeneralesAMController extends Controller
{
    /**
     * Despliega la lista de los datos generales de los acuicultores morales.
     */
    public function index()
    {
        try {
            $datosgeneralesAM = datosgenerales_AM::all();
            $result = $datosgeneralesAM->map(function ($item){
                return [
                    'id' => $item->id,
                    'razon_social' => $item->razon_social,
                    'RFC' => $item->RFC,
                    'CURP' => $item->CURP,
                    'telefono' => $item->telefono,
                    'domicilio' => $item->domicilio,
                    'region_id' => $item->region->nombre_region,
                    'distrito_id' => $item->distrito->nombre_distrito,
                    'muni_id' => $item->municipio->nombre_municipio,
                    'local_id' => $item->localidad->nombre_localidad,
                    'email' => $item->email,
                    'especies_prod_id' => $item->especies_producen->nombre_especie,
                    'etnia_id' => $item->etnias->id,
                    'socios' => $item->socios,
                    'cuenta_siscuarente' => $item->cuenta_siscuarente ? 'Sí': 'NO',
                    'motivo_no_cuenta' => $item->motivo_no_cuenta,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los datos generales de los acuicultores morales', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los datos generales de los acuicultores morales: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Registra los datos generales de un acuicultor moral.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'razon_social' => 'required|string|max:40',
                'RFC' => 'required|string|max:12',
                'CURP' => 'required|string|max:18',
                'telefono' => 'required|string|max:10',
                'domicilio' => 'required|string|max:250',
                'region_id' => 'required|exists:regiones,id',
                'distrito_id' => 'required|exists:distritos,id',
                'muni_id' => 'required|exists:municipios,id',
                'local_id' => 'required|exists:localidades,id',
                'email' => 'required|string|max:30',
                'especies_prod_id' => 'required|exists:especies,id',
                'etnia_id' => 'required|exists:etnias,id',
                'socios' => 'required|string|max:255',
                'cuenta_siscuarente' => 'required|boolean',
                'motivo_no_cuenta' => 'required|string|max:255',
            ]);

            $existeDatosGeneralesAM = datosgenerales_AM::where('razon_social', $data['razon_social'])
            ->orwhere('RFC', $data['RFC'])
            ->orwhere('CURP', $data['CURP'])
            ->first();
            if ($existeDatosGeneralesAM) {
                $errors = [];
                if ($existeDatosGeneralesAM->nombres == $data['razon_social']) {
                    $errors['razon_social'] = 'Este nombre ya esta registrado';
                }
                if ($existeDatosGeneralesAM->RFC == $data['RFC']) {
                    $errors['RFC'] = 'El RFC ya esta registrado';
                }
                if ($existeDatosGeneralesAM->CURP == $data['CURP']) {
                    $errors['CURP'] = 'La Curp ya esta registrada';
                }
                return ApiResponse::error('Estos datos del acuicultor ya estan registrados', 422, $errors);
            }

            $datosgeneralesAM = datosgenerales_AM::create($data);
            return ApiResponse::success('Los datos fueron registrados exitosamente', 201, $datosgeneralesAM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los datos generales del acuicultor moral: ', 500);
        }
    }

    /**
     * Muestra los datos generales de un acuicultor moral.
     */
    public function show($id)
    {
        try {
            $datosgeneralesAM = datosgenerales_AM::findOrFail($id);
            $result = [
                'id' => $datosgeneralesAM->id,
                'razon_social' => $datosgeneralesAM->razon_social,
                'RFC' => $datosgeneralesAM->RFC,
                'CURP' => $datosgeneralesAM->CURP,
                'telefono' => $datosgeneralesAM->telefono,
                'domicilio' => $datosgeneralesAM->domicilio,
                'region_id' => $datosgeneralesAM->region->nombre_region,
                'distrito_id' => $datosgeneralesAM->distrito->nombre_distrito,
                'muni_id' => $datosgeneralesAM->municipio->nombre_municipio,
                'local_id' => $datosgeneralesAM->localidad->nombre_localidad,
                'email' => $datosgeneralesAM->email,
                'especies_prod_id' => $datosgeneralesAM->especies_producen->nombre_especie,
                'etnia_id' => $datosgeneralesAM->etnias->id,
                'socios' => $datosgeneralesAM->socios,
                'cuenta_siscuarente' => $datosgeneralesAM->cuenta_siscuarente ? 'Sí': 'NO',
                'motivo_no_cuenta' => $datosgeneralesAM->motivo_no_cuenta,
                'created_at' => $datosgeneralesAM->created_at,
                'updated_at' => $datosgeneralesAM->updated_at,
            ];
            return ApiResponse::success('Datos generales obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos generales del acuicultor moral: ', 500);
        }
    }

    /**
     * Actualiza los datos generales de un acuicultor moral.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'razon_social' => 'required|string|max:40',
                'RFC' => 'required|string|max:12',
                'CURP' => 'required|string|max:18',
                'telefono' => 'required|string|max:10',
                'domicilio' => 'required|string|max:250',
                'region_id' => 'required',
                'distrito_id' => 'required',
                'muni_id' => 'required',
                'local_id' => 'required',
                'email' => 'required|string|max:30',
                'especies_prod_id' => 'required',
                'etnia_id' => 'required',
                'socios' => 'required|string|max:255',
                'cuenta_siscuarente' => 'required|boolean',
                'motivo_no_cuenta' => 'required|string|max:255',
            ]);

            $existeDatosGeneralesAM = datosgenerales_AM::where('id', '!=', $id)
            ->where(function ($query) use ($data) {
                $query->where('razon_social', $data['razon_social'])
                ->orwhere(function ($query) use ($data) {
                    $query->where('RFC', $data['RFC'])
                    ->orwhere('CURP', $data['CURP']);
                });
            })
            ->first();

            if ($existeDatosGeneralesAM) {
                $errors = [];
                if ($existeDatosGeneralesAM->nombres === $data['razon_social']) {
                    $errors['razon_social'] = 'El nombre ya está registrado';
                }
                if ($existeDatosGeneralesAM->RFC === $data['RFC']) {
                    $errors['RFC'] = 'El RFC ya está registrado';
                }
                if ($existeDatosGeneralesAM->CURP === $data['CURP']) {
                    $errors['CURP'] = 'La CURP ya está registrada';
                }
                return ApiResponse::error('Estos datos ya estan registrados', 422, $errors);
            }

            $datosgeneralesAM = datosgenerales_AM::findOrFail($id);
            $datosgeneralesAM->update($data);
            return ApiResponse::success('Los datos generales se han actualizado exitosamente', 200);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar los datos generales: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina los datos generales de un acuicultor moral.
     */
    public function destroy($id)
    {
        try {
            $datosgeneralesAM = datosgenerales_AM::findOrFail($id);
            $datosgeneralesAM->delete();
            return ApiResponse::success('Datos generales del acuicultor moral eliminados exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los datos generales del acuicultor moral', 500);
        }
    }
}
