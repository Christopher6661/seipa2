<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\EquipoMenor_PF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EquipoMenorPFController extends Controller
{
    /**
     * Despliega la lista de los equipos de operaciones para embarcaciones menores.
     */
    public function index()
    {
        try {
            $EquipoMenorPF = EquipoMenor_PF::all();
            $result = $EquipoMenorPF->map(function ($item){
                return [
                    'id' => $item->id,
                    'emb_pertenece_id' => $item->registroemb_me_pf->id,
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
     * Crea un equipo de operación menor.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'emb_pertenece_id' => 'required|exists:registroemb_me_pf,id',
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

            $existeEquipoMenorPF = EquipoMenor_PF::where('emb_pertenece_id', $data['emb_pertenece_id'])->first();
            if ($existeEquipoMenorPF) {
                $errors = [];
                if ($existeEquipoMenorPF->emb_pertenece_id === $data['emb_pertenece_id']) {
                    $errors['emb_pertenece_id'] = 'Esta embarcación ya cuenta con equipos de operación';
                }
                return ApiResponse::error('Estos equipos de operación ya estan registrados en esta embarcación menor', 422, $errors);
            }

            $EquipoMenorPF = EquipoMenor_PF::create($data);
            return ApiResponse::success('Equipos de operación registrados exitosamente', 201, $EquipoMenorPF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar los equipos de operaciones: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra un equipo de operación menor.
     */
    public function show($id)
    {
        try {
            $EquipoMenorPF = EquipoMenor_PF::findOrFail($id);
            $result = [
                'id' => $EquipoMenorPF->id,
                'emb_pertenece_id' => $EquipoMenorPF->registroemb_me_pf->id,
                'cuenta_siscon' => $EquipoMenorPF->cuenta_siscon,
                'sistema_conserva' => $EquipoMenorPF->sistema_conserva,
                'siscon_cant' => $EquipoMenorPF->siscon_cant,
                'siscon_tipo' => $EquipoMenorPF->siscon_tipo,
                'cuenta_eqradiocom' => $EquipoMenorPF->cuenta_eqradiocom,
                'equipo_radiocomun' => $EquipoMenorPF->equipo_radiocomun,
                'eqradiocom_cant' => $EquipoMenorPF->eqradiocom_cant,
                'eqradiocom_tipo' => $EquipoMenorPF->eqradiocom_tipo,
                'cuenta_eqseguridad' => $EquipoMenorPF->cuenta_eqseguridad,
                'equipo_seguridad' => $EquipoMenorPF->equipo_seguridad,
                'eqseg_cant' => $EquipoMenorPF->eqseg_cant,
                'eqseg_tipo' => $EquipoMenorPF->eqseg_tipo,
                'cuenta_eqmanejo' => $EquipoMenorPF->cuenta_eqmanejo,
                'equipo_manejo' => $EquipoMenorPF->equipo_manejo,
                'eqmanejo_cant' => $EquipoMenorPF->eqmanejo_cant,
                'eqmanejo_tipo' => $EquipoMenorPF->eqmanejo_tipo,
                'created_at' => $EquipoMenorPF->created_at,
                'updated_at' => $EquipoMenorPF->updated_at,
            ];
            return ApiResponse::success('Equipos de operaciones obtenidos exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipos de operaciones no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los equipos de operaciones: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza un equipo de operación menor.
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

            $existeEquipoMenorPF = EquipoMenor_PF::where('emb_pertenece_id', $request->emb_pertenece_id)->first();
            if ($existeEquipoMenorPF) {
                return ApiResponse::error('Estos equipos de operación ya estan registrados en esta embarcación menor', 422);
            }

            $EquipoMenorPF = EquipoMenor_PF::findOrFail($id);
            $EquipoMenorPF->update($request->all());
            return ApiResponse::success('Equipos de Operaciones actualizados exitosamente', 200, $EquipoMenorPF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipos de operaciones no encontrados', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación:' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar los equipos de operaciones: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina un equipo de operación menor.
     */
    public function destroy($id)
    {
        try {
            $EquipoMenorPF = EquipoMenor_PF::findOrFail($id);
            $EquipoMenorPF->delete();
            return ApiResponse::success('Equipos de operaciones eliminados exitosamente', 200, $EquipoMenorPF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipos de operaciones no encontrados', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar los equipos de operaciones: ' .$e->getMessage(), 500);
        }
    }
}
