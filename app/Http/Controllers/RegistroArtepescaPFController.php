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
            $ArtePescaPF = registro_artepesca_PF::all();
            $result = $ArtePescaPF->map(function ($item){
                return [
                    'id' => $item->id,
                    'tipo_artepesca_id' => $item->arte_pesca->nombre_artpesca,
                    'medidas_metros' => $item->medidas_metros,
                    'longitud' => $item->longitud,
                    'material' => $item->material,
                    'luz_malla' => $item->luz_malla,
                    'especie_obj_id' => $item->especie_objetivo->nombre_especie,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de artes de pesca de pescador fisico', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de artes de pesca para pescador fisico: ' .$e->getMessage(), 500);
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
                'medidas_metros' => 'required|numeric',
                'longitud' => 'required|numeric',
                'material' => 'required|string|max:30',
                'luz_malla' => 'required|numeric',
                'especie_obj_id' => 'required|exists:especies,id'               
            ]);

            $existeArtePescaPF = registro_artepesca_PF::where('tipo_artepesca_id', $data['tipo_artepesca_id'])->first();
            if ($existeArtePescaPF) {
                $errors = [];
                if ($existeArtePescaPF->tipo_artepesca_id === $data['tipo_artepesca_id']) {
                    $errors['tipo_artepesca_id'] = 'Este arte de pesca ya esta registrado';
                }
                return ApiResponse::error('Este arte de pesca ya existe', 422, $errors);
            }

            $ArtePescaPF = registro_artepesca_PF::create($data);
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
            $ArtePescaPF = registro_artepesca_PF::findOrFail($id);
            $result = [
                'id' => $ArtePescaPF->id,
                'tipo_artepesca_id' => $ArtePescaPF->arte_pesca->nombre_artpesca,
                'medidas_metros' => $ArtePescaPF->medidas_metros,
                'longitud' => $ArtePescaPF->longitud,
                'material' => $ArtePescaPF->material,
                'luz_malla' => $ArtePescaPF->luz_malla,
                'especie_obj_id' => $ArtePescaPF->especie_objetivo->nombre_especie,
                'created_at' => $ArtePescaPF->created_at,
                'updated_at' => $ArtePescaPF->updated_at,
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
            $request->validate([
                'tipo_artepesca_id' => 'required',
                'medidas_metros' => 'required|numeric',
                'longitud' => 'required|numeric',
                'material' => 'required|string|max:30',
                'luz_malla' => 'required|numeric',
                'especie_obj_id' => 'required' 
            ]);
            
            $existeArtePescaPF = registro_artepesca_PF::where('tipo_artepesca_id', $request->tipo_artepesca_id)
            ->where('id', '!=', $id)
            ->first();
            if ($existeArtePescaPF) {
            return ApiResponse::error('El tipo de arte de pesca ya esta registrado.', 422);
            }


            $ArtePescaPF = registro_artepesca_PF::findOrFail($id);
            $ArtePescaPF->update($request->all());
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
