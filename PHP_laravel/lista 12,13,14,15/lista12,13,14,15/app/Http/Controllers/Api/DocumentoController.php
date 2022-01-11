<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\DocumentoResource;
use App\Http\Resources\DocumentoResourceCollection;
use App\Http\Resources\DocumentoResourceColletion;
use DateTime;
use Illuminate\Http\Request;
use App\Models\{Documento};
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DocumentoController extends Controller
{

    public function listarDocumentos(){
        $documentos = Documento::paginate(10);    
        return new DocumentoResourceCollection($documentos);
    }

    public function listarDocumento($id){
        $documento = Documento::where('id',$id)->first();

        if(!$documento){
            return response()->json(['message' => 'Documento nao encontrado'], 404);
        }
                
        return new DocumentoResource($documento);
    }

    public function insereDocumento(Request $form){
        $documento = Documento::create($form->all());

        if(!$documento){
            return response()->json(['message' => 'erro ao cadastrar, tente novamente']);
        }                
        return new DocumentoResource($documento);
    }

    public function editarDocumento(Request $form, $id){
        $documento = Documento::find($id);

        if(!$documento){
            return response()->json(['message' => 'Erro ao alterar o documento']);
        }     
        
        $documento->update($form->all());
        return new DocumentoResource($documento);
    }

    public function deletarDocumento($id){
        $documento = Documento::find($id);
        if(!$documento){
            return response()->json(['code' => '500', 'message' => 'Erro ao excluir documento, não encontrado']);
        }
        $documento->delete();
        return response()->json(['message' => 'Documento Excluido com sucesso']);
    }

    public function login(){
        $usuario = ["id" => rand(3000, 20000), "name" =>"Gabriel"];
        session(["usuario" => $usuario]);
    }

    public function logout(){
        session()->forget('usuario');
    }

    
        
}
