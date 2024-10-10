<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EquipoMenor_PM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EquipoMenorPMController extends Controller
{
    /**
     * Despliega la lista de los equipos de operaciones para embarcaciones menores del PM.
     */
    public function index()
    {
        try {
            $EquipoMenorPM = EquipoMenor_PM::all();
            $result = $EquipoMenorPM->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->registroemb_me_pm->id,
                    'cuenta_siscon' => $item->cuenta_siscon,
                    'sistema_conserva' => $item->sistema_conserva,
                    'siscon_cant' => $item->siscon_cant,
                    'siscon_tipo' => $item->siscon_tipo,
                    'cuenta_eqradiocom' => $item->cuenta_eqradiocom,
                    'equipo_radiocomun' => $item->equipo_radiocomun,
                    'eqradiocom_cant' => $item->eqradiocom_cant,
                    'eqradiocom_tipo' => $item->eqradiocom_tipo,
                    'cuenta_eqseguridad' => $item->cuenta_eqseguridad,
                    'equipo_seguridad' => $item->equipo_seguridad,
                    'eqseg_cant' => $item->eqseg_cant,
                    'eqseg_tipo' => $item->eqseg_tipo,
                    'cuenta_eqmanejo' => $item->cuenta_eqmanejo,
                    'equipo_manejo' => $item->equipo_manejo,
                    'eqmanejo_cant' => $item->eqmanejo_cant,
                    'eqmanejo_tipo' => $item->eqmanejo_tipo,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los equipos de operación para embarcaciones menores', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los equipos de operación para embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un equipo de operación menor para el PM.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required|exists:registroemb_me_pm,id',
                'cuenta_siscon' => 'required|boolean',
                'sistema_conserva' => 'required|string|max:50',
                'siscon_cant' => 'required|integer',
                'siscon_tipo' => 'required|string|max:50',
                'cuenta_eqradiocom' => 'required|boolean',
                'equipo_radiocomun' => 'required|string|max:50',
                'eqradiocom_cant' => 'required|integer',
                'eqradiocom_tipo' => 'required|string|max:50',
                'cuenta_eqseguridad' => 'required|boolean',
                'equipo_seguridad' => 'required|string|max:50',
                'eqseg_cant' => 'required|integer',
                'eqseg_tipo' => 'required|string|max:50',
                'cuenta_eqmanejo' => 'required|boolean',
                'equipo_manejo' => 'required|string|max:50',
                'eqmanejo_cant' => 'required|integer',
                'eqmanejo_tipo' => 'required|string|max:50'
            ]);

            $existeEquipoMenorPM = EquipoMenor_PM::where('emb_pertenece_id', $data['emb_pertenece_id'])->first();
            if ($existeEquipoMenorPM) {
                $errors = [];
                if ($existeEquipoMenorPM->emb_pertenece_id === $data['emb_pertenece_id']) {
                    $errors['emb_pertenece_id'] = 'Esta embarcación ya cuenta con equipos de operación';
                }
                return ApiResponse::error('Estos equipos de operación ya estan registrados en esta embarcación menor', 422, $errors);
            }

            $EquipoMenorPM = EquipoMenor_PM::create($data);
            return ApiResponse::success('Equipos de operación registrados exitosamente', 201, $EquipoMenorPM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los equipos de operaciones: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra un equipo de operación menor del PM.
     */
    public function show($id)
    {
        try {
            $EquipoMenorPM = EquipoMenor_PM::findOrFail($id);
            $result = [
                'id' => $EquipoMenorPM->id,
                'emb_pertenece_id' => $EquipoMenorPM->registroemb_me_pm->id,
                'cuenta_siscon' => $EquipoMenorPM->cuenta_siscon,
                'sistema_conserva' => $EquipoMenorPM->sistema_conserva,
                'siscon_cant' => $EquipoMenorPM->siscon_cant,
                'siscon_tipo' => $EquipoMenorPM->siscon_tipo,
                'cuenta_eqradiocom' => $EquipoMenorPM->cuenta_eqradiocom,
                'equipo_radiocomun' => $EquipoMenorPM->equipo_radiocomun,
                'eqradiocom_cant' => $EquipoMenorPM->eqradiocom_cant,
                'eqradiocom_tipo' => $EquipoMenorPM->eqradiocom_tipo,
                'cuenta_eqseguridad' => $EquipoMenorPM->cuenta_eqseguridad,
                'equipo_seguridad' => $EquipoMenorPM->equipo_seguridad,
                'eqseg_cant' => $EquipoMenorPM->eqseg_cant,
                'eqseg_tipo' => $EquipoMenorPM->eqseg_tipo,
                'cuenta_eqmanejo' => $EquipoMenorPM->cuenta_eqmanejo,
                'equipo_manejo' => $EquipoMenorPM->equipo_manejo,
                'eqmanejo_cant' => $EquipoMenorPM->eqmanejo_cant,
                'eqmanejo_tipo' => $EquipoMenorPM->eqmanejo_tipo,
                'created_at' => $EquipoMenorPM->created_at,
                'updated_at' => $EquipoMenorPM->updated_at,
            ];
            return ApiResponse::success('Equipos de operaciones obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipos de operaciones no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los equipos de operaciones: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un equipo de operación menor del PM.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'emb_pertenece_id' => 'required',
                'cuenta_siscon' => 'required|boolean',
                'sistema_conserva' => 'required|string|max:50',
                'siscon_cant' => 'required|integer',
                'siscon_tipo' => 'required|string|max:50',
                'cuenta_eqradiocom' => 'required|boolean',
                'equipo_radiocomun' => 'required|string|max:50',
                'eqradiocom_cant' => 'required|integer',
                'eqradiocom_tipo' => 'required|string|max:50',
                'cuenta_eqseguridad' => 'required|boolean',
                'equipo_seguridad' => 'required|string|max:50',
                'eqseg_cant' => 'required|integer',
                'eqseg_tipo' => 'required|string|max:50',
                'cuenta_eqmanejo' => 'required|boolean',
                'equipo_manejo' => 'required|string|max:50',
                'eqmanejo_cant' => 'required|integer',
                'eqmanejo_tipo' => 'required|string|max:50'
            ]);

            $existeEquipoMenorPM = EquipoMenor_PM::where('emb_pertenece_id', $request->emb_pertenece_id)->first();
            if ($existeEquipoMenorPM) {
                return ApiResponse::error('Estos equipos de operación ya estan registrados en esta embarcación menor', 422);
            }

            $EquipoMenorPM = EquipoMenor_PM::findOrFail($id);
            $EquipoMenorPM->update($request->all());
            return ApiResponse::success('Equipos de Operaciones actualizados exitosamente', 200, $EquipoMenorPM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipos de operaciones no encontrados', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación:' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar los equipos de operaciones: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operación menor del PM.
     */
    public function destroy($id)
    {
        try {
            $EquipoMenorPM = EquipoMenor_PM::findOrFail($id);
            $EquipoMenorPM->delete();
            return ApiResponse::success('Equipos de operaciones eliminados exitosamente', 200, $EquipoMenorPM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipos de operaciones no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los equipos de operaciones: ' .$e->getMessage(), 500);
        }
    }
}
