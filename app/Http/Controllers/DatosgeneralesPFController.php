<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\datosgenerales_PF;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DatosgeneralesPFController extends Controller
{
    /**
     * Despliega la lista de los datos generales de los pescadores fisicos.
     */
    public function index()
    {
        try {
            $datosgeneralesPF = datosgenerales_PF::all();
            $result = $datosgeneralesPF->map(function ($item) {
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
                    'region_id' => $item->Region->nombre_region,
                    'distrito_id' => $item->Distrito->nombre_distrito,
                    'municipio_id' => $item->Municipio->nombre_municipio,
                    'localidad_id' => $item->Localidad->nombre_localidad,
                    'grupo_sanguineo' => $item->grupo_sanguineo,
                    'zona_pesca' => $item->zona_pesca,
                    'etnia_id' => $item->Etnia->nombre_etnia,
                    'cuota_captura' => $item->cuota_captura,
                    'acta_constitutiva' => $item->acta_constitutiva,
                    'cantidad_artepesca' => $item->cantidad_artepesca,
                    'cuenta_permiso' => $item->cuenta_permiso ? '1' : '0',
                    'motivo_no_cuenta' => $item->motivo_no_cuenta,
                    'cuenta_emb_mayor' => $item->cuenta_emb_mayor ? '1' : '0',
                    'motino_cuenta_embma' => $item->motino_cuenta_emb,
                    'cant_emb_ma' => $item->cant_emb_ma,
                    'cant_motores_ma' => $item->cant_motores_ma,
                    'tipos_motores_ma' => $item->tipos_motores_ma,
                    'cuenta_emb_menores' => $item->cuenta_emb_menores ? '1' : '0',
                    'motino_cuenta_embme' => $item->motino_cuenta_embme,
                    'cant_emb_me' => $item->cant_emb_me,
                    'cant_motores_me' => $item->cant_motores_me,
                    'tipos_motores_me' => $item->tipos_motores_me,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los datos generales de los pescadores fisicos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los datos generales de los pescadores fisicos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Registra los datos generales de un pescador fisico.
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
                'domicilio' => 'required|string|max:40',
                'region_id' => 'required|exists:regiones,id',
                'distrito_id' => 'required|exists:distritos,id',
                'municipio_id' => 'required|exists:municipios,id',
                'localidad_id' => 'required|exists:localidades,id',
                'grupo_sanguineo' => 'required|string|max:6',
                'zona_pesca' => 'required|string|max:30',
                'etnia_id' => 'required|exists:etnias,id',
                'cuota_captura' => 'required|string|max:200',
                'acta_constitutiva' => 'required|string|max:255',
                'cantidad_artepesca' => 'required|integer',
                'cuenta_permiso' => 'required|boolean',
                'motivo_no_cuenta' => 'nullable|string|max:200',
                'cuenta_emb_mayor' => 'required|boolean',
                'motino_cuenta_embma' => 'nullable|string|max:200',
                'cant_emb_ma' => 'nullable|integer',
                'cant_motores_ma' => 'nullable|integer',
                'tipos_motores_ma' => 'nullable|string|max:30',
                'cuenta_emb_menores' => 'required|boolean',
                'motino_cuenta_embme' => 'nullable|string|max:200',
                'cant_emb_me' => 'nullable|integer',
                'cant_motores_me' => 'nullable|integer',
                'tipos_motores_me' => 'nullable|string|max:30',
            ]);

            $existeDatosGeneralesPF = datosgenerales_PF::where('nombres', $data['nombres'])
                ->orwhere('RFC', $data['RFC'])
                ->orwhere('CURP', $data['CURP'])
                ->first();
            if ($existeDatosGeneralesPF) {
                $errors = [];
                if ($existeDatosGeneralesPF->nombres == $data['nombres']) {
                    $errors['nombres'] = 'El nombre ya esta registrado';
                }
                if ($existeDatosGeneralesPF->RFC == $data['RFC']) {
                    $errors['RFC'] = 'El RFC ya esta registrado';
                }
                if ($existeDatosGeneralesPF->CURP == $data['CURP']) {
                    $errors['CURP'] = 'La Curp ya esta registrada';
                }
                return ApiResponse::error('Los datos del pescador ya estan registrados', 422, $errors);
            }

            $datosgeneralesPF = datosgenerales_PF::create($data);
            return ApiResponse::success('Los datos fueron registrados exitosamente', 201, $datosgeneralesPF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los datos generales del pescador: ', 500);
        }
    }

    /**
     * Muestra los datos generales de un pescador fisico.
     */
    public function show($id)
    {
        try {
            $datosgeneralesPF = datosgenerales_PF::findOrFail($id);
            $result = [
                'id' => $datosgeneralesPF->id,
                'userprofile_id' => $datosgeneralesPF->perfil_usuario->id,
                'oficregis_id' => $datosgeneralesPF->Oficina->id,
                'nombres' => $datosgeneralesPF->nombres,
                'apellido_pa' => $datosgeneralesPF->apellido_pa,
                'apellido_ma' => $datosgeneralesPF->apellido_ma,
                'RFC' => $datosgeneralesPF->RFC,
                'CURP' => $datosgeneralesPF->CURP,
                'telefono' => $datosgeneralesPF->telefono,
                'email' => $datosgeneralesPF->email,
                'domicilio' => $datosgeneralesPF->domicilio,
                'region_id' => $datosgeneralesPF->Region->id,
                'distrito_id' => $datosgeneralesPF->Distrito->id,
                'municipio_id' => $datosgeneralesPF->Municipio->id,
                'localidad_id' => $datosgeneralesPF->Localidad->id,
                'grupo_sanguineo' => $datosgeneralesPF->grupo_sanguineo,
                'zona_pesca' => $datosgeneralesPF->zona_pesca,
                'etnia_id' => $datosgeneralesPF->Etnia->id,
                'cuota_captura' => $datosgeneralesPF->cuota_captura,
                'acta_constitutiva' => $datosgeneralesPF->acta_constitutiva,
                'cantidad_artepesca' => $datosgeneralesPF->cantidad_artepesca,
                'cuenta_permiso' => $datosgeneralesPF->cuenta_permiso ? '1' : '0',
                'motivo_no_cuenta' => $datosgeneralesPF->motivo_no_cuenta,
                'cuenta_emb_mayor' => $datosgeneralesPF->cuenta_emb_mayor ? '1' : '0',
                'motino_cuenta_embma' => $datosgeneralesPF->motino_cuenta_emb,
                'cant_emb_ma' => $datosgeneralesPF->cant_emb_ma,
                'cant_motores_ma' => $datosgeneralesPF->cant_motores_ma,
                'tipos_motores_ma' => $datosgeneralesPF->tipos_motores_ma,
                'cuenta_emb_menores' => $datosgeneralesPF->cuenta_emb_menores ? '1' : '0',
                'motino_cuenta_embme' => $datosgeneralesPF->motino_cuenta_embme,
                'cant_emb_me' => $datosgeneralesPF->cant_emb_me,
                'cant_motores_me' => $datosgeneralesPF->cant_motores_me,
                'tipos_motores_me' => $datosgeneralesPF->tipos_motores_me,
                'created_at' => $datosgeneralesPF->created_at,
                'updated_at' => $datosgeneralesPF->updated_at,
            ];
            return ApiResponse::success('Datos generales obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos generales del pescador: ', 500);
        }
    }

    /**
     * Actualiza los datos generales de un pescador fisico.
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
                'domicilio' => 'required|string|max:40',
                'region_id' => 'required',
                'distrito_id' => 'required',
                'municipio_id' => 'required',
                'localidad_id' => 'required',
                'grupo_sanguineo' => 'required|string|max:6',
                'zona_pesca' => 'required|string|max:30',
                'etnia_id' => 'required',
                'cuota_captura' => 'required|string|max:200',
                'acta_constitutiva' => 'required|string|max:255',
                'cantidad_artepesca' => 'required|integer',
                'cuenta_permiso' => 'required|boolean',
                'motivo_no_cuenta' => 'required|string|max:200',
                'cuenta_emb_mayor' => 'required|boolean',
                'motino_cuenta_embma' => 'nullable|string|max:200',
                'cant_emb_ma' => 'nullable|integer',
                'cant_motores_ma' => 'nullable|integer',
                'tipos_motores_ma' => 'nullable|string|max:30',
                'cuenta_emb_menores' => 'required|boolean',
                'motino_cuenta_embme' => 'nullable|string|max:200',
                'cant_emb_me' => 'nullable|integer',
                'cant_motores_me' => 'nullable|integer',
                'tipos_motores_me' => 'nullable|string|max:30',
            ]);

            $existeDatosGeneralesPF = datosgenerales_PF::where('id', '!=', $id)
            ->where(function ($query) use ($data) {
                $query->where('nombres', $data['nombres'])
                ->orwhere(function ($query) use ($data) {
                    $query->where('RFC', $data['RFC'])
                    ->orwhere('CURP', $data['CURP']);
                });
            })
            ->first();

        if ($existeDatosGeneralesPF) {
            $errors = [];
            if ($existeDatosGeneralesPF->nombres === $data['nombres']) {
                $errors['nombres'] = 'El nombre ya está registrado';
            }
            if ($existeDatosGeneralesPF->RFC === $data['RFC']) {
                $errors['RFC'] = 'El RFC ya está registrado';
            }
            if ($existeDatosGeneralesPF->CURP === $data['CURP']) {
                $errors['CURP'] = 'La CURP ya está registrada';
            }
            return ApiResponse::error('Estos datos ya estan registrados', 422, $errors);
        }

        $datosgeneralesPF = datosgenerales_PF::findOrFail($id);
        $datosgeneralesPF->update($data);
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
     * Elimina los datos generales de un pescador fisico.
     */
    public function destroy($id)
    {
        try {
            $datosgeneralesPF = datosgenerales_PF::findOrFail($id);
            $datosgeneralesPF->delete();
            return ApiResponse::success('Datos generales del pescador fisico eliminados exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los datos generales del pescador fisico', 500);
        }
    }
}
