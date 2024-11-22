<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_tipoinfraest_AF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroTipoinfraestAFController extends Controller
{
    /**
     * Despliega una lista de los tipos de infraestructura del acuicultor fisico.
     */
    public function index()
    {
        try {
            $TipoInfraestructuraAF = registro_tipoinfraest_AF::all();
            $result = $TipoInfraestructuraAF->map(function ($item){
                return [
                    'id' => $item->id,
                    'estanque_rustico_sup' => $item->estanque_rustico_sup,
                    'estanque_rustico_vol' => $item->estanque_rustico_vol,
                    'estanque_rustico_can' => $item->estanque_rustico_can,
                    'recubiertomem_sup' => $item->recubiertomem_sup,
                    'recubiertomem_vol' => $item->recubiertomem_vol,
                    'recubiertomem_can' => $item->recubiertomem_can,
                    'geomallagallamina_sup' => $item->geomallagallamina_sup,
                    'geomallagallamina_vol' => $item->geomallagallamina_vol,
                    'geomallagallamina_can' => $item->geomallagallamina_can,
                    'tipo_circular_sup' => $item->tipo_circular_sup,
                    'tipo_circular_vol' => $item->tipo_circular_vol,
                    'tipo_circular_can' => $item->tipo_circular_can,
                    'tipo_rectangular_sup' => $item->tipo_rectangular_sup,
                    'tipo_rectangular_vol' => $item->tipo_rectangular_vol,
                    'tipo_rectangular_can' => $item->tipo_rectangular_can,
                    'jaula_flotante_sup' => $item->jaula_flotante_sup,
                    'jaula_flotante_vol' => $item->jaula_flotante_vol,
                    'jaula_flotante_can' => $item->jaula_flotante_can,
                    'cercas_encierros_sup' => $item->cercas_encierros_sup,
                    'cercas_encierros_vol' => $item->cercas_encierros_vol,
                    'cercas_encierros_can' => $item->cercas_encierros_can,
                    'otro_superficie' => $item->otro_superficie,
                    'otro_volumen' => $item->otro_volumen,
                    'otro_cantidad' => $item->otro_cantidad,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los tipos de infraestructura de los acuicultores fisicos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los tipos de infraestructura de los acuicultores fisicos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un registro del tipo de infraestructura de un acuicultor fisico.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'estanque_rustico_sup' => 'required|numeric',
                'estanque_rustico_vol' => 'required|numeric',
                'estanque_rustico_can' => 'required|string|max:50',
                'recubiertomem_sup' => 'required|numeric',
                'recubiertomem_vol' => 'required|numeric',
                'recubiertomem_can' => 'required|string|max:50',
                'geomallagallamina_sup' => 'required|numeric',
                'geomallagallamina_vol' => 'required|numeric',
                'geomallagallamina_can' => 'required|string|max:50',
                'tipo_circular_sup' => 'required|numeric',
                'tipo_circular_vol' => 'required|numeric',
                'tipo_circular_can' => 'requiredstring|max:50',
                'tipo_rectangular_sup' => 'required|numeric',
                'tipo_rectangular_vol' => 'required|numeric',
                'tipo_rectangular_can' => 'requiredstring|max:50',
                'jaula_flotante_sup' => 'required|numeric',
                'jaula_flotante_vol' => 'required|numeric',
                'jaula_flotante_can' => 'required|string|max:50',
                'cercas_encierros_sup' => 'required|numeric',
                'cercas_encierros_vol' => 'required|numeric',
                'cercas_encierros_can' => 'required|string|max:50',
                'otro_superficie' => 'required|numeric',
                'otro_volumen' => 'required|numeric',
                'otro_cantidad' => 'required|string|max:50',
            ]);

            $TipoInfraestructuraAF = registro_tipoinfraest_AF::create($data);
            return ApiResponse::success('Tipo de infraestructura registradas exitosamente', 201, $TipoInfraestructuraAF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar el tipo de infraestructura del acuicultor fisico: ', 500);
        }
    }

    /**
     * Muestra los datos de un tipo de infraestructura del acuicultor fisico.
     */
    public function show($id)
    {
        try {
            $TipoInfraestructuraAF = registro_tipoinfraest_AF::findOrFail($id);
            $result = [
                'id' => $TipoInfraestructuraAF->id,
                'estanque_rustico_sup' => $TipoInfraestructuraAF->estanque_rustico_sup,
                'estanque_rustico_vol' => $TipoInfraestructuraAF->estanque_rustico_vol,
                'estanque_rustico_can' => $TipoInfraestructuraAF->estanque_rustico_can,
                'recubiertomem_sup' => $TipoInfraestructuraAF->recubiertomem_sup,
                'recubiertomem_vol' => $TipoInfraestructuraAF->recubiertomem_vol,
                'recubiertomem_can' => $TipoInfraestructuraAF->recubiertomem_can,
                'geomallagallamina_sup' => $TipoInfraestructuraAF->geomallagallamina_sup,
                'geomallagallamina_vol' => $TipoInfraestructuraAF->geomallagallamina_vol,
                'geomallagallamina_can' => $TipoInfraestructuraAF->geomallagallamina_can,
                'tipo_circular_sup' => $TipoInfraestructuraAF->tipo_circular_sup,
                'tipo_circular_vol' => $TipoInfraestructuraAF->tipo_circular_vol,
                'tipo_circular_can' => $TipoInfraestructuraAF->tipo_circular_can,
                'tipo_rectangular_sup' => $TipoInfraestructuraAF->tipo_rectangular_sup,
                'tipo_rectangular_vol' => $TipoInfraestructuraAF->tipo_rectangular_vol,
                'tipo_rectangular_can' => $TipoInfraestructuraAF->tipo_rectangular_can,
                'jaula_flotante_sup' => $TipoInfraestructuraAF->jaula_flotante_sup,
                'jaula_flotante_vol' => $TipoInfraestructuraAF->jaula_flotante_vol,
                'jaula_flotante_can' => $TipoInfraestructuraAF->jaula_flotante_can,
                'cercas_encierros_sup' => $TipoInfraestructuraAF->cercas_encierros_sup,
                'cercas_encierros_vol' => $TipoInfraestructuraAF->cercas_encierros_vol,
                'cercas_encierros_can' => $TipoInfraestructuraAF->cercas_encierros_can,
                'otro_superficie' => $TipoInfraestructuraAF->otro_superficie,
                'otro_volumen' => $TipoInfraestructuraAF->otro_volumen,
                'otro_cantidad' => $TipoInfraestructuraAF->otro_cantidad,
                'created_at' => $TipoInfraestructuraAF->created_at,
                'updated_at' => $TipoInfraestructuraAF->updated_at,
            ];
            return ApiResponse::success('Tipo de infraestructura obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de infraestructura no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el tipo de infraestructura del acuicultor fisico: ', 500);
        }
    }

    /**
     * Actualiza un registro del tipo de infraestructura del acuicultor fisico.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'estanque_rustico_sup' => 'required|numeric',
                'estanque_rustico_vol' => 'required|numeric',
                'estanque_rustico_can' => 'required|string|max:50',
                'recubiertomem_sup' => 'required|numeric',
                'recubiertomem_vol' => 'required|numeric',
                'recubiertomem_can' => 'required|string|max:50',
                'geomallagallamina_sup' => 'required|numeric',
                'geomallagallamina_vol' => 'required|numeric',
                'geomallagallamina_can' => 'required|string|max:50',
                'tipo_circular_sup' => 'required|numeric',
                'tipo_circular_vol' => 'required|numeric',
                'tipo_circular_can' => 'requiredstring|max:50',
                'tipo_rectangular_sup' => 'required|numeric',
                'tipo_rectangular_vol' => 'required|numeric',
                'tipo_rectangular_can' => 'requiredstring|max:50',
                'jaula_flotante_sup' => 'required|numeric',
                'jaula_flotante_vol' => 'required|numeric',
                'jaula_flotante_can' => 'required|string|max:50',
                'cercas_encierros_sup' => 'required|numeric',
                'cercas_encierros_vol' => 'required|numeric',
                'cercas_encierros_can' => 'required|string|max:50',
                'otro_superficie' => 'required|numeric',
                'otro_volumen' => 'required|numeric',
                'otro_cantidad' => 'required|string|max:50',
            ]);

            $TipoInfraestructuraAF = registro_tipoinfraest_AF::findOrFail($id);
            $TipoInfraestructuraAF->update($data);
            return ApiResponse::success('Tipo de infraestructura actualizada exitosamente', 200);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de infraestructura no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el tipo de infraestructura: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un  registro del tipo de infraestructura del acuicultor fisico.
     */
    public function destroy($id)
    {
        try {
            $TipoInfraestructuraAF = registro_tipoinfraest_AF::findOrFail($id);
            $TipoInfraestructuraAF->delete();
            return ApiResponse::success('Tipo de ifraestructura eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de infraestructura no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el tipo de infraestructura del acuicultor fisico', 500);
        }
    }
}
