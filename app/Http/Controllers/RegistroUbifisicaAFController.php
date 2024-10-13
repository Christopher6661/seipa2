<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_ubifisica_AF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroUbifisicaAFController extends Controller
{
    /**
     * Despliega la lista de los datos de las ubicaciones fisicas de los acuicultores fisicos.
     */
    public function index()
    {
        try {
            $UbicacionFisicaAF = registro_ubifisica_AF::all();
            $result = $UbicacionFisicaAF->map(function ($item){
                return [
                    'id' => $item->id,
                    'nombres' => $item->nombres,
                    'RNPA' => $item->RNPA,
                    'paraje' => $item->paraje,
                    'domicilio' => $item->domicilio,
                    'codigo_postal' => $item->codigo_postal,
                    'telefono' => $item->telefono,
                    'region_id' => $item->regiones->id,
                    'distr_id' => $item->distritos->id,
                    'muni_id' => $item->municipios->id,
                    'local_id' => $item->localidades->id,
                    'inicio_operacion' => $item->inicio_operacion,
                    'fin_operacion' => $item->fin_operacion,
                    'coordenadas_map' => $item->coordenadas_map,
                    'fuente_agua' => $item->fuente_agua,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los datos de las ubicaciones fisicas de los acuicultores fisicos', 200, $result);
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
                'nombres' => 'required|string|max:60',
                'RNPA' => 'required|string|max:50',
                'paraje' => 'required|string|max:60',
                'domicilio' => 'required|string|max:40',
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

            $existeUbFisicaAF = registro_ubifisica_AF::where('nombres', $data['nombres'])
            ->first();
            if ($existeUbFisicaAF) {
                $errors = [];
                if ($existeUbFisicaAF->nombres == $data['nombres']) {
                    $errors['nombres'] = 'El nombre ya esta registrado';
                }
                return ApiResponse::error('Esta ubicación fisica ya estan registrada', 422, $errors);
            }

            $UbicacionFisicaAF = registro_ubifisica_AF::create($data);
            return ApiResponse::success('Los datos fueron registrados exitosamente', 201, $UbicacionFisicaAF);
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
            $UbicacionFisicaAF = registro_ubifisica_AF::findOrFail($id);
            $result = [
                'id' => $UbicacionFisicaAF->id,
                'nombres' => $UbicacionFisicaAF->nombres,
                'RNPA' => $UbicacionFisicaAF->RNPA,
                'paraje' => $UbicacionFisicaAF->paraje,
                'domicilio' => $UbicacionFisicaAF->domicilio,
                'codigo_postal' => $UbicacionFisicaAF->codigo_postal,
                'telefono' => $UbicacionFisicaAF->telefono,
                'region_id' => $UbicacionFisicaAF->regiones->id,
                'distr_id' => $UbicacionFisicaAF->distritos->id,
                'muni_id' => $UbicacionFisicaAF->municipios->id,
                'local_id' => $UbicacionFisicaAF->localidades->id,
                'inicio_operacion' => $UbicacionFisicaAF->inicio_operacion,
                'fin_operacion' => $UbicacionFisicaAF->fin_operacion,
                'coordenadas_map' => $UbicacionFisicaAF->coordenadas_map,
                'fuente_agua' => $UbicacionFisicaAF->fuente_agua,
                'created_at' => $UbicacionFisicaAF->created_at,
                'updated_at' => $UbicacionFisicaAF->updated_at,
            ];
            return ApiResponse::success('Datos de la ubicación fisica obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos generales no encontrado', 404);
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
                'nombres' => 'required|string|max:60',
                'RNPA' => 'required|string|max:50',
                'paraje' => 'required|string|max:60',
                'domicilio' => 'required|string|max:40',
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

            $existeUbFisicaAF = registro_ubifisica_AF::where('id', '!=', $id)
            ->where(function ($query) use ($data) {
                $query->where('nombres', $data['nombres']);
            })
            ->first();

            if ($existeUbFisicaAF) {
                $errors = [];
                if ($existeUbFisicaAF->nombres === $data['nombres']) {
                    $errors['nombres'] = 'El nombre ya está registrado';
                }
                return ApiResponse::error('Estos datos de la ubicación fisica ya estan registrados', 422, $errors);
            }

            $UbicacionFisicaAF = registro_ubifisica_AF::findOrFail($id);
            $UbicacionFisicaAF->update($data);
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
            $UbicacionFisicaAF = registro_ubifisica_AF::findOrFail($id);
            $UbicacionFisicaAF->delete();
            return ApiResponse::success('Datos de la ubicación fisica eliminados exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos de la ubicación fisica no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los datos de la ubicación fisica', 500);
        }
    }
}
