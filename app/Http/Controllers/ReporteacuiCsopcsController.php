<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\reporteacui_csopcs;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReporteacuiCsopcsController extends Controller
{
    /**
     * Despliega la lista de reportes de acuicultura.
     */
    public function index()
    {
        try {
            $ReporteacuiCsopcs = reporteacui_csopcs::all();
            $result = $ReporteacuiCsopcs->map(function ($item){
                return [
                    'id' => $item->id,
                    'dia' => $item->dia,
                    'mes' => $item->mes,
                    'anio' => $item->anio,
                    'especie' => $item->especie,
                    'volumen_prodkg' => $item->volumen_prodkg,
                    'talla_promedio' => $item->talla_promedio,
                    'destino_produccion' => $item->destino_produccion,
                    'valor_estimado_cap' => $item->valor_estimado_cap,
                    'siembra_dias' => $item->siembra_dias,
                    'siembra_mes' => $item->siembra_mes,
                    'siembra_anio' => $item->siembra_anio,
                    'unidad_receptora' => $item->unidad_receptora,
                    'siembra_especie' => $item->siembra_especie,
                    'numero_organismos' => $item->numero_organismos,
                    'estadio' => $item->estadio,
                    'pais' => $item->pais,
                    'estado' => $item->estado,
                    'municipio' => $item->municipio,
                    'localidad' => $item->localidad,
                    'unidad_procedencia' => $item->unidad_procedencia,
                    'certificado_sanitario' => $item->certificado_sanitario,
                    'guia_pesca' => $item->guia_pesca,
                    'valor_lote' => $item->valor_lote,
                    'metodo_traslado' => $item->metodo_traslado,
                    'criasemilla_dia' => $item->criasemilla_dia,
                    'criasemilla_mes' => $item->criasemilla_mes,
                    'criasemilla_anio' => $item->criasemilla_anio,
                    'num_organismosem' => $item->num_organismosem,
                    'periodo_prod_ini' => $item->periodo_prod_ini,
                    'periodo_prod_fin' => $item->periodo_prod_fin,
                    'estadio_salida' => $item->estadio_salida,
                    'talla_salida' => $item->talla_salida,
                    'detino_prod' => $item->detino_prod,
                    'valor_produccion' => $item->valor_produccion,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at
                ];
            });
            return ApiResponse::success('Lista de reportes de acuicultura', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los reportes de acuicultura: ' .$e->getMessage(), 500 );
        }
    }

    /**
     * Genera un nuevo reporte de acuicultura.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'dia' => 'required|string|max:50',
                'mes' => 'required|string|max:50',
                'anio' => 'required|string|max:50',
                'especie' => 'required|string|max:50',
                'volumen_prodkg' => 'required|numeric',
                'talla_promedio' => 'required|numeric',
                'destino_produccion' => 'required|string|max:50',
                'valor_estimado_cap' => 'required|numeric',
                'siembra_dias' => 'required|string|max:50',
                'siembra_mes' => 'required|string|max:50',
                'siembra_anio' => 'required|string|max:50',
                'unidad_receptora' => 'required|string|max:50',
                'siembra_especie' => 'required|string|max:50',
                'numero_organismos' => 'required|string|max:50',
                'estadio' => 'required|string|max:50',
                'pais' => 'required|string|max:50',
                'estado' => 'required|string|max:50',
                'municipio' => 'required|string|max:50',
                'localidad' => 'required|string|max:50',
                'unidad_procedencia' => 'required|string|max:50',
                'certificado_sanitario' => 'required|string|max:255',
                'guia_pesca' => 'required|string|max:50',
                'valor_lote' => 'required|numeric',
                'metodo_traslado' => 'required|string|max:50',
                'criasemilla_dia' => 'required|string|max:50',
                'criasemilla_mes' => 'required|string|max:50',
                'criasemilla_anio' => 'required|string|max:50',
                'num_organismosem' => 'required|string|max:50',
                'periodo_prod_ini' => 'required|date',
                'periodo_prod_fin' => 'required|date',
                'estadio_salida' => 'required|string|max:50',
                'talla_salida' => 'required|string|max:50',
                'detino_prod' => 'required|string|max:50',
                'valor_produccion' => 'required|numeric'
            ]);

            $existeReporteacuiCsopcs = reporteacui_csopcs::where(function ($query) use ($data){
                $query->where('dia', $data['dia'])
                ->orWhere('mes', $data['mes'])
                ->orWhere('anio', $data['anio']);
            })->first();

            if ($existeReporteacuiCsopcs) {
                $errors = [];
                if ($existeReporteacuiCsopcs->dia === $data['dia']) {
                    $errors['dia'] = 'El dia del registro ya existe.';
                }
                if ($existeReporteacuiCsopcs->mes === $data['mes']) {
                    $errors['mes'] = 'El mes del registro ya existe.';
                }
                if ($existeReporteacuiCsopcs->anio === $data['anio']) {
                    $errors['anio'] = 'El año del registro ya existe.';
                }
                return ApiResponse::error('Este reporte ya esta registrado', 422, $errors);
            }

            $ReporteacuiCsopcs = reporteacui_csopcs::create($data);
            return ApiResponse::success('Reporte de acuicultura creado exitosamente', 201, $ReporteacuiCsopcs);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422);
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el reporte de acuicultura: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra la información de un reporte de acuicultura.
     */
    public function show($id)
    {
        try {
            $ReporteacuiCsopcs = reporteacui_csopcs::findOrFail($id);
            $result = [
                'id' => $ReporteacuiCsopcs->id,
                'dia' => $ReporteacuiCsopcs->dia,
                'mes' => $ReporteacuiCsopcs->mes,
                'anio' => $ReporteacuiCsopcs->anio,
                'especie' => $ReporteacuiCsopcs->especie,
                'volumen_prodkg' => $ReporteacuiCsopcs->volumen_prodkg,
                'talla_promedio' => $ReporteacuiCsopcs->talla_promedio,
                'destino_produccion' => $ReporteacuiCsopcs->destino_produccion,
                'valor_estimado_cap' => $ReporteacuiCsopcs->valor_estimado_cap,
                'siembra_dias' => $ReporteacuiCsopcs->siembra_dias,
                'siembra_mes' => $ReporteacuiCsopcs->siembra_mes,
                'siembra_anio' => $ReporteacuiCsopcs->siembra_anio,
                'unidad_receptora' => $ReporteacuiCsopcs->unidad_receptora,
                'siembra_especie' => $ReporteacuiCsopcs->siembra_especie,
                'numero_organismos' => $ReporteacuiCsopcs->numero_organismos,
                'estadio' => $ReporteacuiCsopcs->estadio,
                'pais' => $ReporteacuiCsopcs->pais,
                'estado' => $ReporteacuiCsopcs->estado,
                'municipio' => $ReporteacuiCsopcs->municipio,
                'localidad' => $ReporteacuiCsopcs->localidad,
                'unidad_procedencia' => $ReporteacuiCsopcs->unidad_procedencia,
                'certificado_sanitario' => $ReporteacuiCsopcs->certificado_sanitario,
                'guia_pesca' => $ReporteacuiCsopcs->guia_pesca,
                'valor_lote' => $ReporteacuiCsopcs->valor_lote,
                'metodo_traslado' => $ReporteacuiCsopcs->metodo_traslado,
                'criasemilla_dia' => $ReporteacuiCsopcs->criasemilla_dia,
                'criasemilla_mes' => $ReporteacuiCsopcs->criasemilla_mes,
                'criasemilla_anio' => $ReporteacuiCsopcs->criasemilla_anio,
                'num_organismosem' => $ReporteacuiCsopcs->num_organismosem,
                'periodo_prod_ini' => $ReporteacuiCsopcs->periodo_prod_ini,
                'periodo_prod_fin' => $ReporteacuiCsopcs->periodo_prod_fin,
                'estadio_salida' => $ReporteacuiCsopcs->estadio_salida,
                'talla_salida' => $ReporteacuiCsopcs->talla_salida,
                'detino_prod' => $ReporteacuiCsopcs->detino_prod,
                'valor_produccion' => $ReporteacuiCsopcs->valor_produccion,
                'created_at' => $ReporteacuiCsopcs->created_at,
                'updated_at' => $ReporteacuiCsopcs->updated_at
            ];
            return ApiResponse::success('Reporte de acuicultura obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Reporte de acuicultura no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el reporte de acuicultura: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Edita los datos de un reporte de acuicultura.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'dia' => 'required|string|max:50',
                'mes' => 'required|string|max:50',
                'anio' => 'required|string|max:50',
                'especie' => 'required|string|max:50',
                'volumen_prodkg' => 'required|numeric',
                'talla_promedio' => 'required|numeric',
                'destino_produccion' => 'required|string|max:50',
                'valor_estimado_cap' => 'required|numeric',
                'siembra_dias' => 'required|string|max:50',
                'siembra_mes' => 'required|string|max:50',
                'siembra_anio' => 'required|string|max:50',
                'unidad_receptora' => 'required|string|max:50',
                'siembra_especie' => 'required|string|max:50',
                'numero_organismos' => 'required|string|max:50',
                'estadio' => 'required|string|max:50',
                'pais' => 'required|string|max:50',
                'estado' => 'required|string|max:50',
                'municipio' => 'required|string|max:50',
                'localidad' => 'required|string|max:50',
                'unidad_procedencia' => 'required|string|max:50',
                'certificado_sanitario' => 'required|string|max:255',
                'guia_pesca' => 'required|string|max:50',
                'valor_lote' => 'required|numeric',
                'metodo_traslado' => 'required|string|max:50',
                'criasemilla_dia' => 'required|string|max:50',
                'criasemilla_mes' => 'required|string|max:50',
                'criasemilla_anio' => 'required|string|max:50',
                'num_organismosem' => 'required|string|max:50',
                'periodo_prod_ini' => 'required|date',
                'periodo_prod_fin' => 'required|date',
                'estadio_salida' => 'required|string|max:50',
                'talla_salida' => 'required|string|max:50',
                'detino_prod' => 'required|string|max:50',
                'valor_produccion' => 'required|numeric'
            ]);

            $existeReporteacuiCsopcs = reporteacui_csopcs::where(function ($query) use ($data, $id) {
                $query->where('dia', $data['dia'])
                ->orWhere('mes', $data['mes'])
                ->orWhere('anio', $data['anio']);
            })->where('id', '!=', $id)->first();

            if ($existeReporteacuiCsopcs) {
                $errors = [];
                if ($existeReporteacuiCsopcs->dia === $request->dia) {
                    $errors['dia'] = 'El dia del registro del reporte ya esta existe.';
                }
                if ($existeReporteacuiCsopcs->mes === $request->mes) {
                    $errors['mes'] = 'El mes del registro del reporte ya esta existe.';
                }
                if ($existeReporteacuiCsopcs->anio === $request->anio) {
                    $errors['anio'] = 'El año del registro del reporte ya esta registrado.';
                }
                return ApiResponse::error('El reporte de acuicultura ya existe', 422, $errors);
            }

            $ReporteacuiCsopcs = reporteacui_csopcs::findOrFail($id);
            $ReporteacuiCsopcs->update($data);
            return ApiResponse::success('Reporte de acuicultura actualizado exitosamente', 200, $ReporteacuiCsopcs);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Reporte de acuicultura no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el reporte de acuicultura: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un reporte de acuicultura.
     */
    public function destroy($id)
    {
        try {
            $ReporteacuiCsopcs = reporteacui_csopcs::findOrFail($id);
            $ReporteacuiCsopcs->delete();
            return ApiResponse::success('Reporte de acuicultura eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Reporte de acuicultura no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el reporte de acuicultura: ' .$e->getMessage(), 500);
        }
    }
}
