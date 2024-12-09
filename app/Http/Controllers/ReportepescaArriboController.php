<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\reportepesca_arribo;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReportepescaArriboController extends Controller
{
    /**
     * Despliega la lista de los reportes de pesca de arribo.
     */
    public function index()
    {
        try {
            $ReportesPescaArribo = reportepesca_arribo::all();
            $result = $ReportesPescaArribo->map(function ($item){
                return [
                    'id' => $item->id,
                    'dia' => $item->dia,
                    'mes' => $item->mes,
                    'anio' => $item->anio,
                    'especie' => $item->especie,
                    'volumen_prodkg' => $item->volumen_prodkg,
                    'talla_promedio' => $item->talla_promedio,
                    'zona_captura' => $item->zona_captura,
                    'valor_estimado_cap' => $item->valor_estimado_cap,
                    'embarcacion' => $item->embarcacion,
                    'arte_pesca' => $item->arte_pesca,
                    'metodo_traslado' => $item->metodo_traslado,
                    'pesca_accidental' => $item->pesca_accidental ? '1' : '0',
                    'quien_hizo_reporte' => $item->quien_hizo_reporte == 'Representante' ? 'Representante' :
                    ($item->quien_hizo_reporte == 'Socio' ? 'Socio' : 'Representante'),
                    'nombre_hizo_rep' => $item->nombre_hizo_reporte,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at
                ];
            });
            return ApiResponse::success('Lista de reportes de pesca de arribo', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los reportes de pesca de arribo: ' .$e->getMessage(), 500 );
        }
    }

    /**
     * Genera un nuevo reporte de pesca de arribo.
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
                'zona_captura' => 'required|string|max:50',
                'valor_estimado_cap' => 'required|numeric',
                'embarcacion' => 'required|string|max:50',
                'arte_pesca' => 'required|string|max:50',
                'metodo_traslado' => 'required|string|max:50',
                'pesca_accidental' => 'required|boolean',
                'quien_hizo_reporte' => 'required|in:Representante,Socio',
                'nombre_hizo_rep' => 'required|string|max:50'
            ]);

            $existeReporteArribo = reportepesca_arribo::where(function ($query) use ($data){
                $query->where('dia', $data['dia'])
                ->orWhere('mes', $data['mes'])
                ->orWhere('anio', $data['anio']);
            })->first();

            if ($existeReporteArribo) {
                $errors = [];
                if ($existeReporteArribo->dia === $data['dia']) {
                    $errors['dia'] = 'El dia del registro ya existe.';
                }
                if ($existeReporteArribo->mes === $data['mes']) {
                    $errors['mes'] = 'El mes del registro ya existe.';
                }
                if ($existeReporteArribo->anio === $data['anio']) {
                    $errors['anio'] = 'El año del registro ya existe.';
                }
                return ApiResponse::error('Este reporte ya esta registrado', 422, $errors);
            }

            $ReportesPescaArribo = reportepesca_arribo::create($data);
            return ApiResponse::success('Reporte de pesca de arribo creado exitosamente', 201, $ReportesPescaArribo);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' .$e->getMessage(), 422);
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el reporte de pesca de arribo: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra un registro de reporte de pesca de arribo
     */
    public function show($id)
    {
        try {
            $ReportesPescaArribo = reportepesca_arribo::findOrFail($id);
            $result = [
                'id' => $ReportesPescaArribo->id,
                'dia' => $ReportesPescaArribo->dia,
                'mes' => $ReportesPescaArribo->mes,
                'anio' => $ReportesPescaArribo->anio,
                'especie' => $ReportesPescaArribo->especie,
                'volumen_prodkg' => $ReportesPescaArribo->volumen_prodkg,
                'talla_promedio' => $ReportesPescaArribo->talla_promedio,
                'zona_captura' => $ReportesPescaArribo->zona_captura,
                'valor_estimado_cap' => $ReportesPescaArribo->valor_estimado_cap,
                'embarcacion' => $ReportesPescaArribo->embarcacion,
                'arte_pesca' => $ReportesPescaArribo->arte_pesca,
                'metodo_traslado' => $ReportesPescaArribo->metodo_traslado,
                'pesca_accidental' => $ReportesPescaArribo->pesca_accidental ? '1' : '0',
                'quien_hizo_reporte' => $ReportesPescaArribo->quien_hizo_reporte == 'Representante' ? 'Representante' :
                ($ReportesPescaArribo->quien_hizo_reporte == 'Socio' ? 'Socio' : 'Representante'),
                'nombre_hizo_rep' => $ReportesPescaArribo->nombre_hizo_rep
            ];
            return ApiResponse::success('Reporte de pesca de arribo obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Reporte de pesca de arribo no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el reporte de pesca de arribo: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un reporte de pesca de arribo.
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
                'zona_captura' => 'required|string|max:50',
                'valor_estimado_cap' => 'required|numeric',
                'embarcacion' => 'required|string|max:50',
                'arte_pesca' => 'required|string|max:50',
                'metodo_traslado' => 'required|string|max:50',
                'pesca_accidental' => 'required|boolean',
                'quien_hizo_reporte' => 'required|in:Representante,Socio',
                'nombre_hizo_rep' => 'required|string|max:50'
            ]);

            $existeReporteArribo = reportepesca_arribo::where(function ($query) use ($data, $id) {
                $query->where('dia', $data['dia'])
                ->orWhere('mes', $data['mes'])
                ->orWhere('anio', $data['anio']);
            })->where('id', '!=', $id)->first();

            if ($existeReporteArribo) {
                $errors = [];
                if ($existeReporteArribo->dia === $request->dia) {
                    $errors['dia'] = 'El dia del registro del reporte ya esta existe.';
                }
                if ($existeReporteArribo->mes === $request->mes) {
                    $errors['mes'] = 'El mes del registro del reporte ya esta existe.';
                }
                if ($existeReporteArribo->anio === $request->anio) {
                    $errors['anio'] = 'El año del registro del reporte ya esta registrado.';
                }
                return ApiResponse::error('El reporte de pesca de arribo ya existe', 422, $errors);
            }

            $ReportesPescaArribo = reportepesca_arribo::findOrFail($id);
            $ReportesPescaArribo->update($data);
            return ApiResponse::success('Reporte de pesca de arribo actualizado exitosamente', 200, $ReportesPescaArribo);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Reporte de pesca de arribo no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el reporte de pesca de arribo: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un reporte de pesca de arribo.
     */
    public function destroy($id)
    {
        try {
            $ReportesPescaArribo = reportepesca_arribo::findOrFail($id);
            $ReportesPescaArribo->delete();
            return ApiResponse::success('Reporte de pesca de arribo eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Reporte de pesca de arribo no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el reporte de pesca de arribo: ' .$e->getMessage(), 500);
        }
    }
}
