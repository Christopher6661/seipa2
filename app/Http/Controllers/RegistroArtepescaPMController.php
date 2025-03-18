<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_artepesca_PM;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroArtepescaPMController extends Controller
{
    /**
     * Despliega la lista de las artes de pesca del pescador moral.
     */
    public function index()
    {
        try {
            $ArtePescaPM = registro_artepesca_PM::with('esp_objetivo', 'arte_pesca')->get();
           
            $result = $ArtePescaPM->map(function ($item){
                return [
                    'id' => $item->id,
                    'tipo_artepesca_id' => $item->arte_pesca->nombre_artpesca,
                    'medida_largo' => $item->medida_largo,
                    'medida_ancho' => $item->medida_ancho,
                    'material' => $item->material,
                    'luz_malla' => $item->luz_malla,
                    'especie_obj_id' => $item->esp_objetivo ? $item->esp_objetivo->pluck('nombre_especie')->toArray() : [],
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de artes de pesca de pescador moral', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de artes de pesca para pescador moral: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Crea un arte de pesca.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'tipo_artepesca_id' => 'required|exists:arte_pesca,id',
                'medida_largo' => 'required|numeric',
                'medida_ancho' => 'required|numeric',
                'material' => 'required|string|max:30',
                'luz_malla' => 'required|numeric',
                'especie_obj_id' => 'required|array',
                'especie_obj_id.*' => 'integer|exists:especies,id', 
            ]);

            $especiesProdId = $data['especie_obj_id'];
            unset($data['especie_obj_id']);

            $existeArtePescaPM = registro_artepesca_PM::where('tipo_artepesca_id', $data['tipo_artepesca_id'])->first();
            if ($existeArtePescaPM) {
                $errors = [];
                if ($existeArtePescaPM->tipo_artepesca_id === $data['tipo_artepesca_id']) {
                    $errors['tipo_artepesca_id'] = 'Este arte de pesca ya esta registrado';
                }
                return ApiResponse::error('Este arte de pesca ya existe', 422, $errors);
            }

            $ArtePescaPM = registro_artepesca_PM::create($data);

            $ArtePescaPM->esp_objetivo()->attach($especiesProdId);

            return ApiResponse::success('Arte de pesca creado exitosamente', 201, $ArtePescaPM);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el arte de pesca: '  .$e->getMessage(), 500);
        }
    }

    /**
     * Muestra un arte de pesca.
     */
    public function show($id)
    {
        try {
            $ArtePescaPM = registro_artepesca_PM::with('esp_objetivo')->findOrFail($id);
            $result = [
                'id' => $ArtePescaPM->id,
                'tipo_artepesca_id' => $ArtePescaPM->arte_pesca->id,
                'medida_largo' => $ArtePescaPM->medida_largo,
                'medida_ancho' => $ArtePescaPM->medida_ancho,
                'material' => $ArtePescaPM->material,
                'luz_malla' => $ArtePescaPM->luz_malla,
                'especie_obj_id' => $ArtePescaPM->esp_objetivo ? $ArtePescaPM->esp_objetivo->pluck('nombre_especie')->toArray() : [],
                'created_at' => $ArtePescaPM->created_at,
                'updated_at' => $ArtePescaPM->updated_at,
            ];
            return ApiResponse::success('Arte de pesca obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el arte de pesca: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Actualiza el arte de pesca.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'tipo_artepesca_id' => 'required',
                'medida_largo' => 'required|numeric',
                'medida_ancho' => 'required|numeric',
                'material' => 'required|string|max:30',
                'luz_malla' => 'required|numeric',
                'especie_obj_id' => 'required|array',
                'especie_obj_id.*' => 'integer|exists:especies,id',
            ]);
    
            $especiesProdId = $data['especie_obj_id'];
            unset($data['especie_obj_id']);
    
            $existeArtePescaPM = registro_artepesca_PM::where('tipo_artepesca_id', $data['tipo_artepesca_id'])
                ->where('id', '!=', $id)
                ->first();
    
            if ($existeArtePescaPM) {
                return ApiResponse::error('El tipo de arte de pesca ya está registrado.', 422);
            }

            $ArtePescaPM = registro_artepesca_PM::findOrFail($id);
            $ArtePescaPM->update($data);
            $ArtePescaPM->esp_objetivo()->sync($especiesProdId);
    
            return ApiResponse::success('Arte de pesca actualizado exitosamente', 200, $ArtePescaPM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el arte de pesca: ' . $e->getMessage(), 500);
        }
    }    


    /**
     * Elimina el arte de pesca.
     */
    public function destroy($id)
    {
        try {
            $ArtePescaPM = registro_artepesca_PM::findOrFail($id);
            $ArtePescaPM->delete();
            return ApiResponse::success('Arte de pesca eliminado exitosamente', 200, $ArtePescaPM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el arte de pesca: ' .$e->getMessage(), 500);
        }
    }
}
