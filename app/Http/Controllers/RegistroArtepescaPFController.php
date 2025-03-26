<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\registro_artepesca_PF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistroArtepescaPFController extends Controller
{
    /**
     * Despliega la lista de las artes de pesca del pescador fisico.
     */
    public function index()
    {
        try {
            
            $ArtePescaPF = registro_artepesca_PF::with('esp_objetivo')->get();
    
            $result = $ArtePescaPF->map(function ($item) {
                return [
                    'id' => $item->id,
                    'userprofile_id' => $item->perfil_usuario->name,
                    'tipo_artepesca_id' => $item->arte_pesca->nombre_artpesca,
                    'medidas_metros' => $item->medidas_metros,
                    'longitud' => $item->longitud,
                    'material' => $item->material,
                    'luz_malla' => $item->luz_malla,
                    'especie_obj_id' => $item->esp_objetivo ? $item->esp_objetivo->pluck('nombre_especie')->toArray() : [],
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
    
            return ApiResponse::success('Lista de artes de pesca de pescador fisico', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de artes de pesca para pescador fisico: ' . $e->getMessage(), 500);
        }
    }
    

    /**
     * Crea un arte de pesca.
     */
    public function store(Request $request) {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required|exists:users,id',
                'tipo_artepesca_id' => 'required|exists:arte_pesca,id',
                'medidas_metros' => 'required|numeric',
                'longitud' => 'required|numeric',
                'material' => 'required|string|max:30',
                'luz_malla' => 'required|numeric',     
                'especie_obj_id' => 'required|array',
                'especie_obj_id.*' => 'integer|exists:especies,id',        
            ]);

            $especiesProdId = $data['especie_obj_id'];
            unset($data['especie_obj_id']);

            $existeArtePescaPF = registro_artepesca_PF::where('tipo_artepesca_id', $data['tipo_artepesca_id'])->first();
            if ($existeArtePescaPF) {
                $errors = [];
                if ($existeArtePescaPF->tipo_artepesca_id === $data['tipo_artepesca_id']) {
                    $errors['tipo_artepesca_id'] = 'Este arte de pesca ya esta registrado';
                }
                return ApiResponse::error('Este arte de pesca ya existe', 422, $errors);
            }

            $ArtePescaPF = registro_artepesca_PF::create($data);

            $ArtePescaPF->esp_objetivo()->attach($especiesProdId);

            return ApiResponse::success('Arte de pesca creado exitosamente', 201, $ArtePescaPF);
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
            $artePesca = registro_artepesca_PF::with('esp_objetivo')->findOrFail($id);
    
            $result = [
                'id' => $artePesca->id,
                'userprofile_id' => $artePesca->perfil_usuario->id,
                'tipo_artepesca_id' => $artePesca->arte_pesca->id,
                'medidas_metros' => $artePesca->medidas_metros,
                'longitud' => $artePesca->longitud,
                'material' => $artePesca->material,
                'luz_malla' => $artePesca->luz_malla,
                'especie_obj_id' => $artePesca->esp_objetivo ? $artePesca->esp_objetivo->pluck('nombre_especie')->toArray() : [],
                'created_at' => $artePesca->created_at,
                'updated_at' => $artePesca->updated_at,
            ];
    
            return ApiResponse::success('Detalle del arte de pesca', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el detalle del arte de pesca: ' . $e->getMessage(), 500);
        }
    }


    /**
     * Actualiza el arte de pesca.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'userprofile_id' => 'required',
                'tipo_artepesca_id' => 'required',
                'medidas_metros' => 'required|numeric',
                'longitud' => 'required|numeric',
                'material' => 'required|string|max:30',
                'luz_malla' => 'required|numeric',
                'especie_obj_id' => 'required|array',
                'especie_obj_id.*' => 'integer|exists:especies,id',
            ]);

            $especiesProdId = $data['especie_obj_id'];
            unset($data['especie_obj_id']);
            
            $existeArtePescaPF = registro_artepesca_PF::where('tipo_artepesca_id', $data['tipo_artepesca_id'])
            ->where('id', '!=', $id)
            ->first();

            if ($existeArtePescaPF) {
                return ApiResponse::error('El tipo de arte de pesca ya esta registrado.', 422);
            }


            $ArtePescaPF = registro_artepesca_PF::findOrFail($id);
            $ArtePescaPF->update($data);
            $ArtePescaPF->esp_objetivo()->sync($especiesProdId);

            return ApiResponse::success('Arte de pesca actualizado exitosamente', 200, $ArtePescaPF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' .$e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el arte de pesca: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Elimina el arte de pesca.
     */
    public function destroy($id)
    {
        try {
            $ArtePescaPF = registro_artepesca_PF::findOrFail($id);
            $ArtePescaPF->delete();
            return ApiResponse::success('Arte de pesca eliminado exitosamente', 200, $ArtePescaPF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el arte de pesca: ' .$e->getMessage(), 500);
        }
    }
}
