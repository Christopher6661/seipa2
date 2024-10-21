<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_dattececon_AM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroDattececonAMController extends Controller
{
    /**
     * Despliega la lista de los datos tecnico-economicos de los acuicultores morales.
     */
    public function index()
    {
        try {
            $DatosTecnicoEconomicosAM = registro_dattececon_AM::all();
            $result = $DatosTecnicoEconomicosAM->map(function ($item){
                return [
                    'id' => $item->id,
                    'prodprom_x_mes' => $item->prodprom_x_mes,
                    'prodpromx_mes_peso' => $item->prodpromx_mes_peso,
                    'prodprom_mes_talla' => $item->prodprom_mes_talla, 
                    'ciclocultivoultimo_anio' => $item->ciclocultivoultimo_anio,
                    'ciclocult_ultanio_mes' => $item->ciclocult_ultanio_mes,
                    'capturacosecha_anio' => $item->capturacosecha_anio,
                    'capturacos_anio_peso' => $item->capturacos_anio_peso,
                    'captcosanio_mortalidad' => $item->captcosanio_mortalidad,
                    'destino_autoconsimo' => $item->destino_autoconsimo,
                    'destino_comercializacio' => $item->destino_comercializacio,
                    'destino_otro' => $item->destino_otro,
                    'tipo_mercado_local' => $item->tipo_mercado_local ? 'Sí' : 'No',
                    'tipo_mercado_estatal' => $item->tipo_mercado_estatal ? 'Sí' : 'No',
                    'tipo_mercado_regional' => $item->tipo_mercado_regional ? 'Sí' : 'No',
                    'tipo_mercado_otro' => $item->tipo_mercado_otro ? 'Sí' : 'No',
                    'fresco_entero' => $item->fresco_entero ? 'Sí' : 'No',
                    'fresco_entero_preckilo' => $item->fresco_entero_preckilo,
                    'evicerado' => $item->evicerado ? 'Sí' : 'No',
                    'evicerado_preciokilo' => $item->evicerado_preciokilo,
                    'enhielado' => $item->enhielado ? 'Sí' : 'No',
                    'enhielado_preciokilo' => $item->enhielado_preciokilo,
                    'otro' => $item->otro ? 'Sí' : 'No',
                    'otro_preciokilo' => $item->otro_preciokilo,
                    'fuenfinanza_programa' => $item->fuenfinanza_programa,
                    'fuentefianza_anio' => $item->fuentefianza_anio,
                    'costogasto_anualprod' => $item->costogasto_anualprod,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los datos tecnico-economicos de los acuicultores morales', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los datos tecnico-economicos de los acuicultores morales: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un registro de datos tecnico-economicos.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'prodprom_x_mes' => 'required|float',
                'prodpromx_mes_peso' => 'required|in:Kilogramo,Tonelada',
                'prodprom_mes_talla' => 'required|float', 
                'ciclocultivoultimo_anio' => 'required|string|max:30',
                'ciclocult_ultanio_mes' => 'required|string|max:30',
                'capturacosecha_anio' => 'required|string|max:30',
                'capturacos_anio_peso' => 'required|in:Kilogramo,Tonelada',
                'captcosanio_mortalidad' => 'required|float',
                'destino_autoconsimo' => 'required|float',
                'destino_comercializacio' => 'required|float',
                'destino_otro' => 'required|float',
                'tipo_mercado_local' => 'required|boolean',
                'tipo_mercado_estatal' => 'required|boolean',
                'tipo_mercado_regional' => 'required|boolean',
                'tipo_mercado_otro' => 'required|boolean',
                'fresco_entero' => 'required|boolean',
                'fresco_entero_preckilo' => 'required|numeric|max:9999999999.99',
                'evicerado' => 'required|boolean',
                'evicerado_preciokilo' => 'required|numeric|max:9999999999.99',
                'enhielado' => 'required|boolean',
                'enhielado_preciokilo' => 'required|numeric|max:9999999999.99',
                'otro' => 'required|boolean',
                'otro_preciokilo' => 'required|numeric|max:9999999999.99',
                'fuenfinanza_programa' => 'required|float',
                'fuentefianza_anio' => 'required|float',
                'costogasto_anualprod' => 'required|float',
            ]);

            $DatosTecnicoEconomicosAM = registro_dattececon_AM::create($data);
            return ApiResponse::success('Datos tecnico-economicos registrados exitosamente', 201, $DatosTecnicoEconomicosAM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los datos tecnico-economicos del acuicultor moral: ', 500);
        }
    }

    /**
     * Muestra los datos individuales de los registros de datos tecnico-economicos.
     */
    public function show($id)
    {
        try {
            $DatosTecnicoEconomicosAM = registro_dattececon_AM::findOrFail($id);
            $result = [
                'id' => $DatosTecnicoEconomicosAM->id,
                'prodprom_x_mes' => $DatosTecnicoEconomicosAM->prodprom_x_mes,
                'prodpromx_mes_peso' => $DatosTecnicoEconomicosAM->prodpromx_mes_peso,
                'prodprom_mes_talla' => $DatosTecnicoEconomicosAM->prodprom_mes_talla, 
                'ciclocultivoultimo_anio' => $DatosTecnicoEconomicosAM->ciclocultivoultimo_anio,
                'ciclocult_ultanio_mes' => $DatosTecnicoEconomicosAM->ciclocult_ultanio_mes,
                'capturacosecha_anio' => $DatosTecnicoEconomicosAM->capturacosecha_anio,
                'capturacos_anio_peso' => $DatosTecnicoEconomicosAM->capturacos_anio_peso,
                'captcosanio_mortalidad' => $DatosTecnicoEconomicosAM->captcosanio_mortalidad,
                'destino_autoconsimo' => $DatosTecnicoEconomicosAM->destino_autoconsimo,
                'destino_comercializacio' => $DatosTecnicoEconomicosAM->destino_comercializacio,
                'destino_otro' => $DatosTecnicoEconomicosAM->destino_otro,
                'tipo_mercado_local' => $DatosTecnicoEconomicosAM->tipo_mercado_local ? 'Sí' : 'No',
                'tipo_mercado_estatal' => $DatosTecnicoEconomicosAM->tipo_mercado_estatal ? 'Sí' : 'No',
                'tipo_mercado_regional' => $DatosTecnicoEconomicosAM->tipo_mercado_regional ? 'Sí' : 'No',
                'tipo_mercado_otro' => $DatosTecnicoEconomicosAM->tipo_mercado_otro ? 'Sí' : 'No',
                'fresco_entero' => $DatosTecnicoEconomicosAM->fresco_entero ? 'Sí' : 'No',
                'fresco_entero_preckilo' => $DatosTecnicoEconomicosAM->fresco_entero_preckilo,
                'evicerado' => $DatosTecnicoEconomicosAM->evicerado ? 'Sí' : 'No',
                'evicerado_preciokilo' => $DatosTecnicoEconomicosAM->evicerado_preciokilo,
                'enhielado' => $DatosTecnicoEconomicosAM->enhielado ? 'Sí' : 'No',
                'enhielado_preciokilo' => $DatosTecnicoEconomicosAM->enhielado_preciokilo,
                'otro' => $DatosTecnicoEconomicosAM->otro ? 'Sí' : 'No',
                'otro_preciokilo' => $DatosTecnicoEconomicosAM->otro_preciokilo,
                'fuenfinanza_programa' => $DatosTecnicoEconomicosAM->fuenfinanza_programa,
                'fuentefianza_anio' => $DatosTecnicoEconomicosAM->fuentefianza_anio,
                'costogasto_anualprod' => $DatosTecnicoEconomicosAM->costogasto_anualprod,
                'created_at' => $DatosTecnicoEconomicosAM->created_at,
                'updated_at' => $DatosTecnicoEconomicosAM->updated_at,
            ];
            return ApiResponse::success('Datos tecnico-economicos obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos tecnico-economicos no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos tecnico-economicos del acuicultor moral: ', 500);
        }
    }

    /**
     * Actualizar los datos tecnico-economicos del acuicultor moral.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'prodprom_x_mes' => 'required|float',
                'prodpromx_mes_peso' => 'required|in:Kilogramo,Tonelada',
                'prodprom_mes_talla' => 'required|float', 
                'ciclocultivoultimo_anio' => 'required|string|max:30',
                'ciclocult_ultanio_mes' => 'required|string|max:30',
                'capturacosecha_anio' => 'required|string|max:30',
                'capturacos_anio_peso' => 'required|in:Kilogramo,Tonelada',
                'captcosanio_mortalidad' => 'required|float',
                'destino_autoconsimo' => 'required|float',
                'destino_comercializacio' => 'required|float',
                'destino_otro' => 'required|float',
                'tipo_mercado_local' => 'required|boolean',
                'tipo_mercado_estatal' => 'required|boolean',
                'tipo_mercado_regional' => 'required|boolean',
                'tipo_mercado_otro' => 'required|boolean',
                'fresco_entero' => 'required|boolean',
                'fresco_entero_preckilo' => 'required|numeric|max:9999999999.99',
                'evicerado' => 'required|boolean',
                'evicerado_preciokilo' => 'required|numeric|max:9999999999.99',
                'enhielado' => 'required|boolean',
                'enhielado_preciokilo' => 'required|numeric|max:9999999999.99',
                'otro' => 'required|boolean',
                'otro_preciokilo' => 'required|numeric|max:9999999999.99',
                'fuenfinanza_programa' => 'required|float',
                'fuentefianza_anio' => 'required|float',
                'costogasto_anualprod' => 'required|float',
            ]);

            $DatosTecnicoEconomicosAM = registro_dattececon_AM::findOrFail($id);
            $DatosTecnicoEconomicosAM->update($data);
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
     * Eliminar datos tecnico-economicos del acuicultor moral.
     */
    public function destroy($id)
    {
        try {
            $DatosTecnicoEconomicosAM = registro_dattececon_AM::findOrFail($id);
            $DatosTecnicoEconomicosAM->delete();
            return ApiResponse::success('Datos tecnico-economicos eliminados exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Datos tecnico-economicos no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los datos tecnico-economicos del acuicultor moral', 500);
        }
    }
}
