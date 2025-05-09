<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registroemb_me_PF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroembMePFController extends Controller
{
    /**
     * Despliega la lista de embarcaciones menores.
     */
    public function index()
    {
        try {
            $embarcacionMePF = registroemb_me_PF::all();
            $result = $embarcacionMePF->map(function ($item){
                return [
                    'id' => $item->id,
                    'userprofile_id' => $item->perfil_usuario->name,
                    'nombre_emb' => $item->nombre_emb,
                    'matricula' => $item->matricula,
                    'RNP' => $item->RNP,
                    'modelo_emb' => $item->modelo_emb,
                    'capacidad_emb' => $item->capacidad_emb,
                    'vida_util_emb' => $item->vida_util_emb,
                    'marca_emb' => $item->marca_emb,
                    'numpescadores_emb' => $item->numpescadores_emb,
                    'estado_emb' =>  $item->estado_emb == 'Bueno' ? 'Bueno' :
                    ($item->estado_emb == 'Deplorable' ? 'Deplorable' : 'Malo'),
                    'manga_metros' => $item->manga_metros,
                    'eslora_metros' => $item->eslora_metros,
                    'capacidad_carga' => $item->capacidad_carga,
                    'puntal_metros' => $item->puntal_metros,
                    'certificado_seg_mar' => $item->certificad_seg_mar,
                    'movilidad_emb' => $item->movilidad_emb,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de las embarcaciones menores del pescador fisico', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de las embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea una embarcacion menor.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required|exists:users,id',
                'nombre_emb' => 'required|string|max:30',
                'matricula' => 'required|string|max:30',
                'RNP' => 'required|string|max:12',
                'modelo_emb' => 'required|string|max:30',
                'capacidad_emb' => 'required|string|max:200',
                'vida_util_emb' => 'required|string|max:200',
                'marca_emb' => 'required|string|max:30',
                'numpescadores_emb' => 'required|string|max:200',
                'estado_emb' => 'required|in:Bueno,Malo,Deplorable',
                'manga_metros' => 'required|numeric',
                'eslora_metros' => 'required|numeric',
                'capacidad_carga' => 'required|numeric',
                'puntal_metros' => 'required|numeric',
                'certificado_seg_mar' => 'required|string|max:255',
                'movilidad_emb' => 'required|string|max:50'
            ]);


            $embarcacionMePF = registroemb_me_PF::create($data);
            return ApiResponse::success('Embarcación menor creada existosamente', 201, $embarcacionMePF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la embarcación menor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de una embarcacion menor.
     */
    public function show($id)
    {
        try {
            $embarcacionMePF = registroemb_me_PF::findOrFail($id);
            $result = [
                'id' => $embarcacionMePF->id,
                'userprofile_id' => $embarcacionMePF->perfil_usuario->id,
                'nombre_emb' => $embarcacionMePF->nombre_emb,
                'matricula' => $embarcacionMePF->matricula,
                'RNP' => $embarcacionMePF->RNP,
                'modelo_emb' => $embarcacionMePF->modelo_emb,
                'capacidad_emb' => $embarcacionMePF->capacidad_emb,
                'vida_util_emb'=> $embarcacionMePF->vida_util_emb,
                'marca_emb' => $embarcacionMePF->marca_emb,
                'numpescadores_emb' => $embarcacionMePF->numpescadores_emb,
                'estado_emb' =>  $embarcacionMePF->estado_emb == 'Bueno' ? 'Bueno' :
                ($embarcacionMePF->estado_emb == 'Deplorable' ? 'Deplorable' : 'Malo'),
                'manga_metros' => $embarcacionMePF->manga_metros,
                'eslora_metros' => $embarcacionMePF->eslora_metros,
                'capacidad_carga' => $embarcacionMePF->capacidad_carga,
                'puntal_metros' => $embarcacionMePF->puntal_metros,
                'certificado_seg_mar' => $embarcacionMePF->certificado_seg_mar,
                'movilidad_emb' => $embarcacionMePF->movilidad_emb,
                'created_at' => $embarcacionMePF->created_at,
                'updated_at' => $embarcacionMePF->updated_at,
            ];
            return ApiResponse::success('Embarcación menor obtenida existosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la embarcación menor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza una embarcacion menor.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'userprofile_id' => 'required',
                'nombre_emb' => 'required|string|max:30',
                'matricula' => 'required|string|max:30',
                'RNP' => 'required|string|max:12',
                'modelo_emb' => 'required|string|max:30',
                'capacidad_emb' => 'required|string|max:200',
                'vida_util_emb' => 'required|string|max:200',
                'marca_emb' => 'required|string|max:30',
                'numpescadores_emb' => 'required|string|max:200',
                'estado_emb' => 'required|in:Bueno,Malo,Deplorable',
                'manga_metros' => 'required|numeric',
                'eslora_metros' => 'required|numeric',
                'capacidad_carga' => 'required|numeric',
                'puntal_metros' => 'required|numeric',
                'certificado_seg_mar' => 'required|string|max:255',
                'movilidad_emb' => 'required|string|max:50'
            ]);

            /*$existeEmbMenorPF = registroemb_me_PF::where('nombre_emb', $request->nombre_emb)
            ->orwhere('matricula', $request->matricula)
            ->orwhere('RNP', $request->RNP)
            ->first();
            if ($existeEmbMenorPF) {
                return ApiResponse::error('Esta embarcación menor ya existe', 422);
            }*/

            $existeNombreEmb = registroemb_me_PF::where('nombre_emb', $request->nombre_emb)
            ->where('id', '!=', $id)
            ->first();
            if ($existeNombreEmb) {
            return ApiResponse::error('Este nombre de embarcación menor ya está registrado.', 422);
            }
            
            $existeMatricula = registroemb_me_PF::where('matricula', $request->matricula)
            ->where('id', '!=', $id)
            ->first();
            if ($existeMatricula) {
            return ApiResponse::error('Esta matrícula ya está registrado.', 422);
            }
            $existeRNPA = registroemb_me_PF::where('RNP', $request->RNP)
            ->where('id', '!=', $id)
            ->first();
            if ($existeRNPA) {
            return ApiResponse::error('Este RNP ya está registrado.', 422);
            }

            $embarcacionMePF = registroemb_me_PF::findOrFail($id);
            $embarcacionMePF->update($request->all());
            return ApiResponse::success('Embarcación menor actualizada exitosamente', 200, $embarcacionMePF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación menor no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la embarcación menor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina una embarcacion menor.
     */
    public function destroy($id)
    {
        try {
            $embarcacionMePF = registroemb_me_PF::findOrFail($id);
            $embarcacionMePF->delete();
            return ApiResponse::success('Embarcación menor eliminada exitosamente', 200, $embarcacionMePF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación menor no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la embarcación menor: ' .$e->getMessage(), 500);
        }
    }
}
