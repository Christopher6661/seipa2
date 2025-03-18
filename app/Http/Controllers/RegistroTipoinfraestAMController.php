<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_tipoinfraest_AM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroTipoinfraestAMController extends Controller
{
    /**
     * Despliega una lista de los tipos de infraestructura de los acuicultores morales.
     */
    public function index()
    {
        try {
            $TipoInfraestructuraAM = registro_tipoinfraest_AM::all();
            $result = $TipoInfraestructuraAM->map(function ($item){
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
            return ApiResponse::success('Lista de los tipos de infraestructura de los acuicultores morales', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los tipos de infraestructura de los acuicultores morales: ' .$e->getMessage(), 500);
        }
    }
    /**
     * Crea un registro del tipo de infraestructura de un acuicultor moral.
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
                'tipo_circular_can' => 'required|string|max:50',
                'tipo_rectangular_sup' => 'required|numeric',
                'tipo_rectangular_vol' => 'required|numeric',
                'tipo_rectangular_can' => 'required|string|max:50',
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

            $TipoInfraestructuraAM = registro_tipoinfraest_AM::create($data);
            return ApiResponse::success('Tipo de infraestructura registradas exitosamente', 201, $TipoInfraestructuraAM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar el tipo de infraestructura del acuicultor moral: ', 500);
        }
    }

    /**
     * Muestra los datos de un tipo de infraestructura de un acuicultor moral.
     */
    public function show($id)
    {
        try {
            $TipoInfraestructuraAM = registro_tipoinfraest_AM::findOrFail($id);
            $result = [
                'id' => $TipoInfraestructuraAM->id,
                'estanque_rustico_sup' => $TipoInfraestructuraAM->estanque_rustico_sup,
                'estanque_rustico_vol' => $TipoInfraestructuraAM->estanque_rustico_vol,
                'estanque_rustico_can' => $TipoInfraestructuraAM->estanque_rustico_can,
                'recubiertomem_sup' => $TipoInfraestructuraAM->recubiertomem_sup,
                'recubiertomem_vol' => $TipoInfraestructuraAM->recubiertomem_vol,
                'recubiertomem_can' => $TipoInfraestructuraAM->recubiertomem_can,
                'geomallagallamina_sup' => $TipoInfraestructuraAM->geomallagallamina_sup,
                'geomallagallamina_vol' => $TipoInfraestructuraAM->geomallagallamina_vol,
                'geomallagallamina_can' => $TipoInfraestructuraAM->geomallagallamina_can,
                'tipo_circular_sup' => $TipoInfraestructuraAM->tipo_circular_sup,
                'tipo_circular_vol' => $TipoInfraestructuraAM->tipo_circular_vol,
                'tipo_circular_can' => $TipoInfraestructuraAM->tipo_circular_can,
                'tipo_rectangular_sup' => $TipoInfraestructuraAM->tipo_rectangular_sup,
                'tipo_rectangular_vol' => $TipoInfraestructuraAM->tipo_rectangular_vol,
                'tipo_rectangular_can' => $TipoInfraestructuraAM->tipo_rectangular_can,
                'jaula_flotante_sup' => $TipoInfraestructuraAM->jaula_flotante_sup,
                'jaula_flotante_vol' => $TipoInfraestructuraAM->jaula_flotante_vol,
                'jaula_flotante_can' => $TipoInfraestructuraAM->jaula_flotante_can,
                'cercas_encierros_sup' => $TipoInfraestructuraAM->cercas_encierros_sup,
                'cercas_encierros_vol' => $TipoInfraestructuraAM->cercas_encierros_vol,
                'cercas_encierros_can' => $TipoInfraestructuraAM->cercas_encierros_can,
                'otro_superficie' => $TipoInfraestructuraAM->otro_superficie,
                'otro_volumen' => $TipoInfraestructuraAM->otro_volumen,
                'otro_cantidad' => $TipoInfraestructuraAM->otro_cantidad,
                'created_at' => $TipoInfraestructuraAM->created_at,
                'updated_at' => $TipoInfraestructuraAM->updated_at,
            ];
            return ApiResponse::success('Tipo de infraestructura obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de infraestructura no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el tipo de infraestructura del acuicultor moral: ', 500);
        }
    }

    /**
     * Actualiza un registro del tipo de infraestructura de un acuicultor moral.
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
                'tipo_circular_can' => 'required|string|max:50',
                'tipo_rectangular_sup' => 'required|numeric',
                'tipo_rectangular_vol' => 'required|numeric',
                'tipo_rectangular_can' => 'required|string|max:50',
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

            $TipoInfraestructuraAM = registro_tipoinfraest_AM::findOrFail($id);
            $TipoInfraestructuraAM->update($data);
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
     * Elimina un  registro del tipo de infraestructura de un acuicultor moral.
     */
    public function destroy($id)
    {
        try {
            $TipoInfraestructuraAM = registro_tipoinfraest_AM::findOrFail($id);
            $TipoInfraestructuraAM->delete();
            return ApiResponse::success('Tipo de ifraestructura eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de infraestructura no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el tipo de infraestructura del acuicultor moral', 500);
        }
    }
}
