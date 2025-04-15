<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\reportepesca_arribo;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Carbon\Carbon;

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
            $horasTranscurridas = \Carbon\Carbon::parse($item->created_at)->diffInHours(now());
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
                    'pesca_incidental' => $item->pesca_incidental == 'Sí' ? 'Sí' : ($item->pesca_incidental == 'No' ? 'No' : 'Si'),
                    'quien_hizo_reporte' => $item->quien_hizo_reporte == 'Representante' ? 'Representante' :
                    ($item->quien_hizo_reporte == 'Socio' ? 'Socio' : 'Representante'),
                    'nombre_hizo_rep' => $item->nombre_hizo_reporte,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'editable' => $horasTranscurridas < 24,
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
                'pesca_incidental' => 'required|in:Sí,No',
                'quien_hizo_reporte' => 'required|in:Representante,Socio',
                'nombre_hizo_rep' => 'required|string|max:50'
            ]);

            //
            $cantidadReportes = reportepesca_arribo::where('mes', $data['mes'])
                ->where('anio', $data['anio'])
                ->count();

                if ($cantidadReportes >=2) {
                    return ApiResponse::error('Solo se permiten hasta 2 reportes por mes.', 422);
                }

            $existeReporteArribo = reportepesca_arribo::where('dia', $data['dia'])
                ->where('mes', $data['mes'])
                ->where('anio', $data['anio'])
                ->first();

            if ($existeReporteArribo) {
                $errors = [];
                $errors['fecha'] = 'Ya existe un reporte con el mismo dia, mes y año';

                return ApiResponse::error('Repore ya registrado.', 422, $errors);
            }//

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
                'pesca_incidental' => $ReportesPescaArribo->pesca_incidental == 'Sí' ? 'Sí' : ($ReportesPescaArribo->pesca_incidental == 'No' ? 'No' : 'Si'),
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

            $ReportesPescaArribo = reportepesca_arribo::findOrFail($id);

            //Calcular si han pasado más de 24 horas desde la creación
            $tiempoLimite = 24;
            $fechaCreacion = new Carbon($ReportesPescaArribo->created_at);
            $ahora = Carbon::now();

            if ($fechaCreacion->diffInHours($ahora) > $tiempoLimite) {
                return ApiResponse::error('Este reporte ya no puede ser actualizado. Ha pasado el tiempo permitido de edicion (24 horas).', 403);
            }

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
                'pesca_incidental' => 'required|in:Sí,No',
                'quien_hizo_reporte' => 'required|in:Representante,Socio',
                'nombre_hizo_rep' => 'required|string|max:50'
            ]);

            //
            $cantidadReportes = reportepesca_arribo::where('mes', $data['mes'])
                ->where('anio', $data['anio'])
                ->where('id', '!=', $id)
                ->count();

                if ($cantidadReportes >=2) {
                    return ApiResponse::error('Solo se permiten hasta 2 reportes por mes.', 422);
                }

            $existeReporteArribo = reportepesca_arribo::where('dia', $data['dia'])
                ->where('mes', $data['mes'])
                ->where('anio', $data['anio'])
                ->where('id', '!=', $id)
                ->first();

            if ($existeReporteArribo) {
                $errors = [];
                $errors['fecha'] = 'Ya existe otro reporte con el mismo día, mes y año.';
                return ApiResponse::error('El reporte de pesca de arribo ya existe', 422, $errors);
            }//

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
