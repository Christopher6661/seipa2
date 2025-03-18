<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_dattececon_AF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroDattececonAFController extends Controller
{
    /**
     * Despliega la lista de los datos tecnico-economicos del acuicultor fisico.
     */
    public function index()
    {
        try {
            $DatosTecnicoEconomicosAF = registro_dattececon_AF::all();
            $result = $DatosTecnicoEconomicosAF->map(function ($item){
                return [
                    'id' => $item->id,
                    'prodprom_x_mes' => $item->prodprom_x_mes,
                    'prodpromx_mes_peso' => $item->prodpromx_mes_peso === 'Kilogramo' ? 'Kilogramo' : 'Tonelada',
                    'prodprom_mes_talla' => $item->prodprom_mes_talla, 
                    'ciclocultivoultimo_anio' => $item->ciclocultivoultimo_anio,
                    'ciclocult_ultanio_mes' => $item->ciclocult_ultanio_mes,
                    'capturacosecha_anio' => $item->capturacosecha_anio,
                    'capturacos_anio_peso' => $item->capturacos_anio_peso === 'Kilogramo' ? 'Kilogramo' : 'Tonelada',
                    'captcosanio_mortalidad' => $item->captcosanio_mortalidad,
                    'destino_autoconsimo' => $item->destino_autoconsimo,
                    'destino_comercializacio' => $item->destino_comercializacio,
                    'destino_otro' => $item->destino_otro,
                    'tipo_mercado_local' => $item->tipo_mercado_local ? '1' : '0',
                    'tipo_mercado_estatal' => $item->tipo_mercado_estatal ? '1' : '0',
                    'tipo_mercado_regional' => $item->tipo_mercado_regional ? '1' : '0',
                    'tipo_mercado_otro' => $item->tipo_mercado_otro,
                    'fresco_entero' => $item->fresco_entero ? '1' : '0',
                    'fresco_entero_preckilo' => $item->fresco_entero_preckilo,
                    'evicerado' => $item->evicerado ? '1' : '0',
                    'evicerado_preciokilo' => $item->evicerado_preciokilo,
                    'enhielado' => $item->enhielado ? '1' : '0',
                    'enhielado_preciokilo' => $item->enhielado_preciokilo,
                    'otro' => $item->otro ? '1' : '0',
                    'otro_preciokilo' => $item->otro_preciokilo,
                    'fuenfinanza_programa' => $item->fuenfinanza_programa,
                    'fuentefianza_anio' => $item->fuentefianza_anio,
                    'costogasto_anualprod' => $item->costogasto_anualprod,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los datos tecnico-economicos de los acuicultores fisicos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los datos tecnico-economicos de los acuicultores fisicos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un registro de datos tecnico-economicos.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'prodprom_x_mes' => 'required|numeric',
                'prodpromx_mes_peso' => 'required|in:Kilogramo,Tonelada',
                'prodprom_mes_talla' => 'required|numeric', 
                'ciclocultivoultimo_anio' => 'required|string|max:30',
                'ciclocult_ultanio_mes' => 'required|string|max:30',
                'capturacosecha_anio' => 'required|string|max:30',
                'capturacos_anio_peso' => 'required|in:Kilogramo,Tonelada',
                'captcosanio_mortalidad' => 'required|numeric',
                'destino_autoconsimo' => 'required|numeric',
                'destino_comercializacio' => 'required|numeric',
                'destino_otro' => 'required|numeric',
                'tipo_mercado_local' => 'required|boolean',
                'tipo_mercado_estatal' => 'required|boolean',
                'tipo_mercado_regional' => 'required|boolean',
                'tipo_mercado_otro' => 'string|max:40|nullable',
                'fresco_entero' => 'required|boolean',
                'fresco_entero_preckilo' => 'nullable|numeric|max:9999999999.99',
                'evicerado' => 'required|boolean',
                'evicerado_preciokilo' => 'nullable|numeric|max:9999999999.99',
                'enhielado' => 'required|boolean',
                'enhielado_preciokilo' => 'nullable|numeric|max:9999999999.99',
                'otro' => 'required|boolean',
                'otro_preciokilo' => 'nullable|numeric|max:9999999999.99',
                'fuenfinanza_programa' => 'required|string|max:50',
                'fuentefianza_anio' => 'required|numeric',
                'costogasto_anualprod' => 'required|numeric',
            ]);

            $DatosTecnicoEconomicosAF = registro_dattececon_AF::create($data);
            return ApiResponse::success('Datos tecnico-economicos registrados exitosamente', 201, $DatosTecnicoEconomicosAF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los datos tecnico-economicos del acuicultor fisico: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos individuales de los registros de datos tecnico-economicos.
     */
    public function show($id)
    {
        try {
            $DatosTecnicoEconomicosAF = registro_dattececon_AF::findOrFail($id);
            $result = [
                'id' => $DatosTecnicoEconomicosAF->id,
                'prodprom_x_mes' => $DatosTecnicoEconomicosAF->prodprom_x_mes,
                'prodpromx_mes_peso' => $DatosTecnicoEconomicosAF->prodpromx_mes_peso === 'Kilogramo' ? 'Kilogramo' : 'Tonelada',
                'prodprom_mes_talla' => $DatosTecnicoEconomicosAF->prodprom_mes_talla, 
                'ciclocultivoultimo_anio' => $DatosTecnicoEconomicosAF->ciclocultivoultimo_anio,
                'ciclocult_ultanio_mes' => $DatosTecnicoEconomicosAF->ciclocult_ultanio_mes,
                'capturacosecha_anio' => $DatosTecnicoEconomicosAF->capturacosecha_anio,
                'capturacos_anio_peso' => $DatosTecnicoEconomicosAF->capturacos_anio_peso === 'Kilogramo' ? 'Kilogramo' : 'Tonelada',
                'captcosanio_mortalidad' => $DatosTecnicoEconomicosAF->captcosanio_mortalidad,
                'destino_autoconsimo' => $DatosTecnicoEconomicosAF->destino_autoconsimo,
                'destino_comercializacio' => $DatosTecnicoEconomicosAF->destino_comercializacio,
                'destino_otro' => $DatosTecnicoEconomicosAF->destino_otro,
                'tipo_mercado_local' => $DatosTecnicoEconomicosAF->tipo_mercado_local ? '1' : '0',
                'tipo_mercado_estatal' => $DatosTecnicoEconomicosAF->tipo_mercado_estatal ? '1' : '0',
                'tipo_mercado_regional' => $DatosTecnicoEconomicosAF->tipo_mercado_regional ? '1' : '0',
                'tipo_mercado_otro' => $DatosTecnicoEconomicosAF->tipo_mercado_otro,
                'fresco_entero' => $DatosTecnicoEconomicosAF->fresco_entero ? '1' : '0',
                'fresco_entero_preckilo' => $DatosTecnicoEconomicosAF->fresco_entero_preckilo,
                'evicerado' => $DatosTecnicoEconomicosAF->evicerado ? '1' : '0',
                'evicerado_preciokilo' => $DatosTecnicoEconomicosAF->evicerado_preciokilo,
                'enhielado' => $DatosTecnicoEconomicosAF->enhielado ? '1' : '0',
                'enhielado_preciokilo' => $DatosTecnicoEconomicosAF->enhielado_preciokilo,
                'otro' => $DatosTecnicoEconomicosAF->otro ? '1' : '0',
                'otro_preciokilo' => $DatosTecnicoEconomicosAF->otro_preciokilo,
                'fuenfinanza_programa' => $DatosTecnicoEconomicosAF->fuenfinanza_programa,
                'fuentefianza_anio' => $DatosTecnicoEconomicosAF->fuentefianza_anio,
                'costogasto_anualprod' => $DatosTecnicoEconomicosAF->costogasto_anualprod,
                'created_at' => $DatosTecnicoEconomicosAF->created_at,
                'updated_at' => $DatosTecnicoEconomicosAF->updated_at,
            ];
            return ApiResponse::success('Datos tecnico-economicos obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos tecnico-economicos no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos tecnico-economicos del acuicultor fisico: ', 500);
        }
    }

    /**
     * Actualizar los datos tecnico-economicos del acuicultor fisico.
     */
   public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'prodprom_x_mes' => 'required|numeric',
                'prodpromx_mes_peso' => 'required|in:Kilogramo,Tonelada',
                'prodprom_mes_talla' => 'required|numeric', 
                'ciclocultivoultimo_anio' => 'required|string|max:30',
                'ciclocult_ultanio_mes' => 'required|string|max:30',
                'capturacosecha_anio' => 'required|string|max:30',
                'capturacos_anio_peso' => 'required|in:Kilogramo,Tonelada',
                'captcosanio_mortalidad' => 'required|numeric',
                'destino_autoconsimo' => 'required|numeric',
                'destino_comercializacio' => 'required|numeric',
                'destino_otro' => 'required|numeric',
                'tipo_mercado_local' => 'required|boolean',
                'tipo_mercado_estatal' => 'required|boolean',
                'tipo_mercado_regional' => 'required|boolean',
                'tipo_mercado_otro' => 'string|max:40|nullable',
                'fresco_entero' => 'required|boolean',
                'fresco_entero_preckilo' => 'nullable|numeric',
                'evicerado' => 'required|boolean',
                'evicerado_preciokilo' => 'nullable|numeric',
                'enhielado' => 'required|boolean',
                'enhielado_preciokilo' => 'nullable|numeric',
                'otro' => 'required|boolean',
                'otro_preciokilo' => 'nullable|numeric',
                'fuenfinanza_programa' => 'required|string|max:50',
                'fuentefianza_anio' => 'required|numeric',
                'costogasto_anualprod' => 'required|numeric',
            ]);

            $DatosTecnicoEconomicosAF = registro_dattececon_AF::findOrFail($id);
            $DatosTecnicoEconomicosAF->update($data);
            return ApiResponse::success('Datos tecnico-economicos actualizados exitosamente', 200);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos tecnico-economicos no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar los datos tecnico-economicos: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Eliminar datos tecnico-economicos del acuicultor fisico.
     */
    public function destroy($id)
    {
        try {
           $DatosTecnicoEconomicosAF = registro_dattececon_AF::findOrFail($id);
           $DatosTecnicoEconomicosAF->delete();
           return ApiResponse::success('Datos tecnico-economicos eliminados exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos tecnico-economicos no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los datos tecnico-economicos del acuicultor fisico', 500);
        }
    }
}
