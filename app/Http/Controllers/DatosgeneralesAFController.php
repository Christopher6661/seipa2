<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\datosgenerales_AF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DatosgeneralesAFController extends Controller
{
    /**
     * Despliega la lista de los datos generales de los acuicultores fisicos.
     */
    public function index()
    {
        try {
            $datosgeneralesAF = datosgenerales_AF::with('especies')->get();
            $result = $datosgeneralesAF->map(function ($item){
                return [
                    'id' => $item->id,
                    'userprofile_id' => $item->perfil_usuario->name,
                    'oficregis_id' => $item->Oficina->nombre_oficina,
                    'nombres' => $item->nombres,
                    'apellido_pa' => $item->apellido_pa,
                    'apellido_ma' => $item->apellido_ma,
                    'RFC' => $item->RFC,
                    'CURP' => $item->CURP,
                    'telefono' => $item->telefono,
                    'email' => $item->email,
                    'domicilio' => $item->domicilio,
                    'localidad_id' => $item->localidad->nombre_localidad,
                    'municipio_id' => $item->municipio->nombre_municipio,
                    'distrito_id' => $item->distrito->nombre_distrito,
                    'region_id' => $item->region->nombre_region,
                    'grupo_sanguineo' => $item->grupo_sanguineo,
                    'especies_prod_id' => $item->especies ? $item->especies->pluck('nombre_especie')->toArray() : [],
                    'etnia_id' => $item->etnia->nombre_etnia,
                    'cuenta_siscaptura' => $item->cuenta_siscaptura ? 'Sí': 'NO',
                    'motivo_no_cuenta' => $item->motivo_no_cuenta,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los datos generales de los acuicultores fisicos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los datos generales de los acuicultores fisicos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Registra los datos generales de un acuicultor fisico.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required|exists:users,id',
                'oficregis_id' => 'required|exists:oficina,id',
                'nombres' => 'required|string|max:40',
                'apellido_pa' => 'required|string|max:30',
                'apellido_ma' => 'required|string|max:30',
                'RFC' => 'required|string|max:13',
                'CURP' => 'required|string|max:18',
                'telefono' => 'required|string|max:10',
                'email' => 'required|string|max:30',
                'domicilio' => 'required|string|max:250',
                'localidad_id' => 'required|exists:localidades,id',
                'municipio_id' => 'required|exists:municipios,id',
                'distrito_id' => 'required|exists:distritos,id',
                'region_id' => 'required|exists:regiones,id',
                'grupo_sanguineo' => 'required|string|max:6',
                'especies_prod_id' => 'required|array',
                'especies_prod_id.*' => 'integer|exists:especies,id',
                'etnia_id' => 'required|exists:etnias,id',
                'cuenta_siscaptura' => 'required|boolean',
                'motivo_no_cuenta' => 'nullable|string|max:255',
            ]);

            $especiesProdId = $data['especie_prod_id'];
            unset($data['especie_prod_id']);

            $existeDatosGeneralesAF = datosgenerales_AF::where('nombres', $data['nombres'])
            ->orwhere('RFC', $data['RFC'])
            ->orwhere('CURP', $data['CURP'])
            ->first();
            if ($existeDatosGeneralesAF) {
                $errors = [];
                if ($existeDatosGeneralesAF->nombres == $data['nombres']) {
                    $errors['nombres'] = 'El nombre ya esta registrado';
                }
                if ($existeDatosGeneralesAF->RFC == $data['RFC']) {
                    $errors['RFC'] = 'El RFC ya esta registrado';
                }
                if ($existeDatosGeneralesAF->CURP == $data['CURP']) {
                    $errors['CURP'] = 'La Curp ya esta registrada';
                }
                return ApiResponse::error('Los datos del acuicultor ya estan registrados', 422, $errors);
            }

            $datosgeneralesAF = datosgenerales_AF::create($data);

            $datosgeneralesAF->especies()->attach($especiesProdId);

            return ApiResponse::success('Los datos fueron registrados exitosamente', 201, $datosgeneralesAF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los datos generales del acuicultor fisico: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos generales de un acuicultor fisico.
     */
    public function show($id)
    {
        try {
            $datosgeneralesAF = datosgenerales_AF::findOrFail($id);
            $result = [
                    'id' => $datosgeneralesAF->id,
                    'userprofile_id' => $datosgeneralesAF->perfil_usuario->id,
                    'oficregis_id' => $datosgeneralesAF->Oficina->id,
                    'nombres' => $datosgeneralesAF->nombres,
                    'apellido_pa' => $datosgeneralesAF->apellido_pa,
                    'apellido_ma' => $datosgeneralesAF->apellido_ma,
                    'RFC' => $datosgeneralesAF->RFC,
                    'CURP' => $datosgeneralesAF->CURP,
                    'telefono' => $datosgeneralesAF->telefono,
                    'email' => $datosgeneralesAF->email,
                    'domicilio' => $datosgeneralesAF->domicilio,
                    'localidad_id' => $datosgeneralesAF->localidad->id,
                    'municipio_id' => $datosgeneralesAF->municipio->id,
                    'distrito_id' => $datosgeneralesAF->distrito->id,
                    'region_id' => $datosgeneralesAF->region->id,
                    'grupo_sanguineo' => $datosgeneralesAF->grupo_sanguineo,
                    'especies_prod_id' => $datosgeneralesAF->especie_producen->id,
                    'etnia_id' => $datosgeneralesAF->etnias->id,
                    'cuenta_siscaptura' => $datosgeneralesAF->cuenta_siscaptura ? 'Sí': 'NO',
                    'motivo_no_cuenta' => $datosgeneralesAF->motivo_no_cuenta,
                    'created_at' => $datosgeneralesAF->created_at,
                    'updated_at' => $datosgeneralesAF->updated_at,
            ];
            return ApiResponse::success('Datos generales obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos generales del acuicultor fisico: ', 500);
        }
    }

    /**
     * Actualiza los datos generales de un acuicultor fisico.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required',
                'oficregis_id' => 'required',
                'nombres' => 'required|string|max:40',
                'apellido_pa' => 'required|string|max:30',
                'apellido_ma' => 'required|string|max:30',
                'RFC' => 'required|string|max:13',
                'CURP' => 'required|string|max:18',
                'telefono' => 'required|string|max:10',
                'email' => 'required|string|max:30',
                'domicilio' => 'required|string|max:250',
                'localidad_id' => 'required',
                'municipio_id' => 'required',
                'distrito_id' => 'required',
                'region_id' => 'required',
                'grupo_sanguineo' => 'required|string|max:6',
                'especies_prod_id' => 'required',
                'etnia_id' => 'required',
                'cuenta_siscaptura' => 'required|boolean',
                'motivo_no_cuenta' => 'nullable|string|max:255',
            ]);

            $existeDatosGeneralesAF = datosgenerales_AF::where('id', '!=', $id)
            ->where(function ($query) use ($data) {
                $query->where('nombres', $data['nombres'])
                ->orwhere(function ($query) use ($data) {
                    $query->where('RFC', $data['RFC'])
                    ->orwhere('CURP', $data['CURP']);
                });
            })
            ->first();

            if ($existeDatosGeneralesAF) {
                $errors = [];
                if ($existeDatosGeneralesAF->nombres === $data['nombres']) {
                    $errors['nombres'] = 'El nombre ya está registrado';
                }
                if ($existeDatosGeneralesAF->RFC === $data['RFC']) {
                    $errors['RFC'] = 'El RFC ya está registrado';
                }
                if ($existeDatosGeneralesAF->CURP === $data['CURP']) {
                    $errors['CURP'] = 'La CURP ya está registrada';
                }
                return ApiResponse::error('Estos datos ya estan registrados', 422, $errors);
            }

            $datosgeneralesAF = datosgenerales_AF::findOrFail($id);
            $datosgeneralesAF->update($data);
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
     * Elimina los datos generales de un acuicultor fisico.
     */
    public function destroy($id)
    {
        try {
            $datosgeneralesAF = datosgenerales_AF::findOrFail($id);
            $datosgeneralesAF->delete();
            return ApiResponse::success('Datos generales del acuicultor fisico eliminados exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los datos generales del acuicultor fisico', 500);
        }
    }
}
