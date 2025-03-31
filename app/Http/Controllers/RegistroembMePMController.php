<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registroemb_me_PM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroembMePMController extends Controller
{
    /**
     * Despliega la lista de embarcaciones menores del pescador moral.
     */
    public function index()
    {
        try {
            $embarcacionMePM = registroemb_me_PM::all();
            $result = $embarcacionMePM->map(function ($item){
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
                    'estado_emb' => $item->estado_emb,
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
            return ApiResponse::success('Lista de las embarcaciones menores del pescador moral', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de las embarcaciones menores: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea una embarcacion menor del pescador moral.
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

            $existeEmbMenorPM = registroemb_me_PM::where('nombre_emb', $data['nombre_emb'])
            ->orWhere('matricula', $data['matricula'])
            ->orWhere('RNP', $data['RNP']) 
            ->exists();

            if ($existeEmbMenorPM) {
                $errors = [];
                if (registroemb_me_PM::where('nombre_emb', $data['nombre_emb'])->exists()) {
                    $errors['nombre_emb'] = 'Este nombre ya esta registrado';
                }
                if (registroemb_me_PM::where('matricula', $data['matricula'])->exists()) {
                    $errors['matricula'] = 'Esta matricula ya esta registrada';
                }
                if (registroemb_me_PM::where('RNP', $data['RNP'])->exists()) {
                    $errors['RNP'] = 'Este RNP ya esta registrado';
                }
                return ApiResponse::error('Esta embarcación menor ya existe', 422, $errors);
            }

            $embarcacionMePM = registroemb_me_PM::create($data);
            return ApiResponse::success('Embarcación menor creada existosamente', 201, $embarcacionMePM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la embarcación menor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra los datos de una embarcacion menor del pescador moral.
     */
    public function show($id)
    {
        try {
            $embarcacionMePM = registroemb_me_PM::findOrFail($id);
            $result = [
                'id' => $embarcacionMePM->id,
                'userprofile_id' => $embarcacionMePM->perfil_usuario->id,
                'nombre_emb' => $embarcacionMePM->nombre_emb,
                'matricula' => $embarcacionMePM->matricula,
                'RNP' => $embarcacionMePM->RNP,
                'modelo_emb' => $embarcacionMePM->modelo_emb,
                'capacidad_emb' => $embarcacionMePM->capacidad_emb,
                'vida_util_emb'=> $embarcacionMePM->vida_util_emb,
                'marca_emb' => $embarcacionMePM->marca_emb,
                'numpescadores_emb' => $embarcacionMePM->numpescadores_emb,
                'estado_emb' => $embarcacionMePM->estado_emb,
                'manga_metros' => $embarcacionMePM->manga_metros,
                'eslora_metros' => $embarcacionMePM->eslora_metros,
                'capacidad_carga' => $embarcacionMePM->capacidad_carga,
                'puntal_metros' => $embarcacionMePM->puntal_metros,
                'certificado_seg_mar' => $embarcacionMePM->certificado_seg_mar,
                'movilidad_emb' => $embarcacionMePM->movilidad_emb,
                'created_at' => $embarcacionMePM->created_at,
                'updated_at' => $embarcacionMePM->updated_at,
            ];
            return ApiResponse::success('Embarcación menor obtenida existosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la embarcación menor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza una embarcacion menor del pescador moral.
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

            /*$existeEmbMenorPM = registroemb_me_PM::where('nombre_emb', $request->nombre_emb)
            ->orwhere('matricula', $request->matricula)
            ->orwhere('RNP', $request->RNP)
            ->first();
            if ($existeEmbMenorPM) {
                return ApiResponse::error('Esta embarcación menor ya existe', 422);
            }*/

            $existeEmbMenorPM = registroemb_me_PM::where(function($query) use ($request) {
                $query->where('nombre_emb', $request->nombre_emb)
                ->orWhere('matricula', $request->matricula)
                ->orWhere('RNP', $request->RNP);
            })
            ->where('id', '!=', $id) 
            ->first();

            if ($existeEmbMenorPM) {
                return ApiResponse::error('Este embarcación menor ya existe', 422);
            }

            $embarcacionMePM = registroemb_me_PM::findOrFail($id);
            $embarcacionMePM->update($request->all());
            return ApiResponse::success('Embarcación menor actualizada exitosamente', 200, $embarcacionMePM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación menor no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la embarcación menor: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina una embarcacion menor del pescador moral.
     */
    public function destroy($id)
    {
        try {
            $embarcacionMePM = registroemb_me_PM::findOrFail($id);
            $embarcacionMePM->delete();
            return ApiResponse::success('Embarcación menor eliminada exitosamente', 200, $embarcacionMePM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Embarcación menor no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la embarcación menor: ' .$e->getMessage(), 500);
        }
    }
}
