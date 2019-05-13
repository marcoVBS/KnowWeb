<?php

namespace App\Http\Controllers\HelpDesk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\HelpDesk\HelpDeskResponse;
use App\Models\HelpDesk\HelpDeskArchive;
use App\User;

class HelpDeskResponseController extends Controller
{
    
    public function create(Request $request){
        $response = new HelpDeskResponse();
        $response->usuario_id = Auth::id();
        $response->atendimento_id = $request->atendimento_id;
        $response->resposta = $request->resposta;
        if($response->save()){
            foreach ($request->imagens as $image) {
                $upload = $this->saveArchive($response->atendimento_id, $image['nome'], $image['caminho'], $response->id_resposta_atendimento, 'Imagem');
                if(!$upload){
                    return response()->json([
                        'stored' => false
                    ]);
                }
            }
            return response()->json([
                'stored' => true,
                'id_resposta' => $response->id_resposta_atendimento,
                'id_atendimento' => $response->atendimento_id
            ]);
        }else{
            return response()->json([
                'stored' => false
            ]);
        }
    }

    public function saveArchive($atendimento_id, $name, $caminho, $resposta_id, $tipo){
        $archive = new HelpDeskArchive();
        $archive->atendimento_id = $atendimento_id;
        $archive->nome = $name;
        $archive->caminho = $caminho;
        $archive->tipo = $tipo;
        $archive->resposta_atendimento_id = $resposta_id;
        if($archive->save()){
            return true;
        }else{
            return false;
        }
    }

    public function uploadImage(Request $request){
        $extension = $request->file->getClientOriginalExtension();
        $name = time().'id-'.Auth::id().'.'.$extension;
        $path = '/KnowWeb/public/storage/atendimentos/imagens/respostas/' . $name;
        
        if($request->hasFile('file') && $request->file('file')->isValid()){
            $upload = $request->file->storeAs('/atendimentos/imagens/respostas/', $name);
            if($upload){
                return response()->json([
                    'path' => $path,
                    'name' => $name
                ]);
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function uploadFiles(Request $request){
        $id_resposta = $request->id_resposta;
        $id_atendimento = $request->id_atendimento;
        $name = $request->file('file')->getClientOriginalName();
        $path = 'storage/atendimentos/arquivos/respostas/'.$id_resposta.'/'. $name;

        if($request->hasFile('file') && $request->file('file')->isValid()){
            $upload = $request->file('file')->storeAs('/atendimentos/arquivos/respostas/'.$id_resposta.'/', $name);

            if($upload){
                $save = $this->saveArchive($id_atendimento, $name, $path, $id_resposta, 'Arquivo');
                if($save){
                    return response()->json([
                        'upload' => true
                    ]);
                }else{
                    return response()->json([
                        'upload' => false
                    ]);
                }
            }else{
                return response()->json([
                    'upload' => false
                ]);
            }
        }else{
            return response()->json([
                'upload' => false
            ]);
        }
    }

    public function getResponses(Request $request){
        $responses = HelpDeskResponse::where('atendimento_id', $request->id)->get();
        foreach ($responses as $response) {
            $user = User::find($response->usuario_id);
            $response->autor = $user->nome;
            $response->autor_foto = $user->foto;
            $response->archives = HelpDeskArchive::where('resposta_atendimento_id', $response->id_resposta_atendimento)->where('tipo', '<>', 'Imagem')->get();
        }
        return response()->json([
            'responses' => $responses
        ]);
    }
    
}
