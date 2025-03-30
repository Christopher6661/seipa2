<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_ubifisica_AM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroUbifisicaAMController extends Controller
{
    /**
     * Despliega la lista de los datos de las ubicaciones fisicas de los acuicultores morales.
     */
    public function index()
    {
        try {
            $UbicacionFisicaAM = registro_ubifisica_AM::all();
            $result = $UbicacionFisicaAM->map(function ($item){
                return [
                    'id' => $item->id,
                    'userprofile_id' => $item->perfil_usuario->name,
                    'razon_social' => $item->razon_social,
                    'RNPA' => $item->RNPA,
                    'domicilio' => $item->domicilio,
                    'codigo_postal' => $item->codigo_postal,
                    'telefono' => $item->telefono,
                    'region_id' => $item->Region->nombre_region,
                    'distr_id' => $item->Distrito->	nombre_distrito,
                    'muni_id' => $item->Municipio->nombre_municipio,
                    'local_id' => $item->Localidad->nombre_localidad,
                    'inicio_operacion' => $item->inicio_operacion,
                    'fin_operacion' => $item->fin_operacion,
                    'coordenadas_map' => $item->coordenadas_map,
                    'fuente_agua' => $item->fuente_agua,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los datos de las ubicaciones fisicas de los acuicultores morales', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los datos de las ubicaciones fisicas: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Registra los datos para la ubicación fisica.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required|exists:users,id',
                'razon_social' => 'required|string|max:250',
                'RNPA' => 'required|string|max:50',
                'domicilio' => 'required|string|max:250',
                'codigo_postal' => 'required|string|max:5',
                'telefono' => 'required|string|max:10',
                'region_id' => 'required|exists:regiones,id',
                'distr_id' => 'required|exists:distritos,id',
                'muni_id' => 'required|exists:municipios,id',
                'local_id' => 'required|exists:localidades,id',
                'inicio_operacion' => 'required|date',
                'fin_operacion' => 'required|date',
                'coordenadas_map' => 'required|string|max:255',
                'fuente_agua' => 'required|string|max:40',
            ]);

            $existeUbFisicaAM = registro_ubifisica_AM::where('razon_social', $data['razon_social'])
            ->first();
            if ($existeUbFisicaAM) {
                $errors = [];
                if ($existeUbFisicaAM->nombres == $data['razon_social']) {
                    $errors['razon_social'] = 'El nombre ya esta registrado';
                }
                return ApiResponse::error('Esta ubicación fisica ya estan registrada', 422, $errors);
            }

            $UbicacionFisicaAM = registro_ubifisica_AM::create($data);
            return ApiResponse::success('Los datos fueron registrados exitosamente', 201, $UbicacionFisicaAM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los datos de la ubicación fisica: ', 500);
        }
    }

    /**
     * Muestra los datos de una ubicación fisica.
     */
    public function show($id)
    {
        try {
            $UbicacionFisicaAM = registro_ubifisica_AM::findOrFail($id);
            $result = [
                'id' => $UbicacionFisicaAM->id,
                'userprofile_id' => $UbicacionFisicaAM->perfil_usuario->id,
                'razon_social' => $UbicacionFisicaAM->razon_social,
                'RNPA' => $UbicacionFisicaAM->RNPA,
                'domicilio' => $UbicacionFisicaAM->domicilio,
                'codigo_postal' => $UbicacionFisicaAM->codigo_postal,
                'telefono' => $UbicacionFisicaAM->telefono,  
                'region_id' => $UbicacionFisicaAM->Region->id,
                'distr_id' => $UbicacionFisicaAM->Distrito->id,
                'muni_id' => $UbicacionFisicaAM->Municipio->id,
                'local_id' => $UbicacionFisicaAM->Localidad->id,
                'inicio_operacion' => $UbicacionFisicaAM->inicio_operacion,
                'fin_operacion' => $UbicacionFisicaAM->fin_operacion,
                'coordenadas_map' => $UbicacionFisicaAM->coordenadas_map,
                'fuente_agua' => $UbicacionFisicaAM->fuente_agua,
                'created_at' => $UbicacionFisicaAM->created_at,
                'updated_at' => $UbicacionFisicaAM->updated_at,
            ];
            return ApiResponse::success('Datos de la ubicación fisica obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos de la ubicación fisica no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos de la ubicación fisica: ', 500);
        }
    }

    /**
     * Actualiza los datos de una ubicación fisica.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required',
                'razon_social' => 'required|string|max:250',
                'RNPA' => 'required|string|max:50',
                'domicilio' => 'required|string|max:250',
                'codigo_postal' => 'required|string|max:5',
                'telefono' => 'required|string|max:10',
                'region_id' => 'required',
                'distr_id' => 'required',
                'muni_id' => 'required',
                'local_id' => 'required',
                'inicio_operacion' => 'required|date',
                'fin_operacion' => 'required|date',
                'coordenadas_map' => 'required|string|max:255',
                'fuente_agua' => 'required|string|max:40',
            ]);

            $existeUbFisicaAM = registro_ubifisica_AM::where('id', '!=', $id)
            ->where(function ($query) use ($data) {
                $query->where('razon_social', $data['razon_social']);
            })
            ->first();

            if ($existeUbFisicaAM) {
                $errors = [];
                if ($existeUbFisicaAM->nombres === $data['razon_social']) {
                    $errors['razon_social'] = 'El nombre ya está registrado';
                }
                return ApiResponse::error('Estos datos de la ubicación fisica ya estan registrados', 422, $errors);
            }

            $UbicacionFisicaAM = registro_ubifisica_AM::findOrFail($id);
            $UbicacionFisicaAM->update($data);
            return ApiResponse::success('Los datos de la ubicación fisica se han actualizado exitosamente', 200);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos de la ubicación fisica no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar los datos de la ubicación fisica: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina una ubicación fisica.
     */
    public function destroy($id)
    {
        try {
            $UbicacionFisicaAM = registro_ubifisica_AM::findOrFail($id);
            $UbicacionFisicaAM->delete();
            return ApiResponse::success('Datos de la ubicación fisica eliminados exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos de la ubicación fisica no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los datos de la ubicación fisica', 500);
        }
    }
}
